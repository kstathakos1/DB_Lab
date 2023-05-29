<?php include 'config/database.php' ?>

<?php
$conn=getDb();
    $sql = 'SELECT * FROM author';
    $result = mysqli_query($conn, $sql);
    $author = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<h2>Author List</h2>

<?php if(empty($author)): ?>
    <p class="lead mt3">There are no authors</p>
<?php endif; ?>

<?php foreach($author as $item): ?>
    <div class = "card my-3 w-75">
    <div class = "card-body text-center">
        <?php echo $item['authors_first_name'] . " " . $item['authors_last_name']; ?>
    </div>
    </div>
<?php endforeach; ?>