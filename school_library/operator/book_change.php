<?php
include('../config/database.php');

if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$bookIsbn = $_GET['ISBN'];
$status = $_SESSION['status'];
$textareaathor = null;
$textareacategory = null;
$textareapublisher = null;
$c = 0;
$conn = getDb();
$book = $conn->query("SELECT * FROM book WHERE ISBN= $bookIsbn ;");
$author = $conn->query("    SELECT distinct  concat(authors_first_name,' ',authors_last_name) as name
                                     FROM author_name_book
                                        where ISBN=$bookIsbn ;");
$category = $conn->query("SELECT *
                                FROM book_category bc
                                inner join category c on bc.category_id = c.category_id
                                where bc.ISBN=$bookIsbn;");
$language = $conn->query("select l.language as language
                                from book b
                                inner join language l on b.language_id = l.language_id
                                where b.ISBN=$bookIsbn;");
$book1=$conn->query("select * from book where ISBN=$bookIsbn");
$result1=mysqli_fetch_assoc($book1);
while ($row = mysqli_fetch_assoc($author)) {
    // Append the data to the textarea content
    $c++;
    if ($c == mysqli_num_rows($author)) {
        $textareaathor .= $row['name'];
    } else
        $textareaathor .= $row['name'] . ", ";

}
$c = 0;
while ($row = mysqli_fetch_assoc($category)) {
    // Append the data to the textarea content
    $c++;
    if ($c == mysqli_num_rows($category)) {
        $textareacategory .= $row['category'];
    } else
        $textareacategory .= $row['category'] . ", ";

}
$language = mysqli_fetch_assoc($language);
?>

<html>
<head>
    <!-- Import css and js packages -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/custom.css?<?= time() ?>">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/jquery-ui.js"></script>

    <link rel="shortcut icon" href="../library.jpg" type="image/x-icon">
    <title>Book Details</title>

</head>
<body>
<?php include('navbar.php'); ?>

<!--                align="top"-->
<!--                width="288" height="278"-->
<!--                align="flex-start"-->
<!--                vspace="60"-->
<!--                hspace="15"-->
<form id="bookchange" method="POST" action="bookchange.php?ISBN=<?=$bookIsbn?>&AUTHOR=<?=$textareaathor?>&CATEGORY=<?=$textareacategory?>&image=<?=$result1['image']?>" enctype="multipart/form-data" autocomplete="off">
    <div style="margin-left: 10%;">
        <?php while ($result = $book->fetch_assoc()) { ?>

            <div style="display: flex;">
                <h4 style="margin-top: 5%; display:flex;">
                    <div>Title :</div>
                    <textarea name="title" rows="1" cols="35"><?=$result['title']?></textarea>


                </h4>
            </div>
            <div class="book_page">
                <img src="<?=$result['image'] ?>" class="book_half_image">
                <div class="book_half">

                    <div class='bold'> Summary:</div>
                    <div>
                    <textarea name="summary" rows="2" cols="40" class="w-100 container"><?=$result['summary']?>
                        </textarea>
                    </div>
                    <div class="bold" style="margin-top: 10px">Athors:</div>
                    <textarea name="author" rows="1" cols="40" class="w-50 "><?php echo $textareaathor;?></textarea>
                    <div class="bold" style="margin-top: 10px">Category:</div>
                    <textarea name="category" rows="1" cols="40" class="w-50"><?= $textareacategory?></textarea>
                    <div class="bold" style="margin-top: 10px">Publisher:</div>
                    <textarea name="publisher" rows="1" cols="40" class="w-50"><?=$result['publisher']?></textarea>
                    <div class="bold" style="margin-top: 10px">Language:</div>
                    <textarea name="language" rows="1" cols="40" class="w-50"><?=$language['language']?></textarea>

                </div>
            </div><input type="file" class="form-control w-25" id="image1" name="image1">
            <div class="align_next">

                <div class='bold'> ISBN :&nbsp;</div>
                <div style="padding-left:5.4%"><textarea name="ISBN" rows="1" cols="40" class="w-2"
                                                         style="text-align: center;"><?=$result['ISBN']?></textarea>
                </div>

            </div>
            <div style="display: flex;">
                <div class="bold"> Number of pages:</div>
                <div><textarea name="numpage" rows="1" cols="40" class="w-2"
                               style="text-align: center"><?=$result['page']?></textarea>
                </div>
            </div>
        <?php } ?>
    </div>

    <button
            class="btn btn-outline-success button-position fas fa-save fa-xl "
            data-bs-auto-close="outside" type="submit"
    >
        Save Changes
    </button>

</form>


</body>