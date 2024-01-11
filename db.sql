CREATE TABLE product (
     id INT NOT NULL AUTO_INCREMENT,
     name VARCHAR(128) NOT NULL,
     description TEXT NULL DEFAULT NULL,
     PRIMARY KEY (id)
);

CREATE USER 'ominas_dbuser'@'localhost' IDENTIFIED BY 'secret';

GRANT ALL PRIVILEGES ON ominas.* TO 'ominas_dbuser'@'localhost';

INSERT INTO product (name, description)
VALUES ('Product One', 'This is product one'),
       ('Second Product', 'A second product here'),
       ('Product #3', ''),
       ('The 4th One', 'Some <b>HTML</b> in the description');
