<?php
    require 'connect.php';

    //Get posted data
    $postdata = file_get_contents("php://input");
    if(isset($postdata) && !empty($postdata)){
        //Extract the data
        $request = json_decode($postdata);
        if(trim($request->data->fornecedor) === '' || trim($request->data->designacao) === '' || trim($request->data->fabricante) === '' || (int)$request->data->numRef < 1 || (int)$request->data->lote < 1 || (int)$request->data->testeEmbal < 1 || trim($request->data->apres) === '' || (int)$request->data->precoEuro < 1 || (int)$request->data->precoEscudo < 1) {
            // client error response
            return http_response_code(400);
        }

        // sanitize the datas posted
        $fornecedor = mysqli_real_escape_string($con, trim($request->data->fornecedor));
        $designacao = mysqli_real_escape_string($con, trim($request->data->designacao));
        $fabricante = mysqli_real_escape_string($con, trim($request->data->fabricante));
        $numRef = mysqli_real_escape_string($con, (int)$request->data->numRef);
        $testeEmbal = mysqli_real_escape_string($con, trim($request->data->testeEmbal));
        $apres = mysqli_real_escape_string($con, trim($request->data->apres));
        $precoEuro = mysqli_real_escape_string($con, (int)$request->data->precoEuro);
        $precoEscudo = mysqli_real_escape_string($con, (int)$request->data->precoEscudo);

        $sql = "UPDATE `products` SET `fornecedor` = `$fornecedor`, `designacao` = `$designacao`, `fabricante` = `$fabricante`, `numRef` = `$numRef`, `lote` = `$lote`, `testEmbal` = `$testEmbal`, `apres` = `$apres`, `precoEuro` = `$precoEuro`, `precoEscudo ` = `$precoEscudo `";
        if(mysqli_query($con, $sql)) {
            http_response_code(204);
        }
        else {
            return http_response_code(422);
        }
    }
?>