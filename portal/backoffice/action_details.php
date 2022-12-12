<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];
    $booking_id = $_GET["request_id"];
    $user_name = $_GET["user_id"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }
    if($booking_id == ""){
        header("Location:all_schedule_list.php");
    }
    //check value in cart
    /*$query_get_rtps = mysqli_query($connection, "SELECT COUNT(*) AS 'notification' FROM `leave_module` WHERE `status`= 'Pending'");
    while($data = mysqli_fetch_array($query_get_rtps)){
         $total = $data['notification'];     
    }*/
    //get user information and prepare for display
    $query_get_details = mysqli_query($connection, "SELECT * FROM `users` WHERE `username` = '".$user_login_id."'");
    while($row = mysqli_fetch_array($query_get_details)){
        $names = $row['fullnames']; 
        $employee_id = $row["username"];
        $user_role = $row["role"];     
    }
    $query_get_client = mysqli_query($connection, "SELECT u.NRC, u.fullnames, b.reason, b.date_from, b.date_to, b.status, b.car_id, b.booking_id, u.username FROM users u, bookings b WHERE u.username = b.user_id AND b.status = 'Pending' AND b.user_id = 'josephlungu18@gmail.com' AND b.booking_id = 'REF26025034'");
    
    while($rows = mysqli_fetch_array($query_get_client)){
        $nrc_id = $rows['NRC']; 
        $names = $rows['fullnames'];
        $description = $rows['reason'];
        $date_from_ = $rows['date_from'];
        $date_to_ = $rows['date_to'];
        $status_id = $rows['status'];
        $car_name = $rows['car_id'];        
    }
    //Button Click here
    if(isset($_POST["submit_button"])){
        $full_names = $_POST["names"];
        $phone_number = $_POST["phone_id"];
        $email_address = $_POST["email_id"];
        $nrc_number = $_POST["nrc_id"];
        $address_residential = $_POST["address"];
        $country_nation = $_POST["country"];
        $town = $_POST["city"];

        $query_update_user = "UPDATE `users` SET `fullnames`='".$full_names."',`phonenumber`='".$phone_number."',`email`='".$email_address."',`nrc`='".$nrc_number."',`address`='".$address_residential."',`country`='".$country_nation."',`city`='".$town."',`date`='".date("Y-m-d")."' WHERE `username`='".$_GET["id"]."'";                       
        if(mysqli_query($connection, $query_update_user)){
            $error_message = '<b style="color: #00FF00;">Details updated successfully</b>';
        }
        else{
            $error_message = '<b style="color: #FF0000;">Failed to update user, '.$full_names.'. Try again</b>';
        }        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <title>Portal | Action</title>
</head>
<body>
    <header>
        <div class="sub-header">
            <div class="contact-holder">  
                <div id="phone-holder">
                    <span><img style="width: 35px; height: 35px; margin-top: -9px;" src="../images/profile.png" alt="profile"/><i><?php echo $names; ?></i></span><br />
                </div>              
                <div id="reg-holder">
                    <?php
                            echo '<span><a href="logout.php" id="apply-id" class="button-clicks">Sign Out</a></span> <span><a href="flaged-reviews.php" id="apply-id" class="button-clicks">Reports <sup><label style="font-weight: bold;">'.$total.'</label></sup></a></span>';

                    ?>
                                        
                </div>
            </div>
        </div>
        <div class="main-header">
            <div class="nav-holder">
                <div id="logo-div">
                    <img src="../../assets/images/logo/logo.png" alt="logo">
                </div>
                <nav>
                    <ul>
                        <li><a href="admin-home.php">Dashboard</a></li>
                        <?php
                            echo '<li><a href="employees-list.php">Employees</a></li>
                            <li><a href="all_schedule_list.php">Schedule</a></li>
                            <li><a href="security.php">Security</a></li>
                            <li><a href="inspection.php">Inspection</a></li>
                            <li><a href="admin-home.php">Reports</a></li>';                                    
                        ?>                      
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <section>
        <div class="rolling-images">
            <div class="profile-img">
                <img style="width: 80px; height: 80px" src="../images/pending.png" alt="profile_image"/>
            </div>
            <div class = "profile_details">
                <span>Request details</span>
                <hr/><br/>  
                <form method="post" action="action_details.php">          
                    <input id="search-id" type="text" name="nrc" class="inputs" value="<?php echo $nrc_id; ?>" style="text-align: center;" readonly />
                    <input id="search-id" type="text" name="fullnames" class="inputs" value="<?php echo $names; ?>" style="text-align: center;" readonly /><br/><br/>
                    <input id="search-id" type="text" name="reason" class="inputs" value="<?php echo $description; ?>" style="text-align: center;" readonly />
                    <input id="search-id" type="text" name="status" class="inputs" value="<?php echo $status_id; ?>" style="text-align: center;" readonly /><br/><br/>
                    <input id="search-id" type="text" name="car_id" class="inputs" value="<?php echo $car_name; ?>" style="text-align: center;" readonly />
                    <input id="search-id" type="text" name="ref_id" class="inputs" value="<?php echo $booking_id; ?>" style="text-align: center;" readonly /><br/><br/>
                    <label><i>Displays start and end date below</i></label><br />
                    <input id="search-id" type="text" name="start_date" class="inputs" value="<?php echo $date_from_; ?>" style="text-align: center;" readonly />
                    <input id="search-id" type="text" name="end_date" class="inputs" value="<?php echo $date_to_; ?>" style="text-align: center;" readonly /><br/><br/>
                    <a href="contract-detils.php?user=<?php echo $user_name; ?>" target="_blank" >View contract details</a><br/><br/>
                    
                    <input id="submit-id" type="submit" name="approve-button" value="Approve"/>
                    <input id="submit-id" type="submit" name="reject-button" value="Decline"/>
                    
                </form>
            </div>        
        </div>
    </section>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF;"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>     
</body>
</html>