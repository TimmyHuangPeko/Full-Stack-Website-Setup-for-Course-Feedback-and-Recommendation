create table Course (
    courseId varchar(16) not null,
    semester varchar(8) not null,
    courseType varchar(64) not null,
    name varchar(64) not null,
    courseDate varchar(16) not null,
    courseStartTime time(0) not null,
    courseEndTime time(0) not null,
    classroom varchar(32) not null,
    courseRequired boolean not null,
    credit tinyint(1) unsigned not null,
    outline varchar(2048),
    objective varchar(1024),
    teachMethod varchar(256),
    evaluation varchar(256),
    outlineToken varchar(4096),
    objectiveToken varchar(2048),

    constraint PK_Course primary key (courseId, semester, courseType)
);