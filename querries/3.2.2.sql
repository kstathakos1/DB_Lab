DELIMITER $$
CREATE PROCEDURE out_of_date_borrowers (IN first_name CHAR(255), IN last_name CHAR(255), IN days_out INT,IN school int)
BEGIN
    SELECT CONCAT(u.last_name, ' ', u.first_name) AS 'Borrower, out of date', 
    DATEDIFF(NOW(), r.expected_return_date) AS 'delaying_time'
    FROM user u
    INNER JOIN rental r ON r.username = u.username
    WHERE ((days_out IS NULL AND DATEDIFF(NOW(), r.expected_return_date) > 0)
           OR (days_out IS NOT NULL AND days_out < 7 AND DATEDIFF(NOW(), r.expected_return_date) >= 7)
           OR (days_out IS NOT NULL AND days_out >= 7 AND DATEDIFF(NOW(), r.expected_return_date) > days_out))
    AND (u.first_name = first_name OR first_name IS NULL OR first_name = '')
    AND (u.last_name = last_name OR last_name IS NULL OR last_name = '')
    AND (u.school_id=school)
    GROUP BY u.last_name, u.first_name;
END$$
DELIMITER ;
