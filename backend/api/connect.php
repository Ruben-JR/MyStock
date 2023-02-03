<?php
    
    $db_url = "";
    $db_user = "";
    $db_password = "";
    $db_name = "";

    $con = mysqli_connect($db_url, $db_user, $db_password, $db_name);
    if (!$con) {
        echo "Connction failed" .mysqli_connect_error();
    }
?>