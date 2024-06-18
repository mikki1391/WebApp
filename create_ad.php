<?php
require_once 'includes/functions.php';

header("Content-Type: application/json");

// Проверка авторизации пользователя и метода POST
if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
    exit();
}

// Собрать данные из формы
$title = trim($_POST['title']);
$description = trim($_POST['description']);
$user_id = $_SESSION['user_id'];

// Создать объявление в базе данных
$ad_id = create_ad($title, $description, $user_id);

// Если объявление было успешно создано, возврат данных объявления в формате JSON
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

