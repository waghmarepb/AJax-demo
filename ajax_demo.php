<?php 
session_start();
include '../connection.php';
$id=$_SESSION['SESS_MEMBER_ID'];

if(!$id)
      {
        header('Location: ../login');
      }
$qry2=mysql_query("SELECT `product_id`,`product_name` FROM `tbl_product` WHERE product_flag=0");
$product_names ='<datalist id="crystal-item-names">';
while($row2=mysql_fetch_array($qry2))
{
    $product_names .= '<option value="'.$row2['product_name'].'">'.$row2['product_id'].'</option>';
}
$product_names .='</datalist>';


$qry3=mysql_query("SELECT `distributor_id`,`distributor_lname`,`distributor_fname`,`distributor_mname` FROM `tbl_cmember` WHERE distributor_flag=1");
$product_names3 ='<datalist id="crystal-names">';
while($row3=mysql_fetch_array($qry3))
{
    $product_names3 .= '<option value="'.$row3['distributor_id'].'">'.$row3['distributor_lname'].' '.$row3['distributor_fname'].' '.$row3['distributor_mname'].'</option>';
}
$product_names3 .='</datalist>';


if(isset($_POST['submit']))
{
    
    
    $product_fgender=$_POST["formGender1"];
    $product_lname=$_POST["a_lname"];
    $product_fname=$_POST["a_fname"];
    $product_mname=$_POST["a_mname"];
    $product_gender=$_POST["gender"];
    $product_dob=$_POST["birth_date"];
    $product_aadharno=$_POST["aadhar_no"];
    $product_aadharname=$_POST["aadhar_name"];
    $product_mnumber=$_POST["mobile_number"];
    $product_email=$_POST["email_id"];
    $product_subtotal=$_POST["product_subtotal"];
    $product_tax=$_POST["product_totaltax"];
    $product_total=$_POST["product_total"];
    $product_user=$_POST["user_id"];
    
    
    $insert = mysql_query ("INSERT INTO `tbl_invoice`(`product_fgender`, `product_lname`, `product_fname`, `product_mname`, `product_gender`, `product_dob`, `product_aadharno`, `product_aadharname`, `product_mnumber`, `product_email`, `product_subtotal`, `product_tax`, `product_total`, `user_pk`, `invoice_accept`, `admin_flag`, `invoice_flag`) VALUES  ('$product_fgender','$product_lname','$product_fname','$product_mname','$product_gender','$product_dob','$product_aadharno','$product_aadharname','$product_mnumber','$product_email','$product_subtotal','$product_tax','$product_total','$product_user',0,0,0)");
          $lastid = mysql_insert_id ();
    

    
  $product_name=$_POST["product_name"];
  $product_cost=$_POST["product_cost"];
  $product_qty=$_POST["product_qty"];
  $product_ntax=$_POST["new-tax"];
  $product_nprice=$_POST["net-price"];
    
 
    $count_var=count($product_name);
      for($i=0; $i<$count_var; $i++)
      {
          
      $insert1 = mysql_query ("INSERT INTO `tbl_invoice_details`(`invoice_id`, `product_name`, `product_cost`, `product_qty`, `product_tax`, `product_price`, `user_pk`, `deails_flag`) VALUES ($lastid,'$product_name[$i]','$product_cost[$i]','$product_qty[$i]','$product_ntax[$i]','$product_nprice[$i]',$product_user,0)");
          
        
    $rank_margin=0;
    $senior_id=0;
    $distributor_amount=0;    
    $qry3=mysql_query("SELECT * FROM `tbl_cmember` WHERE distributor_id= $product_user");
        while($row3=mysql_fetch_array($qry3))
        {
            $rank_id =$row3['distributor_note'];
            $distributor_amount =$row3['distributor_amount'];
            $senior_id=$row3['ref_id'];
              
            
            if($rank_id=='0000000001')
            {
                    $SE1="";
                    $SM1="";
                    $DL1="";
                    $DB1="";
                    $S1="";
                    $SS1="";
                    $EM1="";
                    $M1="";
                   // $DN1=;
                $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                           // $DN1=$row31[product_dn];
                       }
                
                $SE=($SE1*(float)$product_subtotal)/100;
                $SM=($SM1*(float)$product_subtotal)/100;
                $DL=($DL1*(float)$product_subtotal)/100;
                $DB=($DB1*(float)$product_subtotal)/100;
                $S=($S1*(float)$product_subtotal)/100;
                $SS=($SS1*(float)$product_subtotal)/100;
                $EM=($EM1*(float)$product_subtotal)/100;
                $M=($M1*(float)$product_subtotal)/100;
                //$DN=($DN1*(float)$product_subtotal)/100;
                
                      $insert1=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row1=mysql_fetch_array($insert1)) 
                {   
                    //LEvel1 START
                    $amount1=$row1['distributor_amount'];
                     $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SE,$lastid,$product_user,0)");
                    $SE += $amount1;
                    $insert1=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SE WHERE `distributor_id`=$product_user");
                    
                    //LEvel2 START
                    $senior_id11=$row1['ref_id'];
                    $insert11=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id11");
                    while($row11=mysql_fetch_array($insert11)) 
                    {   
                        $amount11=$row11['distributor_amount'];
                         $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SM,$lastid,$senior_id11,0)");
                        $SM += $amount11;
                        $insert11=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SM WHERE `distributor_id`=$senior_id11");
                        
                        //LEvel3 START
                        $senior_id12=$row11['ref_id'];
                        $insert12=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id12");
                        while($row12=mysql_fetch_array($insert12)) 
                        {   
                            $amount12=$row12['distributor_amount'];
                             $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DL,$lastid,$senior_id12,0)");
                            $DL += $amount12;
                            $insert12=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DL WHERE `distributor_id`=$senior_id12");
                            //LEvel4 START
                            $senior_id13=$row12['ref_id'];
                            $insert13=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id13");
                            while($row13=mysql_fetch_array($insert13)) 
                            {   
                                $amount13=$row13['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DB,$lastid,$senior_id13,0)");
                                $DB += $amount13;
                                $insert13=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DB WHERE `distributor_id`=$senior_id13");
                                //LEvel5 START
                                $senior_id14=$row13['ref_id'];
                                $insert14=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id14");
                                while($row14=mysql_fetch_array($insert14)) 
                                {   
                                $amount14=$row14['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($S,$lastid,$senior_id14,0)");
                                $S += $amount14;
                                $insert14=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$S WHERE `distributor_id`=$senior_id14");
                                     //LEvel5 START
                                    $senior_id15=$row14['ref_id'];
                                    $insert15=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id15");
                                    while($row15=mysql_fetch_array($insert15)) 
                                    {   
                                    $amount15=$row15['distributor_amount'];
                                        $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SS,$lastid,$senior_id15,0)");
                                    $SS += $amount15;
                                    $insert15=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SS WHERE `distributor_id`=$senior_id15");
                                            //LEvel6 START
                                        $senior_id16=$row15['ref_id'];
                                        $insert16=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id16");
                                        while($row16=mysql_fetch_array($insert16)) 
                                        {   
                                        $amount16=$row16['distributor_amount'];
                                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($EM,$lastid,$senior_id16,0)");
                                        $EM += $amount16;
                                        $insert16=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$EM WHERE `distributor_id`=$senior_id16");
                                            //LEvel7 START
                                        $senior_id17=$row16['ref_id'];
                                        $insert17=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id17");
                                        while($row17=mysql_fetch_array($insert17)) 
                                        {   
                                        $amount17=$row17['distributor_amount'];
                                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$senior_id17,0)");
                                        $M += $amount17;
                                        $insert17=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$senior_id17");
                                             /*LEvel8 START
                                        $senior_id18=$row17['ref_id'];
                                        $insert18=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id18");
                                        while($row18=mysql_fetch_array($insert18)) 
                                        {   
                                        $amount18=$row18['distributor_amount'];
                                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id18,0)");
                                        $DN += $amount18;
                                        $insert27=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id18");
                                 

                                        }LEvel9 CLOSE*/

                                        }//LEvel8 CLOSE

                                        }//LEvel7 CLOSE

                                    }//LEvel6 CLOSE    
                                }//LEvel5 CLOSE
                                
                            }//LEvel4 CLOSE
                            
                        }//LEvel3 CLOSE

                    }//LEvel2 CLOSE
                   
                }//LEvel1 CLOSE
      

                
                
                
                
        }
            else if($rank_id=='0000000002')
            {
                 $SE1="";
$SM1="";
$DL1="";
$DB1="";
$S1="";
$SS1="";
$EM1="";
$M1="";
//$DN1=;  
                $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                           // $DN1=$row31[product_dn];
                       }
                
                
                
                
                
                $SM=(($SE1+$SM1)*(float)$product_subtotal)/100;
                $DL=($DL1*(float)$product_subtotal)/100;
                $DB=($DB1*(float)$product_subtotal)/100;
                $S=($S1*(float)$product_subtotal)/100;
                $SS=($SS1*(float)$product_subtotal)/100;
                $EM=($EM1*(float)$product_subtotal)/100;
                $M=($M1*(float)$product_subtotal)/100;
                //$DN=($DN1*(float)$product_subtotal)/100;
                    $insert2=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row2=mysql_fetch_array($insert2)) 
                {   
                    //LEvel1 START
                    $amount2=$row2['distributor_amount'];
                    $insert02 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SM,$lastid,$product_user,0)");
                    $SM += $amount2;
                    $insert2=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SM WHERE `distributor_id`=$product_user");
                    //LEvel2 START
                    $senior_id21=$row2['ref_id'];
                    $insert21=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id21");
                    while($row21=mysql_fetch_array($insert21)) 
                    {   
                        $amount21=$row21['distributor_amount'];
                        $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DL,$lastid,$senior_id21,0)");
                        $DL += $amount21;
                        $insert21=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DL WHERE `distributor_id`=$senior_id21");
                        //LEvel3 START
                        $senior_id22=$row21['ref_id'];
                        $insert22=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id22");
                        while($row22=mysql_fetch_array($insert22)) 
                        {   
                            $amount22=$row22['distributor_amount'];
                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DB,$lastid,$senior_id22,0)");
                            $DB += $amount22;
                            $insert22=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DB WHERE `distributor_id`=$senior_id22");
                            //LEvel4 START
                            $senior_id23=$row22['ref_id'];
                            $insert23=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id23");
                            while($row23=mysql_fetch_array($insert23)) 
                            {   
                                $amount23=$row23['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($S,$lastid,$senior_id23,0)");
                                $S += $amount23;
                                $insert23=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$S WHERE `distributor_id`=$senior_id23");
                                //LEvel5 START
                                $senior_id24=$row23['ref_id'];
                                $insert24=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id24");
                                while($row24=mysql_fetch_array($insert24)) 
                                {   
                                $amount24=$row24['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SS,$lastid,$senior_id24,0)");
                                $SS += $amount24;
                                $insert24=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SS WHERE `distributor_id`=$senior_id24");
                                     //LEvel5 START
                                    $senior_id25=$row24['ref_id'];
                                    $insert25=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id25");
                                    while($row25=mysql_fetch_array($insert25)) 
                                    {   
                                    $amount25=$row25['distributor_amount'];
                                     $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($EM,$lastid,$senior_id25,0)");       //LEvel6 START
                                    $EM += $amount25;
                                    $insert25=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$EM WHERE `distributor_id`=$senior_id25");
                                        $senior_id26=$row25['ref_id'];
                                        $insert26=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id26");
                                        while($row26=mysql_fetch_array($insert26)) 
                                        {   
                                        $amount26=$row26['distributor_amount'];
                                         $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$senior_id26,0)");   //LEvel7 START
                                        $M += $amount26;
                                        $insert26=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$senior_id26");
//                                        $senior_id27=$row26['ref_id'];
//                                        $insert27=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id27");
//                                        while($row27=mysql_fetch_array($insert27)) 
//                                        {   
//                                        $amount27=$row27['distributor_amount'];
//                                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id27,0)");
//                                        $DN += $amount27;
//                                        $insert27=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id27");
//                                        }//LEvel7 CLOSE

                                        }//LEvel6 CLOSE

                                    }//LEvel5 CLOSE    
                                }//LEvel5 CLOSE
                                
                            }//LEvel4 CLOSE
                            
                        }//LEvel3 CLOSE

                    }//LEvel2 CLOSE
                   
                }//LEvel1 CLOSE
      
                
                
                
                
            }
            else if($rank_id=='0000000003')
            {
                  $SE1="";
$SM1="";
$DL1="";
$DB1="";
$S1="";
$SS1="";
$EM1="";
$M1="";
//$DN1=;
                $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                          //  $DN1=$row31[product_dn];
                       }
                $DL=((($SE1+$SM1+$DL1))*(float)$product_subtotal)/100;
                $DB=($DB1*(float)$product_subtotal)/100;
                $S=($S1*(float)$product_subtotal)/100;
                $SS=($SS1*(float)$product_subtotal)/100;
                $EM=($EM1*(float)$product_subtotal)/100;
                $M=($M1*(float)$product_subtotal)/100;
               // $DN=($DN1*(float)$product_subtotal)/100;
                
                $insert3=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row3=mysql_fetch_array($insert3)) 
                {   
                    //LEvel1 START
                    $amount3=$row3['distributor_amount'];
                    $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DL,$lastid,$product_user,0)");
                    $DL += $amount3;
                    $insert3=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DL WHERE `distributor_id`=$product_user");
                    //LEvel2 START
                    $senior_id31=$row3['ref_id'];
                    $insert31=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id31");
                    while($row31=mysql_fetch_array($insert31)) 
                    {   
                        $amount31=$row31['distributor_amount'];
                        $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DB,$lastid,$senior_id31,0)");
                        $DB += $amount31;
                        $insert31=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DB WHERE `distributor_id`=$senior_id31");
                        //LEvel3 START
                        $senior_id32=$row31['ref_id'];
                        $insert32=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id32");
                        while($row32=mysql_fetch_array($insert32)) 
                        {   
                            $amount32=$row32['distributor_amount'];
                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($S,$lastid,$senior_id32,0)");
                            $S += $amount32;
                            $insert32=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$S WHERE `distributor_id`=$senior_id32");
                            //LEvel4 START
                            $senior_id33=$row32['ref_id'];
                            $insert33=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id33");
                            while($row33=mysql_fetch_array($insert33)) 
                            {   
                                $amount33=$row33['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SS,$lastid,$senior_id33,0)");
                                $SS += $amount33;
                                $insert33=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SS WHERE `distributor_id`=$senior_id33");
                                //LEvel5 START
                                $senior_id34=$row33['ref_id'];
                                $insert34=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id34");
                                while($row34=mysql_fetch_array($insert34)) 
                                {   
                                $amount34=$row34['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($EM,$lastid,$senior_id34,0)");
                                $EM += $amount34;
                                $insert34=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$EM WHERE `distributor_id`=$senior_id34");
                                     //LEvel5 START
                                    $senior_id35=$row34['ref_id'];
                                    $insert35=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id35");
                                    while($row35=mysql_fetch_array($insert35)) 
                                    {   
                                    $amount35=$row35['distributor_amount'];
                                      $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$senior_id35,0)");      
                                    $M += $amount35;
                                    $insert35=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$senior_id35");
//                                        //LEvel6 START
//                                        $senior_id36=$row35['ref_id'];
//                                        $insert36=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id36");
//                                        while($row36=mysql_fetch_array($insert36)) 
//                                        {   
//                                        $amount36=$row36['distributor_amount'];
//                                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id36,0)");
//                                        $DN += $amount36;
//                                        $insert36=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id36");
//                                        }//LEvel6 CLOSE

                                    }//LEvel5 CLOSE    
                                }//LEvel5 CLOSE
                                
                            }//LEvel4 CLOSE
                            
                        }//LEvel3 CLOSE

                    }//LEvel2 CLOSE
                   
                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DL,$lastid,$product_user,0)");}//LEvel1 CLOSE
      
                
                
                
            }
            else if($rank_id=='0000000004')
            {
                    $SE1="";
$SM1="";
$DL1="";
$DB1="";
$S1="";
$SS1="";
$EM1="";
$M1="";
//$DN1=;
                $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                         //   $DN1=$row31[product_dn];
                       }
                $DB=(($SE1+$SM1+$DL1+$DB1)*(float)$product_total)/100;
                $S=($S*(float)$product_total)/100;
                $SS=($SS1*(float)$product_total)/100;
                $EM=($EM1*(float)$product_total)/100;
                $M=($M1*(float)$product_total)/100;
              //  $DN=($DN1*(float)$product_total)/100;
                $insert4=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row4=mysql_fetch_array($insert4)) 
                {   
                    //LEvel1 START
                    $amount4=$row4['distributor_amount'];
                    $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DB,$lastid,$product_user,0)");
                    $DB += $amount4;
                    $insert4=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DB WHERE `distributor_id`=$product_user");
                    //LEvel2 START
                    $senior_id41=$row4['ref_id'];
                    $insert41=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id41");
                    while($row41=mysql_fetch_array($insert41)) 
                    {   
                        $amount41=$row41['distributor_amount'];
                        $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($S,$lastid,$senior_id41,0)");
                        $S += $amount41;
                        $insert41=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$S WHERE `distributor_id`=$senior_id41");
                        //LEvel3 START
                        $senior_id42=$row41['ref_id'];
                        $insert42=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id42");
                        while($row42=mysql_fetch_array($insert42)) 
                        {   
                            $amount42=$row42['distributor_amount'];
                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SS,$lastid,$senior_id42,0)");
                            $SS += $amount42;
                            $insert42=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SS WHERE `distributor_id`=$senior_id42");
                            //LEvel4 START
                            $senior_id43=$row42['ref_id'];
                            $insert43=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id43");
                            while($row43=mysql_fetch_array($insert43)) 
                            {   
                                $amount43=$row43['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($EM,$lastid,$senior_id43,0)");
                                $EM += $amount43;
                                $insert43=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$EM WHERE `distributor_id`=$senior_id43");
                                //LEvel5 START
                                $senior_id44=$row43['ref_id'];
                                $insert44=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id44");
                                while($row44=mysql_fetch_array($insert44)) 
                                {   
                                $amount44=$row44['distributor_amount'];
                                $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$senior_id44,0)");
                                $M += $amount44;
                                $insert44=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$senior_id44");
//                                     //LEvel5 START
//                                    $senior_id45=$row44['ref_id'];
//                                    $insert45=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id45");
//                                    while($row45=mysql_fetch_array($insert45)) 
//                                    {   
//                                    $amount45=$row45['distributor_amount'];
//                                        $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id45,0)");
//                                    $DN += $amount45;
//                                    $insert45=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id45");
//
//                                    }//LEvel5 CLOSE    
                                }//LEvel5 CLOSE
                                
                            }//LEvel4 CLOSE
                            
                        }//LEvel3 CLOSE

                    }//LEvel2 CLOSE
                   
                }//LEvel1 CLOSE
              
            }
            else if($rank_id=='0000000005')
            {   
                     $SE1="";
$SM1="";
$DL1="";
$DB1="";
$S1="";
$SS1="";
$EM1="";
$M1="";
//$DN1=;
                $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                          //  $DN1=$row31[product_dn];
                       }
                $S=(($SE1+$SM1+$DL1+$DB1+$S1)*(float)$product_total)/100;
                $SS=($SS1*(float)$product_total)/100;
                $EM=($EM1*(float)$product_total)/100;
                $M=($M1*(float)$product_total)/100;
               // $DN=($DN1*(float)$product_total)/100;
                $insert5=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row5=mysql_fetch_array($insert5)) 
                {   
                    //LEvel1 START
                    $amount5=$row5['distributor_amount'];
                    $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($S,$lastid,$product_user,0)");
                    $S += $amount5;
                    $insert5=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$S WHERE `distributor_id`=$product_user");
                    //LEvel2 START
                    $senior_id51=$row5['ref_id'];
                    $insert51=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id51");
                    while($row51=mysql_fetch_array($insert51)) 
                    {   
                        $amount51=$row51['distributor_amount'];
                          $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SS,$lastid,$senior_id51,0)");
                        $SS += $amount51;
                        $insert51=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SS WHERE `distributor_id`=$senior_id51");
                        //LEvel3 START
                        $senior_id52=$row51['ref_id'];
                        $insert52=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id52");
                        while($row52=mysql_fetch_array($insert52)) 
                        {   
                            $amount52=$row52['distributor_amount'];
                                 $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($EM,$lastid,$senior_id52,0)");
                            $EM += $amount52;
                            $insert52=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$EM WHERE `distributor_id`=$senior_id52");
                            //LEvel4 START
                            $senior_id53=$row52['ref_id'];
                            $insert53=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id53");
                            while($row53=mysql_fetch_array($insert53)) 
                            {   
                                $amount53=$row53['distributor_amount'];
                                     $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$senior_id53,0)");
                                $M += $amount53;
                                $insert53=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$senior_id53");
//                                //LEvel5 START
//                                $senior_id54=$row53['ref_id'];
//                                $insert54=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id54");
//                                while($row54=mysql_fetch_array($insert54)) 
//                                {   
//                                $amount54=$row54['distributor_amount'];
//                                     $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id54,0)");    
//                                $DN += $amount54;
//                                $insert54=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id54");
//                                }//LEvel5 CLOSE
                                
                            }//LEvel4 CLOSE
                            
                        }//LEvel3 CLOSE

                    }//LEvel2 CLOSE
                   
                }//LEvel1 CLOSE
                
            }
            else if($rank_id=='0000000006')
            {   
                  $SE1="";
$SM1="";
$DL1="";
$DB1="";
$S1="";
$SS1="";
$EM1="";
$M1="";
//$DN1=;
                $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                         //   $DN1=$row31[product_dn];
                       }
                $SS=(($SE1+$SM1+$DL1+$DB1+$S1+$SS1)*(float)$product_total)/100;
                $EM=($EM1*(float)$product_total)/100;
                $M=($M1*(float)$product_total)/100;
               // $DN=($DN1*(float)$product_total)/100;
                $insert6=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row6=mysql_fetch_array($insert6)) 
                {   
                    //LEvel1 START
                    $amount6=$row6['distributor_amount'];
                         $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($SS,$lastid,$product_user,0)");
                    $SS += $amount6;
                    $insert6=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$SS WHERE `distributor_id`=$product_user");
                    //LEvel2 START
                    $senior_id61=$row6['ref_id'];
                    $insert61=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id61");
                    while($row61=mysql_fetch_array($insert61)) 
                    {   
                        $amount61=$row61['distributor_amount'];
                         $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($EM,$lastid,$senior_id61,0)");
                        $EM += $amount61;
                        $insert61=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$EM WHERE `distributor_id`=$senior_id61");
                        //LEvel3 START
                        $senior_id62=$row61['ref_id'];
                        $insert62=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id62");
                        while($row62=mysql_fetch_array($insert62)) 
                        {   
                            $amount62=$row62['distributor_amount'];
                              $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$senior_id62,0)");
                            $M += $amount62;
                            $insert62=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$senior_id62");
//                            //LEvel4 START
//                            $senior_id63=$row62['ref_id'];
//                            $insert63=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id63");
//                            while($row63=mysql_fetch_array($insert63)) 
//                            {   
//                                $amount63=$row63['distributor_amount'];
//                                  $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id63,0)");
//                                $DN += $amount63;
//                                $insert63=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id63");
//                            }//LEvel4 CLOSE
                            
                        }//LEvel3 CLOSE

                    }//LEvel2 CLOSE
                   
                }//LEvel1 CLOSE
            
            
            }
            else if($rank_id=='0000000007')
            {   
                 $SE1="";
$SM1="";
$DL1="";
$DB1="";
$S1="";
$SS1="";
$EM1="";
$M1="";
//$DN1=;
                $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                           // $DN1=$row31[product_dn];
                       }
               
                
                
                
                $EM=(($SE1+$SM1+$DL1+$DB1+$S1+$SS1+$EM1)*(float)$product_total)/100;
                $M=($M1*(float)$product_total)/100;
               // $DN=($DN1*(float)$product_total)/100;
                
                $insert7=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row7=mysql_fetch_array($insert7)) 
                {   
                    //LEvel1 START
                    $amount7=$row7['distributor_amount'];
                      $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($EM,$lastid,$product_user,0)");
                    $EM += $amount7;
                    $insert7=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$EM WHERE `distributor_id`=$product_user");
                    //LEvel2 START
                    $senior_id71=$row7['ref_id'];
                    $insert71=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id71");
                    while($row71=mysql_fetch_array($insert71)) 
                    {   
                        $amount71=$row71['distributor_amount'];
                        $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$senior_id71,0)");
                        $M += $amount71;
                        $insert71=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$senior_id71");
//                        //LEvel3 START
//                        $senior_id72=$row71['ref_id'];
//                        $insert72=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id72");
//                        while($row72=mysql_fetch_array($insert72)) 
//                        {   
//                            $amount72=$row72['distributor_amount'];
//                            $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id72,0)");
//                            $DN += $amount72;
//                            $insert72=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id72");
//                        }//LEvel3 CLOSE

                    }//LEvel2 CLOSE
                    
                    
            
                }//LEvel1 CLOSE
            
            }
            else if($rank_id=='0000000008')
            {   
                $SE1="";
$SM1="";
$DL1="";
$DB1="";
$S1="";
$SS1="";
$EM1="";
$M1="";
//$DN1=;
                 $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
                       while($row31=mysql_fetch_array($qry31))
                       {
                            $SE1=$row31[product_se];
                            $SM1=$row31[product_sm];
                            $DL1=$row31[product_dl];
                            $DB1=$row31[product_db];
                            $S1=$row31[product_s];
                            $SS1=$row31[product_ss];
                            $EM1=$row31[product_em];
                            $M1=$row31[product_m];
                          //  $DN1=$row31[product_dn];
                       }
               
                
                
                
                $M=(($SE1+$SM1+$DL1+$DB1+$S1+$SS1+$EM1+$M1)*(float)$product_total)/100;
               // $DN=($DN1*(float)$product_total)/100;
                //LEvel1 START
                $insert80=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
                while($row80=mysql_fetch_array($insert80)) 
                {   
                    //LEvel1 START
                    $amount80=$row80['distributor_amount'];
                    $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($M,$lastid,$product_user,0)");
                    $M += $amount80;
                    $insert8=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$M WHERE `distributor_id`=$product_user");
//                    //LEvel2 START
//                    $senior_id81=$row8['ref_id'];
//                    $insert81=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$senior_id81");
//                    while($row81=mysql_fetch_array($insert81)) 
//                    {   
//                        //LEvel1 START
//                        $amount81=$row81['distributor_amount'];
//                        $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$senior_id81,0)");
//                        $DN += $amount81;
//                        $insert81=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$senior_id81");
//
//                    }//LEvel2 CLOSE
            
                }//LEvel1 CLOSE
            
            }
