<?php
header("Content-Type: application/json");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // force errors to throw exceptions

include '../../include/connections.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method");
    }

    // Receive values from Android
    $clientID = $_POST['clientID'] ?? '';
    $countyID = $_POST['countyID'] ?? '';
    $townName = $_POST['townName'] ?? '';
    $address = $_POST['address'] ?? '';
    $paymentRef = $_POST['paymentRef'] ?? '';
    $serviceName = $_POST['serviceName'] ?? '';
    $servicePrice = $_POST['servicePrice'] ?? '';
    $serviceID = $_POST['serviceID'] ?? '';
    $petName = $_POST['petName'] ?? '';
    $serviceDate = $_POST['serviceDate'] ?? '';

    // Validation
    if (empty($townName)) throw new Exception("Enter town");
    if (empty($address)) throw new Exception("Enter address");
    if (empty($paymentRef)) throw new Exception("Enter payment code");

    // Get town ID
    $townQ = mysqli_query($con, "SELECT town_id FROM towns WHERE town_name='$townName' AND county_id='$countyID'");
    $townRow = mysqli_fetch_assoc($townQ);
    if (!$townRow) throw new Exception("Invalid town");
    $townID = $townRow['town_id'];

    // Delivery details
    $exists = mysqli_query($con, "SELECT * FROM delivery WHERE client_id='$clientID'");
    if (mysqli_num_rows($exists) < 1) {
        mysqli_query($con, "INSERT INTO delivery(county_id, town_id, client_id, address) VALUES('$countyID', '$townID', '$clientID', '$address')");
    } else {
        mysqli_query($con, "UPDATE delivery SET county_id='$countyID', town_id='$townID', address='$address' WHERE client_id='$clientID'");
    }

    // Insert booking
    $insertBooking = "INSERT INTO bookings(client_id, county_id, town_id, address, pet_name, service_id, service_name, service_fee, payment_code, order_status, order_date, service_date)
                      VALUES('$clientID', '$countyID', '$townID', '$address', '$petName', '$serviceID', '$serviceName', '$servicePrice', '$paymentRef', '1', CURDATE(), $serviceDate)";

    if (!mysqli_query($con, $insertBooking)) throw new Exception("Failed to insert booking");

    $orderID = mysqli_insert_id($con);

    // Insert payment
    $insertPayment = "INSERT INTO service_payment(order_id, client_id, amount, payment_code, payment_date)
                      VALUES('$orderID', '$clientID', '$servicePrice', '$paymentRef', CURDATE())";

    if (!mysqli_query($con, $insertPayment)) throw new Exception("Failed to insert payment");

    echo json_encode(["status" => "1", "message" => "Booking Request Received Successfully"]);

} catch (Exception $e) {
    echo json_encode(["status" => "0", "message" => $e->getMessage()]);
}
?>
