<footer>
        <div class="container">
            <ul>
                <li>
                    <?php if (isset($_SESSION['username'])): ?>
                    <div class="user-info">
                        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                    <?php endif; ?>
                </li>
                <li><a href="logout.php">Разлогиниться</a></li>
            </ul>
            <p>&copy; <?php echo date("Y"); ?> Мой сайт объявлений. Все права направо.</p>
        </div>
    </footer>
</body>
</html>
