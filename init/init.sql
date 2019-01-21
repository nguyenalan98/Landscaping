/* TODO: create tables */
CREATE TABLE `users`(
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `username` TEXT NOT NULL UNIQUE,
  `password` TEXT NOT NULL,
  `session` TEXT UNIQUE
);

INSERT INTO users (username, password) VALUES ('michael', '$2y$10$ZMXHTWvirnmeGBvPjHuQGeEyS0MrxDzXZgLFiWbFS.7MiFH95xms2');
INSERT INTO users (username, password) VALUES ('jackson', '$2y$10$uxhiMfio/G8TWxcFa8YFQe7N1K.Rg1L5b/KX9PlJbetqsRR.7Q2MC');
/*
michael: Mypassword1
jackson: pajamahunt1
*/

CREATE TABLE prices(
  'id' INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  'name' TEXT NOT NULL UNIQUE,
  'price' FLOAT NOT NULL
);

INSERT INTO prices (name, price) VALUES ('marigoldpr', 5);
INSERT INTO prices (name, price) VALUES ('mondograsspr', 23);
INSERT INTO prices (name, price) VALUES ('geraniumpr', 9);
INSERT INTO prices (name, price) VALUES ('moccapr', 15);
INSERT INTO prices (name, price) VALUES ('shrubspr', 30);
INSERT INTO prices (name, price) VALUES ('treespr', 85);
INSERT INTO prices (name, price) VALUES ('mulchpr', 0.20);
INSERT INTO prices (name, price) VALUES ('weedingpr', 0.03);
INSERT INTO prices (name, price) VALUES ('lawnmowingpr', 0.0375);

CREATE TABLE projects(
  id INTEGER UNIQUE  NOT NULL PRIMARY KEY AUTOINCREMENT,
  image_name text NOT NULL,
  image_ext  text NOT NULL,
  project_name text UNIQUE,
  details text,
  date_up text
);

CREATE TABLE tags(
  tag_id INTEGER UNIQUE NOT NULL PRIMARY KEY AUTOINCREMENT,
  tag TEXT NOT NULL UNIQUE
);

INSERT INTO tags (tag) VALUES ('Flower Bed');
INSERT INTO tags (tag) VALUES ('Tree Base');
INSERT INTO tags (tag) VALUES ('Lawn Care');
INSERT INTO tags (tag) VALUES ('Shrubs');
INSERT INTO tags (tag) VALUES ('Fountain');

CREATE TABLE projects_tags(
  id INTEGER UNIQUE NOT NULL PRIMARY KEY AUTOINCREMENT,
  project_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL
);

INSERT INTO projects_tags (project_id, tag_id) VALUES (2,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (3,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (4,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (5,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (7,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (10,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (11,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (12,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (13,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (15,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (19,1);
INSERT INTO projects_tags (project_id, tag_id) VALUES (23,1);

INSERT INTO projects_tags (project_id, tag_id) VALUES (7,2);
INSERT INTO projects_tags (project_id, tag_id) VALUES (10,2);
INSERT INTO projects_tags (project_id, tag_id) VALUES (12,2);
INSERT INTO projects_tags (project_id, tag_id) VALUES (14,2);
INSERT INTO projects_tags (project_id, tag_id) VALUES (15,2);

INSERT INTO projects_tags (project_id, tag_id) VALUES (18,3);
INSERT INTO projects_tags (project_id, tag_id) VALUES (21,3);
INSERT INTO projects_tags (project_id, tag_id) VALUES (22,3);

INSERT INTO projects_tags (project_id, tag_id) VALUES (3,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (5,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (6,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (8,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (9,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (11,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (13,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (16,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (17,4);
INSERT INTO projects_tags (project_id, tag_id) VALUES (20,4);

INSERT INTO projects_tags (project_id, tag_id) VALUES (23,5);

/* TODO: initial seed data */
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('1.JPG','JPG', 'Project 1');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('2.JPG','JPG', 'Project 2');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('3.JPG','JPG', 'Project 3');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('4.JPG','JPG', 'Project 4');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('5.JPG','JPG', 'Project 5');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('6.JPG','JPG', 'Project 6');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('7.JPG','JPG', 'Project 7');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('8.JPG','JPG', 'Project 8');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('9.JPG','JPG', 'Project 9');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('10.JPG','JPG', 'Project 10');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('11.JPG','JPG', 'Project 11');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('12.JPG','JPG', 'Project 12');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('13.JPG','JPG', 'Project 13');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('14.JPG','JPG', 'Project 14');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('15.JPG','JPG', 'Project 15');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('16.JPG','JPG', 'Project 16');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('17.JPG','JPG', 'Project 17');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('18.JPG','JPG', 'Project 18');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('19.JPG','JPG', 'Project 19');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('20.JPG','JPG', 'Project 20');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('21.JPG','JPG', 'Project 21');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('22.JPG','JPG', 'Project 22');
INSERT INTO projects (image_name,image_ext, project_name) VALUES ('23.JPG','JPG', 'Project 23');
