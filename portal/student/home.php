<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }   
    //get user information and prepare for display
    $query_get_details = mysqli_query($connection, "SELECT * FROM `users` WHERE `username` = '".$user_login_id."'");
    while($row = mysqli_fetch_array($query_get_details)){
        $names = $row['fullnames']; 
        $employee_id = $row["username"];
        $user_role = $row["role"];     
    }

    if($user_role != "Client"){
        header("Location:../administrator/admin-home.php");
    }

    $query_get_rtps = mysqli_query($connection, "SELECT COUNT(*) AS 'notification' FROM `bookings` WHERE `status`= 'Pending' AND expired='No'");
    while($data = mysqli_fetch_array($query_get_rtps)){
         $total = $data['notification'];     
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <title>Portal | Home</title>
</head>
<body>
    <header>
        <div class="sub-header">
            <div class="contact-holder">  
                <div id="phone-holder">
                    <span><img style="width: 35px; height: 35px; margin-top: -7px;" src="../images/profile.png" alt="profile"/><i><?php echo $names; ?></i></span><br />
                </div>              
                <div id="reg-holder">
                    <?php
                        echo '<span><a href="logout.php" id="apply-id" class="button-clicks">Sign Out</a></span><img src="../images/icons8-notification-20.png" /><sup style="color: #FFFFFF; font-weight: bold;">'.$total.'</sup>';
                    ?>
                                        
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="nav-holder">
                <div id="logo-div">
                    <img src="../../assets/images/logo/logo.jpg" alt="logo">
                </div>
                <nav>
                    <ul>
                        <li><a href="home.php">Dashboard</a></li>
                        <?php
                            echo '<li><a href="user-details.php">Profile</a></li>
                            <li><a href="booking-request.php">Bookings</a></li>
                            <li><a href="Booking-history.php">Booking History</a></li>
                            <li><a href="contract.php">Contract</a></li>';
                                        
                        ?>                     
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <section>
        <div class="rolling-images">
        <a href="all_booking_list.php">
                <div class="leave-divs" id="four">
                    <div class="inner-div">Booking Pending</div>
                    <p>
                        <?php
                            $query_pending = mysqli_query($connection, "SELECT COUNT(*) AS 'pending' FROM `bookings` WHERE `status` = 'Pending' AND expired='No' AND `user_id`='".$user_login_id."'");
                            if($data = mysqli_fetch_array($query_pending)){
                                echo $data['pending'];     
                            }
                        ?>
                    </p>
                </div>
            </a>
            <a href="booking-approved.php">
                <div class="leave-divs" id="five">
                        <div class="inner-div">Booking Approved</div>
                        <p>
                            <?php
                                $query_approved = mysqli_query($connection, "SELECT COUNT(*) AS 'approved' FROM `bookings` WHERE `status` = 'Approved' AND `user_id`='".$user_login_id."'");
                                if($data = mysqli_fetch_array($query_approved)){
                                    echo $data['approved'];     
                                }
                            ?>
                        </p>
                </div>
            </a>
            <a href="booking-declined.php">
                <div class="leave-divs" id="six">
                    <div class="inner-div">Booking Declined</div>
                    <p>
                    <?php
                        $query_declined = mysqli_query($connection, "SELECT COUNT(*) AS 'declined' FROM `bookings` WHERE `status` = 'Declined' AND `user_id`='".$user_login_id."'");
                        if($data = mysqli_fetch_array($query_declined)){
                            echo $data['declined'];     
                        }
                    ?>
                    </p>
                </div>
            </a>
        </div>
    </section>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF;"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>     
</body>
</html>