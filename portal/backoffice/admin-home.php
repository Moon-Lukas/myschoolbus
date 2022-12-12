<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
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
        $_SESSION["logged_user"] = $row["emp_id"];    
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
                            echo '<li><a href="employees-list.php">Employees</a></li>
                            <li><a href="student-list.php">Students</a></li>
                            <li><a href="all_schedule_list.php">Schedule</a></li>
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
            <a href="clients-list.php">
                <div class="report-divs" id="one">
                    <div class="inner-div">Students</div>
                    <p>
                        <?php
                            $query_emp = mysqli_query($connection, "SELECT COUNT(*) AS 'students' FROM `student` WHERE `status_id`=1");
                            if($data = mysqli_fetch_array($query_emp)){
                                 echo $data['students'];     
                            }
                        ?>
                    </p>
                </div>
            </a>
            <a href="employees-list.php">
                <div class="report-divs" id="two">
                    <div class="inner-div">Employees</div>
                    <p>
                        <?php
                            $query_dep = mysqli_query($connection, "SELECT COUNT(*) AS 'employees' FROM `employee` WHERE `status_id`=1");
                            if($data = mysqli_fetch_array($query_dep)){
                                echo $data['employees'];     
                            }
                        ?>
                    </p>
                </div>
            </a>
            <a href="cars-list.php">
                <div class="report-divs" id="three">
                    <div class="inner-div">All Buses</div>
                        <p>
                            <?php
                                $query_bra = mysqli_query($connection, "SELECT COUNT(*) AS 'schoolbuses' FROM `sch_bus` WHERE `bus_status_id`=1");
                                if($data = mysqli_fetch_array($query_bra)){
                                    echo $data['schoolbuses'];     
                                }
                            ?>
                        </p>
                </div>
            </a>                
            <br><br>
            <a href="all_schedule_list.php">
                <div class="leave-divs" id="four">
                    <div class="inner-div">Pending Bookings</div>
                    <p>
                        <?php
                            $query_pending = mysqli_query($connection, "SELECT COUNT(*) AS 'pending' FROM `student_book_bus` WHERE `status_id` = 1");
                            if($data = mysqli_fetch_array($query_pending)){
                                echo $data['pending'];     
                            }
                        ?>
                    </p>
                </div>
            </a>
            <a href="booking-approved.php">
                <div class="leave-divs" id="five">
                        <div class="inner-div">Approved Bookings</div>
                        <p>
                            <?php
                                $query_approved = mysqli_query($connection, "SELECT COUNT(*) AS 'approved' FROM `student_book_bus` WHERE `status_id` = 2");
                                if($data = mysqli_fetch_array($query_approved)){
                                    echo $data['approved'];     
                                }
                            ?>
                        </p>
                </div>
            </a>
            <a href="booking-declined.php">
                <div class="leave-divs" id="six">
                    <div class="inner-div">Declined Booking</div>
                    <p>
                    <?php
                        $query_declined = mysqli_query($connection, "SELECT COUNT(*) AS 'declined' FROM `student_book_bus` WHERE `status_id` = 3");
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
        <div style="background-color: #006600; text-align: center; color: rgba(255, 136, 0, 0.897);"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: #FFFFFF; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>   
</body>
</html>