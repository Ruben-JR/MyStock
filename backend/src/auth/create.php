<?php
    require "connect.php";

    //get posted data
    $postdata = file_get_contents("php://input");
    if(isset($postdata) && !empty($postdata)){
        //extract the data
        $request = json_decode($postdata);
        if(trim($request->data->username) === '' || trim($request->data->email) === '' || trim($request->data->password) === '' || (int)$request->data->phone < 1) {
            return http_response_code(400);
        }

        $username = mysqli_real_escape_string($con, trim($request->data->username));
        $email = mysqli_real_escape_string($con, trim($request->data->email));
        $password = mysqli_real_escape_string($con, trim($request->data->password));
        $phone = mysqli_real_escape_string($con, (int)$request->data->phone < 1);

        $sql = "INSERT INTO `utilizador` (`username`, `email`, `password`, `phone`) values ('{$username}', '{$email}', '{$password}', '{$phone}')";
        if(mysqli_query($con, $sql)) {
            $utilizador = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'phone' => $phone
            ];
            echo json_encode(['data' => $utilizador]);
        }
        else {
            http_response_code(422);
        }
    }
?>