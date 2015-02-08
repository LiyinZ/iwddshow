-- USE gc200298955;
CREATE TABLE php_a1_projects (
	id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(255) NOT NULL,
	description TEXT,
	user_id INT NOT NULL,
	url VARCHAR(512) NOT NULL,
	view_count INT DEFAULT 0,
	last_view TIMESTAMP,
	created_at TIMESTAMP,
	PRIMARY KEY (id)
);

ALTER TABLE php_a1_projects ADD likes INT DEFAULT 0 AFTER view_count;

-- Test 
INSERT INTO php_a1_projects (name, description, user_id, url) VALUES ('Pure css', 'yahoo', 1, 'http://www.yahoo.ca');
INSERT INTO php_a1_projects (name, description, user_id, url) VALUES ('javascript', 'testing', 24, 'http://www.georgiancollege.ca');
INSERT INTO php_a1_projects (name, description, user_id, url) VALUES ('Github', 'is cool', 23, 'https://uwaterloo.ca/');
INSERT INTO php_a1_projects (name, description, user_id, url) VALUES ('Amazon', 'what are you buying?', 1, 'http://www.amazon.ca');