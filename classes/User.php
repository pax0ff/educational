<?php
/**
 * Created by PhpStorm.
 * User: nor02
 * Date: 17/08/2018
 * Time: 11:43
 */

class User
{
    private $_db,
            $_data,
            $_sessionName,
            $_isLoggedIn;

    public function __construct($user = null)
    {
        $this->_db= Database::getInstance();
        $this->_sessionName = Config::get('session/session_name');

        if(!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if($this->find($user)) {
                    $this->_isLoggedIn = true;
                } else {
                    //logout
                }
            }
        } else {
            $this->find($user);
        }
    }

    public function update($fields = array(), $id=null) {

        if(!$id && $this->isLoggedIn()) {
            $id = $this->data()->ID;
        }


        if(!$this->_db->update('User',$id,$fields)) {
            throw new Exception("There was a problem updating");
        }
    }

    public function create($fields = array()) {
        if(!$this->_db->insert('User',$fields)) {
            throw new Exception('There was a problem creating an account');
        }
    }

    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'ID' : 'UserName';
            $data = $this->_db->get('User',array($field, '=' , $user));

            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username=null, $password=null) {
        $user = $this->find($username);
        if($user) {
            //echo $this->data()->Password . '<br>' . Hash::make($password,$this->data()->Salt);
            if($this->data()->Password === Hash::make($password,$this->data()->Salt)) {
                Session::put($this->_sessionName, $this->data()->ID);
                return true;
            }
        }
    }

    public function data() {
        return $this->_data;
    }

    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }

    public function logout() {
        Session::delete($this->_sessionName);
    }
}