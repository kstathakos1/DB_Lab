<?php
include('../config/database.php');

if (!isset($_SESSION)) session_start();
$conn = getDb();
$school_id = $_SESSION['id'];
$title = $_POST['title'];
$new_isbn = $_POST['ISBN'];
echo $new_isbn . "<br>";
$summary = $_POST['summary'];
$numpage = $_POST['numpage'];
$image=$_FILES['image1'];
$full_path = $image['tmp_name'];
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
print_r($image);
$new_authors = $_POST['author'];
$new_authors_array = explode(", ", $new_authors);
$language = $_POST['language'];
$new_categories = $_POST['category'];
$new_category_array = explode(", ", $new_categories);
$publisher = $_POST['publisher'];
$old_isbn = $_GET['ISBN'];
$old_authors = $_GET['AUTHOR'];
$old_category = $_GET['CATEGORY'];
$old_authors_array = explode(", ", $old_authors);
$old_category_array = explode(", ", $old_category);

$sql_lanquage = $conn->query("select language_id('$language') as li");
$row_new_language = mysqli_fetch_assoc($sql_lanquage);

if ($row_new_language['li'] == null) {
    $insert_language = $conn->query("insert into language (language) VALUES ('$language')");
}
if ($old_isbn == $new_isbn) {
    {
        $sql = "update book
    set title='$title',summary='$summary',language_id=(select language_id('$language') as li), publisher='$publisher',page=$numpage,image='$image_url'
    where ISBN=$new_isbn ;";
        $sql = $conn->query($sql);
    }
    {
        $c = 0;
        $count_old_authors = count($old_authors_array);
        $count_new_authors = count($new_authors_array);
        foreach ($new_authors_array as $new_author) {
            $sql_new_author_id = $conn->query("select routine_name('$new_author') as name_id; ");
            $old_author_name = $old_authors_array[$c];
            $sql_old_author_id = $conn->query("SELECT routine_name('$old_author_name') AS name_id; ");
            $row_new_authors = mysqli_fetch_assoc($sql_new_author_id);
            $row_old_authors = mysqli_fetch_assoc($sql_old_author_id);
            if ($row_new_authors['name_id'] == null) {
                list($first_name, $last_name) = explode(" ", $new_author, 2);
                $insert_author = $conn->query("insert into author (authors_first_name, authors_last_name) VALUES ('$first_name','$last_name')");
                $new_authors_id = $conn->query("select routine_name('$new_author') as name_id; ");
                $row_new_authors = mysqli_fetch_assoc($new_authors_id);
                $author = $row_new_authors['name_id'];
            } else {
                $author = $row_new_authors['name_id'];
            }
            $old_author_id = $row_old_authors['name_id'];
            $author_update = $conn->query("update book_author set authors_id=$author where (ISBN=$new_isbn and authors_id=$old_author_id);");
            if ($c == $index_author = min($count_new_authors, $count_old_authors) - 1)
                break;
            $c++;
        }
        $index_author += 1;
        $differrens_authors = $count_new_authors - $count_old_authors;
        if ($differrens_authors > 0) {
            for ($i = 0; $i < $differrens_authors; $i++) {
                $new_author = $new_authors_array[$index_author + $i];
                $sql_new_author_id = $conn->query("select routine_name('$new_author') as name_id; ");
                $row_new_authors = mysqli_fetch_assoc($sql_new_author_id);
                if ($row_new_authors['name_id'] == null) {
                    list($first_name, $last_name) = explode(" ", $new_author, 2);
                    $insert_author = $conn->query("insert into author (authors_first_name, authors_last_name) VALUES ('$first_name','$last_name')");
                    $new_authors_id = $conn->query("select routine_name('$new_author') as name_id; ");
                    $row_new_authors = mysqli_fetch_assoc($new_authors_id);
                    $author = $row_new_authors['name_id'];
                } else {
                    $author = $row_new_authors['name_id'];
                }
                $book_author_insert = $conn->query("insert into book_author (authors_id,ISBN) VALUES ($author,$new_isbn)");

            }

        }
        if ($differrens_authors < 0) {
            for ($i = 0; $i < abs($differrens_authors); $i++) {
                $old_author_name = $old_authors_array[$index_author + $i];
                $sql_old_author_id = $conn->query("SELECT routine_name('$old_author_name') AS name_id; ");

                $row_old_authors = mysqli_fetch_assoc($sql_old_author_id);
                $old_author_id = $row_old_authors['name_id'];
                $delete_book_author = $conn->query("delete from book_author where authors_id=$old_author_id and ISBN=$new_isbn ;");
            }
        }
    }
    $k = 0;
    $count_new_category = count($new_category_array);
    $count_old_category = count($old_category_array);
    foreach ($new_category_array as $new_category) {
        $sql_new_category_id = $conn->query("select category_id('$new_category') as cat_id ; ");
        $old_category = $old_category_array[$k];
        $sql_old_category_id = $conn->query("select category_id('$old_category') as cat_id ;");
        $row_new_category = mysqli_fetch_assoc($sql_new_category_id);
        $row_old_category = mysqli_fetch_assoc($sql_old_category_id);
        if ($row_new_category['cat_id'] == null) {
            $insert_category = $conn->query("insert into category (category) VALUES ('$new_category');");
            $new_category_id = $conn->query("select category_id('$new_category') as cat_id ; ");
            $row_new_category = mysqli_fetch_assoc($new_category_id);
            $category = $row_new_category['cat_id'];
        } else
            $category = $row_new_category['cat_id'];
        $old_category_id = $row_old_category['cat_id'];
        $category_update = $conn->query("update book_category set category_id=$category where (ISBN=$new_isbn and category_id=$old_category_id );");

        if ($k == $index_category = min($count_new_category, $count_old_category) - 1)
            break;
        $k++;
    }
    $index_category += 1;
    $differens_category = $count_new_category - $count_old_category;
    if ($differens_category > 0) {
        for ($i = 0; $i < $differens_category; $i++) {
            $new_category = $new_category_array[$index_category + $i];
            $sql_new_category_id = $conn->query("select category_id('$new_category') as cat_id ; ");
            $row_new_category = mysqli_fetch_assoc($sql_new_category_id);
            if ($row_new_category['cat_id'] == null) {
                $insert_category = $conn->query("insert into category (category) VALUES ('$new_category');");
                $new_category_id = $conn->query("select category_id('$new_category') as cat_id ; ");
                $row_new_category = mysqli_fetch_assoc($new_category_id);
                $category = $row_new_category['cat_id'];
            } else
                $category = $row_new_category['cat_id'];
            $book_category_insert = $conn->query("insert into book_category (ISBN,category_id) VALUES ($new_isbn,$category);");
        }
    }
    if ($differens_category < 0) {
        for ($i = 0; $i < abs($differens_category); $i++) {
            $old_category = $old_category_array[$index_category + $i];
            $sql_old_category_id = $conn->query("select category_id('$old_category') as cat_id ;");
            $row_old_category = mysqli_fetch_assoc($sql_old_category_id);
            $old_category_id = $row_old_category['cat_id'];
            $delete_book_category = $conn->query("delete from book_category where category_id=$old_category_id and ISBN=$new_isbn ;");
        }
    }


} else {
    $sql_lanquage = $conn->query("select language_id('$language') as id ; ");
    $row_new_language = mysqli_fetch_assoc($sql_lanquage);
    $language_id = $row_new_language['id'];
    $sql_book_insert = $conn->query("insert into book (ISBN,title,image,publisher,page,summary,language_id) VALUES ($new_isbn,'$title','$image_url','$publisher',$numpage ,'$summary',$language_id) ; ");
    $sql_inventory_update = $conn->query("update inventory set ISBN=$new_isbn where school_id=$school_id and ISBN=$old_isbn ;");
    foreach ($new_authors_array as $new_author) {
        echo $new_author;
        $sql_new_author_id = $conn->query("select routine_name('$new_author') as name_id; ");
        $row_new_authors = mysqli_fetch_assoc($sql_new_author_id);
        echo $row_new_authors['name_id'];
        if ($row_new_authors['name_id'] == null) {
            list($first_name, $last_name) = explode(" ", $new_author, 2);
            $insert_author = $conn->query("insert into author (authors_first_name, authors_last_name) VALUES ('$first_name','$last_name')");
            $new_authors_id = $conn->query("select routine_name('$new_author') as name_id; ");
            $row_new_authors = mysqli_fetch_assoc($new_authors_id);
            $author = $row_new_authors['name_id'];
        } else {
            $author = $row_new_authors['name_id'];
        }
        echo $author;
        $author_update = $conn->query("insert into book_author (ISBN, authors_id) Values ($new_isbn, $author)");
    }

    $count_new_category = count($new_category_array);

    foreach ($new_category_array as $new_category) {
        $sql_new_category_id = $conn->query("select category_id('$new_category') as cat_id ; ");
        $row_new_category = mysqli_fetch_assoc($sql_new_category_id);
        if ($row_new_category['cat_id'] == null) {
            $insert_category = $conn->query("insert into category (category) VALUES ('$new_category');");
            $new_category_id = $conn->query("select category_id('$new_category') as cat_id ; ");
            $row_new_category = mysqli_fetch_assoc($new_category_id);
            $category = $row_new_category['cat_id'];
        } else
            $category = $row_new_category['cat_id'];
        $category_update = $conn->query("insert into book_category (ISBN, category_id) Values ($new_isbn, $category);");

    }

}
header("Location: book_change.php?ISBN=$new_isbn");
?>