//            else if($rank_id=='0000000009')
//            {
//                            $SE1="";
//                            $SM1="";
//                            $DL1="";
//                            $DB1="";
//                            $S1="";
//                            $SS1="";
//                            $EM1="";
//                            $M1="";
//                            $DN1=;
//                 $qry31=mysql_query("SELECT * FROM `tbl_product` WHERE product_name='$product_name'");
//                       while($row31=mysql_fetch_array($qry31))
//                       {
//                            $SE1=$row31[product_se];
//                            $SM1=$row31[product_sm];
//                            $DL1=$row31[product_dl];
//                            $DB1=$row31[product_db];
//                            $S1=$row31[product_s];
//                            $SS1=$row31[product_ss];
//                            $EM1=$row31[product_em];
//                            $M1=$row31[product_m];
//                            $DN1=$row31[product_dn];
//                       }
//               
//                
//                
//                
//                $DN=(($SE1+$SM1+$DL1+$DB1+$S1+$SS1+$EM1+$M1+$DN1)*(float)$product_total)/100;
//                
//                $insert90=mysql_query("SELECT * FROM `tbl_cmember` WHERE `distributor_id`=$product_user");
//                while($row90=mysql_fetch_array($insert9)) 
//                {   
//                    //LEvel1 START
//                    $amount90=$row90['distributor_amount'];
//                      $insert2 = mysql_query ("INSERT INTO `tbl_commission`(`commission_amount`, `invoice_id`, `user_id`, `commission_flag`) VALUES ($DN,$lastid,$product_user,0)");
//                    $DN += $amount90;
//                    $insert90=mysql_query("UPDATE `tbl_cmember` SET `distributor_amount`=$DN WHERE `distributor_id`=$product_user");
//                }//LEvel1 CLOSE
// 
//                 
//            }
        
            else{
                
            }
    
          $_SESSION['SESS_PAN_ID']=$lastid;  
                 header('location: print.php'); 
    
    
    
    
    
                 
                                
}
          
          
          
      }
        
   
    
    
 

}
?>

