<?php
    include ('config/database.php');

    if (!isset($_SESSION)) session_start();
    $username= $_SESSION['username'];
    $ISBN = $_POST['ISBN'];

    $conn = getDb();

    $sql = "DELETE FROM RESERVATION WHERE username = '$username' AND ISBN = '$ISBN'";
    if (mysqli_query($conn, $sql)) {
        header("Location: book.php?ISBN=$ISBN");
    }

?>