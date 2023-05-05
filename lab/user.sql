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
    `school-id`  int                                not null
);

