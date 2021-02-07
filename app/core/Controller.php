<?php

class Controller
{
    public function checkLogged()
    {
        if (!isset($_SESSION["id"])) {
            redirect("/public/login");
        }
    }

    public function model($model)
    {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        require_once 'top.php';
        require_once 'banner.php';
        require_once '../app/views/' . $view . '.php';

        require_once 'bottom.php';
    }

    public function isValidInput($input)
    {
        return !empty($input) && !is_null($input);
    }
}

?>
