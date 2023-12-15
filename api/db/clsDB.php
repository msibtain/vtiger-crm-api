<?php

class clsDB
{
    private $con;
    private $host;
    private $username;
    private $password;
    private $database;

    public function __construct($host, $username, $password, $database) {

        $this->host         = $host;
        $this->username     = $username;
        $this->password     = $password;
        $this->database     = $database;

        $this->connect();

    }

    private function connect() {

        $this->con = mysqli_connect(
                $this->host, 
                $this->username, 
                $this->password) or die("Can't connect");
        mysqli_select_db($this->con, $this->database);

    }

    public function query($query) {
        return mysqli_query($this->con, $query) or mysqli_error($this->con);
    }

    public function insert_id() {
        return mysqli_insert_id( $this->con );
    }

    public function getRows($query) {
        $arrRows = [];
        $result = mysqli_query($this->con, $query);
        while ($row = mysqli_fetch_object($result))
        {
            $arrRows[] = $row;
        }
        return $arrRows;
    }


}