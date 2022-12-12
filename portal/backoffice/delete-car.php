<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }

   
    if(mysqli_query($connection, "DELETE FROM `cars` WHERE `id` = '".$_GET["id"]."'")){ 
        header("Location:car-list.php");                      
    }
    else{
        header("Location:car-list.php"); 
    }    
?>