create table book_category
(
    category_id int not null,
    ISBN        int not null,
    constraint book_category_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
);

