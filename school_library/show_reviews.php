<?php
    include ('config/database.php');

    if (!isset($_SESSION)) session_start();
    $ISBN = $_POST['ISBN'];
    $conn = getDb();

    $sql = "SELECT * FROM review WHERE ISBN = '$ISBN'";
    $result = $conn->query($sql);


    foreach($result as $item): ?>
            <div class="container" style="border-radius: 1rem; background-color: #DDD9D2; margin-top: 3.5%;">
                                <div style="display: flex; flex-direction: row; margin-left: 10%;">
                                        <div class = "card-body text-left">
                                            <div style="flex-direction: column; font-size: 20px; color: black; font-family:Book Antiqua;">
                                                    "<?php echo $item['review'] ?>"
                                                <div style="font-size: 15px; color: black; font-family:Book Antiqua; font-weight: bold;"> 
                                                    <?php 
                                                        if ($item['review_score'] == 1) echo("Strongly Dislike");
                                                        if ($item['review_score'] == 2) echo("Dislike");
                                                        if ($item['review_score'] == 3) echo("Neutral");
                                                        if ($item['review_score'] == 4) echo("Like");
                                                        if ($item['review_score'] == 5) echo("Strongly Like");
                                                    ?>
                                                </div>
                                                <div style="font-size: 13px; color: black; font-family:Book Antiqua;"> by <?php echo $item['username']?> </div>
                                            </div>
                                        </div>
                                </div>
    </div>
        <?php endforeach; ?>

        <!-- <form id="go_back" method="POST" action="book.php?$ISBN<?=$ISBN?>" autocomplete="on">
                <button
                        class="btn btn-secondary btn-lg btn-dark button-position"
                        type="submit"
                >
                    Go Back
                </button>
        </form> -->