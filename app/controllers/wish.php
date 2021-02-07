<?php

class Wish extends Controller
{

    /**
     * Dispatch function.
     * Choose which operation do according "op" 
    */
    public function index()
    {
        $this->checkLogged();

        $operation = filter_input(INPUT_POST, "op", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        switch ($operation) {
            case 'add':
                $this->addWish();
                break;
            case 'remove':
                $this->removeWish();
                break;
            case 'exists':
                $this->isInWish();
                break;

            default:
                redirect('home');
            break;
        }
    }

    /**
     * add an element to the logged user's wishlist
     */
    private function addWish()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$this->isValidInput($prod_id)) {
            echo json_encode(Response::throwError());
        } else {
            $product = $this->model("WishModel");
            if ($product->addWish($user_id, $prod_id)) {
                echo json_encode(new Response(1, "Oggetto aggiunto alla wishlist"));
            } else {
                echo json_encode(new Response(-2, "Elemento già in wishlist"));
            }
        }
    }

    /**
     * remove an element from the logged user's wishlist
     */
    private function removeWish()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $product = $this->model("WishModel");
        if (!$this->isValidInput($prod_id)) {
            echo json_encode(Response::throwError());
        } else {
            if ($product->removeWish($user_id, $prod_id)->data > 0) {
                echo json_encode(new Response(1, "Prodotto rimosso con successo"));
            } else {
                echo json_encode(new Response(-2, "Oggetto non in wishlist"));
            }
        }
    }

    /**
     * check if an element is in the logged user's wishlist
     */
    public function isInWish()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $product = $this->model("WishModel");
        if (!$this->isValidInput($prod_id)) {
            return Response::throwError();
        } else {
            $result = $product->isInWish($user_id, $prod_id);
            if ($result->code) {
                $result->data = count($result->data) > 0;
            }
            echo json_encode($result);
        }
    }
}

?>
