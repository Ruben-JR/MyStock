<?php
    namespace User\Controllers;

    class UserController
    {
        private $conn;

        public function __construct()
        {
            $this->conn = require __DIR__ . '../config/dbConnect.php';
        }

        public function createUser()
        {
            // create user logic goes here
            $postdata = file_get_contents("php://input");
            if(isset($postdata) && !empty($postdata)){
                //extract the data
                $request = json_decode($postdata);
                if(trim($request->data->username) === '' || trim($request->data->email) === '' || trim($request->data->password) === '' || (int)$request->data->phone < 1) {
                    return http_response_code(400);
                }

                $username = mysqli_real_escape_string($this->conn, trim($request->data->username));
                $email = mysqli_real_escape_string($this->conn, trim($request->data->email));
                $password = mysqli_real_escape_string($this->conn, trim($request->data->password));
                $phone = mysqli_real_escape_string($this->conn, (int)$request->data->phone < 1);

                $sql = "INSERT INTO `utilizador` (`username`, `email`, `password`, `phone`) values ('{$username}', '{$email}', '{$password}', '{$phone}')";
                if(mysqli_query($this->conn, $sql)) {
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
        }

        public function readUsers()
        {
            // read users logic goes here
            $utilizador = [];
            $sql = "SELECT * FROM utilizador";
            if($result = mysqli_query($this->conn, $sql)) {
                $pt = 0;
                while($row = mysqli_fetch_array($result)) {
                    $utilizador[$pt]["id"]          = $row["id"];
                    $utilizador[$pt]["username"]    = $row["username"];
                    $utilizador[$pt]["email"]       = $row["email"];
                    $utilizador[$pt]["password"]    = $row["password"];
                    $utilizador[$pt]["phone"]       = $row["phone"];
                    $pt++;
                }
                echo json_encode(["data" => $utilizador]);
            }
            else {
                http_response_code(404);
            }
        }

        public function updateUser()
        {
            // update user logic goes here
            $postdata = file_get_contents("php://input");
            if(isset($postdata) && !empty($postdata)) {
                $request = json_decode($postdata);
                if(trim($request->data->phone) === '' || trim($request->data->email) === '' || trim($request->data->password) === '' || (int)$request->data->phone < 0) {
                    return http_response_code(400);
                }

                $username = mysqli_real_escape_string($this->conn, trim($request->data->username));
                $email = mysqli_real_escape_string($this->conn, trim($request->data->email));
                $password = mysqli_real_escape_string($this->conn, trim($request->data->password));
                $phone = mysqli_real_escape_string($this->conn, trim($request->data->phone));

                $sql = "UPDATE `utilizador` SET `username` = `$username`, `email` = `$email`, `password` = `$password`, `phone` = `$phone`";
                if(mysqli_query($this->conn, $sql)) {
                    http_response_code(204);
                }
                else {
                    return http_response_code(422);
                }
            }
        }

        public function deleteUser($id)
        {
            // delete user logic goes here
            $id = ($_GET['id'] !== null && (int)$_GET['id'] > 0) ? mysqli_real_escape_string($this->conn, (int)$_GET['id']) : false;
            if(!$id){
                return http_response_code(400);
            }

            $sql = "DELETE FROM `utilizador` WHERE `id` = `{$id}` LIMIT 1";
            if(mysqli_query($this->conn, $sql)) {
                http_response_code(204);
            }
            else {
                return http_response_code(422);
            }
        }
    }
?>
