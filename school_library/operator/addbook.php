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

echo $isbn. "<br>";
echo $title. "<br>";
echo $authors. "<br>";
echo $categories. "<br>";
echo $publisher. "<br>";
echo $language. "<br>";
echo $pages. "<br>";
echo $copies. "<br>";

print_r( $image);
echo $summary. "<br>";

//$new_authors_array = explode(", ", $authors);
//
//
//$new_category_array = explode(", ", $categories);
//
//
//$old_isbn = $_GET['ISBN'];
//
//$old_authors = $_GET['AUTHOR'];
//$old_category = $_GET['CATEGORY'];
//$old_authors_array = explode(", ", $old_authors);
//$old_category_array = explode(", ", $old_category);
//
//$sql_lanquage = $conn->query("select language_id('$language') as li");
//$row_new_language = mysqli_fetch_assoc($sql_lanquage);
