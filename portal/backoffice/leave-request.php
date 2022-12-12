<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../config-files/config.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:index.php");
    }
    //get user information and prepare for display
    $query_get_employee = mysqli_query($connection, "SELECT * FROM employee_data ed, users u WHERE ed.employee_id = u.NRC AND u.email = '".$user_login_id."'");
    while($rows = mysqli_fetch_array($query_get_employee)){
        $names = $rows['firstname']." ".$rows['lastname']; 
        $employee_id = $rows["NRC"];
        $fname = $rows['firstname'];
        $lname = $rows['lastname']; 
        $phone_id = $rows['Phone'];
        $email_id = $rows['email'];
        $nrc_id = $rows['NRC'];
        $dpt_id = $rows['department_id'];
        $post = $rows['position'];
        $type = $rows['attachment_type'];
        $date_end = $rows['ending_date'];
        $date_start = $rows['Date'];          
    }

    if(isset($_POST["leave-button"])){        
        $query_update_status = "INSERT INTO `leave_module`(`employeeID`, `description`, `date_from`, `date_to`, `status`, `date_applied`) VALUES ('".$_POST["employee_number"]."','".$_POST["description"]."','".$_POST["start_date"]."','".$_POST["end_date"]."','Pending','".date("d/m/Y")."')";
    
        if(mysqli_query($connection, $query_update_status)){
            header("Location: all_leave_list.php");
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
                    <span><img style="width: 35px; height: 35px; margin-top: -7px;" src="../images/profile.png" alt="profile"/><i><?php echo $names; ?></i></span><br />
                </div>              
                <div id="reg-holder">
                    <?php
                        echo '<span><a href="logout.php" id="apply-id" class="button-clicks">Sign Out</a></span>';
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
                        <li><a href="home.php">Dashboard</a></li>
                        <?php
                            echo '<li><a href="user-details.php">Profile</a></li>
                            <li><a href="leave-request.php">Leave Request</a></li>
                            <li><a href="user-evaluation.php">Evaluation</a></li>';
                                        
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
                <input id="search-id" type="text" name="employee_number" class="inputs" value="<?php echo $employee_id; ?>" style="text-align: center;" readonly />
                <input id="search-id" type="text" name="description" class="inputs" placeholder="Why you are applying.." style="text-align: center;" Required /><br/><br/>
                <label><i>Choose start and end date below</i></label><br />
                <input id="search-id" type="date" name="start_date" class="inputs" style="text-align: center;" Required />
                <input id="search-id" type="date" name="end_date" class="inputs" style="text-align: center;" Required /><br><br>
                
                <input id="submit-id" type="submit" name="leave-button" value="Request"/>
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