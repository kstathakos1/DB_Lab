<!DOCTYPE html>
<html lang="en">
<head> <!-- Import css and js packages -->

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css?<?= time() ?>">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/fontawesome.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
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
    include('config/database.php');

    if (!isset($_SESSION)) session_start();
    $username = $_SESSION['username'];
    $school_id=$_SESSION['id'];
    $status=$_SESSION['status'];
    $conn = getDb();
    $sql_search="call book_search_";
    if ($status!='student')
        $sql_search.="op(";
    else
        $sql_search.="user(";
    $title=$_POST['title'];
    if ($title==null)
        $sql_search.="null,";
    else
        $sql_search.="'$title',";
    $category=$_POST['category'];
    if ($category==null)
        $sql_search.="null,";
    else
        $sql_search.="'$category',";
    $author=$_POST['author'];
    if ($author==null)
        $sql_search.="null,";
    else
        $sql_search.="'$author',";
    if ($status!='student'){
        $copies=$_POST['copies'];
        if ($copies==null)
            $sql_search.="null,$school_id);";
        else
            $sql_search.="'$copies',$school_id);";
    }
    else
        $sql_search.="$school_id);";
    $result=$conn->query($sql_search);

    ?>
</head>
<body>
<?php include('navbar.php') ?>
<div class="container" id="background">
    <div class="container" id="top_bar">
        <img
            src="library-PhotoRoom.png-PhotoRoom.png"
            vspace="15"
            width="60"
            style="margin-left: 47.4%"
        >

        <form id="serach" action="index.php" autocomplete="off">
            <div class="row" style="margin-bottom: 1%">


                <div class="col-2">
                    <div class="btn-group">

                        <button type="submit" class="btn btn-dark "
                                aria-haspopup="true" aria-expanded="false">
                            Back
                        </button>
                    </div>

                </div>
            </div>
        </form>

    </div>
    <div class="container" id="top_bar">
        <div class="row">
            <div class="centered-table">
                <?php if (mysqli_num_rows($result) == 0) { ?>
                    <div>
                        <h2>Not found</h2>
                    </div>
                <?php } else {
                    ?>
                    <table class="table table1" style="margin-top: 0%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">ISBN</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($rental = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><img src="<?php echo $rental['image']; ?>"
                                    width="100"></td>
                                <td><a style="color: black;"
                                       href="book.php?ISBN=<?= $rental['ISBN'] ?>"><?php echo $rental['title'] ?></a>
                                </td>
                                <td><?php echo $rental['ISBN']; ?></td>




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