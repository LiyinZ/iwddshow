-- USE gc200298955;
DROP TABLE php_a1_users;

CREATE TABLE php_a1_users (
	id INT NOT NULL AUTO_INCREMENT,
	last_name VARCHAR(50) NOT NULL,
	first_name VARCHAR(50) NOT NULL,
	student_num CHAR(9) NOT NULL,
	url VARCHAR(512),
	created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	last_logged TIMESTAMP,
	PRIMARY KEY (id)
);
-- Example
INSERT INTO php_a1_users (last_name, first_name, student_num) VALUES ('Doe', 'John', '123456789');