<!DOCTYPE html>
<html><?php include "../requirements/head.php"?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <?php include "../requirements/header.php"?>
  <!-- Left side column. contains the logo and sidebar -->
  <?php include "../requirements/side_menu.php"?>
  <!-- Left side column. contains the logo and sidebar -->
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      
      <section class="content">
          
          <div class="row"><br/> </div>
    
        <div class="row">
   <div class="col-md-12">

         
                         <div class="box box-danger">
            <div class="box-header">
                <div class="col-md-12">
                    <div class="col-md-4"></div>
                <div class="col-md-4">
              <h5 class="box-title"><b>New Sale Request</b></h5>
                </div>
            </div>

            <div class="box-body">
                 
                <form name="new_pan" id="new_pan" action="" method="post" enctype="multipart/form-data">
                    <h4><b>1.PERSONAL INFORMATION</b> </h4>
                
                     <div class="form-group col-md-12"> 
                        <div class="input-group">
                            <b> Full Name of Applicant&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </b>
                        </div>
                    </div> <!-- Applicant Name Gender-->
                    
                    <div class="form-group col-md-12">
                            <div class="form-group col-md-3">       
                        <div class="input-group">
                       <div class="input-group-addon">
                                <b> Applicant Title </b> <i class="glyphicon glyphicon-phone"></i>
                            </div>   
                    
                    <select class="form-control" name="formGender1" required>
                      <option value="">-----------------Select----------------------</option>
                      <option value="mr">Shri</option>
                      <option value="mrs">Smt/Mrs</option>
                      <option value="ms">Kumari/MS</option>
                    </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                           <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <input type="text" class="form-control" name="a_lname" id="a_lname" placeholder="Last Name Required" required>
                    </div>
                        </div> 
                        <div class="col-md-3">
                      <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <input type="text" class="form-control" name="a_fname" id="a_fname" placeholder="First Name">
                    </div>
                         </div>
                        <div class="col-md-3">
                      <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-user"></i>
                      </div>
                      <input type="text" class="form-control" name="a_mname" id="a_mname" placeholder="Middle Name">
                    </div>
                         </div>
                    </div> <!-- Applicant Name Gender-->
                    
                    
                    <div class="form-group col-md-6">
                              <div class="input-group">
                                  <font color="red">*</font>  
                                <b>Gender:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="gender" value="female">Female 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="gender" value="male">Male
                            </div>
                          </div><!-- Gender -->
            
                                  
                     <?php echo $product_names3;?>
                          <div class="form-group col-md-6">
                              <div class="input-group">
                                                              <div class="input-group-addon">
                                       <font color="red">*</font> 
            <b> User_ID </b><i class="glyphicon glyphicon-phone"></i>
            </div>
        
                                  <input type="text" class="form-control" name="user_id" list="crystal-names" placeholder="distributor id" required>
                              </div>
                        </div> <!-- Reminder Message --> 
                    
                         <!-- Contact Details-->             
                    <div class="form-group col-md-12">
                <div class="input-group">   
                       <h4><b> 2.CONTACT DETAILS</b> </h4>                
                  </div>
              </div>
              
                    <div class="form-group col-md-12">
                       <div class="input-group">
                            <b> Telephone Number </b>
                       </div>
                    </div><!-- Contact Details Telephone-->             
                    
                    <div class="form-group col-md-6">

                <div class="input-group">
                  <div class="input-group-addon">
                      <font color="red">*</font> 
                    <b>Telephone/Mobile No</b> <i class="glyphicon glyphicon-phone"></i>
                  </div>
                  <input type="text" class="form-control" name="mobile_number" id="mobile_number" placeholder="The Telephone No. field is required." required >
                </div>
                    </div> <!-- Contact Details Mobile-->  
                    <div class="form-group col-md-6">

                <div class="input-group">
                  <div class="input-group-addon">
                      
                  <b> Email_ID </b><i class="glyphicon glyphicon-phone"></i>
                  </div>
                  <input type="email" class="form-control" name="email_id" id="email_id" placeholder="The email field is required.">
                </div>
                    </div><!-- Contact Details Email-->  
                    
        
              <div class="form-group col-md-12">
                <div class="input-group">   
                       <h4><b> 3.Product Details</b> </h4>  
                    
                  </div>
                  <div class="input-group pull-right">
                  <button type="button" class="btn btn-info btn-sm" onclick="add_crystal_row();">Add Row</button>
                  </div>
                  <?php echo $product_names;?>
                  
                  <table class="table table-bordered">
                      <thead>
                        <tr>
                            <th></th>
                            <th>Item</th>
                            <th>Unit Cost</th>
                            <th>Quantity</th>
                            <!--<th>Tax</th>-->
                            <th>Price</th>
                        </tr>
                      </thead>
                      <tbody id="crystal-table">
                          <tr class="crystal-item">
                              <td></td>
                              <td><input type="text" name="product_name[]" list="crystal-item-names" class="form-control search-item" /></td>
                              <td><input type="text" name="product_cost[]" class="form-control unit-cost" onkeyup="item_calculation()"/></td>
                              <td><input type="number" name="product_qty[]"class="form-control unit-qty" onkeyup="item_calculation()" value="" step="1"/></td><!--
                              <td><input type="hidden" name="new-tax[]" class="form-control new-tax" readonly/><input type="hidden" class="unit-tax" value="" /></td>-->
                              <td><input type="text" name="net-price[]" class="form-control net-price" readonly/></td>
                          </tr>
                         </tbody> 
                      <tfoot>
                          <tr id="subtotal-row">
                              <td colspan="3"></td>
                              <td>Sub-Total</td>
                              <td id="subtotal-val" name="product_subtotal">0
                              </td>
                              <input type="hidden" class="subtotal-val" name="product_subtotal">
                          </tr>
                          <tr></tr>    
                          <!--
                          <tr id="tax-row">
                              <td colspan="4"></td>
                              <td>Tax</td>
                              <td id="tax-val" name="product_totaltax">0
                              </td>
                              <input type="hidden" class="tax-val" name="product_totaltax">
                          </tr>-->
                          <tr id="total-row">
                              <td colspan="3"></td>
                              <td>Total</td>
                              <td  id="total-val" name="product_total">0</td>
                              <input type="hidden" class="total-val" name="product_total">
                          </tr>
                      </tfoot>
                  
                  
                  </table>
               </div>      
                <div class="row"><br></div>
                <div class="row">
                  <div class="col-md-4"> <button type="submit" class="btn btn-block btn-success" name="submit">Save</button></div>
                   <div class="col-md-4"><button type="button" class="btn btn-block btn-warning" onclick="myFunction()" value="Reset form" >Clear</button></div>
                 <a href="index.php">  <div class="col-md-4"><button type="button" class="btn btn-block btn-info">Back</button></div></a>
                    
               </div>
                </form>
          </div>      
          </div>
       </div></div></div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 
