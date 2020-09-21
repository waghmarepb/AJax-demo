<?php 
$db_user="root";
$db_password="";
$db_server="localhost";
$db_name="emp_grade_system";
$conn=mysqli_connect($db_server,$db_user,$db_password);
$bd=mysqli_select_db($conn,$db_name);
?>