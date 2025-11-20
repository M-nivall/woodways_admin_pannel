<?php

include "../../include/connections.php";


 if($_SERVER['REQUEST_METHOD']=='POST'){

     $orderID=$_POST['orderID'];
     $comments=$_POST['comments'];


     $update="UPDATE bookings SET order_status = '6' WHERE order_id = '$orderID'";
     if(mysqli_query($con,$update)){

         $update="UPDATE assigned_services SET assign_status='Completed', comments = '$comments' WHERE order_id='$orderID'";
         mysqli_query($con,$update);

         $response['status']=1;
         $response['message']='Service Completed Sucessfull, Awaiting Customer Confirmation';

     }else{
         $response['status']=0;
         $response['message']='Please try again';


     }
     echo json_encode($response);
      }
?>