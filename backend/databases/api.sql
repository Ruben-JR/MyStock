CREATE TABLE IF EXISTS produtos;

CREATE TABLE produtos (
    id int(11) NOT NULL auto_increment,
    fornecedor VARCHAR(50) NOT NULL,
    designacao VARCHAR(50) NOT NULL,
    fabricantes VARCHAR(50) NOT NULL,
    numRef int(20) NOT NULL,
    lote int(20) NOT NULL,
    testeEmbal int(20) NOT NULL,
    apres VARCHAR(50) NOT NULL,
    precoEuro int(11) NOT NULL,
    precoEscudo int(11) NOT NULL,
    PRIMARY KEY (id)
)default charset = utf8;
