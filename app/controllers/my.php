<?php

class My extends Controller
{
    /**
     * Dispatch function.
     * Choose which operation do according "op" 
     */
    public function index($name = "")
    {
        $this->checkLogged();

        $operation = filter_input(INPUT_POST, "op", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        switch ($operation) {
            case 'get':
                echo json_encode($this->getUser());
                break;
            case 'order':
                echo json_encode($this->getOrders());
                break;
            case 'wish':
                echo json_encode($this->getWish());
                break;
            default:
                $user = $this->getUser();
                if ($user->code) {
                    $user = $user->data;
                }

                $orders = $this->getOrders()->data;

                $this->view('my', ['orderList' => $orders, 'user' => $user]);
                break;
        }
    }

    /**
     * load the wishlist page 
     */
    public function wishlist()
    {
        $this->checkLogged();

        $user = $this->getUser();
        if ($user->code) {
            $user = $user->data;
        }

        $prodList = $this->getWish()->data;
        $this->view('wishlist', ['prodList' => $prodList, 'user' => $user]);
    }

    /**
     * return the logged user info
     */
    public function getUser()
    {
        $user_id = $_SESSION['id'];
        $user = $this->model("User");
        $ret = $user->getUser($user_id);
        return $ret;
    }

    /**
     * return a list of orders for the logged user
     */
    public function getOrders()
    {
        $user_id = $_SESSION['id'];

        $user = $this->model("User");

        $curr_id = -1;
        $orders = $user->getOrders($user_id);
        if ($orders->code) {
            $orders = $orders->data;
        } else {
            return Response::throwError();
        }

        $retArray = [];
        $subArray = [];
        $prodArray = [];
        foreach ($orders as $order) {
            if ($order['id'] != $curr_id) {
                if ($curr_id != -1) {
                    $subArray[] = $prodArray;
                    array_push($retArray, $subArray);
                    $subArray = [];
                    $prodArray = [];
                }
                $curr_id = $order['id'];
                $subArray = ['id' => $order['id'], 'date' => $order['date'], 'price' => $order['total_price']];
            }
            array_push($prodArray, ['prod_id' => $order['p_id'], 'prod_name' => $order['name'], 'price' => $order['price'], 'quantity' => $order['quantity']]);
        }
        if ($orders != null) {
            $subArray[] = $prodArray;
            array_push($retArray, $subArray);
        }
        return new Response(1, "", $retArray);
    }


    /**
     * return the wishlist for logged user
     */
    public function getWish()
    {
        $user_id = $_SESSION['id'];
        $user = $this->model('User');
        $wishList = $user->getWish($user_id);

        return $wishList;
    }
}

?>
