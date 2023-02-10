<?php
    require "connect.php";

    //get the posted data
    $postdata = file_get_contents("php://input");
    if(isset($postdata) && !empty($postdata)){
        // Extract the data
        $request = json_decode($postdata);
        if(trim($request->data->fornecedor) === '' || ($request->data->designacao) === '' || ($request->data->fabricante) === '' || (int)$request->data->numRef < 1 || ($request->data->lote) < 1 || ($request->data->testeEmbal) < 1 || ($request->data->apres) === '' || ($request->data->precoEuro) < 1 || ($request->data->precoEscudo) < 1) {
            // client error response
            return http_response_code(400);
        }

        // sanitize the datas posted
        $fornecedor = mysqli_real_escape_string($con, trim($request->data->model));
        $designacao = mysqli_real_escape_string($con, trim($request->data->designacao));
        $fabricante = mysqli_real_escape_string($con, trim($request->data->fabricante));
        $numRef = mysqli_real_escape_string($con, trim($request->data->numRef));
        $testeEmbal = mysqli_real_escape_string($con, trim($request->data->testeEmbal));
        $apres = mysqli_real_escape_string($con, trim($request->data->apres));
        $precoEuro = mysqli_real_escape_string($con, trim($request->data->precoEuro));
        $precoEscudo = mysqli_real_escape_string($con, trim($request->data->precoEscudo));

        $sql = "INSERT INTO `products`(`fornecedor`, `designacao`, `fabricante`, `numRef`, `lote`, `testEmbal`, `apres`, `precoEuro`, `precoescudo`) VALUES ( '{$fornecedor}', '{$designacao}', '{$fabricante}', '{$numRef}', '{$lote}', '{$testeEmbal}', '{$apres}', '{$precoEuro}', '{$precoEscudo}')";
        if(mysqli_query($con, $sql)) {
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
?>