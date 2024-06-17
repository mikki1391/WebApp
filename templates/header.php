<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой сайт объявлений</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
            <ul>
                    <li><a href="index.php">Главная страница</a></li>
                    <li><a href="login.php">Войти</a></li>
                    <li><a href="register.php">Зарегестрироваться</a></li>
                    <li><a href="post_ad.php">Добавить объявление</a></li>
                    <li><a href="ads.php">Все объявления</a></li>
                    <li>
                        <?php if (isset($_SESSION['username'])): ?>
                        <div class="user-info">
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </div>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
           
        </div>
    </header>
