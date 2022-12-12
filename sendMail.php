<?php
session_start();

//get values from signup
$full_names = $_GET["names"];
$username = $_GET["user"];
$email_address = $_GET["email"];
$pword = $_GET["password"]; 


//initialize email sending
$to = $email_address; 
$from = 'chibozumaambo@gmail.com'; 
$fromName = 'University of Lusaka Skool Bus'; 
 
$subject = "Account Details"; 
 
$htmlContent = ' 
    <html> 
    <head> 
        <title>Account Login Details</title> 
    </head> 
    <body> 
        <h1>Hello! '.$full_names.',</h1> 
        <table cellspacing="0" style="border: 2px dashed rgb(3, 83, 173); width: 100%; text-align: center;"> 
            <p style="font-size: 14px;"><b>Username: </b>'.$username.'</p>
            <p style="font-size: 14px;"><b>Password: </b>'.$pword.'</p><br/>
            <a style="padding: 8px;background-color: rgba(255, 136, 0, 0.897); text-decoration: none; color: #fff; font-type: bold;" href="http://localhost:8081/checkmartsite/sign-in.php" target="_blank">Login Now</a><br/>
            <br/>
        </table> 
    </body> 
    </html>'; 
 
// Set content-type header for sending HTML email 
$headers = "MIME-Version: 1.0" . "\r\n"; 
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
 
// Additional headers 
$headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
/*$headers .= 'Cc: jlungu@unilus.ac.zm' . "\r\n"; 
$headers .= 'Bcc: josephlungu270@yahoo.com' . "\r\n"; */
 
// Send email 
if(mail($to, $subject, $htmlContent, $headers)){ 
    if($_SESSION["username"] != ""){
        Header("Location:portal/administrator/add-users.php?session_key=1");
    }
    else{
        Header("Location:sign-up.php?session_key=1");
    }
    
}else{ 
    if($_SESSION["username"] != ""){
        Header("Location:portal/administrator/add-users.php?session_key=2");
    }
    else{
        Header("Location:sign-up.php?session_key=2");
    }   
}
?>