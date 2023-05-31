<?php

include ('../config/database.php');
if (!isset($_SESSION)) session_start();
$oldusername=$_SESSION['username'];
$newusername = $_POST['username'];
$first_name = $_POST['first_name'];
$last_name=$_POST['last_name'];
$email=$_POST['email'];
$address=$_POST['address'];
$phone=$_POST['phone_number'];
$birth=$_POST['birth_date'];


$conn = getDb();
$_SESSION['username']=$newusername;
$sql = "update user
set username='$newusername',first_name='$first_name',last_name='$last_name',email='$email',address='$address',birth_date='$birth'
where username='$oldusername';";
$update=mysqli_query($conn,$sql);
header("Location: profile.php");


?>
