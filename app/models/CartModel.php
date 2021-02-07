<?php
class CartModel extends Database
{
    public function getCart($user_id)
    {
        $sql = "SELECT c.id as cart_id, c.cart_quantity,
        p.id, p.name, p.quantity as disponible_quantity, price, 
        s.name as seller_name, s.surname as seller_surname
        FROM cart c JOIN products p ON (c.prod_id = p.id) JOIN sellers s ON (p.seller_id = s.id)
        WHERE c.user_id = $user_id";

        return $this->selectQuery($sql);
    }

    public function addCart($user_id, $prod_id, $quantity)
    {
        $sql = "INSERT INTO cart (user_id, prod_id, cart_quantity) VALUES ($user_id, $prod_id, $quantity)";
        return $this->insertUpdateQuery($sql);
    }

    public function isInCart($user_id, $prod_id)
    {
        $sql = "SELECT cart_quantity 
        FROM cart 
        WHERE user_id = $user_id AND prod_id = $prod_id";
        return $this->selectQuery($sql, true);
    }

    public function removeCart($user_id, $prod_id)
    {
        $sql = "DELETE FROM cart WHERE user_id = $user_id AND prod_id = $prod_id";
        return $this->deleteQuery($sql);
    }

    public function countCart($user_id)
    {
        $sql = "SELECT COALESCE(SUM(cart_quantity), 0) as cnt 
        FROM cart 
        WHERE user_id = $user_id";
        return $this->selectQuery($sql, true);
    }

    public function flushCart($user_id)
    {
        $sql = "DELETE FROM cart WHERE user_id = $user_id";
        return $this->deleteQuery($sql);
    }

    public function updateCart($user_id, $prod_id, $newQuantity)
    {
        $sql = "UPDATE cart SET cart_quantity = $newQuantity WHERE user_id = $user_id AND prod_id = $prod_id";
        return $this->insertUpdateQuery($sql);
    }

    public function getNextID()
    {
        $sql = "SELECT COALESCE(MAX(id) + 1, 1) as next FROM orders";
        $max = $this->selectQuery($sql, true)->data;
        return $max['next'];
    }

    public function completeOrder($user_id)
    {
        $order_productQuery = "INSERT INTO orders_product (order_id, prod_id, price, quantity) VALUES ";

        $timestamp = date('Y-m-d H:i:s');
        $order_id = $this->getNextID();
        $items = $this->getCart($user_id)->data;
        $total_price = 0;

        for ($i = 0; $i < count($items); $i++) {
            $item = $items[$i];
            $prod_id = intval($item['id']);
            $quantity = intval($item['cart_quantity']);
            $price = floatval($item['price']);

            $order_productQuery = $order_productQuery . "($order_id, $prod_id, $price, $quantity)";
            if ($i != count($items) - 1) 
                $order_productQuery = $order_productQuery . ", ";

            $total_price += $price;
        }

        // aggiungo la riga nella tabella orders
        $ordersQuery = "INSERT INTO orders (id, date, user_id, price) VALUES ($order_id, '$timestamp', $user_id, $total_price)";
        $num_insert = $this->insertUpdateQuery($ordersQuery);
        if (!$num_insert->code || $num_insert->data <= 0) {
            return new Response(-1, "Errore durante la creazione dell'ordine QUI: " . "INSERT INTO orders (order_id, date, user_id, address_id, price) VALUES ($order_id, '$timestamp', $user_id, $total_price)");
        }

        // inserisco all'interno di orders_product i vari elementi
        $num_insert = $this->insertUpdateQuery($order_productQuery);
        if (!$num_insert->code || $num_insert->data != count($items)) {
            return new Response(-1, "Errore durante la creazione dell'ordine");
        }

        foreach ($items as $item) {
            // UPDATE products SET quantity = quantity - $item['cart_quantity'] WHERE id = $items['prod_id'];
        }

        // flush cart
        $this->flushCart($user_id);

        return new Response(1, "Ordine creato con successo");
    }
}

?>
