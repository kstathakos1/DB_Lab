
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