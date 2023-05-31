<?php

    include ('config/database.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!isset($_SESSION)) session_start();

    $conn = getDb();

    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $school_q="SELECT school_id as id FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $school=$conn->query($school_q);
    $school=mysqli_fetch_array($school);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user==null) {
      header("Location: login.php?wrongCredentials=true");
    } else {
        $_SESSION['username'] = $username;
        $_SESSION['id']=$school['id'];
        $_SESSION['status']=$user['status'];

        header("Location: books.php?username=$username");
    }

?>