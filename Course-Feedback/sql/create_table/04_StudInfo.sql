create table StudInfo (
    userId varchar(16) not null,
    department varchar(32),
    grade tinyint(1) unsigned,
    admissionTime varchar(8) not null,
    qualified boolean default 0,

    constraint PK_StudInfo primary key (userId)
);