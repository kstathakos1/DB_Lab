<?php
    include ('config/database.php');

    $username = $_POST['username'];
    $ISBN = $_POST['ISBN'];

    if (!isset($_SESSION)) session_start();

    $conn = getDb();
    
    $sql = "INSERT INTO reservation (username, ISBN) VALUES ( '$username', '$ISBN')";
    var_dump($sql);

    $result = mysqli_query($conn, $sql);

    header("Location: book.php?ISBN=$ISBN");
?>