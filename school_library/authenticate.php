<?php

    include ('config/database.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    var_dump($password . ' ' . $username);

    $conn = getDb();

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (count($user) == 0) {
        header("Location: login.php?wrongCredentials=true");
    } else {
        header("Location: books.php?username=$username");
    }

?>