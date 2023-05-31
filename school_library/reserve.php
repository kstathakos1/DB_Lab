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
    if(empty($availableReservation)):
            header("Location: book.php?ISBN=$ISBN&NotAvailable=true");
    endif;


    $sql_rsl = "SELECT COUNT(reservation_id) FROM reservation
                WHERE username = '$username'
                AND reservation_date + 7 >= CURRENT_TIMESTAMP";

    $LimitedReservations = $conn->query($sql_rsl);

    if($LimitedReservations >= 2):
            header("Location: book.php?ISBN=$ISBN&LimitedReservations=true");
    endif;
     
    

    $sql_Rented = "SELECT COUNT(rental_id) 
                    FROM inventory i
                    INNER JOIN rental r ON r.inventory_id = i.inventory_id
                    WHERE i.ISBN = $ISBN AND r.username = $username AND actual_return_date is NULL";

    $Rented = $conn->query($sql_Rented);
    if($Rented=0):
            header("Location: book.php?ISBN=$ISBN&Rented=true");
    endif;

    $sql_not_returned = "SELECT COUNT(rental_id) FROM rental
                            WHERE actual_return_date IS NULL
                            AND username = 'aarmstrong'
                            AND expected_return_date < CURRENT_TIMESTAMP";

    $NotReturned = $conn->query($sql_NotReturned);
    if($NotReturned != 0):
            header("Location: book.php?ISBN=$ISBN&NotReturned=true");
    endif;
?>