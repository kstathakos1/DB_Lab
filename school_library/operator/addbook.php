<?php include('../config/database.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION)) session_start();
$conn = getDb();
$school_id = $_SESSION['id'];
$isbn = $_POST['ISBN'];
$title = $_POST['title'];
$authors = $_POST['authors'];
$categories = $_POST['categories'];
$publisher = $_POST['publisher'];
$pages = $_POST['pages'];
$copies = $_POST['copies'];
$language = $_POST['language'];
$summary = $_POST['summary'];
$authors_array = explode(", ", $authors);
$category_array = explode(", ", $categories);
$_SESSION['success_log']='';
$image = $_FILES['image'];
print_r($image);
$full_path = $image['tmp_name']; // Use the correct array key to access the temporary path

require 'vendor/autoload.php';

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

Configuration::instance([
    'cloud' => [
        'cloud_name' => 'dxjqxk3v7',
        'api_key' => '357863356125793',
        'api_secret' => '6jFQIC1M2HbpK2eEH9_dRy36wFE'
    ],
    'url' => [
        'secure' => true
    ]
]);

$data = (new UploadApi())->upload($full_path); // Remove the single quotes around $full_path
$image_url= $data['secure_url'];
$sql_lanquage = $conn->query("select language_id('$language') as li");
$row_new_language = mysqli_fetch_assoc($sql_lanquage);
if ($row_new_language['li'] == null) {
    $insert_language = $conn->query("insert into language (language) VALUES ('$language')");
}
$sql_lanquage = $conn->query("select language_id('$language') as li");
$row_new_language = mysqli_fetch_assoc($sql_lanquage);
$language_id = $row_new_language['li'];
$query_book_insert="insert into book (ISBN,title,image,publisher,page,summary,language_id) VALUES ($isbn,'$title','$image_url','$publisher',$pages ,'$summary',$language_id) ; ";
try {
    // Execute the query
    $book_insert = $conn->query($query_book_insert);

    // Check if the query was successful
    if ($book_insert) {
        echo "Record inserted successfully.";
    } else {
        echo "Error: Unable to insert the record.";
    }
} catch (mysqli_sql_exception $e) {
    // Check if the error is due to a duplicate entry
    if ($e->getCode() == 1062) {
        $_SESSION['success'] = 'error';
        $_SESSION['success_log'] .= 'ISBN already exists';
//        header("Location: add_book.php");
    } else {
        echo "Error: " . $e->getMessage();
    }
}
foreach ($authors_array as $authors_name) {
    $sql_author_id = $conn->query("select routine_name('$authors_name') as name_id; ");
    $row_authors = mysqli_fetch_assoc($sql_author_id);
    if ($row_authors['name_id'] == null) {
        list($first_name, $last_name) = explode(" ", $authors_name, 2);
        $insert_author = $conn->query("insert into author (authors_first_name, authors_last_name) VALUES ('$first_name','$last_name')");
        $authors_id = $conn->query("select routine_name('$authors_name') as name_id; ");
        $row_authors = mysqli_fetch_assoc($authors_id);
    }
    $author = $row_authors['name_id'];
    $book_author_insert = $conn->query("insert into book_author (authors_id,ISBN) VALUES ($author,$isbn)");
}
foreach ($category_array as $category_name) {
    $sql_category_id = $conn->query("select category_id('$category_name') as category_id; ");
    $row_categories = mysqli_fetch_assoc($sql_category_id);
    if ($row_categories['category_id'] == null) {
        $insert_author = $conn->query("insert into category (category) VALUES ('$category_name')");
        $sql_category_id = $conn->query("select category_id('$category_name') as category_id; ");
        $row_categories = mysqli_fetch_assoc($sql_category_id);
    }
    $category = $row_categories['category_id'];
    $book_category_insert = $conn->query("insert into book_category (category_id,ISBN) VALUES ($category,$isbn)");
}
for ($i = 0; $i < $copies; $i++) {
    $sql_inventory = $conn->query("insert into inventory (school_id,ISBN) VALUES ($school_id,$isbn)");
}
if (!$sql_lanquage) {
    $_SESSION['success'] = 'error';
    $_SESSION['success_log'] = 'language';
} elseif (!$book_author_insert) {
    $_SESSION['success'] = 'error';
    $_SESSION['success_log'] .= 'author';
} elseif (!$book_category_insert) {
    $_SESSION['success'] = 'error';
    $_SESSION['success_log'] .= 'category';
} elseif (!$sql_inventory) {
    $_SESSION['success'] = 'error';
    $_SESSION['success_log'] .= 'inventory';}
else if ($sql_lanquage&&$book_author_insert&&$book_category_insert&&$sql_inventory&&$book_insert){
    $_SESSION['success'] = 'success';
    $_SESSION['success_log'] = 'The book was added successfully';
}
header("Location: add_book.php");
?>