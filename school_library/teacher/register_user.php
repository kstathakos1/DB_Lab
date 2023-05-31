<?php
include('../config/database.php');

if (!isset($_SESSION)) session_start();
$username = $_SESSION['username'];
$id=$_SESSION['id'];
$conn = getDb();

$result = $conn->query("SELECT * FROM user WHERE username='$username';");
$result1=$conn->query("select if(school_number>0,concat(school_number,' ',school_type,' ',city),concat(school_type,' ',city)) as name
from school_unit order by school_number
 ;");
$result2=$conn->query("select if(school_number>0,concat(school_number,' ',school_type,' ',city),concat(school_type,' ',city)) as name
from school_unit where school_id=$id
 ;");
$user = mysqli_fetch_array($result);
$school=mysqli_fetch_array($result2);

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
                <div class="card-body text-center" style="display: flex;justify-content: center;align-items: center; margin-bottom: 0;">
                    <img
                        src="../library.jpg"
                        width="60"
                        style="margin-bottom: 0%"
                    ></div>
                <div class="text-center" style="margin-top: 0%;margin-right: 5%">
                    <form id="changeinfo" method="POST" action="changeinfo.php" autocomplete="off">
                        <div class="mb-2" style=" display: flex;">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">username</label>
                            <input
                                    type="text"
                                    autocomplete="off"
                                    id="username"
                                    placeholder=<?=$user['username']?>
                                    name='username'
                                    class="form-control form-control-lg align-self-center"
                                    value=<?=$user['username']?>
                                    required="required"

                            />
                        </div>

                        <div class="mb-2" style=" display: flex;">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">First Name</label>
                            <input
                                    type="text"
                                    autocomplete="off"
                                    id="First Name"
                                    placeholder=<?=$user['first_name']?>
                                    name='first_name'
                                    class="form-control form-control-lg align-self-center"
                                    value=<?=$user['first_name']?>
                                    required="required"
                            />
                        </div>

                        <div class="mb-2" style=" display: flex;">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Last Name</label>
                            <input
                                    type="text"
                                    autocomplete="off"
                                    id="last_name"
                                    placeholder=<?=$user['last_name']?>
                                    name='last_name'
                                    class="form-control form-control-lg align-self-center"
                                    value=<?=$user['last_name']?>
                                    required="required"
                            />
                        </div>

                        <div class="mb-2" style=" display: flex;">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">E-mail</label>
                            <input
                                    type="text"
                                    autocomplete="off"
                                    id="email"
                                    placeholder=<?=$user['email']?>
                                    name='email'
                                    class="form-control form-control-lg align-self-center"
                                    value=<?=$user['email']?>
                                    required="required"

                            />
                        </div>


                        <div class="mb-2" style=" display: flex;">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Phone Number</label>
                            <input
                                    type="text"
                                    autocomplete="off"
                                    id="phone_number"
                                    placeholder=<?=$user['phone_number']?>
                                    name='phone_number'
                                    class="form-control form-control-lg align-self-center"
                                    value=<?=$user['phone_number']?>
                                    required="required"

                            />
                        </div>

                        <div class="mb-2" style=" display: flex;">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Address</label>
                            <input
                                    type="text"
                                    autocomplete="off"
                                    id="address"
                                    placeholder=<?=$user['address']?>
                                    name='address'
                                    class="form-control form-control-lg align-self-center"
                                    value=<?=$user['address']?>
                                    required="required"

                            />
                        </div>

                        <div class="mb-2" style=" display: flex;">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">Birth Date</label>
                            <input
                                    type="text"
                                    placeholder=<?=$user['birth_date']?>
                                    onfocus="(this.type='date')"
                                    autocomplete="off"
                                    id="birth_date"
                                    name='birth_date'
                                    class="form-control form-control-lg align-self-center"
                                    value=<?=$user['birth_date']?>
                                    required="required"

                            />
                        </div>


                        <div class="form-outline mb-2" style="display: flex">
                            <label style="width: 30%;align-items: center; vertical-align: center ;margin-top: 10px">School</label>
                            <select name="school" class="form-control" id="school" style="mso-field-change-value: <?=$school['name']?>" >
                                <?php while ($row1=mysqli_fetch_array($result1)):;?>
                                    <option <?php if ($row1[0]==$school['name']) ?> selected>
                                        <?php echo $row1[0];?>
                                    </option>
                                <?php endwhile;?>
                            </select>
                        </div>
                        <button style="margin-top:2%"
                                class="btn btn-secondary btn-lg btn-dark"
                                type="submit"
                        >
                            Change Informations
                        </button>
                    </form>




                </div>

            </div>
        </div>
    </div>
</div>
</div>
</body>
