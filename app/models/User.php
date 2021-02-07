<?php

class User extends Database
{
    public $name;

    public function login($user, $pwd)
    {
        $sql = "SELECT * FROM users WHERE username = '$user'";
        $user = $this->selectQuery($sql)->data;
        if ($user) {
            foreach ($user as $u) {
                $correct_password = $u["password"];
                return $pwd === $correct_password ? $u['id'] : false;
            }
        } else {
            return false; 
        }
    }

    public function register($user, $pwd, $email, $name, $surname) 
    {
        $sql = "INSERT INTO users (username, password, email, name, surname) VALUES ('$user', '$pwd', '$email', '$name', '$surname')";
        return $this->insertUpdateQuery($sql);

    }

    public function getUser($user_id)
    {
        $sql = "SELECT * FROM users WHERE id = $user_id";
        return $this->selectQuery($sql, true);
    }

    public function getOrders($user_id)
    {
        $sql = "SELECT o.id, o.date, o.price as total_price, op.price, op.quantity, p.id as p_id, p.name 
        FROM orders o JOIN orders_product op ON (o.id = op.order_id) JOIN products p ON (op.prod_id = p.id) 
        WHERE user_id = $user_id 
        ORDER BY o.id DESC";
        return $this->selectQuery($sql);
    }

    public function getWish()
    {
        $id = $_SESSION['id'];
        $sql = "SELECT p.* FROM wishlists w JOIN products p ON (w.prod_id = p.id) WHERE w.user_id = $id";
        return $this->selectQuery($sql);
    }
}

?>
