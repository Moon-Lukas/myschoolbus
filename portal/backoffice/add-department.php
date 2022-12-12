<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../config-files/config.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../index.php");
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
        $dpID = $_POST["depart_id"];
        $dpName = $_POST["depart_name"];
        $status_id = $_POST["status"];
        

        if(!empty($dpID) && !empty($dpName)){
            $query_existing_user = mysqli_query($connection, "SELECT * FROM `departments` WHERE `department_id` = '".$dpID."'");

            if($row = mysqli_fetch_array($query_existing_user)){
                              
                $error = '<span style="color: red;">Department with ID "'.$dpID.'" already in the system</span>';
            }
            else{                                
                $query_insert_n = "INSERT INTO `departments`(`department_id`, `department_name`, `status`) VALUES ('".$dpID."','".$dpName."','".$status_id."')";
                if(mysqli_query($connection, $query_insert_n)){
                    //$_SESSION["email_message"] = "<span>Hello, ".$full_names." You have registered";
                    header("Location:departments-list.php");  
                }                               
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
                    <input id="search-id" type="text" name="depart_id" class="inputs" placeholder="Enter Department ID.." style="text-align: center;" Required />
                    <input id="search-id" type="text" name="depart_name" class="inputs" placeholder="Enter Department Name.." style="text-align: center;" Required /><br/><br/>
                    <select class='selects' name='status'>
                        <option disabled>Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select><br/><br/>
                    
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