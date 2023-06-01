<?php
include('../config/database.php');

if (!isset($_SESSION)) session_start();
$school_id=$_SESSION['id'];
$title=$_POST['title'];
$newisbn=$_POST['ISBN'];
$summary=$_POST['summary'];
$numpage=$_POST['numpage'];
$authors=$_POST['author'];
$language=$_POST['language'];
$category=$_POST['category'];
$publisher=$_POST['publisher'];
$oldisbn=$_GET['ISBN'];
if ($oldisbn==$newisbn){
    $sql="update book
set title='$title',summary='$summary',language_id=(select language_id('$language') as li), publisher='$publisher',page=$numpage
where ISBN=$newisbn ;";
}
?>
