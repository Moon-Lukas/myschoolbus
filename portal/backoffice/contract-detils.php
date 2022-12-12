<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }
    if(empty($_GET["user"])){
        header("Location:action_details.php");
    }
    //get user information and prepare for display
    $query_get_employee = mysqli_query($connection, "SELECT * FROM contracts c, users u WHERE c.user_id = u.username AND c.user_id = '".$_GET["user"]."'");
    while($rows = mysqli_fetch_array($query_get_employee)){
        $names_ = $rows['fullnames']; 
        $phone_id = $rows['phonenumber'];
        $email_id = $rows['email'];
        $nrc_id = $rows['nrc'];
        $adr_id = $rows['address'];
        $country_ = $rows['country'];
        $city_ = $rows['city'];
        $date_eng = $rows['date'];
        $drivers_license = $rows['drivers_license'];
        $employer = $rows['employer'];
        $empdetails = $rows['employer_address'];       
    }
    $enable_edit = "readonly";
    $enable_button = "";
    $update_button = "hidden";
    if(isset($_POST["enable-button"])){
        $enable_edit = "";//remeoves the readonly property
        $enable_button = "hidden";
        $update_button = "";
    }
    else if(isset($_POST["edit-button"])){  
        $drivers_license = $_POST["license"];
        $employer_name = $_POST["employerid"];
        $employer_address = $_POST["employerdetails"];
        $payment = $_POST["payid"];
        $status = $_POST["Active"];        

        $rand_value = rand(100,10000);        
        $con_id = "CON".$rand_value.date("s").date("i");//i = gets minutes

        $query_existing_contract = mysqli_query($connection, "SELECT * FROM `contracts` WHERE `user_id` = '".$_GET["user"]."'");

        if($row = mysqli_fetch_array($query_existing_contract)){
            $query_update_contract = "UPDATE `contracts` SET `contract_id`='".$con_id."',`drivers_license`='".$drivers_license."',`employer`='".$employer_name."',`employer_address`='".$employer_address."',`payment_type`='".$payment."' WHERE `user_id` = '".$_GET["user"]."'";                       
            if(mysqli_query($connection, $query_update_contract)){
                ?>
                    <script>window.alert("You have update your details");</script>;
                <?php
                $enable_edit = "readonly";
                $update_button = "hidden";
                $enable_button = "";
            }
        }else{
            $query_insert_contrator = "INSERT INTO `contracts`(`contract_id`, `user_id`, `drivers_license`, `employer`, `employer_address`,`payment_type`, `status`) VALUES ('".$con_id."','".$user_login_id."','".$drivers_license."','".$employer_name."','".$employer_address."','".$payment."','Active')";                       
            if(mysqli_query($connection, $query_insert_contrator)){
                ?>
                    <script>window.alert("You have added the contracts details");</script>;
                <?php
                $enable_edit = "readonly";
                $update_button = "hidden";
                $enable_button = "";
                
            }
            else{
                ?>
                    <script>window.alert("Failed to add details");</script>;
                <?php                
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
    
    <title>Portal | Contract Details</title>
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
                <img style="width: 80px; height: 80px" src="../images/contract.png" alt="profile_image"/>
            </div>
            <div class = "profile_details">
                
                <span><b>Contract details</b></span>
                <hr style="color: #006600" /><br/>
                <form method="post" action="contract.php">
                    <input id="search-id" type="text" name="names" class="inputs" value="<?php echo $names_; ?>" style="text-align: center;" <?php echo $enable_edit; ?> />
                    <input id="search-id" type="text" name="phone_id" class="inputs" value="<?php echo $phone_id; ?>" style="text-align: center;" <?php echo $enable_edit; ?> /><br/><br/>
                    <input id="search-id" type="text" name="email_id" class="inputs" value="<?php echo $email_id; ?>" style="text-align: center;" <?php echo $enable_edit; ?> />
                    <input id="search-id" type="text" name="nrc_id" class="inputs" value="<?php echo $nrc_id; ?>" style="text-align: center;" <?php echo $enable_edit; ?> /><br/><br/>
                    <input id="search-id" type="text" name="address" class="inputs" value="<?php echo $adr_id; ?>" style="text-align: center;" <?php echo $enable_edit; ?> placeholder="Residential Address.." />
                    <input id="search-id" type="text" name="license" class="inputs" value="<?php echo $drivers_license; ?>" style="text-align: center;" <?php echo $enable_edit; ?> placeholder="Drivers License.." /><br/><br/>
                    <span><b>Account details</b></span>
                    <hr style="color: #006600" /><br/>
                    <input id="search-id" type="text" name="country" class="inputs" value="<?php echo $country_; ?>" style="text-align: center;" <?php echo $enable_edit; ?> />
                    <input id="search-id" type="text" name="city" class="inputs" value="<?php echo $city_; ?>" style="text-align: center;" <?php echo $enable_edit; ?>  /><br/><br/>
                    <span><b>Employers details</b></span>
                    <hr style="color: #006600" /><br/>
                    <input id="search-id" type="text" name="employerid" class="inputs" value="<?php echo $employer; ?>" style="text-align: center;" <?php echo $enable_edit; ?> placeholder="Employer.."/>
                    <input id="search-id" type="text" name="employerdetails" class="inputs" value="<?php echo $empdetails; ?>" style="text-align: center;" <?php echo $enable_edit; ?> placeholder="Employer Address.."  /><br/><br/>
                    <span><b>Payment Type</b></span>
                    <hr style="color: #006600" /><br/>
                    <select class="selects" name="payid">
                        <option value="" disabled>Select Mode of Payment</option>
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="BankTransfer">Bank Transfer</option>
                        <option value="CreditCard">Cash</option>
                        <option value="Other">Other</option>
                    </select><br><br>

                    <input id="submit-id" type="submit" name="enable-button" value="Enable Editing" <?php echo $enable_button; ?> />
                    <input id="submit-id" type="submit" name="edit-button" value="Confirm" <?php echo $update_button; ?> />
                    <br /><span><i>Note that all details above have to be provided, to be eligible to make a booking.</i></span>
                </form>
            </div>        
        </div>
    </section>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF;"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>    
</body>
</html>