<?php

class Cart extends Controller
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
            case 'get':
                echo json_encode($this->getCart());
                break;
            case 'count':
                echo json_encode($this->getCount());
                break;
            case 'add':
                echo json_encode($this->addCart());
                break;
            case 'remove':
                echo json_encode($this->removeCart());
                break;
            case 'update':
                echo json_encode($this->updateCart());
                break;
            case 'order':
                echo json_encode($this->createOrder());
                break;
            default:
                $this->visualizePage();
                break;
        }
    }


    /**
     * Recalculate the number of items in cart and the total price, and 
     * returns it into an array
     */
    private function recalculateValue($cart)
    {
        $total_price = 0;
        $total_quantity = 0;
        if ($cart->code) {
            if ($cart->data != null) {
                foreach ($cart->data as $item_cart) {
                    $total_price += $item_cart['price'] * $item_cart['cart_quantity'];
                }
            }
        }

        $count = $this->getCount();
        if ($count->code) {
            $total_quantity = $count->data['cnt'];
        }

        return [$total_price, $total_quantity];
    }

    /**
     * Display the page calling "view"
     */
    private function visualizePage()
    {
        $cart = $this->getCart();
        $values = $this->recalculateValue($cart);

        $this->view('cart', ['cart' => $cart->data, 'total_price' => $values[0], 'total_quantity' => $values[1]]);
    }

    /**
     * Return the items in cart for the logged user.
     */
    private function getCart()
    {
        $user_id = $_SESSION['id'];
        $cartModel = $this->model("CartModel");

        return $cartModel->getCart($user_id);
    }

    /**
     * Return the count of the items in cart for the logged user.
     */
    private function getCount()
    {
        $user_id = $_SESSION['id'];
        $cart = $this->model("CartModel");

        return $cart->countCart($user_id);
    }

    /**
     * Insert an item in the cart. If the item is already in the cart, increment the
     * number of item in cart.
     */
    private function addCart()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $cart = $this->model("CartModel");
        $prod = $this->model("Product");

        $max_quantity = $prod->getProduct($prod_id);
        if ($max_quantity->code) {
            $max_quantity = $max_quantity->data['quantity'];
        } else {
            return Response::throwError();
        }

        if (!$this->isValidInput($prod_id) || !$this->isValidInput($quantity) || !is_numeric($prod_id) || !is_numeric($quantity) || $quantity <= 0 || $quantity > $max_quantity) {
            return Response::throwError();
        }

        $prodInCart = $cart->isInCart($user_id, $prod_id);
        if ($prodInCart->code) {
            $prodInCart = $prodInCart->data;
        }

        // if items was already in cart, increment it if it is possible
        if ($prodInCart != null) {
            $old_quantity = $prodInCart['cart_quantity'];
            $new_quantity = $quantity + $old_quantity;

            if ($new_quantity <= $max_quantity) {
                $update = $cart->updateCart($user_id, $prod_id, $new_quantity);
                if ($update->code) {
                    $newCount = $cart->countCart($user_id)->data;
                    return new Response(1, "Oggetto aggiunto al carrello", $newCount);
                } else {
                    return $update;
                }
            } else {

                return new Response(-1, "Limite massimo di questo oggetto raggiunto");
            }
        // else, simply add item to the cart 
        } else {
            $add = $cart->addCart($user_id, $prod_id, $quantity);
            if ($add->code) {
                $newCount = $cart->countCart($user_id)->data;
                return new Response(1, "Oggetto aggiunto al carrello", $newCount);
            }
        }

        return Response::throwError();
    }

    /**
     * Remove an item from the cart.
     */
    private function removeCart()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $cart = $this->model("CartModel");
        if (!$this->isValidInput($prod_id) || !is_numeric($prod_id)) {
            return Response::throwError();
        }

        $remove = $cart->removeCart($user_id, $prod_id);
        if ($remove->code) {
            if ($remove->data > 0) {
                $cart = $this->getCart();
                $values = $this->recalculateValue($cart);

                return new Response(1, "Prodotto rimosso con successo", ['total_price' => $values[0], 'total_quantity' => $values[1]]);
            } else {
                return new Response(-1, "Oggetto non presente nel carrello");
            }
        } else {
            return $remove;
        }
    }

    /**
     * Update the count of an existing item on the cart.
     */
    private function updateCart()
    {
        $user_id = $_SESSION['id'];
        $prod_id = filter_input(INPUT_POST, 'prod_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $cart = $this->model("CartModel");
        $product = $this->Model("Product");

        $max_quantity = $product->getProduct($prod_id);
        if ($max_quantity->code) {
            $prod_max_quantity = $max_quantity->data['quantity'];
        } else {
            return Response::throwError();
        }

        if (!$this->isValidInput($prod_id) || !$this->isValidInput($quantity) || !is_numeric($prod_id) || !is_numeric($quantity) || $quantity <= 0 || $quantity > $prod_max_quantity) {
            return Response::throwError();
        }

        $update = $cart->updateCart($user_id, $prod_id, $quantity);
        if ($update->code) {
            if ($update->data > 0) {
                $cart = $this->getCart();
                $values = $this->recalculateValue($cart);

                return new Response(1, "Prodotto aggiornato con successo", ['total_price' => $values[0], 'total_quantity' => $values[1]]);
            // now row updated
            } else {
                return new Response(-1, "Nessuna modifica da fare");
            }
        } else {
            return $update;
        }
    }


    /**
     * Create a new order, getting all items in cart for the
     * logged user
     */
    private function createOrder()
    {
        $user_id = $_SESSION['id'];
        $cart = $this->model("CartModel");

        return $cart->completeOrder($user_id);
    }
}

?>
