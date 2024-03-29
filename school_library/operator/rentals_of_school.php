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
        $search='%'.$search.'%';
        $result = $conn->query("SELECT r.rental_id, r.username, r.rental_date, r.expected_return_date, r.actual_return_date, i.ISBN, CONCAT(u.first_name, ' ', u.last_name) AS name,b.title
FROM rental r
INNER JOIN inventory i ON r.inventory_id = i.inventory_id
    inner join book b on i.ISBN = b.ISBN
INNER JOIN user u ON r.username = u.username

WHERE CONCAT(u.first_name, ' ', u.last_name) like '$search' AND i.school_id = $school_id ;");

    } else {

        $result = $conn->query("SELECT concat(u.first_name,' ',u.last_name) as name ,u.username,b.title,b.ISBN,r.rental_date,r.expected_return_date,r.actual_return_date,r.rental_id
FROM rental r 
    inner join user u on r.username = u.username
inner join inventory i on r.inventory_id = i.inventory_id
inner join book b on i.ISBN = b.ISBN
where i.school_id=$school_id 
order by r.rental_date desc");
    }

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
        <div class="modal fade" id="addrental" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">New Rental</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form id="addrent" method="post" action="addrental.php" autocomplete="off">
                        <div class="modal-body">
                            <label>username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i
                                            class="fas fa-user-alt"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control" name="username" placeholder="username"
                                       autocomplete="off" required="required" id="username">
                            </div>
                            <label style="margin-top: 2rem; ">Book ISBN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-regular fa-book"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control" placeholder="ISBN" name="ISBN"
                                       autocomplete="off" required="required" id="ISBN" style="margin-bottom: 1rem;">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Rental</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <form id="serach" action="rentals_of_school.php?search=" autocomplete="off">
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
                        <button type="button" class="btn btn-dark fas fa-add" data-toggle="modal"
                                data-target="#addrental">Add Rental</button>
                        <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="delayed.php">Delayed</a>
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
                                    ?>
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