<?php

class Database
{
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_count = 0;

    private function __construct()
    {
        try {
           $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';port=8889;dbname=' .Config::get('mysql/db_name'),Config::get('mysql/username'),Config::get('mysql/password'));

            echo 'Connected';
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function query($sql,$params=array()) {
        $this->_error = false;
        $paramPos = 1;
        if($this->_query = $this->_pdo->prepare($sql)) {
            if(count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($paramPos,$param);
                    $paramPos++;
                }
            }

            if($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }
            else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function error() {
        return $this->_error;
    }
}