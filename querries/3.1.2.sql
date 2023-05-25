
-- Id must be replaced with the respective category identifier when creating the function
SELECT DISTINCT author.authors_first_name, author.authors_last_name
FROM author
    INNER JOIN book_author ba ON author.authors_id = ba.authors_id
    INNER JOIN book_category bc ON ba.ISBN = bc.ISBN
    INNER JOIN category  ON bc.category_id = category.category_id
WHERE category.category_id = id;

SELECT concat(first_name,' ',last_name) AS 'Name'
    FROM user u
        INNER JOIN rental r ON u.username = r.username
INNER JOIN inventory i ON r.inventory_id = i.inventory_id
INNER JOIN book_category bc ON i.ISBN=bc.ISBN
INNER JOIN category c ON bc.category_id = c.category_id
WHERE c.category_id = id AND (u.status='teacher' OR u.status='operator');

