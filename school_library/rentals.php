<?php
    include ('config/database.php');

    if (!isset($_SESSION)) session_start();
    $username= $_SESSION['username'];

    $conn = getDb();

    $result = $conn->query("CALL find_my_books('$username')");

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
      <title>Rentals</title>

    </head>
    <body>
        <?php include ('navbar.php');?>

        <h4 style="margin-top: 5%; margin-left: 10%;">Rentals List</h4>

        <?php if(empty($result)): ?>
            <p class="lead mt3">There are no rentals</p>
        <?php endif; ?>
        
        <?php foreach($result as $item): ?>
            <div style="margin-left: 10%;" class = "card my-3 w-75">
            <div class = "card-body text-center">
                <?php echo $item['title'] ?>
            </div>
            </div>
        <?php endforeach; ?>
    </body>
