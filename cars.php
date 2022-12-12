<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    //session_start();

    include "config-files/connectiondb.php";

    $index = $_GET["id"];
    
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

    <title>Check Mart | Home</title>

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
    <!-- ==========header-section========== -->
    <!-- ==========banner-section========== -->
    <section class="banner-section bg_img" data-background="assets/images/banner/checkmart-background.jpg">
        <div class="container">
            <div class="banner-content mx-auto text-center">                
                <h1 class="title wow fadeInDown" data-wow-duration="1.5s">Check our fleet</h1>
                <p class="wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s">Checkmart Security and Travel Tours is an emerging Security and car rental Company that is owned by Local Zambians.</p>
                <div class="button-group justify-content-center wow fadeInUp" data-wow-delay="1s" data-wow-duration="1s">
                    <a href="book.php?id=<?php echo $index;?>" class="custom-button">Book a car?</a>
                    <a href="security-services.php" class="custom-button active">Security?</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ==========banner-section========== -->
    <section class="course-section padding-top padding-bottom">        
            <?php
                if(is_numeric($index)){
                    $break = 0;
                    $query_cars = mysqli_query($connection, "SELECT * FROM `cars` WHERE `id`='".$index."'");
                    while($row = mysqli_fetch_array($query_cars)){
                        if($break == 0 || $break % 3 == 0){                        
                        echo '<div class="container">
                        <div class="row justify-content-center mb-30-none"><div class="col-md-6 col-sm-10 col-lg-4">
                        ';
                        }
                        echo '<div class="course-item">
                            <div class="c-thumb course-thumb">
                                <a href="car-details.php?id='.$row["id"].'">
                                    <img src="'.$row["car_image_url"].'" alt="cars">
                                </a>
                                <div class="price-tag">                                
                                    <span class="time">New</span>
                                </div>
                            </div>
                            <div class="course-content">
                                <h3 class="title">'.$row["brand_name"].'</h3>
                                <p>'.$row["car_name"].'</p>
                            </div>
                        </div>
                        </div>';
                        if($break == 0 || $break % 3 == 0){
                        echo '</div>
                        </div>';
                        }
                    }
                }
                else{
                    header("Location:index.php");
                }
            ?>            
    </section>
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
</html>
