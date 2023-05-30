<?php

include ('../config/database.php');

$oldpassword = $_POST['old_password'];
$newpassword = $_POST['new_password'];
$connewpassword=$_POST['cnew_password'];
echo $oldpassword,$newpassword,$connewpassword;
if (!isset($_SESSION)) session_start();

$conn = getDb();

//$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
//$school_q="SELECT school_id as id FROM user WHERE username='$username'";
//$result = mysqli_query($conn, $sql);
//$school=$conn->query($school_q);
//$school=mysqli_fetch_array($school);
//$user = mysqli_fetch_array($result, MYSQLI_ASSOC);
//
//if (count($user) == 0) {
//    header("Location: login.php?wrongCredentials=true");
//} else {
//    $_SESSION['username'] = $username;
//    $_SESSION['id']=$school['id'];
//    $_SESSION['status']=$user['status'];
//
//    header("Location: books.php?username=$username");
//}

?>
