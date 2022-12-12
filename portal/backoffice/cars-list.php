<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }
    //check value in cart
    $query_get_rtps = mysqli_query($connection, "SELECT COUNT(*) AS 'notification' FROM `bookings` WHERE `status`= 'Pending' AND expired='No'");
    while($data = mysqli_fetch_array($query_get_rtps)){
         $total = $data['notification'];     
    }
    //get user information and prepare for display
    $query_get_details = mysqli_query($connection, "SELECT * FROM `users` WHERE `username` = '".$user_login_id."'");
    while($row = mysqli_fetch_array($query_get_details)){
        $names = $row['fullnames']; 
        $employee_id = $row["username"];
        $user_role = $row["role"];     
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <title>Admin | Car List</title>
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
        <?php
                $index = 1;
                //get user information and prepare for display
                $query_get_reviews = mysqli_query($connection, "SELECT * FROM `cars`");
                echo "<table>
                        <tr>
                            <th>No.</th>
                            <th>CAR NAME</th>
                            <th>DESCRIPTION</th>
                            <th>MODEL</th>
                            <th>BRAND</th>
                            <th>ACTION</th>
                        </tr>";
                while($row = mysqli_fetch_array($query_get_reviews)){
                    echo "<tr><td>".$index."</td><td><a href='".$row["car_image_url"]."' target='_blank'>".$row["car_name"]."</a></td><td>".$row["car_description"]."</td><td>".$row["car_model"]."</td><td>".$row["brand_name"]."</td><td><a style='color: #fff; text-decoration: none; ' href='delete-car.php?id=".$row["id"]."'><img src='../images/delete.png' alt='Delete' /></a></td></tr>";  
                    $index++;
                }
                echo "</table>";
                echo "<br /><br /><a id='user_add' href='add-car.php'>Add New Car</a>";
            ?>        

        </div>
    </section>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF;"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>   
</body>
</html>