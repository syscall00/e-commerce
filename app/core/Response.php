<?php

class Response
{
    public $code;

    public $description;

    public $data;

    public function __construct($code, $description, $data = [])
    {
        $this->code = $code;
        $this->description = $description;
        $this->data = $data;
    }

    public static function throwError()
    {
        return new Response(-1, "Errore temporaneo");
    }
}

?>
