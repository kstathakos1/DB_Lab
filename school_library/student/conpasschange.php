<?php

include ('../config/database.php');

$oldpassword = $_POST['old_password'];
$newpassword = $_POST['new_password'];
$connewpassword=$_POST['cnew_password'];

if (!isset($_SESSION)) session_start();
if ($newpassword!=$connewpassword)
    header("Location: password_change.php?wrongCredentials=true");
$conn = getDb();
$username=$_SESSION['username'];

$sql = $conn->query("update user set password='$newpassword' where username='$username';");
header("Location: profile.php");


?>
