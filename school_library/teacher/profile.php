<?php
include('../config/database.php');

if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$id=$_SESSION['id'];
$conn = getDb();

$result = $conn->query("SELECT * FROM user WHERE username='$username';");
$result1=$conn->query("select if(school_number>0,concat(school_number,' ',school_type,' ',city),concat(school_type,' ',city)) as name
from school_unit
where school_id=$id ;");
$user = mysqli_fetch_array($result);
$school=mysqli_fetch_array($result1);


?>

<html>
<head>
    <!-- Import css and js packages -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/custom.css?<?= time() ?>">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/all.min.css">

    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/jquery-ui.js"></script>

    <link rel="shortcut icon" href="../library.jpg" type="image/x-icon">
    <title>Book Details</title>

</head>
<body>
<?php include('navbar.php'); ?>
<div class="container" id="background">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-xl-5" style="align-items: center; vertical-align: center;margin-top: 1%">
            <div class="card" style="border-radius: 2rem; margin-top: 2%; margin-bottom: 5%; text-align: center;vertical-align: center;">
                <div class="card-body text-center" >
                    <img
                        src="../library.jpg"
                        width="60"
                        style="margin-bottom: 0"
                    ></div>
                <div class="card-body text-center" style="margin-top: 0%">
                    <form class="text-center">
                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">username</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['username']?></label>
                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">First Name</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['first_name']?></label>

                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Last Name</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['last_name']?></label>
                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">E-mail</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['email']?></label>

                    </div>
                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Address</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['address']?></label>
                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Phone Number</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['phone_number']?></label>

                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Birth Date</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['birth_date']?></label>
                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">School</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$school['name']?></label>

                    </div>
                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">status</label>
                        <label
                                type="text"
                                id="username"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        ><?=$user['status']?></label>

                    </div></form>
                    <form id="change_info"  action="register_user.php" >
                    <button style="margin-top:2%"
                            class="btn btn-secondary btn-lg btn-dark"
                            type="submit">
                        Change Profile Information
                    </button></form>



            </div>

        </div>
    </div>
</div>
</div>
</div>
</body>