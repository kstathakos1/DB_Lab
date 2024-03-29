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

$active_rentals = $conn->query("SELECT b.title FROM book b
                         INNER JOIN inventory i ON i.ISBN = b.ISBN
                         INNER JOIN rental r ON r.inventory_id = i.inventory_id
                         WHERE r.username= '$username' AND r.actual_return_date IS NULL;");

$past_rentals = $conn->query("SELECT b.title FROM book b
                         INNER JOIN inventory i ON i.ISBN = b.ISBN
                         INNER JOIN rental r ON r.inventory_id = i.inventory_id
                         WHERE r.username= '$username' AND r.actual_return_date IS NOT NULL;");

$active_reservations = $conn->query("SELECT b.title FROM book b
                                    INNER JOIN reservation r ON r.ISBN = b.ISBN
                                    WHERE r.username= 'aarmstrong' AND r.expiration_date > DATE(CURRENT_TIMESTAMP);");
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
        <div class="col-xl-5" style="align-items: center; vertical-align: center;margin-top: 4%">
            <div class="card" style="border-radius: 2rem; margin-top: 5%; margin-bottom: 5%; text-align: center;vertical-align: center;">
                <div class="card-body text-center">
                    <img
                            src="../library.jpg"
                            vspace="15"
                            hspace="15"
                            width="60"
                    >

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

                    </div>


                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Active Rentals:</label>
                        <label
                                type="text"
                                id="active_rentals"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        >
                        <?php
                            while ($row = $active_rentals->fetch_assoc()) {
                                echo $row['title'] . '<br>';
                              }
                        ?>

                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Past Rentals:</label>
                        <label
                                type="text"
                                id="active_rentals"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        >
                        <?php
                            while ($row = $past_rentals->fetch_assoc()) {
                                echo $row['title'] . '<br>';
                              }
                        ?>

                    </div>

                    <div class="mb-2" style=" display: flex;">
                        <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Active Reservations:</label>
                        <label
                                type="text"
                                id="active_rentals"
                                class="form-control form-control-lg align-self-center"
                                style="width: 70%;"
                        >
                        <?php
                            while ($row = $active_reservations->fetch_assoc()) {
                                echo $row['title'] . '<br>';
                              }
                        ?>

                    </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>
</body>
