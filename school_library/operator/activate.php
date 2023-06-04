<?php
include ('../config/database.php');
if (!isset($_SESSION)) session_start();
$username=$_GET['username'];
$location=$_GET['location'];
$conn=getDb();
$deactivate=$conn->query("update user set activity='activated' where username='$username'");
unset($_GET);

header("Location: $location");