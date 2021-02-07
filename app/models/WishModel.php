<?php
class WishModel extends Database
{
    public function addWish($user_id, $prod_id)
    {
        $sql = "INSERT INTO wishlists (user_id, prod_id) VALUES ($user_id, $prod_id)";
        return $this->insertUpdateQuery($sql);
    }

    public function isInWish($user_id, $prod_id)
    {
        $sql = "SELECT * FROM wishlists WHERE user_id = $user_id AND  prod_id = $prod_id";
        return $this->selectQuery($sql);
    }

    public function removeWish($user_id, $prod_id)
    {
        $sql = "DELETE FROM wishlists WHERE user_id = $user_id AND prod_id = $prod_id";
        return $this->deleteQuery($sql);
    }
}

?>
