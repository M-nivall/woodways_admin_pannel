<?php

include "../../include/connections.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $orderID = $_POST['orderID'];

    // Update booking status
    $updateBooking = "UPDATE bookings SET order_status = '2' WHERE order_id='$orderID'";
    
    // Update payment status
    $updatePayment = "UPDATE service_payment SET payment_status = 'Paid' WHERE order_id='$orderID'";

    $response = [];

    if(mysqli_query($con, $updateBooking) && mysqli_query($con, $updatePayment)) {
        $response['status'] = 1;
        $response['message'] = 'Payment Approved Successfully';
    } else {
        $response['status'] = 0;
        $response['message'] = 'Please try again';
    }

    echo json_encode($response);
}
?>
