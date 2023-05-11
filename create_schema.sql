create table authors
(
    authors_id        int  not null
        primary key,
    authors_fist_name char not null,
    authors_last_name char not null
);

create table category
(
    category_id int  not null
        primary key,
    category    char not null,
    constraint category_pk2
        unique (category)
);

create table language
(
    `language-id` int  not null
        primary key,
    language      char null,
    constraint language_pk2
        unique (language)
);

create table Book
(
    ISBN          int          not null
        primary key,
    Title         char         null,
    publisher     char         null,
    page          int          null,
    summary       varchar(255) null,
    `language-id` int          null,
    constraint `Book_language_language-id_fk`
        foreign key (`language-id`) references language (`language-id`)
);

create table book_author
(
    author_id int not null,
    ISBN      int not null,
    constraint book_author_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN),
    constraint book_author_authors_authors_id_fk
        foreign key (author_id) references authors (authors_id)
);

create table book_category
(
    category_id int not null,
    ISBN        int not null,
    constraint book_category_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN),
    constraint book_category_category_category_id_fk
        foreign key (category_id) references category (category_id)
);

create table operator
(
    operator_id   int  not null
        primary key,
    op_first_name char not null,
    op_last_name  char not null
);

create table School_unit
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
    operator_id           int  null,
    constraint School_unit_pk
        unique (operator_id),
    constraint School_unit_operator_operator_id_fk
        foreign key (operator_id) references operator (operator_id)
);

create table inventory
(
    ISBN           int not null,
    `inventory-id` int not null
        primary key,
    `school-id`    int not null,
    constraint inventory_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN),
    constraint `inventory_School_unit_school-id_fk`
        foreign key (`school-id`) references School_unit (`school-id`)
);

create table user
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
    `school-id`  int                                not null,
    constraint `user_School_unit_school-id_fk`
        foreign key (`school-id`) references School_unit (`school-id`)
);

create table rentals
(
    rental_id            int          not null
        primary key,
    username             varchar(255) not null,
    inventory_id         int          not null,
    rental_date          datetime     not null,
    expected_return_date datetime     not null,
    actual_return_date   datetime     not null,
    constraint `rentals_inventory_inventory-id_fk`
        foreign key (inventory_id) references inventory (`inventory-id`),
    constraint rentals_user_username_fk
        foreign key (username) references user (username)
);

create table reservation
(
    reservation_id   int          not null
        primary key,
    username         varchar(255) not null,
    reservation_date datetime     not null,
    expiration_date  datetime     not null,
    ISBN             int          null,
    constraint reservation_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN),
    constraint reservation_user_username_fk
        foreign key (username) references user (username)
);
