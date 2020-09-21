<?php
if(isset($_POST['departmentName']) && isset($_POST['gradeName']))
{ 
  include("connection.php"); 
$department = $_POST['departmentName'];
 $grade = $_POST['gradeName'];
 $find=mysqli_query($conn, "SELECT * FROM `tbl_emp_records` WHERE `emp_department`='$department' AND `emp_grade`='$grade'");
 while($row=mysqli_fetch_array($find))
 {
    
echo '<br><input type=checkbox name=emp[] value='.$row["emp_id"].'> '.$row["emp_name"].'<br>';
      
}
    
    
    
 exit;
}
?>
