<?php
include ('config/database.php');

if (!isset($_SESSION)) session_start();
$username= $_SESSION['username'];
$sc=$_SESSION['id'];
$conn = getDb();
$result = $conn->query("select distinct concat(authors_first_name,' ',authors_last_name) as name
from author_name_book anb
inner join inventory i on anb.inventory_id = i.inventory_id
where i.school_id=$sc
order by name
;");

?>

<html>
<head>
    <!-- Import css and js packages -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css?<?=time()?>">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>

    <link rel="shortcut icon" href="library.jpg" type="image/x-icon">
    <title>Authors</title>

</head>
<body>
<?php include ('navbar.php');?>

<h4 style="margin-top: 5%; margin-left: 10%;">Author List</h4>

<?php if(empty($result)): ?>
    <p class="lead mt3">There are no books</p>
<?php endif; ?>

<?php foreach($result as $item):
    $name = $item['name'];?>
    <div style="display: flex; flex-direction: row; margin-left: 10%;" class = "card my-3 w-75">
        <div class = "card-body text-left">
            <div style="display: inline-block; flex-direction: column;">
                <a style="color: black;" href="author.php?author=<?=$name?>"><?php echo $item['name'] ?></a>

            </div>
        </div>
    </div>
<?php endforeach; ?>
</body>