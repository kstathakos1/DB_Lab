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
    SELECT concat( rps.school_number,' ', rps.school_type, ' ', rps.city) AS 'School Name',
           COUNT(r.rental_id) AS 'number of loans'
    FROM RENTALS_PER_SCHOOL rps
    INNER JOIN rental r ON rps.rental_id = r.rental_id
    WHERE (year_param IS NULL OR YEAR(r.rental_date) = year_param)
        AND (month_param IS NULL OR MONTH(r.rental_date) = month_param)
    GROUP BY rps.school_id;
END;



create
    definer = root@localhost procedure teacher_book_category_loan(IN arg1 int)
begin
    select distinct concat(first_name,' ',last_name) AS 'Name'
        from user u
            inner join rental r ON u.username = r.username
    inner join inventory i ON r.inventory_id = i.inventory_id
    inner join book_category bc on i.ISBN=bc.ISBN
    inner join category c on bc.category_id = c.category_id
    where c.category_id=arg1 and (u.status='teacher' or u.status='operator');

end;


create
    definer = root@localhost procedure author_categorization(IN id int)
BEGIN
        SELECT distinct author.authors_first_name, author.authors_last_name
        from author
            inner join book_author ba on author.authors_id = ba.authors_id
            inner join book_category bc on ba.ISBN = bc.ISBN
            inner join category  on bc.category_id = category.category_id
        where category.category_id = id;
end;


SELECT concat(u.first_name,' ',u.last_name) AS Name_teacher, count(r.rental_id) as Number_rented_Books
FROM user u
inner join rental r on u.username = r.username
where YEAR(CURRENT_DATE)-year(u.birth_date)<=40 AND (u.status='teacher' or u.status='operator')
group by u.username
order by count(r.rental_id) desc
;

SELECT  concat(a.authors_first_name,' ',a.authors_last_name) as 'Authors name'
from author a
inner join book_author ba on a.authors_id = ba.authors_id
inner join inventory i on ba.ISBN = i.ISBN
left outer join rental r on i.inventory_id = r.inventory_id
group by a.authors_id
HAVING count(r.rental_id)=0;


DROP TABLE IF EXISTS rentals_per_year;

CREATE TEMPORARY TABLE rentals_per_year (
    SELECT count(*) AS number, school_id, YEAR(rental_date)
    FROM rental r INNER JOIN user u ON u.username=r.username
    GROUP by school_id, YEAR(rental_date)
    HAVING number > 20
);

SELECT number, group_concat(CONCAT( first_name, ' ', last_name ) separator ', ') AS operator_names
FROM rentals_per_year rpy
INNER JOIN user u ON u.school_id=rpy.school_id
AND status='operator'
GROUP BY number;



SELECT concat(category1,', ', category2) as most_common_category_pair, COUNT(*) AS count
FROM (
    SELECT c1.category AS category1, c2.category AS category2,i1.ISBN as isbn
    FROM book_category bc1
    JOIN book_category bc2 ON bc1.ISBN = bc2.ISBN AND bc1.category_id < bc2.category_id
    inner join category c1 on bc1.category_id = c1.category_id
    inner join category c2 on bc2.category_id=c2.category_id
    inner join inventory i1 on bc1.ISBN = i1.ISBN


    inner join rental r1 on i1.inventory_id = r1.inventory_id
) t

GROUP BY category1, category2
ORDER BY count DESC
LIMIT 3;


SELECT a.authors_first_name,a.authors_last_name, count(ba.ISBN) as number_of_books
FROM author a
join book_author ba on a.authors_id = ba.authors_id
group by a.authors_id
having number_of_books+5<=(SELECT max(num1)
                           FROM (
                           SELECT count(*) as num1
                           FROM author a
                               inner join book_author b on a.authors_id = b.authors_id
                                                     group by a.authors_id)
                               as maxnumer);



create view copies_per_school
as
    select b.title,b.ISBN,b.image,b.publisher,i.school_id,count(i.inventory_id) as copies
        from book b
inner join inventory i on b.ISBN = i.ISBN
group by b.ISBN,i.school_id;

create procedure book_search_op(IN title char(255),IN category int,IN author int,IN copies int,IN school int)
SELECT cps.title,group_concat(concat(a.authors_first_name,' ',a.authors_last_name) separator ', ') as authors_name
FROM copies_per_school cps
inner join book_author ba on cps.ISBN = ba.ISBN
inner join author a on a.authors_id = ba.authors_id
inner join book_category bc on ba.ISBN = bc.ISBN
inner join category c on c.category_id = bc.category_id
where (title is null or locate(title,cps.title))
AND (category is null or bc.category_id=category)
AND (author is null or a.authors_id=author)
AND (copies is null or copies=cps.copies)
AND (cps.school_id=school)
group by cps.title
;

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


create
    definer = root@localhost procedure avarage_review(IN username char(255), IN category int)
SELECT sum(r.review_score)/count(r.review_id) as avarage_review
FROM review r
inner join book_category bc on r.ISBN = bc.ISBN
where (username is null or username=r.username) AND (category is null or category=bc.category_id)
group by username,category;



create
    definer = root@localhost function routine_name(arg1 varchar(255)) returns int deterministic
begin
    declare au int;
    select authors_id into au
        from author
           where concat(authors_first_name,' ',authors_last_name)=arg1;
    return au;
    end;


create procedure book_search_user(IN title varchar(255),IN category char(255),IN author varchar(255) ,IN school int)
    SELECT distinct b.title
FROM book b
inner join book_author ba on b.ISBN = ba.ISBN
inner join author a on ba.authors_id = a.authors_id
inner join book_category bc on b.ISBN = bc.ISBN
inner join category c on bc.category_id = c.category_id
inner join inventory i on b.ISBN = i.ISBN
where (title is null or locate(title,b.title))
  AND (category is null or category=c.category)
  AND (author is null or a.authors_id=routine_name(author))
AND (school=i.school_id)

;


DELIMITER $$
CREATE PROCEDURE find_my_books (IN p_username CHAR(255))
BEGIN
    SELECT b.title,b.ISBN,r.actual_return_date,r.expected_return_date,r.rental_date
    FROM book b
        INNER JOIN inventory i ON i.ISBN=b.ISBN
        INNER JOIN rental r ON r.inventory_id=i.inventory_id
        INNER JOIN user u ON u.username=r.username
    WHERE u.username=p_username;
END$$
DELIMITER ;

call find_my_books('KK');