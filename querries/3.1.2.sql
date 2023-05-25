create
definer = root@localhostprocedure procedure author_categorization (IN id INT)
    BEGIN
        SELECT author.authors_fist_name, author.authors_last_name
        from author
            inner join book_author ba on author.authors_id = ba.authors_id
            inner join book_category bc on ba.ISBN = bc.ISBN
            inner join category  on bc.category_id = category.category_id
        where category.category_id = id;
end;

create procedure teacher_book_category_loan(IN arg1 int)
begin
    select concat(first_name,' ',last_name) AS 'Name'
        from user u
            inner join rental r ON u.username = r.username
    inner join inventory i ON r.inventory_id = i.inventory_id
    inner join book_category bc on i.ISBN=bc.ISBN
    inner join category c on bc.category_id = c.category_id
    where c.category_id=arg1 and (u.status='teacher' or u.status='operator');

end;
;
