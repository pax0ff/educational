<?php
require '../core/init.php';

$user =  new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate  =  new Validation();
        $validation = $validate->check($_POST , array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
               // 'unique' => 'User'
            ),
            'password' => array(
                //'required'=>false,
                'min'=>2,
                'max'=>20

            ),
            'password_again' => array(
                //'required' => false,
                'matches'=> 'password'
            ),
            'firstname' => array(
                'required'=>true,
                'min'=>2,
                'max'=>30
            ),
            'lastname' => array(
                'required' => true ,
                'min' => 2,
                'max' => 30
            )
        ));

        if($validation->passed()) {
            try {

                $user->update(array(
                    'UserName' => Input::get('username'),
                    'FirstName' => Input::get('firstname'),
                    'LastName' => Input::get('lastname'),
                    'Email' => Input::get('email')
                ));

                Session::flash('updatedSuccessfully','Your details have been succesfully updated');
                Redirect::to('home');

            } catch(Exception $e) {
                $e->getMessage();
            }
        } else {
            foreach ($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update information</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <!-- <link rel="icon" type="image/png" href="../assets/images/icons/favicon.ico"/>-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <form class="login100-form " method="POST">
					<span class="login100-form-title p-b-26">
						Update your information
					</span>
                <span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>

                <div class="wrap-input100 ">
                    <span class="focus-input100" data-placeholder="">Firstname</span><br>
                    <input class="input100" type="text" name="firstname"  id="firstname" value="<?php echo escape($user->data()->FirstName)?>">

                </div>
                <div class="wrap-input100 " data-validate = "">
                    <span class="focus-input100">Lastname</span><br>
                    <input class="input100" type="text" name="lastname" id="lastname" value="<?php echo escape($user->data()->LastName)?>">

                </div>
                <div class="wrap-input100 " data-validate = "">
                    <span class="focus-input100">E-mail</span><br>
                    <input class="input100" type="email" name="email" id="email" value="<?php echo escape($user->data()->Email)?>">

                </div>
                <div class="wrap-input100 " data-validate = "">
                    <span class="focus-input100">Username</span><br>
                    <input class="input100" type="text" name="username" id="username" value="<?php echo escape($user->data()->UserName)?>">

                </div>
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" type="submit">
                            Update
                        </button>
                    </div>
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
            </form>
        </div>
    </div>
</div>
</body>
</html>