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
    <title>Deactivated Users</title>
    <?php
    include('../config/database.php');

    if (!isset($_SESSION)) session_start();
    $username = $_SESSION['username'];
    $school_id=$_SESSION['id'];
    $conn = getDb();
    $result=$conn->query("SELECT concat(first_name,' ',last_name)as name,u.username,email ,activity,status,count(rental_id) as rents
FROM user u
left join rental r on u.username = r.username
where school_id=$school_id and activity='deactivated'

group by u.username");




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

        <form id="serach" action="delayed.php?search=" autocomplete="off">
            <div class="row" style="margin-bottom: 1%">


                <div class="col-2">
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle " data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            options
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="users.php">All</a>
                            <a class="dropdown-item" href="users_activated.php">Activated</a>
                            <a class="dropdown-item" href="users_acceptance.php">Waiting Acceptance </a>
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
                        <h2>There arent any deactivated users</h2>
                    </div>
                <?php } else {
                    ?>
                    <table class="table table1" style="margin-top: 0%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">username</th>
                            <th scope="col">Name</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Status</th>
                            <th scope="col">Number of Total Rents</th>
                            <th scope="col">Activity Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($rental = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><a style="color: black;"
                                       href="user.php?user=<?= $rental['username'] ?>"><?php echo $rental['username'] ?></a>
                                </td>
                                <td><?php echo $rental['name']; ?></td>
                                <td><?php echo $rental['email']; ?></td>
                                <td><?php echo $rental['status']; ?></td>
                                <td><?php echo $rental['rents']; ?></td>
                                <td>
                                    <?php if ($rental['activity']=='activated'){?>
                                        <button type="button" class="btn btn-warning"> <a href="deactivate.php?username=<?=$rental['username']?>&location=users.php" class="text-decoration-none text-reset"> Deactivate</a>
                                        </button>
                                    <?php } elseif ($rental['activity']=='deactivated'){ ?>
                                        <button type="button" class="btn btn-outline-primary"> <a href="activate.php?username=<?=$rental['username']?>&location=users.php" class="text-decoration-none text-reset"> Activate</a>
                                        </button>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-outline-success"> <a href="accept.php?username=<?=$rental['username']?>&location=users.php" class="text-decoration-none text-reset"> Accept</a>
                                        </button><?php } ?>
                                    <button type="button" class="btn btn-outline-danger "><a href="delete.php?username=<?=$rental['username']?>&location=users.php" class="text-decoration-none text-reset">
                                            Delete
                                        </a> </button>

                                </td>

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