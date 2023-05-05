create table reservation
(
    reservation_id   int          not null
        primary key,
    username         varchar(255) not null,
    reservation_date datetime     not null,
    expiration_date  datetime     not null,
    `return-date`    datetime     not null,
    ISBN             int          null,
    constraint reservation_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
);

