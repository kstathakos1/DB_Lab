<?php
if (!isset($_SESSION)) session_start();
$status = $_SESSION['status'];
if ($_SESSION['username'] == null)
    header("Location: login.php");
?>
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/custom.css?<?= time() ?>">
<link rel="stylesheet" href="../css/fontawesome.min.css">
<link rel="stylesheet" href="../css/all.min.css">
<link rel="stylesheet" href="../css/jquery-ui.css">
<link rel="stylesheet" href="../css/all.css">
<link rel="stylesheet" href="../css/fontawesome.css">
<link rel="stylesheet" href="../css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery-1.10.2.js"></script>
<script src="../js/jquery-ui.js"></script>

<link rel="shortcut icon" href="../library.jpg" type="image/x-icon">

<nav class="navbar navbar-light" style="background-color: #DDD9D2;" ¬>
    <div class="navbar-header justify-content:start;"
         style="justify-content:start; display: flex; flex-direction: row;">

        <a class="navbar-brand nav-head left-spaced" href="../index.php"><img
                    src="../library-PhotoRoom.png-PhotoRoom.png"
                    rel="shortcut icon" width="50" height="50"
                    style="margin-top: 0;"></a>
        <a class="navbar-brand nav-head text-decoration-underline" href="index.php" style="margin-top: 10px">Rentals of School
            </a>
        <a class="navbar-brand nav-head text-decoration-underline" href="book_category_history.php"
           style="margin-top: 10px">Book Category History</a>
        <a class="navbar-brand nav-head text-decoration-underline" href="youngteachers.php"
           style="margin-top: 10px">Young Teachers with most rents</a>

        </div>
        <div class="navbar-header justify-content:start;"
         style="justify-content:start; display: flex; flex-direction: row; margin-left: 7%;">
        <a class="navbar-brand nav-head text-decoration-underline" href="obscure-authors.php"
            style="margin-top: 10px">Obscure Authors</a>
        <a class="navbar-brand nav-head text-decoration-underline" href="oper-same-number.php"
            style="margin-top: 10px">Operators with same number</a>
        <a class="navbar-brand nav-head text-decoration-underline" href="top-three-category-pairs.php"
            style="margin-top: 10px">Top 3 Category Pairs</a>
        <a class="navbar-brand nav-head text-decoration-underline" href="authors-five-or-less.php"
            style="margin-top: 10px">Runner-up Authors</a>
    </div>
    <div class="navbar-end justify-content:end;">
        <div class="spaced btn-group">
            <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false"><i class="fas fa-user fa-xl">
                    <?= $_SESSION['username'] ?></span></i>
            </button>
            <ul class="dropdown-menu text-center" style="min-width: 100%;">
                <li>
                    <ul class="dropdown dropdown-item-text">
                        <form action="../profile-redirect.php" style="all: unset; cursor: pointer;">
                            <button
                                    class="text-center"
                                    name="profile"
                                    style="all: unset; cursor: pointer;"
                            > Profile
                            </button>
                        </form>
                    </ul>
                    <?php if ($status != 'student' and $status != 'teacher') {
                        ?>
                        <ul class="dropdown dropdown-item-text">
                            <form action="index.php" style="all: unset; cursor: pointer;">
                                <button
                                        name="profile"
                                        style="all: unset; cursor: pointer;"
                                > Tools
                                </button>
                            </form>
                        </ul>
                    <?php } ?>
                    <?php if ($status=='admin'){
                        ?>
                        <ul class="dropdown dropdown-item-text">
                            <form action="admin_tools.php"style="all: unset; cursor: pointer;">
                                <button
                                        name="profile"
                                        style="all: unset; cursor: pointer;"
                                > Admin Tools
                                </button>
                            </form>
                        </ul>
                    <?php }?>

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


<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>




<nav class="navbar navbar-light">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">School Library</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="">Home</a></li>
      <li><a href="books.php">Books</a></li>
      <li><a href="rentals.php">Rentals</a></li>
      <li><a href="manage.php">Management</a></li>
    </ul>
  </div>
</nav>

<div class="container">
  <h3>Inverted Navbar</h3>
  <p>An inverted navbar is black instead of gray.</p>
</div>

</body>
</html> -->
