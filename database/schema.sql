CREATE TABLE tasks (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  description VARCHAR(200) NOT NULL,
  done TINYINT(1) DEFAULT 0,
  PRIMARY KEY (id)
)
ENGINE=InnoDB;

INSERT INTO tasks (description, done) VALUES ('Learn REST', false);