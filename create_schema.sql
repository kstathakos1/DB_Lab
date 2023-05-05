create table if not exists Book
(
    ISBN          int          not null
        primary key,
    Title         char         null,
    publisher     char         null,
    page          int          null,
    summary       varchar(255) null,
    `language-id` int          null
);

create table if not exists School_unit
(
    `school-id`           int  not null
        primary key,
    school_name           int  null,
    city                  char null,
    `school-mail`         char not null,
    address               char null,
    telephone             int  null,
    Headmaster_first_name char null,
    Headmaster_last_name  int  null,
    operator_id           int  null
);

create table if not exists authors
(
    authors_id        int  not null
        primary key,
    authors_fist_name char not null,
    authors_last_name char not null
);

create table if not exists book_author
(
    author_id int not null,
    ISBN      int not null,
    constraint book_author_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
);

create table if not exists book_category
(
    category_id int not null,
    ISBN        int not null,
    constraint book_category_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
);

create table if not exists category
(
    category_id int  not null
        primary key,
    category    char not null,
    constraint category_pk2
        unique (category)
);

create table if not exists inventory
(
    ISBN           int not null,
    `inventory-id` int not null
        primary key,
    `school-id`    int not null,
    constraint inventory_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
);

create table if not exists operator
(
    operator_id   int  not null
        primary key,
    op_first_name char not null,
    op_last_name  char not null
);

create table if not exists rentals
(
    rental_id            int          not null
        primary key,
    username             varchar(255) not null,
    inventory_id         int          not null,
    rental_date          datetime     not null,
    expected_return_date datetime     not null,
    actual_return_date   datetime     not null
);

create table if not exists reservation
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

create table if not exists user
(
    username     varchar(255)                       not null
        primary key,
    password     varchar(255)                       not null,
    first_name   char                               not null,
    last_name    char                               not null,
    address      varchar(255)                       not null,
    email        varchar(255)                       not null,
    status       enum ('user', 'oparator', 'admin') not null,
    phone_number int                                not null,
    `school-id`  int                                not null
);

