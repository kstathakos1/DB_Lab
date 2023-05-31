<?php
include('config/database.php');

if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$bookIsbn = $_GET['ISBN'];

$conn = getDb();
$book = $conn->query("SELECT * FROM book WHERE ISBN=$bookIsbn");
$author = $conn->query("    SELECT distinct  concat(authors_first_name,' ',authors_last_name) as name
                                     FROM author_name_book
                                        where ISBN=$bookIsbn ;");
$category=$conn->query("SELECT *
                                FROM book_category bc
                                inner join category c on bc.category_id = c.category_id
                                where bc.ISBN=$bookIsbn;");


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
                <div class="bold" style="margin-top: 10px">Athors:</div>

                <?php foreach ($author as $item):
                    $author_name = $item['name']; ?>
                    <a style="color: black;"
                       href="author.php?author=<?= $item['name'] ?>"><?php echo $item['name'] ?></a>
                <?php endforeach; ?>
                <div class="bold" style="margin-top: 10px">Category:</div>
                <?php foreach ($category as $item):
                    $category1 = $item['category']; ?>
                    <a style="color: black;"
                       href="category.php?category=<?= $item['category'] ?>"><?php echo $item['category'] ?></a>
                <?php endforeach; ?>
                <div class="bold" style="margin-top: 10px">Publisher:</div>
                <?php foreach ($book as $item):
                    $publisher = $item['publisher']; ?>
                    <a style="color: black;"
                       href="publisher.php?publisher=<?= $item['publisher'] ?>"><?php echo $item['publisher'] ?></a>
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

<?php if (isset($_GET['NotAvailable'])) echo '<div class="alert alert-danger text-center" role="alert"> No available copies right now.</div>' ?>
<?php if (isset($_GET['LimitedReservations'])) echo '<div class="alert alert-danger text-center" role="alert"> You have already reserved two books this week!</div>' ?>
<?php if (isset($_GET['Rented'])) echo '<div class="alert alert-danger text-center" role="alert"> You cant reserve a book you are currently renting.</div>' ?>
<?php if (isset($_GET['NotReturned'])) echo '<div class="alert alert-danger text-center" role="alert"> You have to return your expired book first.</div>' ?>
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