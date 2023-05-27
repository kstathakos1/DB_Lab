create
    definer = root@localhost procedure avarage_review(IN username char(255), IN category int)
SELECT sum(r.review_score)/count(r.review_id) as avarage_review
FROM review r
inner join book_category bc on r.ISBN = bc.ISBN
where (username is null or username=r.username) AND (category is null or category=bc.category_id)
group by username,category;