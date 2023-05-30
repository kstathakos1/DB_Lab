<?php
    include ('config/database.php');

    $username = $_POST['username'];
    $ISBN = $_POST['ISBN'];
    $currentDate = date('Y-m-d');
    if (!isset($_SESSION)) session_start();

    $conn = getDb();
    
    $sql = "INSERT INTO reservation (username, ISBN,reservation_date) VALUES ( '$username', '$ISBN','$currentDate')";

    var_dump($sql);
    $result = mysqli_query($conn, $sql);

    header("Location: book.php?ISBN=$ISBN");
?>