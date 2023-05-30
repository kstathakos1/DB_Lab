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