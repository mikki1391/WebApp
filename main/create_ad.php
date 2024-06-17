<?php
require_once 'includes/functions.php';

header("Content-Type: application/json");

// Check if user is logged in and if the request method is POST
if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
    exit();
}

// Collect ad data from the submitted form
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$user_id = $_SESSION['user_id'];

// Create the ad in the database
$ad_id = create_ad($title, $description, $user_id);

// If the ad was created successfully, return the ad data as JSON
if ($ad_id) {
    echo json_encode([
        "success" => true,
        "ad" => [
            "title" => $title,
            "description" => $description,
            "username" => $_SESSION['username']
        ]
    ]);
} else {
    echo json_encode(["success" => false, "error" => "Error creating ad. Please try again later."
]);
}

