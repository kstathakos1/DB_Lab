
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
    $integers = null;
    $strings = null;
    $conn = getDb();
    $school_id = $_SESSION['id'];
   $result=$conn->query("SELECT concat(category1,' and ', category2) AS most_common_category_pair, COUNT(*) AS count
                         FROM (
                                SELECT c1.category AS category1, c2.category AS category2,i1.ISBN AS isbn
                                FROM book_category bc1
                                JOIN book_category bc2 ON bc1.ISBN = bc2.ISBN AND bc1.category_id < bc2.category_id
                                INNER JOIN category c1 ON bc1.category_id = c1.category_id
                                INNER JOIN category c2 ON bc2.category_id=c2.category_id
                                INNER JOIN inventory i1 ON bc1.ISBN = i1.ISBN
   
   
                            INNER JOIN rental r1 ON i1.inventory_id = r1.inventory_id
                        ) t

                        GROUP BY category1, category2
                        ORDER BY count DESC
                        LIMIT 3;");

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



    </div>
    <div class="container" id="top_bar">
        <div class="row">
            <div class="centered-table">
                <?php if (mysqli_num_rows($result) == 0) { ?>
                    <div>
                        <h2>Nothing found</h2>
                    </div>
                <?php } else {
                    ?>
                    <table class="table table1" style="margin-top: 0%">
                        <thead class="thead-dark">
                        <tr>
                            <div style = "font-size: 13px;">Top-3 pairs of categories that appeared in rentals </div>
                        </tr>
                        </thead>
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Category Pairs</th> 
                            <th scope="col">Number of times they appeared together</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while ($pairs = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td>
                                    <?php echo $pairs['most_common_category_pair']; ?>
                                </td>
                                <td>
                                    <?php echo $pairs['count']?> 
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