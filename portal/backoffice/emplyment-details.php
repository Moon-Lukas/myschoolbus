<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../config-files/config.php";
    $user_login_id = $_SESSION["username"];
    $nrc_id = $_GET["nrc"];

    $full_names = $_GET["names"];

    if($user_login_id == ""){
        header("Location:../index.php");
    }
    if(empty($nrc_id)){
        header("Location:add-users.php");
    }
        //check value in cart
    $query_get_rtps = mysqli_query($connection, "SELECT COUNT(*) AS 'notification' FROM `leave_module` WHERE `status`= 'Pending'");
    while($data = mysqli_fetch_array($query_get_rtps)){
         $total = $data['notification'];     
    }
    //get user information and prepare for display
    $query_get_details = mysqli_query($connection, "SELECT * FROM `administrators` WHERE `username` = '".$user_login_id."'");
    while($row = mysqli_fetch_array($query_get_details)){
        $names = $row['fullnames'];
        $user_role = $row['role'];        
    }
    $error = "";

    if(isset($_POST["signup-button"])){
        $depart = $_POST["department"];
        $user_role = $_POST["role"];
        $user_salary = $_POST["salary"];
        $qualif = $_POST["qualification"];
        $attach = $_POST["attach_type"];
        $date = $_POST["date_to"];

        if(!empty($depart) && !empty($user_role) && !empty($user_salary) && !empty($qualif) && !empty($attach) && !empty($date)){

            $query_existing_user = mysqli_query($connection, "SELECT * FROM `employee_data` WHERE `employee_id` = '".$_SESSION["nrc_identity"]."'");

            if($row = mysqli_fetch_array($query_existing_user)){
                              
                $error = '<span style="color: red;">User with Username "'.$_SESSION["nrc_identity"].'" already in the system</span>';
            }
            else{                                
                $query_insert_n = "INSERT INTO `employee_data`(`employee_id`, `department_id`, `position`, `qualification`, `attachment_type`, `ending_date`) VALUES ('".$_SESSION["nrc_identity"]."','".$depart."','".$user_role."','".$qualif."','".$attach."','".$date."')";
                if(mysqli_query($connection, $query_insert_n)){
                    //$_SESSION["email_message"] = "<span>Hello, ".$full_names." You have registered";
                    header("Location:employee-list.php");  
                }                               
            }
        }
        //echo "Register normal";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <title>HR | Home</title>
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
                    <img src="../images/logo.jpg" alt="logo">
                </div>
                <nav>
                    <ul>
                        <li><a href="admin-home.php">Dashboard</a></li>
                        <?php
                            echo '<li><a href="employee-list.php">Employee</a></li>
                            <li><a href="all_leave_list.php">Leave Module</a></li>
                            <li><a href="evaluation.php">Evaluation</a></li>
                            <li><a href="organization.php">Organization</a></li>
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

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <?php
                        $sql_depart = "SELECT * FROM `departments`";
                        $sql_query_depart = mysqli_query($connection, $sql_depart);
                        
                        echo "<select class='selects' name='department'>";
                        while($rows = mysqli_fetch_array($sql_query_depart)){
                            echo "<option value='".$rows['department_id']."'>".$rows['department_name']."</option>";
                        }
                        echo "</select>";
                    ?> 
                    <?php
                        $sql_role = "SELECT * FROM `roles`";
                        $sql_query_role = mysqli_query($connection, $sql_role);
                        
                        echo "<select class='selects' name='role'>";
                        while($rows = mysqli_fetch_array($sql_query_role)){
                            echo "<option value='".$rows['name']."'>".$rows['name']."</option>";
                        }
                        echo "</select>";
                    ?> <br/><br/>
                    <input id="search-id" type="number" name="salary" class="inputs" placeholder="Enter Gross Salary.." style="text-align: center;" Required min="0"/>
                    <select class='selects' name='qualification'>
                        <option disabled>Select Qualification</option>
                        <option value="General">General</option>
                        <option value="Certiicate">Certificate</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Degree">Degree</option>
                        <option value="Masters">Masters</option>
                        <option value="Doctoral">Doctoral</option>
                    </select><br/><br/>
                    <select class='selects' name='attach_type'>
                        <option disabled>Select Attachment type</option>
                        <option value="internship">Internship</option>
                        <option value="Contract">Contract</option>
                        <option value="Permanent">Permanent</option>
                    </select>
                    <input id="search-id" type="date" name="date_to" class="inputs" style="text-align: center;" Required /><br/><br/>

                    <input id="submit-id" type="submit" name="signup-button" value="Submit"/>
                </form>
            </div>
        </div>
    </section>
    <footer>
        <div>
            <span>&copy; <?php echo date("Y");?> ZANIS<br />All Rights Reserved<br/><i>Developed by Isaiah Chimwala</i></span>
        </div>
    </footer>    
</body>
</html>