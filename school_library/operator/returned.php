<?php
include ('../config/database.php');
if (!isset($_SESSION))
    session_start();
$conn=getDb();
$rental_id=$_GET['rental_id'];
$sql_update_rental=$conn->query("update rental set actual_return_date=current_date where rental_id=$rental_id ;");
header("Location: rentals_of_school.php");