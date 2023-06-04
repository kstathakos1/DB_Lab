<?php
include ('../config/database.php');
if (!isset($_SESSION)) session_start();
$username=$_GET['username'];
$location=$_GET['location'];
$conn=getDb();
$delete=$conn->query("delete from review where username='$username'");
$delete=$conn->query("delete from rental where username='$username'");
$delete=$conn->query("delete from reservation where username='$username'");
$delete=$conn->query("delete from user where username='$username'");
unset($_GET);
header("Location: $location");