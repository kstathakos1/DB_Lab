use lab;
drop view if exists rentals_per_school;
create view rentals_per_school as
select inventory.school_id      AS school_id,
       rental.rental_id          AS rental_id,
       school_unit.school_number AS school_number,
       school_unit.school_type   AS school_type,
       school_unit.city          AS city
from ((school_unit join inventory
       on ((school_unit.school_id = inventory.school_id))) join rental
      on ((inventory.inventory_id = rental.inventory_id)));

drop procedure if exists list_loans_by_school;
create
    definer = root@localhost procedure list_loans_by_school(IN year_param int, IN month_param int)
    SELECT concat( rps.school_number,' ', rps.school_type, ' ', rps.city) AS 'School Name',
           COUNT(r.rental_id) AS 'number of loans'
    FROM RENTALS_PER_SCHOOL rps
    INNER JOIN rental r ON rps.rental_id = r.rental_id
    WHERE (year_param IS NULL OR YEAR(r.rental_date) = year_param)
        AND (month_param IS NULL OR MONTH(r.rental_date) = month_param)
    GROUP BY rps.school_id;



drop procedure if exists teacher_book_category_loan;
create
    definer = root@localhost procedure teacher_book_category_loan(IN arg1 int)

    select distinct concat(first_name,' ',last_name) AS 'Name'
        from user u
            inner join rental r ON u.username = r.username
    inner join inventory i ON r.inventory_id = i.inventory_id
    inner join book_category bc on i.ISBN=bc.ISBN
    inner join category c on bc.category_id = c.category_id
    where c.category_id=arg1 and (u.status='teacher' or u.status='operator');

drop procedure if exists author_categorization;
create procedure author_categorization(IN id int)
        SELECT distinct author.authors_first_name, author.authors_last_name
        from author
            inner join book_author ba on author.authors_id = ba.authors_id
            inner join book_category bc on ba.ISBN = bc.ISBN
            inner join category  on bc.category_id = category.category_id
        where category.category_id = id;



# SELECT concat(u.first_name,' ',u.last_name) AS Name_teacher, count(r.rental_id) as Number_rented_Books
# FROM user u
# inner join rental r on u.username = r.username
# where YEAR(CURRENT_DATE)-year(u.birth_date)<=40 AND (u.status='teacher' or u.status='operator')
# group by u.username
# order by count(r.rental_id) desc
# ;

# SELECT  concat(a.authors_first_name,' ',a.authors_last_name) as 'Authors name'
# from author a
# inner join book_author ba on a.authors_id = ba.authors_id
# inner join inventory i on ba.ISBN = i.ISBN
# left outer join rental r on i.inventory_id = r.inventory_id
# group by a.authors_id
# HAVING count(r.rental_id)=0;


DROP TABLE IF EXISTS rentals_per_year;

CREATE TEMPORARY TABLE rentals_per_year (
    SELECT count(*) AS number, school_id, YEAR(rental_date)
    FROM rental r INNER JOIN user u ON u.username=r.username
    GROUP by school_id, YEAR(rental_date)
    HAVING number > 20
);

# SELECT number, group_concat(CONCAT( first_name, ' ', last_name ) separator ', ') AS operator_names
# FROM rentals_per_year rpy
# INNER JOIN user u ON u.school_id=rpy.school_id
# AND status='operator'
# GROUP BY number;



# SELECT concat(category1,', ', category2) as most_common_category_pair, COUNT(*) AS count
# FROM (
#     SELECT c1.category AS category1, c2.category AS category2,i1.ISBN as isbn
#     FROM book_category bc1
#     JOIN book_category bc2 ON bc1.ISBN = bc2.ISBN AND bc1.category_id < bc2.category_id
#     inner join category c1 on bc1.category_id = c1.category_id
#     inner join category c2 on bc2.category_id=c2.category_id
#     inner join inventory i1 on bc1.ISBN = i1.ISBN
#
#
#     inner join rental r1 on i1.inventory_id = r1.inventory_id
# ) t
#
# GROUP BY category1, category2
# ORDER BY count DESC
# LIMIT 3;


# SELECT a.authors_first_name,a.authors_last_name, count(ba.ISBN) as number_of_books
# FROM author a
# join book_author ba on a.authors_id = ba.authors_id
# group by a.authors_id
# having number_of_books+5<=(SELECT max(num1)
#                            FROM (
#                            SELECT count(*) as num1
#                            FROM author a
#                                inner join book_author b on a.authors_id = b.authors_id
#                                                      group by a.authors_id)
#                                as maxnumer);


drop view if exists copies_per_school;
create view copies_per_school
as
    select b.title,b.ISBN,b.image,b.publisher,i.school_id,count(i.inventory_id) as copies
        from book b
inner join inventory i on b.ISBN = i.ISBN
group by b.ISBN,i.school_id;

drop procedure if exists book_search_op;
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

drop procedure if exists out_of_date_borrowers;
DELIMITER $$
CREATE PROCEDURE out_of_date_borrowers (IN first_name CHAR(255), IN last_name CHAR(255), IN days_out INT,IN school int)
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
DELIMITER ;
DELIMITER $$
drop procedure if exists avarage_review;
create
    definer = root@localhost procedure avarage_review(IN username char(255), IN category int)
SELECT sum(r.review_score)/count(r.review_id) as avarage_review
FROM review r
inner join book_category bc on r.ISBN = bc.ISBN
where (username is null or username=r.username) AND (category is null or category=bc.category_id)
group by username,category;
DELIMITER ;

DELIMITER $$
drop function if exists routine_name;
create
    definer = root@localhost function routine_name(arg1 varchar(255)) returns int deterministic
begin
    declare au int;
    select authors_id into au
        from author
           where concat(authors_first_name,' ',authors_last_name)=arg1;
    return au;
    end;
DELIMITER ;
DELIMITER $$
drop procedure if exists book_search_user;
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
AND (school=i.school_id);
DELIMITER ;


drop procedure if exists find_my_books;
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
drop view if exists author_name_book;
create view author_name_book as
select author.authors_first_name AS authors_first_name,
       author.authors_last_name  AS authors_last_name,
       i.ISBN                          AS ISBN,
       ba.authors_id                   AS authors_id,
       i.inventory_id                  AS inventory_id
from ((author join book_author ba
       on ((author.authors_id = ba.authors_id))) join inventory i
      on ((ba.ISBN = i.ISBN)));

drop view if exists not_rented;
create view not_rented as
select inventory_id AS inventory_id, ISBN AS ISBN
from inventory
where (not (exists(select 1
                   from rental
                   where (rental.inventory_id=inventory.inventory_id))));


drop view if exists operator_user_info;
create view operator_user_info as
select username    AS username,
       first_name   AS first_name,
       last_name    AS last_name,
       address      AS address,
       email        AS email,
       phone_number AS phone_number,
       school_id    AS school_id,
       status       AS status
from user;
DELIMITER $$
drop function if exists school_name;
create function school_name(arg1 varchar(255)) returns int
    deterministic
begin
    declare sn int;
select school_id into sn
    from school_unit
        where arg1=if(school_number!=0, concat(school_number,' ',school_type,' ',city),concat(school_type,' ',city));
    return sn;
end;
DELIMITER ;


create
    definer = root@localhost function language_id(arg1 varchar(255)) returns int deterministic
begin
    declare id int;
select  language_id into id
    from language
        where arg1=language;
    return id;
end;

create
    definer = root@localhost function category_id(arg1 varchar(255)) returns int deterministic
begin
    declare id int;
select  category_id into id
    from category
        where arg1=category;
    return id;
end;


