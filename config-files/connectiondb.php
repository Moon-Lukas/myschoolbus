<?php    
    $connection = mysqli_connect('localhost', 'root', '', 'schoolbusdb');

    if($connection == false){
        Header("Location:index.php");
        //echo "Not Connected";
    }
    else{
        //echo "Connected";
    }
?>