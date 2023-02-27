create table AdminInfo (
    userId varchar(16) not null,
    authority bit(8) default b'001',

    constraint PK_AdminInfo primary key (userId)
);