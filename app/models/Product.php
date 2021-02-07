<?php

class Product extends Database
{
    public function getListProduct($name, $limit, $offset, $available, $star, $min, $max)
    {
        $sql = "SELECT p.*, s.name as seller_name, s.surname as seller_surname 
        FROM products p JOIN sellers s ON (p.seller_id = s.id) 
        WHERE p.name like '%$name%' AND rating >= $star AND price >= $min AND price <= $max ";
        if ($available) {
            $sql = $sql . "AND quantity > 0 ";
        }

        $sql = $sql . "LIMIT $limit OFFSET $offset";

        return $this->selectQuery($sql);
    }

    public function getAutocomplete($name, $limit)
    {
        $sql = "SELECT p.id, SUBSTRING(p.name, 1, 70) as value 
        FROM products p
        WHERE name LIKE '%$name%' LIMIT $limit";

        return $this->selectQuery($sql);
    }

    public function getProduct($prod_id)
    {
        return $this->selectQuery("SELECT p.*, s.name as seller_name, s.surname as seller_surname FROM products p JOIN sellers s ON (p.seller_id = s.id) WHERE p.id = " . $prod_id, true);
    }

    public function getRelated($cat_id)
    {
        return $this->selectQuery("SELECT id FROM products WHERE category = $cat_id ORDER BY RAND() LIMIT 10");
    }

    public function getPopular()
    {
        return $this->selectQuery("SELECT v.prod_id FROM visited v JOIN products p ON ( v.prod_id = p.id ) Group By v.prod_id Order by COUNT(v.prod_id) desc limit 10");
    }

    // visited
    public function saveVisited($user_id, $prod_id)
    {
        return $this->insertUpdateQuery("INSERT INTO visited (user_id, prod_id) VALUES( $user_id, $prod_id)");
    }

    // REVIEW
    public function getReviews($id)
    {
        return $this->selectQuery("SELECT u.name, u.surname, r.vote, r.review, r.time FROM reviews r JOIN products p ON (r.prod_id = p.id) JOIN users u ON (r.user_id = u.id) WHERE p.id = " . $id);
    }

    public function getReview($user_id, $prod_id)
    {
        return $this->selectQuery("SELECT u.name, u.surname, r.vote, r.review, r.time FROM reviews r JOIN products p ON (r.prod_id = p.id) JOIN users u ON (r.user_id = u.id) WHERE p.id = $prod_id AND u.id = $user_id");
    }

    public function addReview($user_id, $prod_id, $vote, $review)
    {
        return $this->insertUpdateQuery("INSERT INTO reviews (user_id, prod_id, vote, review) VALUES ($user_id, $prod_id, $vote, '$review')");
    }

    public function generateStars($ratingNumber)
    {
        $result = "";
        $i = 1;
        for (; $i <= $ratingNumber; $i++) {
            $result = $result . '<i class="fas fa-star fa-sm text-primary"></i>';
        }

        for (; $i <= 5; $i++) {
            $result = $result . '<i class="far fa-star fa-sm text-primary"></i>';
        }

        return $result;
    }
}

?>
