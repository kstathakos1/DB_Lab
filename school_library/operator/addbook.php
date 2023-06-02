<?php include('../config/database.php');

if (!isset($_SESSION)) session_start();
$conn = getDb();
$school_id = $_SESSION['id'];
$isbn = $_POST['ISBN'];
$title = $_POST['title'];
$authors = $_POST['authors'];
$categories = $_POST['categories'];
$publisher = $_POST['publisher'];
$pages = $_POST['pages'];
$copies=$_POST['copies'];
$language = $_POST['language'];
$image = $_FILES['image'];
$summary = $_POST['summary'];
$authors_array = explode(", ", $authors);
$category_array = explode(", ", $categories);

$sql_lanquage = $conn->query("select language_id('$language') as li");
$row_new_language = mysqli_fetch_assoc($sql_lanquage);
