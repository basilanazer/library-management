<?php
include '../includes/db.php';
session_start();
if ($_SESSION['role'] != 'user') {
    header('Location: ../index.php');
}
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username']; // Get the username for welcome message
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="header">
        <h2>User Dashboard</h2>
        <h1 class="welcome">Welcome, <?php echo htmlspecialchars($username); ?></h1>
        <a class="logout" href="../actions/logout.php">Logout</a>
    </div>
    
    <h3>Available Books</h3>
    <table>
        <tr><th>ID</th><th>Title</th><th>Author</th><th>Available Copies</th><th>Action</th></tr>
        <?php
        $books = $conn->query("SELECT * FROM books");
        while ($book = $books->fetch_assoc()) {
            $loan = $conn->query("SELECT * FROM loans WHERE user_id = $user_id AND book_id = {$book['id']} AND returned = 0");
            if ($loan->num_rows > 0) {
                $loan_data = $loan->fetch_assoc();
                echo "<tr>
                        <td>{$book['id']}</td>
                        <td>{$book['title']}</td>
                        <td>{$book['author']}</td>
                        <td>{$book['available_copies']}</td>
                        <td>Return by: {$loan_data['return_date']}</td>
                      </tr>";
            } else {
                if ($book['available_copies'] <= 0) {
                    echo "<tr>
                            <td>{$book['id']}</td>
                            <td>{$book['title']}</td>
                            <td>{$book['author']}</td>
                            <td style='color: red;'>Out of Stock</td>
                            <td><button disabled>Borrow</button></td>
                          </tr>";
                } else {
                    echo "<tr>
                            <td>{$book['id']}</td>
                            <td>{$book['title']}</td>
                            <td>{$book['author']}</td>
                            <td>{$book['available_copies']}</td>
                            <td><a href='../actions/borrow.php?id={$book['id']}'>Borrow</a></td>
                          </tr>";
                }
            }
        }
        ?>
    </table>
</body>
</html>
