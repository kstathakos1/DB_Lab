create table Book
(
    ISBN          int          not null
        primary key,
    Title         char         null,
    publisher     char         null,
    page          int          null,
    summary       varchar(255) null,
    `language-id` int          null
);

