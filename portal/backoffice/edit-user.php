<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }
    if(empty($_GET["id"])){
        header("Location:clients-list.php");
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
    $query_get_client = mysqli_query($connection, "SELECT * FROM `users` WHERE `username` = '".$_GET["id"]."'");
    
    while($rows = mysqli_fetch_array($query_get_client)){
        $names_ = $rows['fullnames']; 
        $phone_id = $rows['phonenumber'];
        $email_id = $rows['email'];
        $nrc_id = $rows['nrc'];
        $adr_id = $rows['address'];
        $country_ = $rows['country'];
        $city_ = $rows['city'];
        $date_eng = $rows['date'];         
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
    
    <title>Portal | Edit</title>
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
                <img style="width: 80px; height: 80px" src="../images/default.png" alt="profile_image"/>
            </div>
            <div class = "profile_details">
                <form action="edit-user.php?id=<?php echo $_GET["id"];?>" method="post">
                    <span>Profile details</span>
                    <hr style="color: #006600" /><br/>
                    <span><?php echo $error_message; ?></span><br/>
                    <input id="search-id" type="text" name="names" class="inputs" value="<?php echo $names_; ?>" style="text-align: center;" placeholder="Names.." required/>
                    <input id="search-id" type="text" name="phone_id" class="inputs" value="<?php echo $phone_id; ?>" style="text-align: center;" placeholder="Phone No.." required/><br/><br/>
                    <input id="search-id" type="text" name="email_id" class="inputs" value="<?php echo $email_id; ?>" style="text-align: center;" placeholder="Email address.." required/>
                    <input id="search-id" type="text" name="nrc_id" class="inputs" value="<?php echo $nrc_id; ?>" style="text-align: center;" placeholder="Nrc number.." required/><br/><br/>
                    <span>Location details</span>
                    <hr style="color: #006600" /><br/>
                    <input id="search-id" type="text" name="address" class="inputs" value="<?php echo $adr_id; ?>" style="text-align: center;" placeholder="Address.." required/>
                    <input id="search-id" type="text" name="country" class="inputs" value="<?php echo $country_; ?>" style="text-align: center;" placeholder="Country.." required/><br/><br/>
                    <input id="search-id" type="text" name="city" class="inputs" value="<?php echo $city_; ?>" style="text-align: center;" placeholder="Province.." required/>
                    <br/><br/>  
                    <input id="" type="submit" name="submit_button" value="Update Details" />
                </form>              
            </div>        
        </div>
    </section>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF;"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>    
</body>
</html>