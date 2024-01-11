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
/**
  $dsn = "mysql:host=localhost;dbname=ominas;charset=utf8;port=3306";

$pdo = new PDO($dsn, "ominas_dbuser", "secret", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
 */