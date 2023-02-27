create table Feedback (
    postId mediumint unsigned not null auto_increment,
    content varchar(2048) not null,
    aScore tinyint(1) unsigned not null,
    aIll varchar(1024),
    passScore tinyint(1) unsigned not null,
    passIll varchar(1024),
    comScore tinyint(1) unsigned not null,
    comIll varchar(1024),
    learnScore tinyint(1) unsigned not null,
    learnIll varchar(1024),
    hwScore tinyint(1) unsigned not null,
    hwIll varchar(1024),
    exScore tinyint(1) unsigned not null,
    exIll varchar(1024),
    teachContent varchar(2048),
    readTime int unsigned default 0,
    clickTime int unsigned default 0,
    courseId varchar(16) not null,
    semester varchar(8) not null,
    courseType varchar(64) not null,
    

    constraint PK_Feedback primary key (postId)
);