<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'core/init.php';
//echo __ROOT__;
if(Session::exists('registerSuccessfully')) {
    echo Session::flash('registerSuccessfully');
}

if(Session::exists('updatedSuccessfully')) {
    echo Session::flash('updatedSuccessfully');
}

$user =  new User();
if($user->isLoggedIn()) {
?>
    <p>Heloo <a href="#"><?php echo escape($user->data()->UserName);?></a>!</p>

    <ul>
        <li><a href="logout">Logout</a></li>
    </ul>
<?php }
else {
    echo 'You need to <a href="login">login</a> or <a href="register">register</a>';
}?>

<!DOCTYPE html>
<html>
<head>
    <title>
        Homepage
    </title>
</head>

<body>
<p>Homepage</p>
</body>
</html>
