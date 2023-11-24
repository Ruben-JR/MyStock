<?php
    namespace User\Table;

    class UserTable {
        private $conn;

        public function __construct() {
            $this->conn = require __DIR__ . '/../app/config/dbConnect.php';
        }

        public function createUserTable() {
            $sql = "CREATE TABLE produtos (
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
                    )default charset = utf8";

            if($this->conn->query($sql) == TRUE) {
                echo "Table created sucessfully";
            }
            else{
                echo "Error creating table: " . $this->conn->error;
            }

            $this->conn->close();
        }
    }
?>
