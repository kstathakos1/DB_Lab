<!DOCTYPE html>
<html lang="en">
<head> <!-- Import css and js packages -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link
            href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css"
            rel="stylesheet"
    />

    <link rel="shortcut icon" href="../library.jpg" type="image/x-icon">
    <meta charset="UTF-8">
    <title>My Rents</title>
    <?php
    include('../config/database.php');

    if (!isset($_SESSION)) session_start();
    $month=$_POST['month'];
    $year=$_POST['year'];
    $conn = getDb();
    $school_id = $_SESSION['id'];
    if ($month != null) {
        if ($month == 'January' or $month == 'Ιανουάριοσ')
            $month = 1;
        else if ($month == 'February' or $month == 'Φεβρουάριος')
            $month = 2;
        else if ($month == 'March' or $month == 'Μάρτιος')
            $month = 3;
        else if ($month == 'April' or $month == 'Απρίλιος')
            $month = 4;
        else if ($month == 'May' or $month == 'Μάιος')
            $month = 5;
        else if ($month = 'June' or $month == 'Ιούνιος')
            $month = 6;
        else if ($month == 'Jule' or $month == 'Ιούλιος')
            $month = 7;
        else if ($month == 'August' or $month == 'Αύγουστος')
            $month = 8;
        else if ($month == 'September' or $month == 'Σεπτέμβριος')
            $month = 9;
        else if ($month == 'October' or $month == 'Οκτώμβριος')
            $month = 10;
        else if ($month == 'November' or $month == 'Νοέμβριος')
            $month = 11;
        else if ($month == 'December' or $month == 'Δεκέμβριος')
            $month = 12;
    }
    if ($year==null)
        $year='null';
    if ($month==null)
        $month='null';

    $result = $conn->query("call list_loans_by_school($year,$month);");


    ?>
</head>
<body>
<?php include('navbar.php') ?>
<div class="container" id="background">
    <div class="container" id="top_bar">
        <img
                src="../library-PhotoRoom.png-PhotoRoom.png"
                vspace="15"
                width="60"
                style="margin-left: 47.4%"
        >



    </div>
    <div class="container" id="top_bar">
        <div class="row">
            <div class="centered-table">
                <?php if (mysqli_num_rows($result) == 0) { ?>
                    <div>
                        <h2>You Haven't Rented any Books</h2>
                    </div>
                <?php } else {
                    ?>
                    <table class="table table1" style="margin-top: 0%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">School Name</th>
                            <th scope="col">Number of Loans</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($rental = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $rental['name']; ?></td>
                                <td><?php echo $rental['number']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.js"
></script>
<script src="../js/sweetalert.js"></script>
<?php
if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
    ?>
    <script>
        swal({
            title: '<?php echo $_SESSION['success_log'] ?>',
            icon: '<?php echo $_SESSION['success'] ?>',
            button: "Close!",
        });
    </script>
    <?php
    unset($_SESSION['success']);
    unset($_SESSION['success_log']);
}
?>
</body>
</html>