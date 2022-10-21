create table todoitem (
	ITEM_ID		INTEGER		NOT NULL,
	Description	VARCHAR(255)	NOT NULL check(Description <> ''),
	PRIMARY KEY(ITEM_ID)
);

insert into todoitem values (1, 'Read a book');
insert into todoitem values (2, 'Listen to music');
insert into todoitem values (3, 'Clean the toilet');
insert into todoitem values (4, 'Organize office');
insert into todoitem values (5, 'Pay the bills');
insert into todoitem values (6, 'Drink coffee');
insert into todoitem values (7, 'Eat cake');
insert into todoitem values (8, 'Go to the gym');
insert into todoitem values (9, 'Rehearse music');
insert into todoitem values (10, 'Send a postcard');
insert into todoitem values (11, 'Refactor codebase');
insert into todoitem values (12, 'Watch TV');
insert into todoitem values (13, 'Walk around the park');
insert into todoitem values (14, 'Learn how to cook');
insert into todoitem values (15, 'Play a game');
insert into todoitem values (16, 'Attend a meeting');
