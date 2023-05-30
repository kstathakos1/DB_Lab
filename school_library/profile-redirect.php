<?php

include ('config/database.php');
if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$user=$_SESSION['status'];
$conn = getDb();

if ($user=='teacher') {
    header("Location: teacher\profile.php");
} else if ($user=='student'){
    header("Location: student\profile.php");
} else if ($user=='operator'){
    header("Location: teacher\profile.php");
} else
    header("Location: teacher\profile.php");

?>