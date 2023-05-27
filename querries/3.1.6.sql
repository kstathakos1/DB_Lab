--drops
DROP TABLE IF EXISTS rental_category;
DROP TABLE IF EXISTS category_pairs;
DROP TABLE IF EXISTS rented_pairs;
DROP TABLE IF EXISTS number_of_rents;
DROP TABLE IF EXISTS top_3_rents;
DROP TABLE IF EXISTS top_rents;


--joins the rental_id and the category_id
create TEMPORARY TABLE rental_category (
    SELECT rental_id, category_id 
    FROM rental 
    JOIN inventory AS i ON i.inventory_id = rental.inventory_id
    JOIN book_category AS b ON b.ISBN = i.ISBN
);

--contains all of the possible categories and rental_id-s but only once
--it does not have 4 - 8 as a pair but only 8 - 4 
CREATE TEMPORARY TABLE category_pairs (
    SELECT c1.category_id as c1, c2.category_id as c2, rental_id 
    FROM category c1 
    JOIN category c2 join rental_category WHERE c1.category_id > c2.category_id
);

--contains the pairs that have actually been rented and the respective retal_id
CREATE TEMPORARY TABLE rented_pairs(
    SELECT DISTINCT cp.*
    FROM category_pairs cp
    JOIN rental_category rc1 ON rc1.rental_id = cp.rental_id
    JOIN rental_category rc2 ON rc2.rental_id = cp.rental_id
    WHERE cp.c1 IN (rc1.category_id)
    AND cp.c2 IN (rc2.category_id)
);

--all of the pairs and how many times they've been rented
CREATE TEMPORARY TABLE number_of_rents(
    SELECT
        c1, c2,
        COUNT(rental_id) AS rental_count
    FROM rented_pairs
    GROUP BY c1, c2
);

--top 3 rented categories(as id-s) and how many times they have been rented
CREATE TEMPORARY TABLE top_3_rents(
    SELECT  *
    FROM number_of_rents
    ORDER BY rental_count DESC
    LIMIT 3
);

--by name
CREATE TEMPORARY TABLE top_rents (
    SELECT c1.category as c1_name, c2.category as c2_name, rental_count
    FROM top_3_rents tpr
    JOIN category c1 ON c1.category_id = tpr.c1
    JOIN category c2 ON c2.category_id = tpr.c2
);

SELECT CONCAT(c1_name, " and ", c2_name) AS 'Category Pairs', rental_count AS 'Times Rented'
FROM top_rents;
