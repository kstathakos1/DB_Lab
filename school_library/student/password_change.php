<!DOCTYPE html>
<html lang="en">
<head> <!-- Import css and js packages -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/custom.css?<?= time() ?>">
    <link rel="stylesheet" href="../css/fontawesome.min.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css">
    <script src="../js/jquery-1.10.2.js"></script>
    <script src="../js/jquery-ui.js"></script>

    <link rel="shortcut icon" href="../library.jpg" type="image/x-icon">
    <meta charset="UTF-8">
    <title>My Rents</title>
    <?php
    include('../config/database.php');

    if (!isset($_SESSION)) session_start();
    $username = $_SESSION['username'];
    $conn = getDb();
    $result = $conn->query("call find_my_books('$username')");
    $text='Expected to be returned';

    ?>
</head>
<body>
<?php include ('navbar.php') ?>
<div class="container" style="border-radius: 1rem; background-color: #DDD9D2; margin-top: 3.5%;">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-xl-5" >
            <div class="card shadow-2-strong" style="border-radius: 1rem; margin-top: 30%; margin-bottom: 20%; text-align: center;">
                <?php if (isset($_GET['wrongCredentials'])) echo '<div class="alert alert-danger text-center" role="alert"> Wrong credentials. Please try again.</div>' ?>
                    <form id="loginform" method="POST" action="conpasschange.php" autocomplete="on" style="margin-top: 10%">
                        <div class="form-outline mb-4" style="margin-left: 20%; margin-right: 20%;">
                            <input
                                type="password"
                                autocomplete="on"
                                id="old_password"
                                placeholder="Old Password"
                                name='old_password'
                                class="form-control align-self-center"
                                value=""
                                required="required"
                            />
                        </div>

                        <div class="form-outline mb-4" style="margin-left: 20%; margin-right: 20%;">
                            <input
                                type="password"
                                autocomplete="on"
                                id="new_password"
                                placeholder="New Password"
                                name='new_password'
                                class="form-control align-self-center"
                                value=""
                                required="required"
                            />
                        </div>
                        <div class="form-outline mb-4" style="margin-left: 20%; margin-right: 20%;">
                            <input
                                type="password"
                                autocomplete="on"
                                id="cnew_password"
                                placeholder="Confirm New Password"
                                name='cnew_password'
                                class="form-control align-self-center"
                                value=""
                                required="required"
                            />
                        </div>
                        <button
                            class="btn btn-secondary btn-lg btn-dark"
                            type="submit"
                            STYLE="margin-bottom: 10%"
                        >
                            Change Password
                        </button>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




</body>
</html>