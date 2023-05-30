<?php

include ('config/database.php');
if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$user=$_SESSION['status'];
$conn = getDb();

if ($user=='teacher') {
    header("Location: teacher\login.php?wrongCredentials=true");
} else if ($user=='student'){
    echo 'hello';
    header("Location: good\login.php?wrongCredentials=true");
} else if ($user=='operator'){
    header("Location: login.php?wrongCredentials=true");
} else
    header("Location: login.php?wrongCredentials=true");

?>