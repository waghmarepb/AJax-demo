<?php 
include("connection.php");
 
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
       
        <lable>Department :: </lable>
            <select class="search-item" name="dept_drop" id="dept_drop" onchange="val();">
              <option value="">Select Department</option>
                <?php 
                $qry=mysqli_query($conn, "SELECT * FROM `tbl_emp_department` WHERE 1");
                while($row=mysqli_fetch_array($qry))
                {
                                        
                echo '<option value='.$row['department_id'].'>'.$row['department_name'].'</option>';    
                }
                
                
                
                ?>
           
            </select>
      
    
    <table id="user_records" name="user_records">
            </table>
    
  
    </div>
    
    </div>
    <div class="col-md-2">
    
        <input type="button" name="add"  id="add" class="btn btn-info" onclick="myAdd()" value=">>"><br><br>
        <input type="button" name="sub"  id="sub" class="btn btn-info" onclick="mySub()" value="<<">
    
    </div>
       <div class="col-md-5" style="border:1px solid">
    <div class="row"> <br> </div>
    <div class="row"> <br> 
        
        <lable>Select Grade :: </lable>
        <select class="" name="grade_drop" id="grade_drop" onchange="val2();" value="">
              <option value="">Select Grade</option>
             
                   <?php 
                $qry=mysqli_query($conn, "SELECT * FROM `tbl_emp_grade` WHERE 1");
                while($row=mysqli_fetch_array($qry))
                {
                                        
                echo '<option value='.$row['grade_id'].'>'.$row['grade_name'].'</option>';    
                }
                
                
                
                ?>
                
                
            </select>
        
    <table id="user_records1" name="user_records1">
               </table>
  
    </div>
    
    </div>
 
    </div>
    
  
<script>
    function val() {
    d = document.getElementById("dept_drop").value;
    
        jQuery.ajax({
    type: "POST",
    url: "fetch_employee_dept.php",
    data: {
        departmentName: d
    },
    success: function(data){
       // console.log(data);
        jQuery("#user_records").html(data);
        val2();
       
        
        
    },
             error: function() {
            console.log('Error occured');}
        
});
       
}
    
    function val2() {
    e = document.getElementById("grade_drop").value;
        
    d = document.getElementById("dept_drop").value;
        
  jQuery.ajax({
    type: "POST",
    url: "fetch_employee_grade.php",
    data: {
        departmentName: d,
        gradeName: e,
    },
    success: function(data){
       // console.log(data);
        jQuery("#user_records1").html(data);
        val();
        
    },
             error: function() {
            console.log('Error occured');}
        
});
            
            
}
    
    
    function myAdd() {
    e = document.getElementById("grade_drop").value;
    d = document.getElementById("dept_drop").value;
    
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
           
        });
    // alert(val);
    
  jQuery.ajax({
    type: "POST",
    url: "add_grade.php",
    data: {
        departmentName: d,
        gradeName: e,
        arrayVal: val,
        
    },
    success: function(data){
        val2();
        val();
      
    },
             error: function() {
            console.log('Error occured');}
        
});
            
    
    
}
    function mySub() {
    e = document.getElementById("grade_drop").value;
    d = document.getElementById("dept_drop").value;
    
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
           
        });
     
    
  jQuery.ajax({
    type: "POST",
    url: "sub_grade.php",
    data: {
        departmentName: d,
        gradeName: e,
        arrayVal: val,
        
    },
    success: function(data){
         val();
        val2();
    },
             error: function() {
            console.log('Error occured');}
        
});
            
        
}
    
    </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
  
</body>
</html>