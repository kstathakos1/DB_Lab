<?php
include('config/database.php');
if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$school_id=$_SESSION['id'];
$author = $_GET['author'];
$conn = getDb();
$book = $conn->query("SELECT distinct *
FROM copies_per_school cps
inner join book_author ba on cps.ISBN = ba.ISBN
where authors_id=(select routine_name('$author') ) and school_id=$school_id
;");
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
    <title>Author <?=$author?></title>

</head>
<body>
<?php include('navbar.php'); ?>
<h4 style="margin-top: 5%; margin-left: 10%;">Book List of <?= $author ?> </h4>
<?php if(empty($book)): ?>
    <p class="lead mt3">There are no books</p>
<?php endif; ?>

<?php foreach($book as $item):
    $isbn = $item['ISBN'];?>
    <div style="display: flex; flex-direction: row; margin-left: 10%;" class = "card my-3 w-75">
        <div class = "card-body text-left">
            <img
                    src="<?= $item['image'] ?>"
                    vspace="20"
                    hspace="10"
                    width="70"
            >
            <div style="display: inline-block; flex-direction: column;">
                <a style="color: black;" href="book.php?ISBN=<?=$isbn?>"><?php echo $item['title'] ?></a>
                <div style="font-size: 10px;"> <?php echo $item['publisher'] ?></div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</body>