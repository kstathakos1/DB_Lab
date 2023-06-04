drop schema  if exists lab;
create schema lab collate utf8_general_ci;
use lab;
create table author
(
    authors_id         int auto_increment
        primary key,
    authors_first_name char(255) not null,
    authors_last_name  char(255) not null
);

create table category
(
    category_id int auto_increment
        primary key,
    category    char(255) not null,
    constraint category_pk2
        unique (category)
);

create table language
(
    language_id int auto_increment
        primary key,
    language    char(255) null,
    constraint language_pk2
        unique (language)
);

create table book
(
    ISBN        int          not null
        primary key,
    title       char(255)    null,
    image       char(255)    null,
    publisher   char(255)    null,
    page        int          null,
    summary     varchar(255) null,
    language_id int          null,
    constraint book_language_language_id_fk
        foreign key (language_id) references language (language_id)
)
    collate = utf8mb4_unicode_ci;

create table book_author
(
    authors_id int not null,
    ISBN       int not null,
    constraint book_author_author_authors_id_fk
        foreign key (authors_id) references author (authors_id),
    constraint book_author_book_ISBN_fk
        foreign key (ISBN) references book (ISBN)
)
    collate = utf8mb4_unicode_ci;

create table book_category
(
    category_id int not null,
    ISBN        int not null,
    constraint book_category_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint book_category_category_category_id_fk
        foreign key (category_id) references category (category_id)
)
    collate = utf8mb4_unicode_ci;

create table school_unit
(
    school_id             int auto_increment
        primary key,
    school_number         int                                                             null,
    school_type           enum ('Elementary of', 'Junior Highschool of', 'Highschool of') null,
    city                  char(255)                                                       null,
    school_mail           char(255)                                                       not null,
    address               char(255)                                                       null,
    telephone             char(255)                                                       null,
    Headmaster_first_name char(255)                                                       null,
    Headmaster_last_name  char(255)                                                       null
);

create table inventory
(
    ISBN         int not null,
    inventory_id int auto_increment
        primary key,
    school_id    int not null,
    constraint inventory_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint inventory_school_unit_school_id_fk
        foreign key (school_id) references school_unit (school_id)
)
    collate = utf8mb4_unicode_ci;

create table user
(
    username     varchar(255)                                                       not null
        primary key,
    password     varchar(255)                                                       not null,
    first_name   char(255)                                                          not null,
    last_name    char(255)                                                          not null,
    birth_date   date                                                               null,
    address      varchar(255)                                                       not null,
    email        varchar(255)                                                       not null,
    status       enum ('student', 'teacher', 'operator', 'admin', 'user')           not null,
    phone_number char(255)                                                          not null,
    school_id    int                                                                null,
    activity     enum ('activated', 'deactivated', 'submitted') default 'submitted' not null,
    constraint user_pk
        unique (username),
    constraint user_school_unit_school_id_fk
        foreign key (school_id) references school_unit (school_id)
)
    collate = utf8mb4_unicode_ci;

