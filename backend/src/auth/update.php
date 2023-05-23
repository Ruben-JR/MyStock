<?php
    require "connect.php";

    $postdata = file_get_contents("php://input");
    if(isset($postdata) && !empty($postdata)) {
        $request = json_decode($postdata);
        if(trim($request->data->phone) === '' || trim($request->data->email) === '' || trim($request->data->password) === '' || (int)$request->data->phone < 0) {
            return http_response_code(400);
        }
        
        $username = mysqli_real_escape_string($con, trim($request->data->username));
        $email = mysqli_real_escape_string($con, trim($request->data->email));
        $password = mysqli_real_escape_string($con, trim($request->data->password));
        $phone = mysqli_real_escape_string($con, trim($request->data->phone));

        $sql = "UPDATE `utilizador` SET `username` = `$username`, `email` = `$email`, `password` = `$password`, `phone` = `$phone`";
        if(mysqli_query($con, $sql)) {
            http_response_code(204);
        }
        else {
            return http_response_code(422);
        }
    }
?>