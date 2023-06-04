<?php
include('../config/database.php');
if (!isset($_SERVER["HTTP_USER_AGENT"])) {
    die;
}
if (!isset($_SESSION))session_start();
$query = "select if(school_number>0,concat(school_number,' ',school_type,' ',city),concat(school_type,' ',city)) as name
from school_unit;";
$conn = getDb();
$result1 = mysqli_query($conn, $query);

?>

<html>
<head>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.3.1/mdb.min.css"
        rel="stylesheet"
    />

</head>
<?php include('navbar.php') ;

?>
<body>
<div class="container" id="background">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-xl-9 justify-content-center">
            <div class="card "
                 style="border-radius: 2rem; margin-top: 5%; margin-bottom: 5%; text-align: center; vertical-align: center;justify-items: center">
                <div class="card-body">
                    <form id="rentals" method="POST" action="rentalsodschools.php" enctype="multipart/form-data"
                          autocomplete="off">
                        <div class="container-xxl">
                            <img src="../library.jpg"
                                 vspace="15"
                                 hspace="15"
                                 width="60">

                            <div class="row" id="row1" style="margin-top: 2% ;margin-bottom: 3%;">

                                <div class="col-md-6 form-outline mb-8">
                                    <input type="text"
                                           autocomplete="off"
                                           id="year"
                                           name='year'
                                           class="form-control form-control-lg align-self-center"
                                    />
                                    <label class="form-label" for="title">Year</label>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 3%">
                                <div class="col-md-6 form-outline mb-8">
                                    <input type="text"
                                           autocomplete="off"
                                           id="month"
                                           name='month'
                                           class="form-control form-control-lg align-self-center"
                                           value=""
                                    /><label class="form-label" for="title">Month</label></div>

                            </div>

                            <button class="button btn btn-outline-success btn-lg " type="submit">Search</button>

                    </form>
                </div>
            </div>
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
