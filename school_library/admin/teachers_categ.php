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
    <title>Tools</title>
    <?php
    include('../config/database.php');

    if (!isset($_SESSION)) session_start();
    $username = $_SESSION['username'];
    $integers = null;
    $strings = null;
    $conn = getDb();
    $school_id = $_SESSION['id'];
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    }
    else $search=null;

    if ($search == null) {
        $sql = "CALL teacher_book_category_loan(NULL);";
    } else {
        $sql = "CALL teacher_book_category_loan('$search');";
    }

    $teacher = $conn->query($sql);

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

        <form id="serach" action="teachers_categ.php?search=" autocomplete="off">

            <div class="row" style="margin-bottom: 1%">
                <div class="col-10">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-dark" style="height: 2.5rem"><i
                                    class="fas fa-search text-light"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control" id="search" placeholder="Search" name="search"
                               style="height: 2.5rem" value="<?php if (isset($_GET['search'])) echo $_GET['search'] ?>">
                    </div>
                </div>

                <div class="col-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark"
                                aria-haspopup="true" aria-expanded="false"><a href="book_category_history.php" class="text-decoration-none text-reset">Authors of category</a>
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
    <div class="container" id="top_bar">
        <div class="row">
            <div class="centered-table">
                <?php if (isset($_GET['search'])){?>
                <?php if (mysqli_num_rows($teacher) == 0) { ?>
                    <div>
                        <h2>Nothing found</h2>
                    </div>
                <?php } else {
                    ?>
                    <table class="table table1" style="margin-top: 0%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col"> Teacher who borrowed books from th category <?=$search?></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($rental = mysqli_fetch_assoc($teacher)) { ?>
                            <tr>
                                <td>
                                    <?php echo $rental['Name']; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
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