<?php
    include ('config/database.php');

    if (!isset($_SESSION)) session_start();
    $username= $_SESSION['username'];

    $conn = getDb();

    $result = $conn->query("SELECT c.ISBN, title, publisher FROM book LEFT JOIN book_category c ON c.ISBN=book.ISBN");

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
      <title>Books</title>

    </head>
    <body>
        <?php include ('navbar.php');?>

        <h4 style="margin-top: 5%; margin-left: 10%;">Books List</h4>

        <?php if(empty($result)): ?>
            <p class="lead mt3">There are no books</p>
        <?php endif; ?>
        
        <?php foreach($result as $item): ?>
            <div style="margin-left: 10%;" class = "card my-3 w-75">
            <div class = "card-body text-left">
                <?php echo $item['title'] ?>
                <div style="font-size: 10px;"> <?php echo $item['publisher'] ?></div>
            </div>
            </div>
        <?php endforeach; ?>
    </body>