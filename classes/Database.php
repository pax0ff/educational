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

            //echo 'Connected';
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

    public  function action($action,$table,$where = array()) {
        if(count($where) === 3) {
            $operators = array('=' , '<' , '>' , '<=' , '>=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} * FROM `{$table}` WHERE `{$field}` {$operator} '{$value}' ";
                if(!$this->query($sql, array($value))->error() ) {
                    return $this;
                }
            }
        }
        return false;
    }

    public function insert($table,$fields = array() ) {
        if(count($fields)) {
            $keys = array_keys($fields);
            $values=null;
            $x = 1;
            foreach($fields as $field) {
                $values.= '?';
                if($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }
            //die($values);
            $sql = "INSERT INTO `User` (`". implode('`, `' , $keys ) ."`) VALUES ({$values})";
            if(!$this->query($sql,$fields)->error()) {
                return true;
                
            }
            echo $sql;
        }
        return false;
    }

    /**
     * @param $table
     * @param $id
     * @param $fields
     * @return bool
     */
    public function update($table, $id, $fields) {
        $set='';
        $x = 1;

        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            } 
            $x++;
        }
        //die($set);

        $sql =  "UPDATE {$table} SET {$set} WHERE id = {$id}";
        if(!$this->query($sql,$fields)->error()) {
            return true;
        }
        return false;
    }

    public function get($table,$where) {
        return $this->action("SELECT", $table , $where);
    }

    public function delete($table,$where) {
        return $this->action('DELETE', $table , $where);
    }
    public function first() {
        return $this->results()[0];
    }
    public function results() {
        return $this->_results;
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }
}