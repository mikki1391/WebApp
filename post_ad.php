<?php
require_once 'includes/functions.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $errors = [];

    // Проверка правильности формы
    if (empty($title)) {
        $errors[] = "Title is required";
    }
    if (empty($description)) {
        $errors[] = "Description is required";
    }

    // Если нет ошибок, отправка обьявления
    if (empty($errors)) {
        if (submit_ad($title, $description, $_SESSION['user_id'])) {
            header("Location: ads.php");
            exit();
        } else {
            $errors[] = "Ad submission failed. Please try again.";
        }
    }
}

require_once 'templates/header.php';
?>

<main>
    <div class="container">
        <h1>Добавить объявление</h1>
        <form action="post_ad.php" method="post">
            <label for="title">Название</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Описание</label>
            <textarea name="description" id="description" rows="5" required></textarea>

            <input type="submit" value="Отправить">
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
