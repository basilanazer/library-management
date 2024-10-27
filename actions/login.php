<?php
// Include the database connection
include '../includes/db.php';
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to find the user
    $query = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'admin') {
            header('Location: ../admin/dashboard.php');
        } else if ($user['role'] == 'user') {
            header('Location: ../user/dashboard.php');
        }
    } else {
        // Redirect back to login with an error message
        header('Location: ../index.php?error=Invalid username or password');
    }

    $query->close();
} else {
    // Redirect back to login page if accessed directly
    header('Location: ../index.php');
}
?>
