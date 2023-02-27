create table ProfInfo (
    userId varchar(16) not null,
    department varchar(32),
    office varchar(16),

    constraint PK_ProfInfo primary key (userId)
);