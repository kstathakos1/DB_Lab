DELIMITER $$
CREATE PROCEDURE find_my_books (IN p_username CHAR(255))
BEGIN
    SELECT b.title
    FROM book b
        INNER JOIN inventory i ON i.ISBN=b.ISBN
        INNER JOIN rental r ON r.inventory_id=i.inventory_id
        INNER JOIN user u ON u.username=r.username
    WHERE u.username=p_username;
END$$
DELIMITER ; 
