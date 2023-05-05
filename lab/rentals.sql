create table rentals
(
    rental_id            int          not null
        primary key,
    username             varchar(255) not null,
    inventory_id         int          not null,
    rental_date          datetime     not null,
    expected_return_date datetime     not null,
    actual_return_date   datetime     not null
);

