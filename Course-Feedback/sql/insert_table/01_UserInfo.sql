/*normal case*/
insert into UserInfo
values
('B063047894', sha2('B063047894', 256), 'Alice', 'student', 'dcisson0@auda.org.au', '277 429 6258', null),
('B063049107', sha2('B063049107', 256), 'Bob', 'student', 'xormond1@flickr.com', null, null),
('B063046452', sha2('B063046452', 256), 'Jimmy', 'student', 'pgiaomozzo2@etsy.com', null, 'hello, my name is Jimmy. I am two years old now.'),
('B063042316', sha2('B063042316', 256), 'Kevin', 'student', 'tkohler3@psu.edu', '365 230 9960', null),
('B063041155', sha2('B063041155', 256), 'Derick', 'student', 'fjolliffe4@chronoengine.com', null, 'hi.'),
('B063042789', sha2('B063042789', 256), 'Westley', 'student', 'wpeter5@hc360.com', '340 829 7991', 'this is a test'),
('B063045145', sha2('B063045145', 256), 'Bond', 'student', 'bcade6@unblog.fr', '930 534 2678', 'Yo, whats up!'),
('B063106548', sha2('B063106548', 256), 'Veronica', 'student', 'vlangsdon7@imgur.com', null, null),
('B063105910', sha2('B063105910', 256), 'Pekora', 'student', 'dchanson8@nydailynews.com', null, null),
('B063109107', sha2('B063109107', 256), 'Godfrey', 'student', 'ggummery9@addtoany.com', null, "this\n
is\n
a\n
multiline\n
introduction."),
('B063040032', sha2('B063040032', 256), 'Timmy', 'student', 'yles.94214@gmail.com', '0963910112', 'hi, my name is timmy'),
('B063100018', sha2('B063100018', 256), 'Betty', 'student', 'wuyushuan21216@gmail.com', '0905391523', 'hello there, its betty');

/*professor*/
insert into UserInfo
values
('P001', sha2('P001', 256), '鄺獻榮', 'professor', 'srkuang@cse.nsysu.edu.tw', null, null),
('P002', sha2('P002', 256), '蔡崇煒', 'professor', 'cwtsai0807@gmail.com', null, null),
('P003', sha2('P003', 256), '羅文增', 'professor', 'lowen@faculty.nsysu.edu.tw', null, null),
('P004', sha2('P004', 256), '宋克義', 'professor', 'keryea@mail.nsysu.edu.tw', null, null),
('P005', sha2('P005', 256), '王友群', 'professor', 'ycwang@cse.nsysu.edu.tw', null, null),
('P006', sha2('P006', 256), '楊惠芳', 'professor', 'hfyang@mis.nsysu.edu.tw', null, null),
('P007', sha2('P007', 256), '范俊逸', 'professor', 'cifan@mail.cse.nsysu.edu.tw', null, null),
('P008', sha2('P008', 256), '吳亦昕', 'professor', 'wuyishin@mail.nsysu.edu.tw', null, null),
('P009', sha2('P009', 256), '郭瑞坤', 'professor', 'jkkuo@cm.nsysu.edu.tw', null, null),
('P010', sha2('P010', 256), '徐瑞壕', 'professor', 'rhhsu@cse.nsysu.edu.tw', null, null),
('P011', sha2('P011', 256), '李淑敏', 'professor', 'smli@cse.nsysu.edu.tw', null, null),
('P012', sha2('P012', 256), '賴威光', 'professor', 'wklai@cse.nsysu.edu.tw', null, null),
('P013', sha2('P013', 256), '張玉盈', 'professor', 'changyi@mail.cse.nsysu.edu.tw', null, null);

/*admin*/
insert into UserInfo
values
('Admin111', sha2('yles94214', 256), 'Admin111', 'Admin', 'yles.94214@gmail.com', null, 'If you got some suggestion, please contact me.');

/*special case*/
insert into UserInfo
values
('B123456789', sha2('B12345679', 256), 'PersonWithNoFeedback', 'student', 'youbadbad@gmail.com', null, null);
insert into UserInfo
values
('B987654321', sha2('B987654321', 256), 'FreshMan', 'student', 'freshman@gmail.com', null, null);
