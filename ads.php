<?php
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch ads from the database
$ads = fetch_ads();

require_once 'templates/header.php';
?>

<main>
    <div class="container">
        
        <h1>Объявления</h1>
        <table class="ads-table">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Автор</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ads as $ad): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ad['title']); ?></td>
                        <td><?php echo htmlspecialchars($ad['description']); ?></td>
                        <td><?php echo htmlspecialchars($ad['username']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>       

        <!-- форма добавления -->
        <form id="ad-form">
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Описание:</label>
            <textarea id="description" name="description" required></textarea>
            <input type="submit" value="Отправить">
        </form>
    </div>
</main>

<script>
    // Add an event listener to the form submit event
    document.getElementById("ad-form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the form from submitting and reloading the page

        // Create a FormData object to collect the form data
        const formData = new FormData(event.target);

        // Send the form data to the create_ad.php file using AJAX
        fetch("create_ad.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // If the ad was created successfully, update the table with the new ad
                const adRow = `
                    <tr>
                        <td>${data.ad.title}</td>
                        <td>${data.ad.description}</td>
                        <td>${data.ad.username}</td>
                    </tr>
                `;
                document.querySelector(".ads-table tbody").insertAdjacentHTML("afterbegin", adRow);
            } else {
                // If there was an error, display the error message
                alert(data.error);
            }
        });
    });
</script>

<?php require_once 'templates/footer.php'; ?>
