<?php
    $db_host = getenv('DB_HOST');
    $db_user = getenv('DB_USERNAME');
    $db_password = getenv('DB_PASSWORD');
    $db_name = getenv('DB_NAME');

    $con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if(!$con) {
        echo "Connection failed" . mysqli_connect_error();
    }
?>