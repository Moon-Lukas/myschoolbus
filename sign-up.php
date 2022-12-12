<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "config-files/connectiondb.php";

    $error_message = "";

    if(isset($_POST["register"])){

        $user_name = $_POST["username"];
        $names = $_POST["fullnames"];
        $number = $_POST["phone"];
        $mail = $_POST["emailaddress"];
        $pass_key = $_POST["password"];
        $confirm_pass_key = $_POST["confirmpassword"];

        if(!empty($user_name) || !empty($names) || !empty($number) || !empty($mail) || !empty($pass_key) || !empty($confirm_pass_key)){
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                if($pass_key == $confirm_pass_key){
                    if(strlen($pass_key) >= 4){
                        $hasshed_password = MD5($pass_key);
                        $hashed_confirm_password = MD5($confirm_pass_key);

                        $query_existing_user = mysqli_query($connection, "SELECT * FROM `users` WHERE `username` = '".$user_name."'");

                        if($row = mysqli_fetch_array($query_existing_user)){
                              
                            $error_message = '<b style="color: red;">User with Username "'.$mail.'" already in the system, <a href="sign-in.php"> Login</a></b>';
                        }
                        else{     
                            $query_insert_user = "INSERT INTO `users`(`username`, `fullnames`, `phonenumber`, `email`, `nrc`,`role`,`address`, `country`, `city`, `password`, `date`) VALUES ('".$user_name."','".$names."','".$number."','".$mail."','Null','Client','Null','Null','Null','".$hasshed_password."','".date("Y-m-d")."')";                       
                            if(mysqli_query($connection, $query_insert_user)){
                                $_SESSION["error"] = '<b style="color: #00FF00;">User '.$names.' has been added, email sent to '.$mail.'</b>';
                                $_SESSION["error_sending"] = '<b style="color: #00FF00;">User '.$names.' has been added, but email not sent</b>';
                                Header("Location:sendMail.php?user=".$user_name."&names=".$names."&email=".$mail."&password=".$pass_key."");
                            }
                            else{
                                $error_message = '<b style="color: #00FF00;">Failed to add user, '.$names.'. Try again</b>';
                            }                            
                                
                        }
                    }
                    else{
                        $error_message = "<b style='color: #FF0000;'>Password should be atleast 4 characters</b>";
                    }
                }
                else{
                    $error_message = "<b style='color: #FF0000;'>Your password did not match</b>"; 
                }

            }
            else{
                $error_message = "<b style='color: #FF0000;'>Email address not valid</b>"; 
            }
        }
        else{
            $error_message = "<b style='color: #FF0000;'>Note: All fields are required</b>";
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

    <title>Check Mart | Sign Up</title>

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
                        <h3 class="title">Welcome to Checkmart ! Register here</h3>
                        <?php
                            if($_GET["session_key"] == 1){
                                $error_message = $_SESSION["error"];
                            }
                            else if($_GET["session_key"] == 2){
                                $error_message = $_SESSION["error_sending"];
                            }
                        ?>
                        <span><?php echo $error_message; ?></span><br />
                        <form class="sign-in-form" method="post" action="sign-up.php">
                            <div class="form-group">
                                <label for="email01">Username</label>
                                <input type="text" name="username" id="email01" placeholder="Enter your Username" required>
                            </div>
                            <div class="form-group">
                                <label for="email01">Full names</label>
                                <input type="text" name="fullnames" id="email01" placeholder="Enter your Fullnames" required>
                            </div>
                            <div class="form-group">
                                <label for="email01">Phone No.</label>
                                <input type="text" name="phone" id="email01" placeholder="Enter your Phone No" required>
                            </div>
                            <div class="form-group">
                                <label for="email01">Email Address</label>
                                <input type="text" name="emailaddress" id="email01" placeholder="Enter your Email" required>
                            </div>
                            <div class="form-group">
                                <label for="pass01">Password</label>
                                <div class="pass-item">
                                    <input type="password" id="pass01" name="password" placeholder="Please enter your password" required>
                                    <span class="view-pass" id="view-pass-01">
                                        <i class="flaticon-eye"></i>
                                    </span>
                                </div>
                                <br/>
                                <div class="pass-item">
                                    <input type="password" id="pass01" name="confirmpassword" placeholder="Confirm your password" required>
                                    <span class="view-pass" id="view-pass-01">
                                        <i class="flaticon-eye"></i>
                                    </span>
                                </div>
                                <p class="mt-2 d-flex flex-wrap justify-content-between"><a href="sign-in.php">Already have an account?</a></p>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="register" value="Register">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========footer-section========== -->
    <?php include("inc/footer.php"); ?>
    <!-- ==========footer-section========== -->


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