create table rental
(
    rental_id            int auto_increment
        primary key,
    username             varchar(255) not null,
    inventory_id         int          not null,
    rental_date          date         not null,
    expected_return_date date         not null,
    actual_return_date   date         null,
    constraint rental_inventory_inventory_id_fk
        foreign key (inventory_id) references inventory (inventory_id),
    constraint rental_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;

create table reservation
(
    reservation_id   int auto_increment
        primary key,
    username         varchar(255) not null,
    reservation_date datetime     null,
    expiration_date  datetime     null,
    ISBN             int          null,
    constraint reservation_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint reservation_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;

create table review
(
    review_id    int auto_increment
        primary key,
    username     varchar(255) not null,
    review_score int          not null,
    review       varchar(255) null,
    ISBN         int          null,
    constraint review_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint review_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;



create view operator_user_info as
select `lab`.`user`.`username`     AS `username`,
       `lab`.`user`.`first_name`   AS `first_name`,
       `lab`.`user`.`last_name`    AS `last_name`,
       `lab`.`user`.`address`      AS `address`,
       `lab`.`user`.`email`        AS `email`,
       `lab`.`user`.`phone_number` AS `phone_number`,
       `lab`.`user`.`school_id`    AS `school_id`,
       `lab`.`user`.`status`       AS `status`
from `lab`.`user`;

create view rentals_per_school as
select `lab`.`inventory`.`school_id`       AS `school_id`,
       `lab`.`rental`.`rental_id`          AS `rental_id`,
       `lab`.`school_unit`.`school_number` AS `school_number`,
       `lab`.`school_unit`.`school_type`   AS `school_type`,
       `lab`.`school_unit`.`city`          AS `city`
from ((`lab`.`school_unit` join `lab`.`inventory`
       on ((`lab`.`school_unit`.`school_id` = `lab`.`inventory`.`school_id`))) join `lab`.`rental`
      on ((`lab`.`inventory`.`inventory_id` = `lab`.`rental`.`inventory_id`)));

create view author_name_book as
select `lab`.`author`.`authors_first_name` AS `authors_first_name`,
       `lab`.`author`.`authors_last_name`  AS `authors_last_name`,
       `i`.`ISBN`                          AS `ISBN`,
       `ba`.`authors_id`                   AS `authors_id`,
       `i`.`inventory_id`                  AS `inventory_id`
from ((`lab`.`author` join `lab`.`book_author` `ba`
       on ((`lab`.`author`.`authors_id` = `ba`.`authors_id`))) join `lab`.`inventory` `i`
      on ((`ba`.`ISBN` = `i`.`ISBN`)));


create view copies_per_school as
select `b`.`title`               AS `title`,
       `b`.`ISBN`                AS `ISBN`,
       `b`.`image`               AS `image`,
       `b`.`publisher`           AS `publisher`,
       `i`.`school_id`           AS `school_id`,
       count(`i`.`inventory_id`) AS `copies`
from (`lab`.`book` `b` join `lab`.`inventory` `i` on ((`b`.`ISBN` = `i`.`ISBN`)))
group by `b`.`ISBN`, `i`.`school_id`;


create view not_rented as
select `lab`.`inventory`.`inventory_id` AS `inventory_id`, `lab`.`inventory`.`ISBN` AS `ISBN`
from `lab`.`inventory`
where (not (exists(select 1
                   from `lab`.`rental`
                   where (`lab`.`rental`.`inventory_id` = `lab`.`inventory`.`inventory_id`))));



create view operator_user_info as
select `lab`.`user`.`username`     AS `username`,
       `lab`.`user`.`first_name`   AS `first_name`,
       `lab`.`user`.`last_name`    AS `last_name`,
       `lab`.`user`.`address`      AS `address`,
       `lab`.`user`.`email`        AS `email`,
       `lab`.`user`.`phone_number` AS `phone_number`,
       `lab`.`user`.`school_id`    AS `school_id`,
       `lab`.`user`.`status`       AS `status`
from `lab`.`user`;



create procedure author_categorization(IN id char(255))
SELECT distinct author.authors_first_name, author.authors_last_name
        from author
            inner join book_author ba on author.authors_id = ba.authors_id
            inner join book_category bc on ba.ISBN = bc.ISBN
            inner join category  on bc.category_id = category.category_id
        where category.category = id;


create procedure avarage_review(IN username char(255), IN category char(255), IN school_id int)
SELECT sum(r.review_score)/count(r.review_id) as avarage_review
FROM review r
inner join book_category bc on r.ISBN = bc.ISBN
    inner join inventory i on r.ISBN = i.ISBN
inner join category c on bc.category_id = c.category_id
where (username is null or username=r.username) AND (category is null or category=c.category)AND school_id=i.school_id
group by username,category;

create procedure book_search_op(IN title char(255), IN category char(255), IN author char(255), IN copies int,
                                IN school int)
SELECT cps.title,group_concat(concat(a.authors_first_name,' ',a.authors_last_name) separator ', ') as authors_name,cps.image,cps.ISBN as ISBN
FROM copies_per_school cps
inner join book_author ba on cps.ISBN = ba.ISBN
inner join author a on a.authors_id = ba.authors_id
inner join book_category bc on ba.ISBN = bc.ISBN
inner join category c on c.category_id = bc.category_id
where (title is null or locate(title,cps.title))
AND (category is null or c.category like concat('%',category,'%'))
AND (author is null or concat(a.authors_first_name,' ',a.authors_last_name)like concat('%',author,'%'))
AND (copies is null or copies=cps.copies)
AND (cps.school_id=school)
group by cps.title,cps.ISBN;

create procedure book_search_user(IN title char(255), IN category char(255), IN author char(255), IN school int)
SELECT cps.title,group_concat(concat(a.authors_first_name,' ',a.authors_last_name) separator ', ') as authors_name,cps.image,cps.ISBN as ISBN
FROM copies_per_school cps
inner join book_author ba on cps.ISBN = ba.ISBN
inner join author a on a.authors_id = ba.authors_id
inner join book_category bc on ba.ISBN = bc.ISBN
inner join category c on c.category_id = bc.category_id
where (title is null or locate(title,cps.title))
AND (category is null or c.category like concat('%',category,'%'))
AND (author is null or concat(a.authors_first_name,' ',a.authors_last_name)like concat('%',author,'%'))
AND (cps.school_id=school)
group by cps.title,cps.ISBN;


drop
create function category_id(arg1 varchar(255)) returns int
    deterministic
begin
    declare id int;
select  category_id into id
    from category
        where arg1=category;
    return id;
end;

drop procedure if exists find_my_books;
create procedure find_my_books(IN p_username char(255))
BEGIN
    SELECT b.title,b.ISBN,r.actual_return_date,r.expected_return_date,r.rental_date
    FROM book b
        INNER JOIN inventory i ON i.ISBN=b.ISBN
        INNER JOIN rental r ON r.inventory_id=i.inventory_id
        INNER JOIN user u ON u.username=r.username
    WHERE u.username=p_username;
END;


drop function if exists inventory_not_free_copies;
create function inventory_not_free_copies(ISBN int, school_id int) returns int
begin
    declare av int;
select count(*) into av
from inventory i
inner join rental r on i.inventory_id = r.inventory_id
where i.ISBN=ISBN and r.actual_return_date is null and i.school_id=school_id
group by i.school_id,i.ISBN;
        return av;
end;

drop function if exists language_id;
create function language_id(arg1 varchar(255)) returns int
    deterministic
begin
    declare id int;
select  language_id into id
    from language
        where arg1=language;
    return id;
end;


drop procedure if exists
create procedure list_loans_by_school(IN year_param int, IN month_param int)
SELECT concat( rps.school_number,' ', rps.school_type, ' ', rps.city) AS name,
           COUNT(r.rental_id) AS number
    FROM RENTALS_PER_SCHOOL rps
    INNER JOIN rental r ON rps.rental_id = r.rental_id
    WHERE (year_param IS NULL OR YEAR(r.rental_date) = year_param)
        AND (month_param IS NULL OR MONTH(r.rental_date) = month_param)
    GROUP BY rps.school_id;

drop procedure if exists out_of_date_borrowers;
create procedure out_of_date_borrowers(IN search_name varchar(255), IN days_out int, IN school int)
BEGIN
    SELECT CONCAT(u.first_name, ' ', u.last_name) AS 'name', b.title, b.ISBN, r.rental_date,r.rental_id,
           r.actual_return_date, r.expected_return_date, u.username,
           DATEDIFF(NOW(), r.expected_return_date) AS 'delaying_time'
    FROM user u
    INNER JOIN rental r ON r.username = u.username
    INNER JOIN inventory i ON r.inventory_id = i.inventory_id
    INNER JOIN book b ON i.ISBN = b.ISBN
    WHERE ((days_out IS NULL AND DATEDIFF(NOW(), r.expected_return_date) > 0)
           OR (days_out IS NOT NULL AND days_out < 7 AND DATEDIFF(NOW(), r.expected_return_date) >= 7)
           OR (days_out IS NOT NULL AND days_out >= 7 AND DATEDIFF(NOW(), r.expected_return_date) > days_out))
      AND ((search_name IS NULL OR search_name = '') OR (u.first_name LIKE CONCAT('%', search_name, '%') OR u.last_name LIKE CONCAT('%', search_name, '%'))
           OR CONCAT(u.first_name, ' ', u.last_name) like concat('%',search_name,'%'))
      AND i.school_id = school;
END;

drop procedure if exists out_of_date_borrowers_now;
create procedure out_of_date_borrowers_now(IN search_name varchar(255), IN days_out int, IN school int)
BEGIN


    SELECT CONCAT(u.first_name, ' ', u.last_name) AS 'name', b.title, b.ISBN, r.rental_date,r.rental_id,
           r.actual_return_date, r.expected_return_date, u.username,DATEDIFF(NOW(), r.expected_return_date) as delaying_time

    FROM user u
    INNER JOIN rental r ON r.username = u.username
    INNER JOIN inventory i ON r.inventory_id = i.inventory_id
    INNER JOIN book b ON i.ISBN = b.ISBN
    WHERE r.actual_return_date is null and ((days_out IS NULL  and DATEDIFF(NOW(), r.expected_return_date) > 0 )
           OR (days_out IS not NULL  AND DATEDIFF(NOW(), r.expected_return_date) = days_out))
      AND ((search_name IS NULL OR search_name = '') OR (u.first_name LIKE CONCAT('%', search_name, '%') OR u.last_name LIKE CONCAT('%', search_name, '%'))
           OR CONCAT(u.first_name, ' ', u.last_name) like concat('%',search_name,'%'))
      AND i.school_id = school;

END;



drop function if exists reserved_copies;
create function reserved_copies(ISBN int, school_id int) returns int
begin
    declare av int;
    select count(distinct  i.ISBN) into av
        from reservation r
    inner join inventory i on r.ISBN = i.ISBN
    where i.ISBN=ISBN and i.school_id=school_id and current_date<r.expiration_date
    group by i.ISBN;
    return av;
end;
drop function if exists routine_name
create function routine_name(arg1 varchar(255)) returns int
    deterministic
begin
    declare au int;
    select authors_id into au
        from author
           where concat(authors_first_name,' ',authors_last_name)=arg1;
    return au;
    end;



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



drop procedure if exists teacher_book_category_loan;
create procedure teacher_book_category_loan(IN arg1 int)
select distinct concat(first_name,' ',last_name) AS 'Name'
        from user u
            inner join rental r ON u.username = r.username
    inner join inventory i ON r.inventory_id = i.inventory_id
    inner join book_category bc on i.ISBN=bc.ISBN
    inner join category c on bc.category_id = c.category_id
    where c.category_id=arg1 and (u.status='teacher' or u.status='operator');

