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
    $username = $_SESSION['username'];
    $conn = getDb();
    $school_id = $_SESSION['id'];
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        if (is_numeric($search)){
            $result=$conn->query( "call out_of_date_borrowers_now(null,$search,$school_id) ; ");
        }
        else
            if ($search!=' '){
                $search_array=explode(' ',$search);
                if (count($search_array)==3){
                    $name='%'.$search_array[0].' '.$search_array[1].'%';
                    $result=$conn->query( "call out_of_date_borrowers_now('$name',$search_array[2],$school_id) ; ");
                }else{

                $search='%'.$search.'%';
                $result=$conn->query( "call out_of_date_borrowers_now('$search',null,$school_id) ; ");}
            }
            else{
                $result=$conn->query( "call out_of_date_borrowers_now(null,null,$school_id) ; ");
            }
    }
    else
        $result=$conn->query( "call out_of_date_borrowers_now(null,null,$school_id) ; ");
    $text = 'Expected to be returned';

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

        <form id="serach" action="notreturned.php?search=" autocomplete="off">
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
                        <button type="button" class="btn btn-dark dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            options
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="rentals_of_school.php">All Rentals</a>
                            <a class="dropdown-item" href="delayed.php">All Delayed</a>
                        </div>
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
                        <h2>You Haven't Rented any Books</h2>
                    </div>
                <?php } else {
                    ?>
                    <table class="table table1" style="margin-top: 0%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">username</th>
                            <th scope="col">Name</th>
                            <th scope="col">Book</th>
                            <th scope="col">ISBN</th>
                            <th scope="col">Rent Date</th>
                            <th scope="col">Expected Return Date</th>
                            <th scope="col">Actual Return Date</th>
                            <th scope="col">Days Delayed</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($rental = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><a style="color: black;"
                                       href="user.php?user=<?= $rental['username'] ?>"><?php echo $rental['username'] ?></a>
                                </td>
                                <td><?php echo $rental['name']; ?></td>
                                <td><a style="color: black;"
                                       href="../book.php?ISBN=<?= $rental['ISBN'] ?>"><?php echo $rental['title'] ?></a>
                                </td>

                                <td><?php echo $rental['ISBN']; ?></td>
                                <td><?php echo $rental['rental_date']; ?></td>
                                <td><?php echo $rental['expected_return_date']; ?></td>
                                <td><?php
                                    if ($rental['actual_return_date'] != null)
                                        echo $rental['actual_return_date'];
                                    else {
                                        ?>
                                        <button type="button" class="btn btn-sm btn-outline-dark"><a
                                                style=" color: inherit;text-decoration: inherit;text-decoration: none"
                                                href="returned.php?rental_id=<?= $rental['rental_id'] ?>"><?= $text ?> </a>
                                        </button>
                                    <?php }
                                    ?></td>
                                <td><?php echo $rental['delaying_time'];?></td>
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