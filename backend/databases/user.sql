DROP TABLE IF EXISTS utilizador;

CREATE TABLE utilizador (
    id int(11) NOT NULL auto_increment,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    phone int(11),
    PRIMARY KEY (id)
)default charset = utf8;