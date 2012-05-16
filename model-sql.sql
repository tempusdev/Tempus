CREATE TABLE activity (id int, name string(255));
INSERT INTO "activity" VALUES(1,'Coding!');

CREATE TABLE invoice (id int, name string(255));

CREATE TABLE work (id int, date date, hours float, description text, activity_id int, project_id int, invoice_id int, user_id int);
INSERT INTO "work" VALUES(1, '2010-05-16', 4, 'This was fun', 1, 1, 1, 1);

CREATE TABLE user (id int, username string(255), password string(128), updated_at datetime, created_at datetime);
INSERT INTO "user" VALUES(1, 'larosee', 'password', '2012-01-01 10:00:00', '2012-01-01 10:00:00' );
INSERT INTO "user" VALUES(2, 'simensen', 'password', '2012-01-01 10:00:00', '2012-01-01 10:00:00' );