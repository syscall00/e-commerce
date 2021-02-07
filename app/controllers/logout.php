<?php

class Logout extends Controller
{
    /**
     * Destroy the session and redirect to login
     */
    public function index()
    {
        session_destroy();
        session_start();
        redirect("/public/login");
    }
}

?>
