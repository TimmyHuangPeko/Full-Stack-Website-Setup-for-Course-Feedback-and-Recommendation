/*AdminInfo*/
alter table AdminInfo
add constraint FK_AdminInfo_UserInfo
    foreign key (userId) references UserInfo(SSOID)
    on delete cascade on update cascade;

/*ProfInfo*/
alter table ProfInfo
add constraint FK_ProfInfo_UserInfo
    foreign key (userId) references UserInfo(SSOID)
    on delete cascade on update cascade;

/*StudInfo*/
alter table StudInfo
add constraint FK_StudInfo_UserInfo
    foreign key (userId) references UserInfo(SSOID)
    on delete cascade on update cascade;

/*Feedback*/
alter table Feedback
add constraint FK_Feedback_Course
    foreign key (courseId, semester, courseType) references Course(courseId, semester, courseType)
    on delete cascade on update cascade;

/*QA*/
alter table QA
add constraint FK_QA_StudInfo
    foreign key (userId) references StudInfo(userId)
    on delete set null on update cascade,
add constraint FK_QA_Feedback
    foreign key (postId) references Feedback(postId)
    on delete cascade on update cascade;

/*Teach*/
alter table Teach
add constraint FK_Teach_ProfInfo
    foreign key (userId) references ProfInfo(userId)
    on delete cascade on update cascade,
add constraint FK_Teach_Course
    foreign key (courseId, semester, courseType) references Course(courseId, semester, courseType)
    on delete cascade on update cascade;

/*Attend*/
alter table Attend
add constraint FK_Attend_StudInfo
    foreign key (userId) references StudInfo(userId)
    on delete cascade on update cascade,
add constraint FK_Attend_Course
    foreign key (courseId, semester, courseType) references Course(courseId, semester, courseType)
    on delete cascade on update cascade;

/*Post*/
alter table Post
add constraint FK_Post_StudInfo
    foreign key (userId) references StudInfo(userId)
    on delete cascade on update cascade,
add constraint FK_Post_Course
    foreign key (courseId, semester, courseType) references Course(courseId, semester, courseType)
    on delete cascade on update cascade,
add constraint FK_Post_Feedback
    foreign key (postId) references Feedback(postId)
    on delete cascade on update cascade;

/*FeedbackFile*/
alter table FeedbackFile
add constraint FK_FeedbackFile_Feedback
    foreign key (postId) references Feedback(postId)
    on delete cascade on update cascade;