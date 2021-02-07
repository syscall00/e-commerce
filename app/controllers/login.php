<?php

class Login extends Controller
{
    /**
     * Dispatch function.
     * Choose which operation do according "op" 
     */
    public function index()
    {
        $operation = filter_input(INPUT_POST, "op", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        switch ($operation) {
            case 'login':
                $this->doLogin();
                break;
            case 'register':
                echo json_encode($this->doRegister());
                break;
            default:
                $this->view('login', []);
                break;
        }
    }

    /**
     * register a new account. If register goes success, create a session 
     * and set the new user as logged
     */
    public function doRegister()
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $surname = filter_input(INPUT_POST, 'surname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!$this->isValidInput($username) || !$this->isValidInput($password) || !$this->isValidInput($name) ||
           !$this->isValidInput($surname) || !$this->isValidInput($email) ) 
            return Response::throwError();

        $user = $this->model("User");
        
        $register = $user->register($username, md5($password), $email, $name, $surname);
        if($register->code) 
        {
            if($register->data > 0) 
            {
                $id = $user->login($username, md5($password));
                    if (isset($_SESSION)) {
                        session_destroy();
                        session_start();
                    }
                    
                    $_SESSION['id'] = $id;
    
                return new Response(1, "Registrazione effettuata con successo", [$id]);
            }
            else 
                return new Response(0, "Utente già registrato");
        }

        return Response::throwError();

        

    }

    /**
     * Check if user / password are correct
     * and in case create a valid session.
     */
    public function doLogin()
    {
        $user = $this->model("User");

        $name = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (isset($name) && isset($password)) {
            if ($id = $user->login($name, md5($password))) {
                if (isset($_SESSION)) {
                    session_destroy();
                    session_start();
                }

                $_SESSION["id"] = $id;

                echo json_encode(new Response(1, "Login riuscito"));
            } else {
                echo json_encode(new Response(0, "Username e / o password errati."));
            }
        } else {
            echo json_encode(new Response(0, "Errore durante il login."));
        }
        die();
    }

    /**
     * Override basic view behaviour. In login controller we don't need
     * to load the top banner
     */
    public function view($view, $data = [])
    {
        if (isset($_SESSION["id"])) {
            redirect("/public/home");
        }

        session_destroy();
        session_start();
        require_once 'top.php';

        require_once '../app/views/' . $view . '.php';
    }
}

?>
