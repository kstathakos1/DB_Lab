CREATE INDEX idx_author_name ON author (authors_first_name, authors_last_name);

CREATE INDEX idx_category ON category (category);

CREATE INDEX idx_language ON language (language);

CREATE INDEX idx_book_ISBN ON book (ISBN);

CREATE INDEX idx_book_language_id ON book (language_id);

CREATE INDEX idx_book_author_ISBN ON book_author (ISBN);

CREATE INDEX idx_book_author_authors_id ON book_author (authors_id);

CREATE INDEX idx_book_category_ISBN ON book_category (ISBN);

CREATE INDEX idx_book_category_category_id ON book_category (category_id);

CREATE INDEX idx_school_unit_type_city ON school_unit (school_type, city);

CREATE INDEX idx_inventory_ISBN_school_id ON inventory (ISBN, school_id);

CREATE INDEX idx_user_username_status ON user (username, status);

CREATE INDEX idx_rental_username_inventory_id ON rental (username, inventory_id);

CREATE INDEX idx_reservation_username_ISBN ON reservation (username, ISBN);

CREATE INDEX idx_review_ISBN_username ON review (ISBN, username);
