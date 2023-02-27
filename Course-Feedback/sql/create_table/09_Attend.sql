create table Attend (
    userId varchar(16) not null,
    courseId varchar(16) not null,
    semester varchar(8) not null,
    courseType varchar(64) not null,

    constraint PK_Attend primary key (userId, courseId, semester)
);