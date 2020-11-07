<?php

namespace classes\db;

ini_set("display_errors", 1);
error_reporting(E_ALL);

class ConnectionDB
{
    private $link;
    private static $instance = null;

    private function __construct()
    {
        $this->link = mysqli_connect(HOST, USER, PASSWORD, DATABASE)
        or die("Ошибка " . mysqli_error($this->link));
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function sendQuery($query)
    {
        return mysqli_query($this->link, $query);
    }

    public function getResult($query)
    {
        return mysqli_fetch_all($this->sendQuery($query), MYSQLI_ASSOC);
    }

    public function getLastID()
    {
        return mysqli_insert_id($this->link);
    }


}