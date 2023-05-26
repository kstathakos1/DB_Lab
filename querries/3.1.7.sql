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