<?php
if(isset($_POST['departmentName']) && isset($_POST['gradeName']))
{
  include("connection.php"); 
 $department=$_POST['departmentName'];
 $grade=$_POST['gradeName'];
  
 $value=$_POST['arrayVal'];
    
  $cnt=count($value);  
    
  for($i=0; $i <= ($cnt-1); $i++)
 {
      $tempVar=$value[$i];
   $update_emp=mysqli_query($conn, "UPDATE `tbl_emp_records` SET `emp_grade`='$grade' WHERE `emp_department`='$department' AND `emp_id`='$tempVar'");
      
 }
    
    
    
}
?>
