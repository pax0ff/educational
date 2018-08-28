<?php
error_reporting(E_ALL);

if(!isset($_SESSION['status_login']))
{
    require 'pages/login.php';
}
else
{
    require 'admin/dashboard.php';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
</head>
<body>
	
	<p>index page</p>
</body>
</html>