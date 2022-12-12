<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    require_once "commonMethods/mainClass.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }
    //check pending requests
    $query_get_rtps = mysqli_query($connection, "SELECT COUNT(*) AS 'notification' FROM `student_book_bus` WHERE `status_id`= 1");
    while($data = mysqli_fetch_array($query_get_rtps)){
         $total = $data['notification'];     
    }
    //get user information and prepare for display
    $query_get_details = mysqli_query($connection, "SELECT bk.user_id, bk.username, bk.status_id, bk.role_id, bk.emp_id, em.first_name, em.last_name, em.phone_number, em.email_address, em.home_address, em.nrc, em.drivers_license 
    FROM `backoffice_user` bk, `employee` em
    WHERE bk.emp_id = em.emp_id AND bk.username = '".$user_login_id."'");
    while($row = mysqli_fetch_array($query_get_details)){
        $names = $row['first_name']." ".$row['last_name']; 
        $employee_id = $row["username"];
        $user_role = $row["role_id"];     
    }
    $error_message = "";

    if(isset($_POST["signup-button"])){

        $studentNo = $_POST["student_no"];
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $nrc_number = $_POST["nrc_no"];
        $number = $_POST["phone_no"];
        $mail = $_POST["email_address"];
        $programme = $_POST["programme_of_study"];
        $modeOfStudy = $_POST["mode_of_study"];
        $address = $_POST["home_address"];
        $statusId = 1;//Active by default
        $roleId = $_POST["roles"];
        $createdBy = $_SESSION["logged_user"];
        $pass_key = $_POST["password"];
        $confirm_pass_key = $_POST["con_password"];

        if(!empty($studentNo) || !empty($firstName) || !empty($lastName) || !empty($nrc_number) || !empty($mail) || !empty($number) || !empty($programme) || !empty($modeOfStudy) || !empty($address) || !empty($confirm_pass_key)){
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)){
                if($pass_key == $confirm_pass_key){
                    if(strlen($pass_key) >= 4){
                        $hasshed_password = MD5($pass_key);
                        $hashed_confirm_password = MD5($confirm_pass_key);

                        $query_existing_user = mysqli_query($connection, "SELECT u.user_id, u.username, u.status_id, u.role_id, u.stud_id, s.first_name, s.last_name, s.phone_nO, s.email_address 
                        FROM `user` u, `student` s
                        WHERE u.stud_id = s.stud_id AND u.username = '".$user_name."'");

                        if($row = mysqli_fetch_array($query_existing_user)){
                              
                            $error_message = '<b style="color: red;">User with Username "'.$user_name.'" already in the system, <a href="sign-in.php"> Login</a></b>';
                        }
                        else{     
                            $query_insert_user = "INSERT INTO `student`(`student_no`, `first_name`, `last_name`, `nrc_no`, `phone_no`, `email_address`, `programme_of_study`, `mode_of_study`, `home_address`, `status_id`, `created_by`) 
                            VALUES ('".$studentNo."','".$firstName."','".$lastName."','".$nrc_number."','".$number."','".$mail."','".$programme."','".$modeOfStudy."','".$address."','".$statusId."','".$createdBy."')";                       
                            if(mysqli_query($connection, $query_insert_user)){
                                //Get student number and save student to user table
                                $student_user_query = "INSERT INTO `user`(`username`, `status_id`, `role_id`, `password`, `stud_id`, `created_by`) 
                                VALUES ('".$studentNo."','".$statusId."','".$roleId."','".$hasshed_password."','".getStudentBy($studentNo)."','".$createdBy."')";
                                if(mysqli_query($connection, $student_user_query)){
                                    $error_message = '<b style="color: #006600;">User '.$firstName.' has been added.</b>';
                                   // $_SESSION["error_sending"] = '<b style="color: #00FF00;">User '.$firstName.' has been added, but email not sent</b>';
                                    //Header("Location:../../sendMail.php?user=".$studentNo."&names=".$firstName." ".$lastName."&email=".$mail."&password=".$pass_key."");
                                }
                            }
                            else{
                                $error_message = '<b style="color: #00FF00;">Failed to add user, '.$studentNo.'. Try again</b>';
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <title>Portal | Register</title>
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
                    <img src="../../assets/images/logo/logo.jpg" alt="logo">
                </div>
                <nav>
                    <ul>
                    <li><a href="admin-home.php">Dashboard</a></li>
                        <?php
                            echo '<li><a href="clients-list.php">Employees</a></li>
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
        <div class="search-section">  
            <span><?php echo $error_message; ?></span><br />          
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input id="search-id" type="text" name="student_no" class="inputs" placeholder="Enter Student No.." style="text-align: center;" Required />
                <input id="search-id" type="text" name="first_name" class="inputs" placeholder="Enter Firstname.." style="text-align: center;" Required /><br/><br/>
                <input id="search-id" type="text" name="last_name" class="inputs" placeholder="Enter Lastname.." style="text-align: center;" Required />
                <input id="search-id" type="text" name="nrc_no" class="inputs" placeholder="Enter Nrc No.." style="text-align: center;" Required /><br/><br/>
                <input id="search-id" type="text" name="phone_no" class="inputs" placeholder="Enter Phone No.." style="text-align: center;" Required />
                <select class='selects' name='programme_of_study'>
                    <option disabled>Select Programme</option>
                    <option value="AFIN">Bachelor of Accountancy</option>
                    <option value="BBA">Bachelor of Business Administration</option>
                    <option value="BFIN">Bachelor of Banking and Finance</option>
                    <option value="ECF">Bachelor of Economics and Finance</option>
                    <option value="ECA">Bachelor of Economics</option>
                    <option value="LLB">Bachelor of Law</option>
                    <option value="BSPH">Bachelor of Public Health</option>
                    <option value="DRN">Diploma in Registered Nursing</option>
                    <option value="MBCHB">Bachelor of Medicine</option>
                </select><br/><br/>
                <select class='selects' name='mode_of_study'>
                    <option disabled>Select Mode of Study</option>
                    <option value="full time">Full time</option>
                    <option value="part time">Part time</option>
                    <option value="distance">Distance</option>                
                </select>
                <?php
                   getSystemRoles();
                ?>
                <input id="search-id" type="text" name="home_address" class="inputs" placeholder="Enter Home address.." style="text-align: center;" Required />
                <input id="search-id" type="text" name="email_address" class="inputs" placeholder="Enter Email Address.." style="text-align: center;" Required /><br/><br/>
                <input id="search-id" type="password" name="password" class="inputs" placeholder="Enter Password.." style="text-align: center;" Required />
                <input id="search-id" type="password" name="con_password" class="inputs" placeholder="Confirm Password.." style="text-align: center;" Required /><br/><br/>
                    
                <input id="submit-id" type="submit" name="signup-button" value="Register"/>                    
                </form>
            </div>
        </div>
    </section>
    <br/><br/>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF; margin-top: 10%"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>     
</body>
</html>