<?php
include '../includes/db.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin_style.css"> <!-- Link to external CSS -->
    <script src="../js/search.js" defer></script> <!-- Link to external JS -->
</head>
<body>
    <div class="header">
        <h2>Admin Dashboard</h2>
        <h1 class="welcome">Welcome, <?php echo $username; ?></h1>
        <a class="logout" href="../actions/logout.php">Logout</a>
    </div>

    <div class="navbar">
        <a href="dashboard.php?page=books" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'books') ? 'active' : ''; ?>">Books</a>
        <a href="dashboard.php?page=loans" class="<?php echo (isset($_GET['page']) && $_GET['page'] == 'loans') ? 'active' : ''; ?>">Loans</a>
        
    </div>

    <?php
    // Determine which section to display
    $page = isset($_GET['page']) ? $_GET['page'] : 'books';

    if ($page == 'loans') {
        // Loan Details
        echo "<h3>Loan Details</h3>
              <table>
                  <tr><th>Username</th><th>Book Borrowed</th><th>Borrowed Date</th><th>Date to Return</th><th>Action</th></tr>";

        $loans = $conn->query("SELECT loans.*, users.username, books.title FROM loans 
                                JOIN users ON loans.user_id = users.id 
                                JOIN books ON loans.book_id = books.id 
                                WHERE loans.returned = 0");

        while ($loan = $loans->fetch_assoc()) {
            echo "<tr>
                    <td>{$loan['username']}</td>
                    <td>{$loan['title']}</td>
                    <td>{$loan['borrowed_date']}</td>
                    <td>{$loan['return_date']}</td>
                    <td><a href='../actions/mark_returned.php?id={$loan['id']}'>Mark as Returned</a></td>
                  </tr>";
        }
        echo "</table>";
    } else {
        // Book Details
        echo "<h3>Book Details</h3>
              <input type='text' id='searchInput' onkeyup='searchBooks()' placeholder='Search for titles or authors...'>
              <table id='booksTable'>
                  <tr><th>ID</th><th>Title</th><th>Author</th><th>Available Copies</th></tr>";

        $books = $conn->query("SELECT * FROM books");
        while ($book = $books->fetch_assoc()) {
            echo "<tr>
                    <td>{$book['id']}</td>
                    <td>{$book['title']}</td>
                    <td>{$book['author']}</td>
                    <td>{$book['available_copies']}</td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
