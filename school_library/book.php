<?php
include('config/database.php');

if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$bookIsbn = $_GET['ISBN'];
$status=$_SESSION['status'];

$conn = getDb();
$book = $conn->query("SELECT * FROM book WHERE ISBN=$bookIsbn");
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


?>

<html>
<head>
    <!-- Import css and js packages -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css?<?= time() ?>">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

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
        <div style="display: flex;">
            <h4 style="margin-top: 5%; display:flex;">
                <div> <?= $result['title'] ?> </div>
            </h4>
        <?php if ($status=='operator'){?>
                <a href="operator/book_change.php?ISBN=<?=$bookIsbn?>" style="margin-left: auto;">
                <button style="padding: 8px 12px; margin-top: 50%; margin-right: 100% ;"
                        class="btn btn-secondary btn-lg btn-dark "
                        type="submit"><i class="fas fa-pencil-ruler" style="margin-right: 4px;font-size: 24px;"></i></button></a>
            <?php } ?>

        </div>
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
                <div class="bold" style="margin-top: 10px">Language:</div>
                <?php foreach ($language as $item):
                    $la = $item['language']; ?>
                    <a style="color: black;"
                       href="language.php?language=<?= $la ?>"><?php echo $la ?></a>
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

<?php 
     if (isset($_GET['NotAvailable'])) echo '<div class="alert alert-danger text-center" role="alert"> No available copies right now.</div>';
     if (isset($_GET['LimitedReservations'])) echo '<div class="alert alert-danger text-center" role="alert"> You have already reserved two books this week!</div>'; 
     if (isset($_GET['Rented'])) echo '<div class="alert alert-danger text-center" role="alert"> You cant reserve a book you are currently renting.</div>';
     if (isset($_GET['NotReturned'])) echo '<div class="alert alert-danger text-center" role="alert"> You have to return your expired book first.</div>' ;


    $sql_res = "SELECT * FROM reservation 
                WHERE username = '$username'
                AND ISBN = '$bookIsbn' 
                AND expiration_date >= DATE(CURRENT_TIMESTAMP)";

    $ReservedThisBook = $conn->query($sql_res);
                    
    if($ReservedThisBook->num_rows == 0) { ?>
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

    <?php } 

    if($ReservedThisBook->num_rows != 0) { ?>
            <form id="unreservation" method="POST" action="unreserve.php" autocomplete="on">
                <button
                        class="btn btn-secondary btn-lg btn-dark button-position"
                        type="submit"
                >
                    Unreserve
                </button>
                <div style = "margin-left: 10%">reservation expires in: <?php  $res = mysqli_fetch_array($ReservedThisBook, MYSQLI_ASSOC); echo ($res['expiration_date']) ?> </div>
                <input type="hidden" id="username" name="username" value="<?= $username ?>"/>
                <input type="hidden" id="ISBN" name="ISBN" value="<?= $bookIsbn ?>"/>
            </form>
    
    <?php } ?>


</body>