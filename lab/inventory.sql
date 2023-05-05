create table inventory
(
    ISBN           int not null,
    `inventory-id` int not null
        primary key,
    `school-id`    int not null,
    constraint inventory_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
);

