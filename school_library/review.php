<?php
    include ('config/database.php');

    if (!isset($_SESSION)) session_start();
    $username= $_SESSION['username'];
    $ISBN = $_POST['ISBN'];
    $review = $_POST['review'];
    $review_score = $_POST['likert'];


    $conn = getDb();

    $sql = "INSERT INTO review (username, review_score, review, ISBN) VALUES ('$username', '$review_score', '$review', '$ISBN')";

    if($insert_review = $conn->query($sql)) header("Location: book.php?ISBN=$ISBN&BookReviewed");; 

?>   