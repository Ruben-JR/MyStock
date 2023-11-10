<?php
    use Dotenv\Dotenv;
    // Include composer autoload
    require __DIR__ . '/../vendor/autoload.php';

    //Load environment variables from .env
    $dotenv = Dotenv/Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();

    //access environments variable
    $db_host = $_ENV['DB_HOST'];
    $db_name = $_ENV['DB_NAME'];
    $db_password = $_ENV['DB_PASSWORD'];

    $con = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$con) {
        echo "Connction failed" . mysqli_connect_error();
    }
?>