<?php include "../requirements/footer.php"?>
</div>
<!-- ./wrapper -->

<?php include "../requirements/scripts.php"?>
    <script>
function myFunction() {
    document.getElementById("new_case").reset();
}
</script>
   <script>
                 
       jQuery(document).ready(function(){
           
           jQuery(document).on('change', '.search-item', function(){
               var item_object = jQuery(this);
               var val_product = jQuery(this).val();
               var x = jQuery(this).parents('tr');
               jQuery.ajax({
    type: "POST",
    url: "fetch-product.php",
    data: {
        productName: val_product
    },
    success: function(data){
        var splitted_text = data.split("#@#");
//        console.log(item_object.parent().parent());
        x.find('.unit-cost').val(splitted_text[0]);
        x.find('.unit-tax').val(splitted_text[1]);
        x.find('.unit-qty').val('1');
        item_calculation();
        
    }
});
           });
       });
       
       function item_calculation() {
           var sub_total = 0;
           var individual = 0;
           var total_tax = 0;
         
           var total_amount = 0;
           jQuery(".crystal-item").each(function(){
               var item_cost = jQuery(this).find('.unit-cost').val();
               var item_qty = jQuery(this).find('.unit-qty').val();
               var item_tax = jQuery(this).find('.unit-tax').val();
               
               var net_amount= item_cost * item_qty;
               var net_tax= 0;
               var gross_price= net_amount + net_tax;
                jQuery(this).find('.new-tax').val(net_tax);
                jQuery(this).find('.net-price').val(gross_price);
               
               sub_total += net_amount;
               total_tax += net_tax;
               total_tax1 = net_tax.toFixed(2);
               
               total_amount =sub_total;
               
               
           });
           total_amount1=total_amount.toFixed();
           
               jQuery("#subtotal-val").text(sub_total);
               jQuery(".subtotal-val").val(sub_total);
               
               jQuery("#tax-val").text(total_tax1);
               jQuery(".tax-val").val(total_tax1);
               
              jQuery("#total-val").text(total_amount1);
              jQuery(".total-val").val(total_amount1);
           
       }
       
       
                  </script>
                  
               
    
    </body>
</html>