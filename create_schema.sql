drop schema  if exists lab;
create schema lab collate utf8_general_ci;
use lab;
create table author
(
    authors_id         int auto_increment
        primary key,
    authors_first_name char(255) not null,
    authors_last_name  char(255) not null
);

create table category
(
    category_id int auto_increment
        primary key,
    category    char(255) not null,
    constraint category_pk2
        unique (category)
);

create table language
(
    language_id int auto_increment
        primary key,
    language    char(255) null,
    constraint language_pk2
        unique (language)
);

create table book
(
    ISBN        int          not null
        primary key,
    title       char(255)    null,
    image       char(255)    null,
    publisher   char(255)    null,
    page        int          null,
    summary     varchar(255) null,
    language_id int          null,
    constraint book_language_language_id_fk
        foreign key (language_id) references language (language_id)
)
    collate = utf8mb4_unicode_ci;

create table book_author
(
    authors_id int not null,
    ISBN       int not null,
    constraint book_author_author_authors_id_fk
        foreign key (authors_id) references author (authors_id),
    constraint book_author_book_ISBN_fk
        foreign key (ISBN) references book (ISBN)
)
    collate = utf8mb4_unicode_ci;

create table book_category
(
    category_id int not null,
    ISBN        int not null,
    constraint book_category_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint book_category_category_category_id_fk
        foreign key (category_id) references category (category_id)
)
    collate = utf8mb4_unicode_ci;

create table school_unit
(
    school_id             int auto_increment
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

create table inventory
(
    ISBN         int not null,
    inventory_id int auto_increment
        primary key,
    school_id    int not null,
    constraint inventory_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint inventory_school_unit_school_id_fk
        foreign key (school_id) references school_unit (school_id)
)
    collate = utf8mb4_unicode_ci;

create table user
(
    username     varchar(255)                                             not null
        primary key,
    password     varchar(255)                                             not null,
    first_name   char(255)                                                not null,
    last_name    char(255)                                                not null,
    birth_date   date                                                     null,
    address      varchar(255)                                             not null,
    email        varchar(255)                                             not null,
    status       enum ('student', 'teacher', 'operator', 'admin', 'user') not null,
    phone_number char(255)                                                not null,
    school_id    int                                                      null,
    constraint user_pk
        unique (username),
    constraint user_school_unit_school_id_fk
        foreign key (school_id) references school_unit (school_id)
)
    collate = utf8mb4_unicode_ci;

create table rental
(
    rental_id            int auto_increment
        primary key,
    username             varchar(255) not null,
    inventory_id         int          not null,
    rental_date          date         not null,
    expected_return_date date         not null,
    actual_return_date   date         null,
    constraint rental_inventory_inventory_id_fk
        foreign key (inventory_id) references inventory (inventory_id),
    constraint rental_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;

create table reservation
(
    reservation_id   int auto_increment
        primary key,
    username         varchar(255) not null,
    reservation_date datetime     not null,
    expiration_date  datetime     not null,
    ISBN             int          null,
    constraint reservation_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint reservation_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;

create table review
(
    review_id    int auto_increment
        primary key,
    username     varchar(255) not null,
    review_score int          not null,
    review       varchar(255) not null,
    ISBN         int          null,
    constraint review_book_ISBN_fk
        foreign key (ISBN) references book (ISBN),
    constraint review_user_username_fk
        foreign key (username) references user (username)
)
    collate = utf8mb4_unicode_ci;



create view operator_user_info as
select `lab`.`user`.`username`     AS `username`,
       `lab`.`user`.`first_name`   AS `first_name`,
       `lab`.`user`.`last_name`    AS `last_name`,
       `lab`.`user`.`address`      AS `address`,
       `lab`.`user`.`email`        AS `email`,
       `lab`.`user`.`phone_number` AS `phone_number`,
       `lab`.`user`.`school_id`    AS `school_id`,
       `lab`.`user`.`status`       AS `status`
from `lab`.`user`;

create view rentals_per_school as
select `lab`.`inventory`.`school_id`       AS `school_id`,
       `lab`.`rental`.`rental_id`          AS `rental_id`,
       `lab`.`school_unit`.`school_number` AS `school_number`,
       `lab`.`school_unit`.`school_type`   AS `school_type`,
       `lab`.`school_unit`.`city`          AS `city`
from ((`lab`.`school_unit` join `lab`.`inventory`
       on ((`lab`.`school_unit`.`school_id` = `lab`.`inventory`.`school_id`))) join `lab`.`rental`
      on ((`lab`.`inventory`.`inventory_id` = `lab`.`rental`.`inventory_id`)));

