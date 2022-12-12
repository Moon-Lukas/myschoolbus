<?php
    error_reporting(E_ERROR | E_PARSE);//removes the undefined problem
    session_start();

    include "../../config-files/connectiondb.php";
    $user_login_id = $_SESSION["username"];

    if($user_login_id == ""){
        header("Location:../../index.php");
    }
   try{
        if(mysqli_query($connection, "DELETE FROM `student` WHERE `stud_id` = '".$_GET["id"]."'")){ 
            if(mysqli_query($connection, "DELETE FROM `user` WHERE `stud_id` = '".$_GET["id"]."'")){
                $_SESSION["deleted_user"] = "Yes";
                header("Location:clients-list.php");
            }
        }
        else{
            echo "No";
            header("Location:clients-list.php"); 
        } 
    }catch(exeption $ex){
        echo no;
        header("Location:clients-list.php");
    }
?>