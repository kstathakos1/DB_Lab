<?php

    include ('config/database.php');

    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birth_date = $_POST['birth_date'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $status = ($_POST['status'] == 'teacher') ? 'teacher' : 'student';
    $phone_number = $_POST['phone_number'];
    $school_id = $_POST['school_id'];

    $conn = getDb();

    $sql = "INSERT INTO user (
        username, 
        password, 
        first_name, 
        last_name, 
        birth_date, 
        address, 
        email, 
        status, 
        phone_number, 
        school_id) 
        VALUES (
            '$username', 
            '$password', 
            '$first_name', 
            '$last_name', 
            '$birth_date', 
            '$address', 
            '$email', 
            '$status',
            '$phone_number', 
            '$school_id'
        )";
    
    $result = mysqli_query($conn, $sql);
?>