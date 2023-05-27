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
