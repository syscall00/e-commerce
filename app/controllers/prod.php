<?php

class Prod extends Controller
{
    /**
     * Dispatch function.
     * Choose which operation do according "op" 
     */
    public function index($id = "")
    {
        $this->checkLogged();

        $op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        switch ($op) {
            case 'getProd':
                echo json_encode($this->getProd());
                break;
            case 'getReviews':
                echo json_encode($this->getRevs());
                break;
            case 'addReview':
                echo json_encode($this->addReview());
                break;

            default:
                $user_id = $_SESSION['id'];
                if (!$id || !is_numeric($id)) {
                    redirect("/public");
                }

                $data = $this->visualize($user_id, $id)->data;
                if (!$data['prod']) {
                    redirect("/public");
                }

                $this->view('prod', $data);
                break;
        }
    }

    private function visualize($user_id, $prod_id)
    {
        $product = $this->model("Product");
        $ret = new Response(1, "Operazione andata a buon fine");
        $prod = $product->getProduct($prod_id);
        $reviews = $product->getReviews($prod_id);

        if ($prod->code) {
            $prod = $prod->data;
        } else {
            $ret = new Response(0, "Errore durante l'operazione");
        }

        if ($reviews->code && $ret->code) {
            $reviews = $reviews->data;
        } else {
            $ret = new Response(0, "Errore durante l'operazione");
        }

        if ($ret->code) {
            $related = $product->getRelated($prod['category']);

            if ($related->code) {
                $related = $related->data;
            } else {
                $ret = new Response(0, "Errore durante l'operazione");
            }

            $isInWish = $this->model("WishModel")->isInWish($user_id, $prod_id);
            if ($isInWish->code && $ret->code) {
                $isInWish = $isInWish->data != null;
            } else {
                $ret = new Response(0, "Errore durante l'operazione");
            }

            $canReview = $product->getReview($user_id, $prod_id);
            if ($canReview->code && $ret->code) {
                $canReview = $canReview->data == null;
            } else {
                $ret = new Response(0, "Errore durante l'operazione");
            }

            $product->saveVisited($user_id, $prod_id);
        }

        $retArray = ['prod' => $prod, 'related' => $related, 'isInWish' => $isInWish, 'canReview' => $canReview, 'revs' => $reviews, 'modelProd' => $product];
        $ret->data = $retArray;
        return $ret;
    }

    private function getProd()
    {
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product = $this->model("Product");

        if (!$this->isValidInput($prod_id)) {
            return Response::throwError();
        } else {
            return $product->getProduct($prod_id);
        }
    }

    private function getRevs()
    {
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $product = $this->model("Product");

        if (!$this->isValidInput($prod_id)) {
            return Response::throwError();
        } else {
            return $product->getReviews($prod_id);
        }
    }

    private function addReview()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vote = filter_input(INPUT_POST, 'vote', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $review = filter_input(INPUT_POST, 'review', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $product = $this->model("Product");

        if (!$this->isValidInput($prod_id) || !$this->isValidInput($vote) || !$this->isValidInput($review) || $vote <= 0 || $vote > 5) {
            return Response::throwError();
        } else {
            $res = $product->addReview($user_id, $prod_id, $vote, $review);
            if ($res->code && $res->data > 0) {
                $res = $product->getReview($user_id, $prod_id);
                if ($res->code) {
                    return new Response(1, "Recensione aggiunta con successo", $res->data);
                }
            }

            return $res;
        }
    }

    public function isInWish()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $product = $this->model("Product");
        if (!$this->isValidInput($prod_id)) {
            return Response::throwError();
        } else {
            $result = $product->isInWish($user_id, $prod_id);
            if ($result->code) {
                $result->data = count($result->data) > 0;
            }
            echo json_encode(new Response(1, $result));
        }
    }
}
