<?php
    include "../config-files/config.php";

    $button = $_GET["btn"];
    $date1 = $_GET["start"];
    $date2 = $_GET["end"];
    $user_nrc = $_GET["nrc_id"];
    $date = date("d/m/Y");

    $query_update_status = "";
    if($button == "approve"){
        $query_update_status = "UPDATE `leave_module` SET `status`='Approved', `date_applied`='".$date."' WHERE `employeeID` = '".$user_nrc."' AND `date_from` = '".$date1."' AND `date_to` = '".$date2."'";
    }
    else if($button == "reject"){
        $query_update_status = "UPDATE `leave_module` SET `status`='Declined', `date_applied`='".$date."' WHERE `employeeID` = '".$user_nrc."' AND `date_from` = '".$date1."' AND `date_to` = '".$date2."'";
    }
    
    if(mysqli_query($connection, $query_update_status)){
        if($button == "approve"){
            header("Location:leave-approved.php");
        }
        else if($button == "reject"){
            header("Location:leave-declined.php");
        }  
    }   

    //echo "You clicked ".$button." for ".$user_nrc." number ".$date1." and ".$date2;
?>