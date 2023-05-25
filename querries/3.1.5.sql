DROP TABLE IF EXISTS rentals_per_year;

CREATE TEMPORARY TABLE rentals_per_year (
    SELECT count(*) AS number, school_id, YEAR(rental_date) 
    FROM rental r INNER JOIN user u ON u.username=r.username 
    GROUP by school_id, YEAR(rental_date) 
    HAVING number > 2
);

SELECT number, group_concat(CONCAT( first_name, ' ', last_name ) separator ', ') AS operator_names
FROM rentals_per_year rpy 
INNER JOIN user u ON u.school_id=rpy.school_id 
AND status='operator' 
GROUP BY number;