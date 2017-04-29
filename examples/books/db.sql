create table publisher (
	PUBLISHER_ID	INTEGER			NOT NULL,
	Name			VARCHAR(255)	NOT NULL check(name <> ''),
	PRIMARY KEY(PUBLISHER_ID)
);

create table book (
	BOOK_ID			INTEGER			NOT NULL,
	Title			VARCHAR(255)	NOT NULL check(Title <> ''),
	Subtitle		VARCHAR(255),
	PUBLISHER_ID	INTEGER			NOT NULL,
	PRIMARY KEY(BOOK_ID),
	FOREIGN KEY(PUBLISHER_ID) references publisher(PUBLISHER_ID) on update cascade on delete restrict 
);

insert into publisher values (1, 'Addison Wesley');
insert into publisher values (2, 'Prentice Hall');
insert into publisher values (3, 'Wiley');
insert into publisher values (4, 'O''Reilly');

insert into book values (1, 'Component Software', 'Beyond Object-Oriented Programming', 1);
insert into book values (2, 'Design Patterns', '', 1);
insert into book values (3, 'Testing Object-Oriented Systems', '', 1);
insert into book values (4, 'Operating Systems', 'Design and Implementation', 2);
insert into book values (5, 'Introduction to Java Programming', '', 2);
insert into book values (6, 'Modern Compiler Design', '', 3);
insert into book values (7, 'Software Architecture', 'Foundations, Theory, and Practice', 3);
insert into book values (8, 'Reversing', 'Secrets of Reverse Engineering', 3);
insert into book values (9, 'Games & Diversion & Perl Culture', '', 4);
