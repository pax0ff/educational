<?php
session_start();
error_reporting(E_ALL|E_STRICT);
$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'root',
        'db_name' => 'schoolDB'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user'
    )
);

spl_autoload_register(function($class)
{
    require_once 'classes/'. $class. '.php';
});

require_once 'functions/sanitize.php';