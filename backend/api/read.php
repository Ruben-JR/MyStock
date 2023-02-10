<?php
    require "connect.php";

    $products = [];
    $sql = "SELECT * FROM products";
    if($result = mysqli_query($con, $sql)) {
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
