<?php
    namespace Product\Controllers;

    class ProductController {
        private $conn;

        public function __construct() {
            $this->conn = require __DIR__ . '../config/dbConnect.php';
        }

        public function createProduct() {
            // create product logic goes here
            $postdata = file_get_contents("php://input");
            if(isset($postdata) && !empty($postdata)){
                // Extract the data
                $request = json_decode($postdata);
                if(trim($request->data->fornecedor) === '' || trim($request->data->designacao) === '' || trim($request->data->fabricante) === '' || (int)$request->data->numRef < 1 || (int)$request->data->lote < 1 || (int)$request->data->testeEmbal < 1 || trim($request->data->apres) === '' || (int)$request->data->precoEuro < 1 || (int)$request->data->precoEscudo < 1) {
                    // client error response
                    return http_response_code(400);
                }

                // sanitize the datas posted
                $fornecedor = mysqli_real_escape_string($this->conn, trim($request->data->fornecedor));
                $designacao = mysqli_real_escape_string($this->conn, trim($request->data->designacao));
                $fabricante = mysqli_real_escape_string($this->conn, trim($request->data->fabricante));
                $numRef = mysqli_real_escape_string($this->conn, (int)$request->data->numRef);
                $lote = mysqli_real_escape_string($this->conn, (int)$request->data->lote);
                $testEmbal = mysqli_real_escape_string($this->conn, trim($request->data->testeEmbal));
                $apres = mysqli_real_escape_string($this->conn, trim($request->data->apres));
                $precoEuro = mysqli_real_escape_string($this->conn, (int)$request->data->precoEuro);
                $precoEscudo = mysqli_real_escape_string($this->conn, (int)$request->data->precoEscudo);

                $sql = "INSERT INTO `products`(`fornecedor`, `designacao`, `fabricante`, `numRef`, `lote`, `testEmbal`, `apres`, `precoEuro`, `precoescudo`) VALUES ( '{$fornecedor}', '{$designacao}', '{$fabricante}', '{$numRef}', '{$lote}', '{$testEmbal}', '{$apres}', '{$precoEuro}', '{$precoEscudo}')";
                if(mysqli_query($this->conn, $sql)) {
                    $products = [
                        'fornecedor' => $fornecedor,
                        'designacao' => $designacao,
                        'fabricante' => $fabricante,
                        'numRef' => $numRef,
                        'lote' => $lote,
                        'testEmbal' => $testEmbal,
                        'apres' => $apres,
                        'precoEuro' => $precoEuro,
                        'precoEscudo' => $precoEscudo
                    ];
                    echo json_encode(['data' => $products]);
                }
                else {
                    http_response_code(422);
                }
            }
        }

        public function readProducts() {
            // read products logic goes here
            $products = [];
            $sql = "SELECT * FROM products";
            if($result = mysqli_query($this->conn, $sql)) {
                $pt = 0;
                while($row = mysqli_fetch_array($result)){
                    $products[$pt]["id"]            = $row["id"];
                    $products[$pt]["fonecedor"]     = $row["fonecedor"];
                    $products[$pt]["designacao"]    = $row["designacao"];
                    $products[$pt]["fabricante"]    = $row["fabricante"];
                    $products[$pt]["numRef"]        = $row["numRef"];
                    $products[$pt]["lote"]          = $row["lote"];
                    $products[$pt]["testeEmbal"]    = $row["testeEmbal"];
                    $products[$pt]["apres"]         = $row["apres"];
                    $products[$pt]["precoEuro"]     = $row["precoEuro"];
                    $products[$pt]["precoEscudo"]   = $row["precoEscudo"];
                    $pt++;
                }
                echo json_encode(["data" => $products]);
            }
            else {
                // client error response
                http_response_code(404);
            }
        }

        public function updateProduct() {
            // update product logic goes here
            if(isset($postdata) && !empty($postdata)){
                //Extract the data
                $request = json_decode($postdata);
                if(trim($request->data->fornecedor) === '' || trim($request->data->designacao) === '' || trim($request->data->fabricante) === '' || (int)$request->data->numRef < 1 || (int)$request->data->lote < 1 || (int)$request->data->testeEmbal < 1 || trim($request->data->apres) === '' || (int)$request->data->precoEuro < 1 || (int)$request->data->precoEscudo < 1) {
                    // client error response
                    return http_response_code(400);
                }

                // sanitize the datas posted
                $fornecedor = mysqli_real_escape_string($this->conn, trim($request->data->fornecedor));
                $designacao = mysqli_real_escape_string($this->conn, trim($request->data->designacao));
                $fabricante = mysqli_real_escape_string($this->conn, trim($request->data->fabricante));
                $numRef = mysqli_real_escape_string($this->conn, (int)$request->data->numRef);
                $testEmbal = mysqli_real_escape_string($this->conn, trim($request->data->testeEmbal));
                $lote = mysqli_real_escape_string($this->conn, (int)$request->data->lote);
                $apres = mysqli_real_escape_string($this->conn, trim($request->data->apres));
                $precoEuro = mysqli_real_escape_string($this->conn, (int)$request->data->precoEuro);
                $precoEscudo = mysqli_real_escape_string($this->conn, (int)$request->data->precoEscudo);

                $sql = "UPDATE `products` SET `fornecedor` = `$fornecedor`, `designacao` = `$designacao`, `fabricante` = `$fabricante`, `numRef` = `$numRef`, `lote` = `$lote`, `testEmbal` = `$testEmbal`, `apres` = `$apres`, `precoEuro` = `$precoEuro`, `precoEscudo ` = `$precoEscudo `";
                if(mysqli_query($this->conn, $sql)) {
                    http_response_code(204);
                }
                else {
                    return http_response_code(422);
                }
            }
        }

        public function deleteProduct($id) {
            // delete product logic goes here
            $id = ($_GET['id'] != null && (int)$_GET['id'] > 0) ? mysqli_real_escape_string($this->conn, (int)$_GET['id']) : false;
            if(!$id) {
                return http_response_code(400);
            }

            $sql = "DELETE FROM `products` WHERE `id` = '{$id}' LIMIT 1";
            if(mysqli_query($this->conn, $sql)) {
                http_response_code(204);
            }
            else {
                return http_response_code(422);
            }
        }
    }
?>
