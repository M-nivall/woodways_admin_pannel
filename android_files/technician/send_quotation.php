<?php

include "../../include/connections.php";


 if($_SERVER['REQUEST_METHOD']=='POST'){

     $orderID=$_POST['orderID'];
     $empID=$_POST['empID'];
     $materials=$_POST['materials'];
     $serviceFee=$_POST['serviceFee'];
     $serviceNotes=$_POST['serviceNotes'];


     $update="UPDATE bookings SET order_status = '4', service_fee = '$serviceFee', service_notes = '$serviceNotes' WHERE order_id='$orderID'";
     if(mysqli_query($con,$update)){

        $insert = "INSERT INTO tools_requests (emp_id, order_id, materials) VALUES ('$empID', '$orderID', '$materials')";
         mysqli_query($con, $insert);


       // $update2="UPDATE order_items SET item_price='$amount' WHERE order_id='$orderID'";
         //mysqli_query($con,$update2);

         $response['status']=1;
         $response['message']='Quotation Sent, Client Will Recieve an Invoice';

     }else{
         $response['status']=0;
         $response['message']='Please try again';


     }
     echo json_encode($response);
      }
?>