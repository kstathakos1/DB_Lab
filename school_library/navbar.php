<?php
if (!isset($_SESSION)) session_start();
$status=$_SESSION['status'];
if ($_SESSION['username']==null)
    header("Location: login.php");
?>

<nav class="navbar navbar-light" style="background-color: #DDD9D2;" ¬>
    <div class="navbar-header" style="justify-content:start; display: flex; flex-direction: row;">
        <a class="navbar-brand nav-head left-spaced" href="index.php"><img src="library-PhotoRoom.png-PhotoRoom.png"
                                                                           rel="shortcut icon" width="50" height="50"
                                                                           style="margin-top: 0;"></a>
        <a class="navbar-brand nav-head" href="books.php" style="margin-top: 10px">Books</a>
        <a class="navbar-brand nav-head" href="authors.php" style="margin-top: 10px">Authors</a>
        <a class="navbar-brand nav-head" href="categories.php" style="margin-top: 10px">Categories</a>
        <a class="navbar-brand nav-head" href="publishers.php" style="margin-top: 10px">Publishers</a>
    </div>

    <div class="navbar-end justify-content:end;">
        <div class="spaced btn-group">
            <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown"
                    data-bs-auto-close="outside" aria-expanded="false">
                <?= $_SESSION['username'] ?></span>
            </button>
            <ul class="dropdown-menu text-center" style="min-width: 100%;">
                <li>
                    <form action="profile-redirect.php"  style="all: unset; cursor: pointer;">
                        <button
                                name="profile"
                                style="all: unset; cursor: pointer;"
                        > Profile
                        </button>
                    </form>
                    <?php if ($status != 'student' AND $status!='teacher') {
                        ?>
                        <form action="profile-redirect.php" style="all: unset; cursor: pointer;">
                            <button
                                    name="profile"
                                    style="all: unset; cursor: pointer;"
                            > Tools
                            </button>
                        </form>
                    <?php } ?>

                    <form action="logout.php" method="POST" style="all: unset; cursor: pointer;">
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
