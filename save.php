<?php

// Only accept data submitted using POST.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

// Read the form values.
$name = trim($_POST["name"] ?? "");
$message = trim($_POST["message"] ?? "");

// Reject empty fields.
if ($name === "" || $message === "") {
    header("Location: index.php?error=1");
    exit;
}

// Connect to MySQL.
$connection = new mysqli(
    "localhost",
    "root",
    "",
    "mini_web_app"
);

if ($connection->connect_error) {
    die("Database connection failed: " . $connection->connect_error);
}

$connection->set_charset("utf8mb4");

// Prepare the SQL statement safely.
$statement = $connection->prepare(
    "INSERT INTO messages (name, message)
     VALUES (?, ?)"
);

// Place the submitted values into the statement.
$statement->bind_param("ss", $name, $message);

// Save the information.
$statement->execute();

// Close the database resources.
$statement->close();
$connection->close();

// Return to the main page.
header("Location: index.php?saved=1");
exit;