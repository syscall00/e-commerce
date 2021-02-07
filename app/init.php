<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once 'core/App.php';
require_once 'core/database.php';
require_once 'core/Response.php';

require_once 'core/Controller.php';

# Redirects current page to login.php if user is not logged in.
function ensure_logged_in()
{
    if (!isset($_SESSION["id"])) {
        redirect("login", "You must log in before you can view the website.");
    }
}

# Redirects current page to the given URL.
function redirect($url)
{
    # session_write_close();
    header("Location: $url");
    die();
}

?>
