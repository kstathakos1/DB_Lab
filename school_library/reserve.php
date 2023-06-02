<?php
    include ('config/database.php');

    if (!isset($_SESSION)) session_start();
    $username= $_SESSION['username'];
    $ISBN = $_POST['ISBN'];
    $school_id = $_SESSION['id'];
    $currentDate = date('Y-m-d');

    $conn = getDb();



    $sql_ar = "SELECT * FROM inventory
                WHERE inventory_id NOT IN (SELECT i.inventory_id
                    FROM inventory i
                    INNER JOIN rental r ON r.inventory_id = i.inventory_id
                    WHERE i.ISBN = '$ISBN' AND r.actual_return_date is NULL)
                AND ISBN = '$ISBN'
                AND school_id = '$school_id'";

    $availableReservations = $conn->query($sql_ar);
    
    if($availableReservations->num_rows == 0):
            header("Location: book.php?ISBN=$ISBN&NotAvailable=true");
            exit;
    endif;


    $sql_rsl = "SELECT COUNT(reservation_id) AS res_id FROM reservation
                WHERE username = '$username'
                AND expiration_date >= DATE(CURRENT_TIMESTAMP)";

    $LimitedReservations = mysqli_query($conn, $sql_rsl);

    $row = mysqli_fetch_array($LimitedReservations, MYSQLI_ASSOC);
    $res_id = $row['res_id'];
    if($res_id >= 2):
            header("Location: book.php?ISBN=$ISBN&LimitedReservations=true");
            exit;
    endif;
     
    

    $sql_Rented = "SELECT *
                    FROM inventory i
                    INNER JOIN rental r ON r.inventory_id = i.inventory_id
                    WHERE i.ISBN = '$ISBN' AND r.username = '$username' AND actual_return_date is NULL";

    $Rented = $conn->query($sql_Rented);
    var_dump($Rented);
    if($Rented->num_rows != 0):
            header("Location: book.php?ISBN=$ISBN&Rented=true");
            exit;
    endif;

    $sql_not_returned = "SELECT * FROM rental
                            WHERE actual_return_date IS NULL
                            AND username = '$username'
                            AND expected_return_date < DATE(CURRENT_TIMESTAMP)";

    $NotReturned = $conn->query($sql_not_returned);
    var_dump($NotReturned);
    if($NotReturned->num_rows != 0):
            header("Location: book.php?ISBN=$ISBN&NotReturned=true");
            exit;
    endif;


    $sql = "INSERT INTO reservation (username, reservation_date, expiration_date, ISBN) VALUES ('$username', DATE(CURRENT_TIMESTAMP), DATE(CURRENT_TIMESTAMP)+7, '$ISBN')";
    if (mysqli_query($conn, $sql)) {
        header("Location: book.php?ISBN=$ISBN");
    }  
?>