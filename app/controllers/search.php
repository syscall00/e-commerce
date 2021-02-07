<?php

class Search extends Controller
{
    /* Elements per page in search */
    public static $elemPerPage = 10;

    /* Elements per page in autocompleter */
    public static $elemInAutocompleter = 10;

    /**
     * Dispatch function.
     * Choose which operation do according "op" 
     */
    public function index()
    {
        $this->checkLogged();

        $op = filter_input(INPUT_POST, 'op', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        switch ($op) {
            case 'getProd':
                echo json_encode($this->getProducts($search));
                break;

            case 'getSearch':
                // useful ajax handler for autocomplete
                echo json_encode($this->getAutocompleteResults($search));
                break;

            default:
                $prodList = $this->getProducts($search)->data;
                $this->view('search', ['search' => $search, 'prodList' => $prodList, 'modelProd' => $this->model("Product")]);
                break;
        }
    }

    /**
     * Get the most popular items on the website
     */
    public function getProducts($name)
    {
        $retVal = new Response(-1, "Errore durante la ricerca", []);

        $this->dispatchFilters();
        $page = filter_input(INPUT_POST, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$page || is_numeric($page)) {
            $product = $this->model("Product");

            $prodList = $product->getListProduct($name, Search::$elemPerPage, $page * Search::$elemPerPage, $this->available, $this->starRating, $this->minPrice, $this->maxPrice);

            if ($prodList->code == 1) {
                $data = $prodList->data;

                for ($i = 0; $i < count($data); $i++) {
                    $prod = $data[$i];
                    if (strlen($prod['name']) > 70) {
                        $data[$i]['name'] = substr($prod['name'], 0, 69) . "...";
                    }
                }

                $retVal = $prodList;
            }
        }

        return $retVal;
    }

    /**
     *
     */
    public function getAutocompleteResults($name)
    {
        $product = $this->model("Product");

        return $product->getAutocomplete($name, Search::$elemInAutocompleter)->data;
    }

    /**
     *
     */
    private function dispatchFilters()
    {
        $filters = filter_input(INPUT_POST, 'filter', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

        $this->available = isset($filters['available']) ? $filters['available'] === 'true' : false;
        $this->starRating = isset($filters['starRating']) && is_numeric($filters['starRating']) ? $filters['starRating'] : 0;
        $this->minPrice = isset($filters['minPrice']) && is_numeric($filters['minPrice']) ? $filters['minPrice'] : 0;
        $this->maxPrice = isset($filters['maxPrice']) && is_numeric($filters['maxPrice']) ? $filters['maxPrice'] : PHP_INT_MAX;

        if ($this->starRating < 0 || $this->starRating > 5) {
            $this->starRating = 0;
        }

        if ($this->minPrice >= $this->maxPrice) {
            $this->maxPrice = PHP_INT_MAX;
        }

        if ($this->maxPrice <= $this->minPrice) {
            $this->minPrice = 0;
        }
    }
}

?>
