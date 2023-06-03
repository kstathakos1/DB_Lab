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
    $result = $conn->query("SELECT *
FROM rental
inner join inventory i on rental.inventory_id = i.inventory_id
inner join book b on i.ISBN = b.ISBN
where school_id=$school_id");
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
                    <form id="addrebt" method="post">
                        <div class="modal-body">
                            <label>username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text" ><i
                                            class="fas fa-user-alt"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control" placeholder="username" autocomplete="off" required="required" id="username" >
                            </div>
                            <label style="margin-top: 2rem; ">Book ISBN</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text" ><i class="fas fa-regular fa-book"></i>
                                </span>
                                </div>
                                <input type="text" class="form-control" placeholder="username" autocomplete="off" required="required" id="username" style="margin-bottom: 1rem;" >
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Add Rental</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1%">
            <div class="col-10">
                <div class="input-group">
                    <div class="input-group-prepend">
                            <span class="input-group-text bg-dark" style="height: 2.5rem"><i
                                        class="fas fa-search text-light"></i>
                            </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search" style="height: 2.5rem">
                </div>
            </div>
            <div class="col-2">
                <button type="button" class="btn-lg btn-dark fas fa-add" data-toggle="modal" data-target="#addrental">
                    Add Rental
                </button>
            </div>
        </div>
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
                                <td><a style="color: black;"
                                       href="../book.php?ISBN=<?= $rental['ISBN'] ?>"><?php echo $rental['title'] ?></a>
                                </td>
                                <td><?php echo $rental['ISBN']; ?></td>
                                <td><?php echo $rental['rental_date']; ?></td>
                                <td><?php echo $rental['expected_return_date']; ?></td>
                                <td><?php
                                    if ($rental['actual_return_date'] != null)
                                        echo $rental['actual_return_date'];
                                    else
                                        echo $text;
                                    ?></td>
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
</body>
</html>