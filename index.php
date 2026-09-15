<?php
// Connect PHP to MySQL.
$connection = new mysqli(
    "localhost",
    "root",
    "",
    "mini_web_app"
);

// Stop and show an error if the connection fails.
if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

// Allow normal text, symbols, and emojis.
$connection->set_charset("utf8mb4");

// Retrieve all saved messages, newest first.
$result = $connection->query(
    "SELECT name, message, created_at
     FROM messages
     ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Mini Message Board</title>

    <!-- Connect this page to the separate CSS file. -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <main class="container">
        <h1>Mini Message Board</h1>

        <p class="description">
            Write a message and save it to MySQL.
        </p>

        <?php if (isset($_GET["saved"])): ?>
            <p class="success-message">
                Your message was saved successfully.
            </p>
        <?php endif; ?>

        <?php if (isset($_GET["error"])): ?>
            <p class="error-message">
                Please complete both fields.
            </p>
        <?php endif; ?>

        <form
            id="messageForm"
            action="save.php"
            method="post"
        >
            <div class="form-group">
                <label for="name">Your name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    maxlength="100"
                    required
                >
            </div>

            <div class="form-group">
                <label for="message">Your message</label>

                <textarea
                    id="message"
                    name="message"
                    rows="5"
                    maxlength="500"
                    required
                ></textarea>
            </div>

            <button type="submit" id="submitButton">
                Save Message
            </button>
        </form>

        <section class="messages-section">
            <h2>Saved Messages</h2>

            <?php if ($result && $result->num_rows > 0): ?>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <article class="message-card">
                        <h3>
                            <?php
                            echo htmlspecialchars(
                                $row["name"],
                                ENT_QUOTES,
                                "UTF-8"
                            );
                            ?>
                        </h3>

                        <p>
                            <?php
                            echo nl2br(
                                htmlspecialchars(
                                    $row["message"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                )
                            );
                            ?>
                        </p>

                        <small>
                            <?php
                            echo htmlspecialchars(
                                $row["created_at"],
                                ENT_QUOTES,
                                "UTF-8"
                            );
                            ?>
                        </small>
                    </article>

                <?php endwhile; ?>

            <?php else: ?>

                <p>No messages have been saved yet.</p>

            <?php endif; ?>
        </section>
    </main>

    <!-- Connect this page to the separate JavaScript file. -->
    <script src="script.js"></script>

</body>
</html>

<?php
$connection->close();
?>