create schema lab collate utf8_general_ci;
use lab;
create table School_unit
(
    school_id             int                                                             not null
        primary key,
    school_number         int                                                             null,
    school_type           enum ('Elementary of', 'Junior Highschool of', 'Highschool of') null,
    city                  char(255)                                                       null,
    school_mail           char(255)                                                       not null,
    address               char(255)                                                       null,
    telephone             char(255)                                                       null,
    Headmaster_first_name char(255)                                                       null,
    Headmaster_last_name  char(255)                                                       null
);

create table authors
(
    authors_id        int       not null
        primary key,
    authors_fist_name char(255) not null,
    authors_last_name char(255) not null
);

create table category
(
    category_id int       not null
        primary key,
    category    char(255) not null,
    constraint category_pk2
        unique (category)
);

create table language
(
    language_id int       not null
        primary key,
    language    char(255) null,
    constraint language_pk2
        unique (language)
);

create table Book
(
    ISBN        int          not null
        primary key,
    Title       char(255)    null,
    image       char(255)    null,
    publisher   char(255)    null,
    page        int          null,
    summary     varchar(255) null,
    language_id int          null,
    constraint `Book_language_language-id_fk`
        foreign key (language_id) references language (language_id)
)
    collate = utf8mb4_unicode_ci;

create table book_author
(
    authors_id int not null,
    ISBN       int not null,
    constraint book_author_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN),
    constraint book_author_authors_authors_id_fk
        foreign key (authors_id) references authors (authors_id)
)
    collate = utf8mb4_unicode_ci;

create table book_category
(
    category_id int not null,
    ISBN        int not null,
    constraint book_category_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN),
    constraint book_category_category_category_id_fk
        foreign key (category_id) references category (category_id)
)
    collate = utf8mb4_unicode_ci;

create table inventory
(
    ISBN         int not null,
    inventory_id int not null
        primary key,
    school_id    int not null,
    constraint `inventory._School_unit_school_id_fk`
        foreign key (school_id) references School_unit (school_id),
    constraint inventory_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN)
)
    collate = utf8mb4_unicode_ci;

create table user
(
    username     varchar(255)                       not null
        primary key,
    password     varchar(255)                       not null,
    first_name   char(255)                          not null,
    last_name    char(255)                          not null,
    address      varchar(255)                       not null,
    email        varchar(255)                       not null,
    status       enum ('user', 'operator', 'admin') not null,
    phone_number char(255)                          not null,
    school_id    int                                null,
    constraint `user._pk`
        unique (username),
    constraint user_School_unit_school_id_fk
        foreign key (school_id) references School_unit (school_id)
)
    collate = utf8mb4_unicode_ci;

create table rentals
(
    rental_id            int          not null
        primary key,
    username             varchar(255) not null,
    inventory_id         int          not null,
    rental_date          date         not null,
    expected_return_date date         not null,
    actual_return_date   date         null,
    constraint `rentals_inventory_inventory-id_fk`
        foreign key (inventory_id) references inventory (inventory_id),
    constraint rentals_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;

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
)
    collate = utf8mb4_unicode_ci;

create table review
(
    review_id    int          not null
        primary key,
    username     varchar(255) not null,
    review_score int          not null,
    review       varchar(255) not null,
    ISBN         int          null,
    constraint review_Book_ISBN_fk
        foreign key (ISBN) references Book (ISBN),
    constraint review_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;





CREATE VIEW operator_user_info AS
SELECT 
    username,
    first_name,
    last_name,
    address,
    email,
    phone_number,
    school_id,
    status,
    CASE WHEN status = 'operator' THEN NULL ELSE password END AS password
FROM user;
