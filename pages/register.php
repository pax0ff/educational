<?php
error_reporting(E_ALL | E_STRICT);
require_once '../core/init.php';

//var_dump(Token::check(Input::get('token')));

    if(Input::exists()) {
        if(Token::check(Input::get('token'))) {

              //echo 'i have been run';

        $validate  =  new Validation();
        $validation = $validate->check($_POST , array(
                'username' => array(
                        'required' => true,
                        'min' => 2,
                        'max' => 20,
                        'unique' => 'User'
                ),
                'password' => array(
                        'required'=>true,
                        'min'=>2,
                        'max'=>20

                ),
                'password_again' => array(
                        'required' => true,
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
            //echo 'Passed';
            $user = new User();
            $salt = Hash::salt(10);

            try {
                $user->create(array(
                        'FirstName' => Input::get('firstname'),
                        'LastName' => Input::get('lastname'),
                    'Email' => Input::get('email'),
                    'UserName' => Input::get('username'),
                    'Password' => Hash::make(Input::get('password'),$salt),
                    'PasswordConfirmed' => Hash::make(Input::get('password_again'),$salt),
                    'Salt' => $salt,
                    'RegisteredOn' => date('Y-m-d H:i:s'),
                    'LastActivity' => date('Y-m-d H:i:s')
                ));

            } catch(Exception $e) {
                die($e->getMessage());
            }
            Session::flash('registerSuccessfully','You registered succesfully! Now you can login ');
            Redirect::to('home');
        }
        else {
            foreach($validation->errors() as $error) {
                echo $error . '<br>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
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
						Welcome
					</span>
                <span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>

                <div class="wrap-input100 ">
                    <input class="input100" type="text" name="firstname"  id="firstname">
                    <span class="focus-input100" data-placeholder="Firstname"></span>
                </div>
                <div class="wrap-input100 " data-validate = "">
                    <input class="input100" type="text" name="lastname" id="lastname">
                    <span class="focus-input100" data-placeholder="Lastname"></span>
                </div>
                <div class="wrap-input100 " data-validate = "">
                    <input class="input100" type="email" name="email" id="email">
                    <span class="focus-input100" data-placeholder="Email"></span>
                </div>
                <div class="wrap-input100 " data-validate = "">
                    <input class="input100" type="text" name="username" id="username">
                    <span class="focus-input100" data-placeholder="Username"></span>
                </div>

                <div class="wrap-input100" data-validate="">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                    <input class="input100" type="password" name="password" id="password">
                    <span class="focus-input100" data-placeholder="Password"></span>
                </div>
                <div class="wrap-input100 " data-validate="">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                    <input class="input100" type="password" name="password_again" id="password_again">
                    <span class="focus-input100" data-placeholder="Confirm password"></span>
                </div>

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button class="login100-form-btn" type="submit">
                            Register
                        </button>
                    </div>
                </div>
                <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                <div class="text-center p-t-115">
						<span class="txt1">
							Does you have an account?
						</span>

                    <a class="txt2" href="login">
                        Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="assets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="assets/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="assets/vendor/bootstrap/js/popper.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="assets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="assets/vendor/daterangepicker/moment.min.js"></script>
<script src="assets/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="assets/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="assets/js/main.js"></script>

</body>
</html>

