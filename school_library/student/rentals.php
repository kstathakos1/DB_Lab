<!DOCTYPE html>
<html lang="en">
<head> <!-- Import css and js packages -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/custom.css?<?= time() ?>">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/jquery-ui.js"></script>

    <link rel="shortcut icon" href="../library.jpg" type="image/x-icon">
    <meta charset="UTF-8">
    <title>My Rents</title>
    <?php
    include('../config/database.php');

    if (!isset($_SESSION)) session_start();
    $username = $_SESSION['username'];
    $conn = getDb();
    $result = $conn->query("call find_my_books('$username')");
$text='Expected to be returned';

    ?>
</head>
<body>
<?php include ('navbar.php') ?>
<div class="container" id="background">
    <div class="row">
        <div class="centered-table">
            <table class="table table1" style="margin-top: 2%">
                <thead class="thead-dark" >
                <tr>
                    <th scope="col">Book</th>
                    <th scope="col">ISBN</th>
                    <th scope="col">Rent Date</th>
                    <th scope="col">Expected Return Date</th>
                    <th scope="col">Actual Return Date</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($rental = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><a style="color: black;" href="../book.php?ISBN=<?=$rental['ISBN']?>"><?php echo $rental['title'] ?></a></td>
                        <td><?php echo $rental['ISBN']; ?></td>
                        <td><?php echo $rental['rental_date']; ?></td>
                        <td><?php echo $rental['expected_return_date']; ?></td>
                        <td><?php
                            if ($rental['actual_return_date']!=null)
                                echo $rental['actual_return_date'];
                            else
                                echo $text;
                        ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




</body>
</html>