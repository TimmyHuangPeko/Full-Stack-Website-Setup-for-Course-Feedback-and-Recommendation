create table FeedbackFile (
    postId mediumint unsigned not null,
    fileName varchar(128) not null,
    fileContent mediumblob not null,

    constraint PK_FeedbackFile primary key (postId)
);