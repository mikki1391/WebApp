<?php
    session_start();
    require_once 'config.php';

    function register_user($username, $email, $password) {
    global $pdo;

    // Проверка учетной записи
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
    $stmt->execute(['username' => $username, 'email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        if ($user['username'] === $username) {
            return "Username already exists.";
        }
        if ($user['email'] === $email) {
            return "Email already exists.";
        }
    }

    // хеш пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Добавить пользователя в бд
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
    $result = $stmt->execute([
        'username' => $username,
        'email' => $email,
        'password' => $hashed_password,
    ]);

    if ($result) {
        // Авторизация
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        return true;
    }

    return "Registration failed. Please try again.";
    }

    function authenticate_user($username, $password) {
        global $pdo;
    
        // Извлечение пользователя из бд
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
    
        // Проверка пароля
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
    
        return false;
    }
    
    function submit_ad($title, $description, $user_id) {
        global $pdo;
    
        // Запись обьявления в базу
        $stmt = $pdo->prepare("INSERT INTO ads (title, description, user_id) VALUES (:title, :description, :user_id)");
        $result = $stmt->execute([
            'title' => $title,
            'description' => $description,
            'user_id' => $user_id,
        ]);
    
        return $result;
    }
    
    function fetch_ads() {
        global $pdo;
    
        // Извлечь объявления и имена пользователей из базы данных
        $stmt = $pdo->query("SELECT ads.*, users.username FROM ads JOIN users ON ads.user_id = users.id ORDER BY created_at DESC");
        $ads = $stmt->fetchAll();
    
        return $ads;
    }

    function create_ad($title, $description, $user_id) {
        global $pdo;
    
        // Запрос SQL для записи в базу обьявлений
        $stmt = $pdo->prepare("INSERT INTO ads (title, description, user_id) VALUES (:title, :description, :user_id)");
    
        // Привязка данных к SQL запросу
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':user_id', $user_id);
    
        // Запрос SQL возврат ID в случае успеха
        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        } else {
            return false;
        }
    }
    
    
    
    

?>
