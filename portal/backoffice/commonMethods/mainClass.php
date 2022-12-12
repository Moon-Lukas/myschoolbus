<?php

    //function to return status by ID
    function getStatus($id){
        include "../../config-files/connectiondb.php";
        $query_get_status = mysqli_query($connection, "SELECT * FROM `system_status` WHERE `status_id`= ".$id."");
        while($data = mysqli_fetch_array($query_get_status)){
            $status_name = $data['status_name'];     
        }
        return $status_name;
    }
    //function to return student details by stud no
    function getStudentBy($username){
        include "../../config-files/connectiondb.php";
        $query_get_user = mysqli_query($connection, "SELECT * FROM `student` WHERE `student_no`= '".$username."'");
        try{
            while($data = mysqli_fetch_array($query_get_user)){
                $studentId = $data['stud_id'];     
            }
            return $studentId;
        }
        catch(exception  $ex){
            return 0;
        }
    }
    //function to return role details by stud no
    function getSystemRoles(){
        include "../../config-files/connectiondb.php";
        $query_get_role = mysqli_query($connection, "SELECT * FROM `role`");
        echo "<select class='selects' name='roles'>";
        echo "<option disabled>Select role</option>";
        while($data = mysqli_fetch_array($query_get_role)){
            echo "<option value=".$data["role_id"].">".$data["role_name"]."</option>";
        }
        echo "</select><br/><br/>";
    }
?>