<?php
include('../config/database.php');
if (!isset($_SESSION)) session_start();
$username = $_POST['username'];
$isbn = $_POST['ISBN'];
$school_id = $_SESSION['id'];
$conn = getDb();
$sql_unreturned_rent = $conn->query("SELECT *
                                        FROM rental
                                        where username='$username' and actual_return_date is null ;");
$unreturned_rent = mysqli_num_rows($sql_unreturned_rent);
$sql_book_check = $conn->query("select * from book where ISBN= $isbn ;");

if (mysqli_num_rows($sql_book_check) == 0) {
    $_SESSION['success'] = 'error';
    $_SESSION['success_log'] = 'The bool you requested does not exist in the database';
    header("Location: rentals_of_school.php");
}

if ($unreturned_rent > 0) {
    $_SESSION['success'] = 'error';
    $_SESSION['success_log'] = 'The user: ' . $username . ' has an unreturned book';
    header("Location: rentals_of_school.php");
} else {
    $sql_user_status = $conn->query("SELECT status
                                            FROM user
                                            where username='$username';");
    if (mysqli_num_rows($sql_user_status) == 0) {
        $_SESSION['success'] = 'error';
        $_SESSION['success_log'] = 'The username: ' . $username . ' is not valid';
        header("Location: rentals_of_school.php");
    }

    $user_status = mysqli_fetch_assoc($sql_user_status);
    $user_status = $user_status['status'];
    if ($user_status == 'student')
        $max_rent = 2;
    else
        $max_rent = 1;
    $sql_num_of_rents_this_week = $conn->query("SELECT count(*)
                                                    FROM rental
                                                    where username='$username' 
                                                    and rental_date<=date (current_timestamp) 
                                                    and rental_date>=date (current_timestamp()-7)
                                                    group by username;");
    $num_of_rents_this_week = mysqli_num_rows($sql_num_of_rents_this_week);
    if ($num_of_rents_this_week >= $max_rent) {
        $_SESSION['success'] = 'error';
        $_SESSION['success_log'] = 'The user: ' . $username . ' has rented the maximum amount of books for this week';
        header("Location: rentals_of_school.php");
    } else {
        $sql_has_user_reserve = $conn->query("SELECT *
                                            FROM reservation
                                            where username='$username' and ISBN=$isbn;");
        $has_user_reserve = mysqli_num_rows($sql_has_user_reserve);
        if ($has_user_reserve > 0) {
            $sql_delete_reservation = $conn->query("delete from reservation where username='$username' and ISBN=$isbn ;");
            $sql_free_inventory = $conn->query(" SELECT i.inventory_id
                                                        FROM inventory i
                                                        left join rental r on i.inventory_id = r.inventory_id
                                                        where i.ISBN=$isbn and i.school_id=$school_id and (rental_id is null or actual_return_date<=current_date);");
            $free_inventory = mysqli_fetch_assoc($sql_free_inventory);
            $free_inventory = $free_inventory['inventory_id'];
            $sql_insert_rental = $conn->query("insert into rental (username,inventory_id,rental_date,expected_return_date,actual_return_date)
                                                    VALUES ('$username',$free_inventory,DATE(CURRENT_TIMESTAMP),DATE(CURRENT_TIMESTAMP)+7,null);");
            $_SESSION['success'] = 'success';
            $_SESSION['success_log'] = 'The username: ' . $username . ' has rented successfully th book';
            header("Location: rentals_of_school.php");
        } else {
            $sql_reserved_copies = $conn->query("SELECT reserved_copies($isbn,$school_id) as reserved_copies ;");
            $num_reserved_copies = mysqli_fetch_assoc($sql_reserved_copies);
            $num_reserved_copies = $num_reserved_copies['reserved_copies'];
            $sql_rented_copies = $conn->query("select inventory_not_free_copies($isbn,$school_id) as rented_copies ;");
            $num_rented_copies = mysqli_fetch_assoc($sql_rented_copies);
            $num_rented_copies = $num_rented_copies['rented_copies'];
            $sql_copies_in_school = $conn->query("SELECT copies
                                            FROM copies_per_school
                                            where ISBN=$isbn and school_id=$school_id ;");
            $copies_in_school = mysqli_fetch_assoc($sql_copies_in_school);
            $copies_in_school = $copies_in_school['copies'];
            if ($copies_in_school > $num_rented_copies + $num_reserved_copies) {
                $sql_free_inventory = $conn->query(" SELECT i.inventory_id
                                                        FROM inventory i
                                                        left join rental r on i.inventory_id = r.inventory_id
                                                        where i.ISBN=$isbn and i.school_id=$school_id and (rental_id is null or actual_return_date<=current_date);");
                $free_inventory = mysqli_fetch_assoc($sql_free_inventory);
                $free_inventory = $free_inventory['inventory_id'];
                $sql_insert_rental = $conn->query("insert into rental (username,inventory_id,rental_date,expected_return_date,actual_return_date)
                                                    VALUES ('$username',$free_inventory,DATE(CURRENT_TIMESTAMP),DATE(CURRENT_TIMESTAMP)+7,null);");
                $_SESSION['success'] = 'success';
                $_SESSION['success_log'] = 'The user: ' . $username . ' has rented successfully the book';
                header("Location: rentals_of_school.php");
            } else {
                if (mysqli_num_rows($sql_book_check) == 0) {
                    $_SESSION['success'] = 'error';
                    $_SESSION['success_log'] = 'The bool you requested does not exist in the database';
                    header("Location: rentals_of_school.php");
                } else {
                    $_SESSION['success'] = 'error';
                    $_SESSION['success_log'] = 'There are none available copies of the requested book.';
                    header("Location: rentals_of_school.php");
                }
            }

        }


    }


}


?>
