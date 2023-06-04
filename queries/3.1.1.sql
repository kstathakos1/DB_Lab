create view rentals_per_school as
select `lab`.`inventory`.`school_id`       AS `school_id`,
       `lab`.`rental`.`rental_id`          AS `rental_id`,
       `lab`.`school_unit`.`school_number` AS `school_number`,
       `lab`.`school_unit`.`school_type`   AS `school_type`,
       `lab`.`school_unit`.`city`          AS `city`
from ((`lab`.`school_unit` join `lab`.`inventory`
       on ((`lab`.`school_unit`.`school_id` = `lab`.`inventory`.`school_id`))) join `lab`.`rental`
      on ((`lab`.`inventory`.`inventory_id` = `lab`.`rental`.`inventory_id`)));


create
    definer = root@localhost procedure list_loans_by_school(IN year_param int, IN month_param int)
BEGIN
    SELECT concat( rps.school_number,' ', rps.school_type, ' ', rps.city) AS name,
           COUNT(r.rental_id) AS number
    FROM RENTALS_PER_SCHOOL rps
    INNER JOIN rental r ON rps.rental_id = r.rental_id
    WHERE (year_param IS NULL OR YEAR(r.rental_date) = year_param)
        AND (month_param IS NULL OR MONTH(r.rental_date) = month_param)
    GROUP BY rps.school_id;
END;


