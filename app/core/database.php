<?php

class Database
{
    private $dbconnstring = 'mysql:host=127.0.0.1;dbname=ecommerce';
    private $dbuser = 'root';
    private $dbpasswd = '';

    /**
     * Create a PDO object 
     */
    protected function getPDO()
    {
        $connection = null;
        try {
            $connection = new PDO($this->dbconnstring, $this->dbuser, $this->dbpasswd);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo $ex;
        }
        return $connection;
    }

    /**
     * Usefull function for doing a quick SELECT query
     */
    public function selectQuery($sql, $singleValue = false)
    {
        $db = $this->getPDO();
        if ($db != null) {
            try {
                $db->quote($sql);
                $db->prepare($sql);
                $stm = $db->query($sql);

                $db = null;

                if ($singleValue) {
                    $row = $stm->fetch(PDO::FETCH_ASSOC);
                } else {
                    $row = $stm->fetchAll(PDO::FETCH_ASSOC);
                }
                return new Response(1, "Query inviata con successo", $row);
            } catch (Exception $e) {
                return new Response(-1, "Errore interno durante la richiesta");
            }
        } else {
            return new Response(0, "Errore durante la conessione al database");
        }
    }

    /**
     * Usefull function for doing a quick INSERT or UPDATE query
     */
    public function insertUpdateQuery($sql)
    {
        $db = $this->getPDO(); 
        if ($db != null) {
            try {
                $db->quote($sql);
                $statement = $db->prepare($sql);
                $statement->execute();

                return new Response(1, "Query inviata con successo", $statement->rowCount());
            } catch (PDOException $e) {
                return new Response(-1, "Errore interno durante la richiesta");
            }
        } else {
            return new Response(0, "Errore durante la conessione al database");
        }
    }

    /**
     * Usefull function for doing a quick DELETE query
     */
    public function deleteQuery($sql)
    {
        $db = $this->getPDO(); 
        if ($db != null) {
            try {
                $db->quote($sql);
                $statement = $db->prepare($sql);
                $statement->execute();

                return new Response(1, "Query inviata con successo", $statement->rowCount());
            } catch (PDOException $e) {
                return new Response(-1, "Errore interno durante la richiesta");
            }
        } else {
            return new Response(0, "Errore durante la conessione al database");
        }
    }
}

?>
