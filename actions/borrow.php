<?php
include '../includes/db.php';
session_start();

$book_id = $_GET['id'];
$user_id = $_SESSION['user_id'];
$borrow_date = date('Y-m-d');
$return_date = date('Y-m-d', strtotime('+7 days'));

$conn->query("INSERT INTO loans (user_id, book_id, borrowed_date, return_date) VALUES ($user_id, $book_id, '$borrow_date', '$return_date')");
$conn->query("UPDATE books SET available_copies = available_copies - 1 WHERE id = $book_id");

header('Location: ../user/dashboard.php');
?>
