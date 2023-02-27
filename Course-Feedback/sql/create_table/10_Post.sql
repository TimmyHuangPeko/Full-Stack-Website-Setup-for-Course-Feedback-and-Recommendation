create table Post(
    userId varchar(16) not null,
    courseId varchar(16) not null,
    semester varchar(8) not null,
    courseType varchar(64) not null,
    postId mediumint unsigned not null,
    postTime timestamp(0) default current_timestamp(),

    constraint PK_Post primary key (userId, courseId, semester, postId)
);