<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    
    <title>Home | Clients</title>
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
            <div class="filter-class">
                <form method="post" action="">
                    <input type="text" name="search_id" placeholder="Search employee by NRC..." />
                    <button name="search_button">Search</button>
                </form>
            </div>
        <?php
                $index = 1;
                //get user information and prepare for display
                $query_get_reviews = mysqli_query($connection, "SELECT * FROM `Users` WHERE `role`<>'Client'");
                echo "<table>
                        <tr>
                            <th>No.</th>
                            <th>NRC</th>
                            <th>NAMES</th>
                            <th>EMAIL</th>
                            <th>PHONE</th>                            
                            <th>ACTION</th>
                        </tr>";
                while($row = mysqli_fetch_array($query_get_reviews)){
                    echo "<tr><td>".$index."</td><td>".$row["nrc"]."</td><td><a href='edit-user.php?id=".$row["username"]."' >".$row["fullnames"]."</a></td><td>".$row["email"]."</td><td>".$row["phonenumber"]."</td><td><a style='color: #fff; text-decoration: none;' href='delete-users.php?id=".$row["username"]."'><img src='../images/delete.png' alt='Delete' /></a></td></tr>";  
                    $index++;
                }
                echo "</table>";
                echo "<br /><br /><a id='user_add' href='add-users.php'>Add New User</a>";
            ?>        

        </div>
    </section>
    <footer>
        <div style="background-color: #006600; text-align: center; color: #FFFFFF;"><p><span>&copy;&nbsp;</span><span class="copyright-year"></span><?php echo date("Y"); ?> All Rights Reserved<br />Developed by<a href="#" target="_blank" style = "color: Orange; "> <i>Chibozu Maambo</i></a><br />Email: chibozumaambo@gmail.com</p></div>
    </footer>    
</body>
</html>