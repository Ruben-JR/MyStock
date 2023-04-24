<?php
    require 'connect.php';

    //extract validate and sanitize the id
    $id = ($_GET['id'] !== null && (int)$_GET['id'] > 0) ? mysqli_real_escape_string($con, (int)$_GET['id']) : false;
    if(!$id){
        return http_response_code(400);
    }

    $sql = "DELETE FROM `utilizador` WHERE `id` = `{$id}` LIMIT 1";
    if(mysqli_query($CON, $sql)) {
        http_response_code(204);
    }
    esle {
        return http_response_code(422);
    }
?>