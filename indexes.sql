CREATE INDEX rental_rental_date_idx ON rental (rental_date);

CREATE INDEX idx_category ON category (category);

CREATE INDEX idx_user_status_username ON user (status, username);
 
CREATE INDEX idx_inv_id ON inventory(inventory_id);

CREATE INDEX idx_author_id ON author (authors_id);

CREATE INDEX idx_rental_expected_return_date ON rental (expected_return_date); 

CREATE INDEX idx_author_name ON author (authors_first_name, authors_last_name);
