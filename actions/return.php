<?php
include '../includes/db.php';

$loan_id = $_GET['id'];
$conn->query("UPDATE loans SET returned = 1 WHERE id = $loan_id");

$book_id_query = $conn->query("SELECT book_id FROM loans WHERE id = $loan_id");
$book_id = $book_id_query->fetch_assoc()['book_id'];

$conn->query("UPDATE books SET available_copies = available_copies + 1 WHERE id = $book_id");

header('Location: ../admin/dashboard.php?page=loans');
?>
