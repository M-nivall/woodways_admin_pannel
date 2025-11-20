<?php

include '../../include/connections.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pet_name = $_POST['pet_name'] ?? '';
    $species  = $_POST['species'] ?? '';
    $breed    = $_POST['breed'] ?? '';
    $gender   = $_POST['gender'] ?? '';
    $dob      = $_POST['dob'] ?? '';
    $weight   = $_POST['weight'] ?? '';
    $client_id = $_POST['client_id'] ?? '';

    // ---------------------
    // Validate Required Fields
    // ---------------------
    if (
        empty($pet_name) ||
        empty($species) ||
        empty($breed) ||
        empty($gender) ||
        empty($dob) ||
        empty($weight)
    ) {
        $response["status"] = 0;
        $response["message"] = "All fields are required";
        echo json_encode($response);
        mysqli_close($con);
        exit;
    }

    // ---------------------
    // Insert into Pets Table
    // ---------------------
    $insert = "INSERT INTO pets(pet_name, species, breed, gender, date_of_birth, weight, client_id)
               VALUES ('$pet_name','$species','$breed','$gender','$dob','$weight','$client_id')";

    if (mysqli_query($con, $insert)) {

        $response["status"] = 1;
        $response["message"] = "Pet registered successfully";
        echo json_encode($response);

    } else {

        $response["status"] = 0;
        $response["message"] = "Failed to register pet. Try again.";
        echo json_encode($response);
    }

    mysqli_close($con);
}
?>
