
create
    definer = root@localhost function routine_name(arg1 varchar(255)) returns int deterministic
begin
    declare au int;
    select authors_id into au
        from author
           where concat(authors_first_name,' ',authors_last_name)=arg1;
    return au;
    end;
create
    definer = root@localhost procedure book_search_user(IN title char(255), IN category char(255), IN author char(255),
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
AND (cps.school_id=school)
group by cps.title,cps.ISBN;

;