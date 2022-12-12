<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../config-files/config.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../index.php");
    }
    //get user information and prepare for display
    $query_delete_dept = mysqli_query($connection, "DELETE FROM `departments` WHERE `department_id` = '".$_GET["id"]."'");

   
    if(mysqli_fetch_array($query_delete_dept)){ 
        header("Location:departments-list.php");                      
    }
    else{
        //echo "No";
        header("Location:departments-list.php"); 
    }    
?>