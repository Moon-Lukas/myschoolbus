<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    include "config-files/connectiondb.php";


    $error = "";

    if(isset($_POST["submit"])){
        $userID = $_POST["username"];
        $passkey = $_POST["password"];
        $hashed_key = md5($passkey);
        echo $hashed_key;
        if(!empty($userID) && !empty($passkey)){
            $select_user = mysqli_query($connection,"SELECT * FROM `backoffice_user` WHERE `username` = '".$userID."' AND `password` ='".$hashed_key."'");

            if(mysqli_num_rows($select_user) > 0){
                session_start();
                $_SESSION["username"] = $userID;
                Header("Location:portal/backoffice/admin-home.php");
            }
            else{
                $error = '<span style="color: red;">Wrong username or password. <a href="sign-up.php">Sign Up</a></span>';
            }
        }
        else{
            $error = '<span style="color: red;">All fields must be set</span>';
        }
    }
 ?>
<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/lightcase.css">
    <link rel="stylesheet" href="assets/css/odometer.css">
    <link rel="stylesheet" href="assets/css/swiper.min.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">

    <title>Skoolbus | Sign In</title>

</head>

<body>
    <!-- ==========Preloader========== -->
    <div class="preloader">
        <div class="preloader-wrapper">
            <img src="assets/css/loaders.gif" alt="car-loader">
        </div>
    </div>
    <!-- ==========Preloader========== -->

    <!-- ==========scrolltotop========== -->
    <a href="#0" class="scrollToTop" title="ScrollToTop">
        <img src="assets/images/rocket.png" alt="rocket">
    </a>
    <!-- ==========scrolltotop========== -->

    <!-- ==========header-section========== -->
    <?php include("inc/header.php"); ?>

    <!-- ===========Header Cart=========== -->
    <div id="body-overlay" class="body-overlay"></div>
    <!-- ==========privacy-section========== -->
    <section class="account-section padding-top padding-bottom">
        <div class="container" style="margin-left: 30%;">
            <div class="row">
                <div class="col-md-6">
                    <div class="sign-in-form-area">
                        <span><?php echo $error; ?></span><br/>
                        <form class="sign-in-form" method="post" action="backoffice-in.php">
                            <div class="form-group">
                                <label for="email01">Username</label>
                                <input type="text" name="username" id="email01" placeholder="Enter your Username">
                            </div>
                            <div class="form-group">
                                <label for="pass01">Password</label>
                                <div class="pass-item">
                                    <input type="password" id="pass01" name="password" placeholder="Please enter your password">
                                    <span class="view-pass" id="view-pass-01">
                                        <i class="flaticon-eye"></i>
                                    </span>
                                </div>
                                <p class="mt-2 d-flex flex-wrap justify-content-between"><a href="sign-up.php">New Student? Register Here</a><a href="#0"> Forgot Password?</a></p>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="sign in">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <script src="assets/js/jquery.ripples-min.js"></script>
    <script src="assets/js/lightcase.js"></script>
    <script src="assets/js/swiper.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/countdown.min.js"></script>
    <script src="assets/js/odometer.min.js"></script>
    <script src="assets/js/viewport.jquery.js"></script>
    <script src="assets/js/nice-select.js"></script>
    <script src="assets/js/main.js"></script>
</body>


<!-- sign-in.html  22 Nov 2019 04:18:19 GMT -->
</html>