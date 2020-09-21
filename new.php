<?php 
include("connection.php");
$dept_student_list = '';
$dept_student_list1 = '';
$dep_value = '';
$grade_value="";
    if(isset($_POST['dept_drop']) && !empty($_POST['dept_drop']) ){
        $dep_value = $_POST['dept_drop'];
        $query = 'SELECT * FROM `tbl_emp_records` WHERE `emp_department`='.$_POST['dept_drop'];
        $result = mysqli_query($conn,$query);
        while( $row = mysqli_fetch_assoc($result) ){
          
           $dept_student_list1 .= '<br>&nbsp;<input type=checkbox name='.$row['emp_name'].' value='.$row["emp_id"].'> '.$row['emp_name'].'<br>';
        }
        
       
        }

 if(isset($_POST['grade_drop']) && !empty($_POST['grade_drop']) ){
     $grade_drop = $_POST['grade_drop'];
     echo $dep_value;
      $query1 = 'SELECT * FROM `tbl_emp_records` WHERE  `emp_department`='.$dep_value.' AND `emp_grade`='.$grade_drop;
        $result1 = mysqli_query($conn,$query1);
        while( $row1 = mysqli_fetch_assoc($result1) ){
            $dept_student_list .= '<br>&nbsp;<input type=checkbox name='.$row1['emp_name'].' value='.$row1["emp_name"].'> '.$row1['emp_name'].'<br>';
        }
     
     
     
 }
    
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Department Management</title>
 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

    
<body>
<div class="row"><br></div>
<div class="col-md-12">
    <div class="col-md-5" style="border:1px solid">
    <div class="row"> <br> </div>
    <div class="row"> <br> 
        <form name="department" method="post">
        <lable>Department :: </lable>
            <select class="search-item" name="dept_drop" id="dept_drop" onchange="this.form.submit()" value="<?php echo $dep_value?>">
              <option value="">Select Department</option>
                <?php 
                $qry=mysqli_query($conn, "SELECT * FROM `tbl_emp_department` WHERE 1");
                while($row=mysqli_fetch_array($qry))
                {
                                        
                echo '<option value='.$row['department_id'].'>'.$row['department_name'].'</option>';    
                }
                
                
                
                ?>
           
            </select>
        </form>
    <table>
        <?php 
     
        echo $dept_student_list1;
        
        ?>        </table>
    </div>
    
    </div>
    <div class="col-md-2">
    
        <input type="button" name="add"  class="btn btn-info" value=">>"><br><br>
        <input type="button" name="substract" class="btn btn-info" value="<<">
    
    </div>
       <div class="col-md-5" style="border:1px solid">
    <div class="row"> <br> </div>
    <div class="row"> <br> 
         <form name="department" method="post">
        <lable>Select Grade :: </lable>
              <select class="" name="grade_drop" id="grade_drop" onchange="this.form.submit()" value="<?php echo $grade_value?>">
              <option value="">Select Grade</option>
             
                   <?php 
                $qry=mysqli_query($conn, "SELECT * FROM `tbl_emp_grade` WHERE 1");
                while($row=mysqli_fetch_array($qry))
                {
                                        
                echo '<option value='.$row['grade_id'].'>'.$row['grade_name'].'</option>';    
                }
                
                
                
                ?>
                
                
            </select>
        </form>
    <table>
        <?php 
        echo $dept_student_list;
        
        ?>        </table>
    
    
    </div>
    
    </div>
 
    </div>
    
  

    <!-- Bootstrap core JavaScript
    ================================================== -->
  
</body>
</html>