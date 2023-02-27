create table Teach (
    userId varchar(16) not null,
    courseId varchar(16) not null,
    semester varchar(16) not null,
    courseType varchar(64) not null,

    constraint PK_Teach primary key (userId, courseId, semester)
);