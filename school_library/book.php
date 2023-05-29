<?php
include('config/database.php');

if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$bookIsbn = $_GET['ISBN'];

$conn = getDb();

$book = $conn->query("SELECT summary, page, image, title, ISBN FROM book WHERE ISBN=$bookIsbn");
$author = $conn->query("SELECT distinct  concat(authors_first_name,' ',authors_last_name) as name
FROM author_name_book
where ISBN=$bookIsbn ;");
$author1 = mysqli_fetch_assoc($author);

?>

<html>
<head>
    <!-- Import css and js packages -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css?<?= time() ?>">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>

    <link rel="shortcut icon" href="library.jpg" type="image/x-icon">
    <title>Book Details</title>

</head>
<body>
<?php include('navbar.php'); ?>

<!--                align="top"-->
<!--                width="288" height="278"-->
<!--                align="flex-start"-->
<!--                vspace="60"-->
<!--                hspace="15"-->

<div style="margin-left: 10%;">
    <?php while ($result = $book->fetch_assoc()) { ?>
        <h4 style="margin-top: 5%;">
            <div> <?= $result['title'] ?> </div>
        </h4>
        <div class="book_page">
            <img src="<?= $result['image'] ?>" class="book_half_image">
            <div class="book_half">
                <div class='bold'> Summary:</div>
                <div> <?= $result['summary'] ?> </div>
                <div class="bold" style="margin-top: 10px">Athors</div>

                <?php foreach ($author as $item):
                    $author_name = $item['name']; ?>
                    <div >

                        <div class=>
                            <a style="color: black;"
                               href="authors.php?=<?= $item['name'] ?>"><?php echo $item['name'] ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="align_next">
            <div class='bold'> ISBN :&nbsp;</div>
            <div>  <?= $result['ISBN'] ?> </div>

        </div>
        <div> Number of pages: <?= $result['page'] ?> </div>
    <?php } ?>
</div>

<form id="reservation" method="POST" action="reserve.php" autocomplete="on">
    <button
            class="btn btn-secondary btn-lg btn-dark button-position"
            type="submit"
    >
        Reserve
    </button>
    <input type="hidden" id="username" name="username" value="<?= $username ?>"/>
    <input type="hidden" id="ISBN" name="ISBN" value="<?= $bookIsbn ?>"/>
</form>


</body>