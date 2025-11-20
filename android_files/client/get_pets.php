<?php

include '../../include/connections.php';

// Get clientID from POST
$clientID = isset($_POST['clientID']) ? $_POST['clientID'] : '';

if (empty($clientID)) {
    echo json_encode([
        'status' => '0',
        'message' => 'Client ID is required'
    ]);
    exit;
}

// Fetch pets for the client
$select = "SELECT * FROM pets WHERE client_id = ?";
$stmt = mysqli_prepare($con, $select);
mysqli_stmt_bind_param($stmt, "s", $clientID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$results = [];
$results['status'] = mysqli_num_rows($result) > 0 ? "1" : "0";
$results['pets'] = array();

if ($results['status'] === "1") {
    while ($row = mysqli_fetch_assoc($result)) {
        $temp = [];
        $temp['petName'] = $row['pet_name'];
        array_push($results['pets'], $temp);
    }
} else {
    $results['message'] = "No pets found";
}

// Output JSON
echo json_encode($results);

?>
