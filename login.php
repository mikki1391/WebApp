<?php
require_once 'includes/functions.php';

// Проверка авторизации пользователя
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $errors = [];

    // Правильность формы
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // Если нет ошибок, вход в систему
    if (empty($errors)) {
        if ($user = authenticate_user($username, $password)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION[' '] = $user['username'];
            header("Location: ads.php");
            exit();
        } else {
            $errors[] = "Invalid username or password";
        }
    }
}

require_once 'templates/header.php';
?>

<main>
    <div class="container">
        <h1>Авторизация</h1>
        <form action="login.php" method="post">
            <label for="username">Логин</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Пароль</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" value="Login">
        </form>

        <?php
        // Вывод ошибок
        if (!empty($errors)) {
            echo "<ul class='errors'>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>
</main>

<?php require_once 'templates/footer.php'; ?>
