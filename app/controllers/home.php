<?php

class Home extends Controller
{
    /**
     * Dispatch function.
     * Choose which operation do
     */
    public function index()
    {
        $this->checkLogged();

        $operation = filter_input(INPUT_POST, "op", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        switch ($operation) {
            case 'popular':
                echo json_encode($this->getPopular());
                break;

            default:
                $viewData = $this->visualizePage();

                $this->view('home', $viewData);
                break;
        }
    }

    /**
     * Get the most popular items on the website
     */
    private function visualizePage()
    {
        $user_id = $_SESSION['id'];

        $user = $this->model("User");
        $u = $user->getUser($user_id)->data['name'];
        $popular = $this->getPopular()->data;

        return ['name' => $u, 'popularProd' => $popular];
    }

    /**
     * Get the most popular items on the website
     */
    private function getPopular()
    {
        $prod = $this->model("Product");

        return $prod->getPopular();
    }
}

?>
