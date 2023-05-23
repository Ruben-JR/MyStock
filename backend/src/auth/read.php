<?php
    require "connect.php"
    
    $utilizador = [];
    $sql = "SELECT * FROM utilizador";
    if($result = mysqli_query($con, $sql)) {
        $pt = 0;
        while($row = mysqli_fetch_array($result)) {
            $utilizador[$pt]["id"]          = $row["id"];
            $utilizador[$pt]["username"]    = $row["username"];
            $utilizador[$pt]["email"]       = $row["email"];
            $utilizador[$pt]["password"]    = $row["password"];
            $utilizador[$pt]["phone"]       = $row["phone"];
            $pt++;
        }
        echo json_encode(["data" => $utilizador])
    }
    else {
        http_response_code(404);
    }
?>