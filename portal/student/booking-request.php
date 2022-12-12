<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }   
    //get user information and prepare for display
    //get user information and prepare for display
    $query_get_details = mysqli_query($connection, "SELECT * FROM `users` WHERE `username` = '".$user_login_id."'");
    while($row = mysqli_fetch_array($query_get_details)){
        $names = $row['fullnames']; 
        $employee_id = $row["username"];
        $user_role = $row["role"];     
    }
    /*(isset($_POST["leave-button"])){        
        $query_update_status = "INSERT INTO `leave_module`(`employeeID`, `description`, `date_from`, `date_to`, `status`, `date_applied`) VALUES ('".$_POST["employee_number"]."','".$_POST["description"]."','".$_POST["start_date"]."','".$_POST["end_date"]."','Pending','".date("d/m/Y")."')";
    
        if(mysqli_query($connection, $query_update_status)){
            header("Location: all_leave_list.php");
        }   
    }
    $query_get_rtps = mysqli_query($connection, "SELECT COUNT(*) AS 'notification' FROM `leave_module` WHERE `status`= 'Pending' AND employeeID='".$employee_id."'");
    while($data = mysqli_fetch_array($query_get_rtps)){
         $total = $data['notification'];     
    }*/
if(isset($_POST["request-button"])){
    $id_name = $_POST["user_name"];
    $id_car = $_POST["cars_id"];
    $dest_from = $_POST["destinationfrom"];
    $dest_to = $_POST["destinationto"];
    $date_from = $_POST["start_date"];
    $date_to = $_POST["end_date"];

    if($date_from > $date_to){
        $error_message = '<span style="color: red;"><b>Date from</b> can\'t be later than <b>Date to</b></span>';
    }
    else{
        $rand_value = rand(100,10000);        
        $book_id = "REF".$rand_value.date("s").date("i");//i = gets minutes
        
        $query_insert_details = "INSERT INTO `bookings`(`booking_id`, `car_id`, `user_id`, `reason`, `date_from`, `date_to`, `status`,`expired`) VALUES ('".$book_id."',".$id_car.",'".$id_name."','".$dest_from." ".$dest_to."','".$date_from."','".$date_to."','Pending','No')";                       
        if(mysqli_query($connection, $query_insert_details)){            
            $error_message = '<b style="color: #00FF00;">You have successfully booked a car and your Booking ID is '.$book_id.'</b>';
            Header("Location: all_booking_list.php");
        }
        else{
            $error_message = '<b style="color: #00FF00;">There was an error, Try again</b>';
        }     
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
    
    <title>Portal | Book</title>
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
                        echo '<span><a href="logout.php" id="apply-id" class="button-clicks">Sign Out</a></span> <img src="../images/icons8-notification-20.png" /><sup style="color: #FFFFFF; font-weight: bold;">'.$total.'</sup>';
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
        <div class="search-section">
            <span><?php echo $error_message; ?></span><br />  
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input id="search-id" type="text" name="user_name" class="inputs" value="<?php echo $employee_id; ?>" style="text-align: center;" readonly />
                <?php
                        $sql_roles = "SELECT * FROM `cars`";
                        $sql_query_list = mysqli_query($connection, $sql_roles);
                        
                        echo "<select class='selects' name='cars_id'>
                        <option value='' disabled>Select Car</option>";
                        while($rows = mysqli_fetch_array($sql_query_list)){
                            echo "<option value='".$rows['id']."'>".$rows['car_name']."</option>";
                        }
                        echo "</select><br><br>";
                    ?> 
                <input id="search-id" type="text" name="destinationfrom" class="inputs" placeholder="Distination from (Description).." style="text-align: center;" Required />
                <input id="search-id" type="text" name="destinationto" class="inputs" placeholder="Destination to.." style="text-align: center;" Required /><br/><br/>
                <label><i>Choose start and end date below</i></label><br />
                <input id="search-id" type="date" name="start_date" class="inputs" style="text-align: center;" Required />
                <input id="search-id" type="date" name="end_date" class="inputs" style="text-align: center;" Required /><br><br>
                
                <input id="submit-id" type="submit" name="request-button" value="Request"/>
            </form>
    </div>
    </div>
    </section>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF;"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer> 
</body>
</html>