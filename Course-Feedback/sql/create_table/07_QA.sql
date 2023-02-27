create table QA (
    QAId int unsigned not null auto_increment,
    question varchar(1024) not null,
    answer varchar(1024),
    reveal boolean default 0,
    leaveTime timestamp(0) default current_timestamp(),
    userId varchar(16),
    postId mediumint unsigned not null,

    constraint PK_QA primary key (QAId)
);