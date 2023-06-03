<?php
if (!isset($_SESSION)) session_start();
$status = $_SESSION['status'];
if ($_SESSION['username'] == null)
    header("Location: login.php");
?>
<link rel="stylesheet" type="text/css" href="../css/custom.css?<?= time() ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<nav class="navbar navbar-light" style="background-color: #DDD9D2;" ¬>
    <div class="navbar-header" style="justify-content:start; display: flex; flex-direction: row;">
        <a class="navbar-brand nav-head left-spaced" href="../index.php"><img
                    src="../library-PhotoRoom.png-PhotoRoom.png"
                    rel="shortcut icon" width="50" height="50"
                    style="margin-top: 0;"></a>
        <a class="navbar-brand nav-head"  href="profile.php" style="margin-top: 10px">Profile Details</a>
        <a class="navbar-brand nav-head" href="rentals.php" style="margin-top: 10px ; margin-right: 10%;">My Rents</a>
    </div>
    <div class="navbar-end justify-content:end;" style="display: flex">
        <div style="margin-top: 1%">
            <a class="navbar-brand nav-head"  href="password_change.php" style="vertical-align: center">Change
                Password</a>
        </div>
        <div class="spaced btn-group">
            <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false"><i class="fas fa-user fa-xl">
                    <?= $_SESSION['username'] ?></span></i>
            </button>
            <ul class="dropdown-menu text-center" style="min-width: 100%;">
                <li>
                    <?php if ($status != 'student' and $status != 'teacher') {
                        ?>
                        <form action="../operator/index.php" style="all: unset; cursor: pointer;">
                            <button
                                    name="profile"
                                    style="all: unset; cursor: pointer;"
                            > Tools
                            </button>
                        </form>
                    <?php } ?>
                    <form action="../logout.php" method="POST" style="all: unset; cursor: pointer;">
                        <button
                                name="logout"
                                style="all: unset; cursor: pointer;"
                        > Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
