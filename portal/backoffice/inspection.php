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
            <a href="employee-list.php">
                <div class="report-divs" id="one">
                    <div class="inner-div">Employees</div>
                    <p>
                        <?php
                            $query_emp = mysqli_query($connection, "SELECT COUNT(*) AS 'employees' FROM `users`");
                            if($data = mysqli_fetch_array($query_emp)){
                                 echo $data['employees'];     
                            }
                        ?>
                    </p>
                </div>
            </a>
            <a href="departments-list.php">
                <div class="report-divs" id="two">
                    <div class="inner-div">Departments</div>
                    <p>
                        <?php
                            $query_dep = mysqli_query($connection, "SELECT COUNT(*) AS 'department' FROM `departments`");
                            if($data = mysqli_fetch_array($query_dep)){
                                echo $data['department'];     
                            }
                        ?>
                    </p>
                </div>
            </a>
            <a href="branches-list.php">
                <div class="report-divs" id="three">
                    <div class="inner-div">Branches</div>
                        <p>
                            <?php
                                $query_bra = mysqli_query($connection, "SELECT COUNT(*) AS 'branch' FROM `branches`");
                                if($data = mysqli_fetch_array($query_bra)){
                                    echo $data['branch'];     
                                }
                            ?>
                        </p>
                </div>
            </a>               
            
        </div>
    </section>
    <footer>
        <div>
            <span>&copy; <?php echo date("Y");?> ZANIS<br />All Rights Reserved<br/><i>Developed by Isaiah Chimwala</i></span>
        </div>
    </footer>    
</body>
</html>