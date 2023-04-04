<?php
    $host = "127.0.0.1:3000";
    $db_user = "mylab";
    $db_password = "";
    $db_name = "mystock";

    $con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$con) {
        echo "Connction failed" .mysqli_connect_error();
    }
?>
