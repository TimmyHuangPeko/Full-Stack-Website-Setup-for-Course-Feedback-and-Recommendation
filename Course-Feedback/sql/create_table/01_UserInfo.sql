create table UserInfo (
    SSOID varchar(16) not null,
    password varchar(512) not null,
    name varchar(64) not null,
    identity varchar(16) not null,
    email varchar(64) not null,
    phone varchar(16),
    introduction varchar(2048),

    constraint PK_UserInfo primary key (SSOID)
);