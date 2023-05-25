SELECT  concat(a.authors_first_name,' ',a.authors_last_name) as 'Authors name'
from author a
inner join book_author ba on a.authors_id = ba.authors_id
inner join inventory i on ba.ISBN = i.ISBN
left outer join rental r on i.inventory_id = r.inventory_id
group by a.authors_id
HAVING count(r.rental_id)=0