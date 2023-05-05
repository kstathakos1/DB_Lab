create table book_author
(
    author_id int not null,
    ISBN      int not null,
    constraint book_author_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
);

