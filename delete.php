<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "iceicebabybaby99!", "visita_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_favorite'])) {
    $favoriteId = $_POST['favorite_id'];
    $userId = $_SESSION['user_id'];

    $deleteSql = "DELETE FROM favorites WHERE user_id = ? AND destination_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);

    if ($deleteStmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $deleteStmt->bind_param("ii", $userId, $favoriteId);

    if (!$deleteStmt->execute()) {
        die("Execute failed: " . $deleteStmt->error);
    }

    $deleteStmt->close();
    $conn->close();

    // Redirect back to the favorites section
    header("Location: afterLogin.php");
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>
