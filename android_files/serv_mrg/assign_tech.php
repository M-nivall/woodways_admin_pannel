<?php

include "../../include/connections.php";


 if($_SERVER['REQUEST_METHOD']=='POST'){

     $orderID=$_POST['orderID'];
     $username=$_POST['username'];
     $service=$_POST['service'];

     $select="SELECT * FROM employees WHERE username='$username'";
     $query=mysqli_query($con,$select);
     $row=mysqli_fetch_array($query);

     $empID=$row['emp_id'];

     $update="UPDATE bookings SET order_status = '3' WHERE order_id='$orderID'";
     if(mysqli_query($con,$update)){

         $insert="INSERT INTO assigned_services ( emp_id, order_id, service_type)VALUES ('$empID','$orderID', '$service')";
         mysqli_query($con,$insert);

         $response['status']=1;
         $response['message']='Service Assigned Successfully';

     }else{
         $response['status']=0;
         $response['message']='Please try again';


     }
     echo json_encode($response);
      }
?>