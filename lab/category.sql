create table category
(
    category_id int  not null
        primary key,
    category    char not null,
    constraint category_pk2
        unique (category)
);

