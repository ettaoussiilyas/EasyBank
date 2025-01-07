<?php

    // require_once '../core/BaseController.php';

    require_once '../app/models/User.php';

    class UserController extends BaseController {

        private $userModel;

        public function __construct(){
            $this->userModel = new User();
        }

        //update user

        public function updateUser(){

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $picture = $_POST['picture'];

            if(empty($name) || empty($email) || empty($password) || empty($picture)){
                return $this->renderClient('profile',['emptyFieldsUpdate'=>'Please fill all fields']);
            }
            $password = password_hash($password, DEFAULT_PASSWORD);
            $data = [
                'id' => $_SESSION['user_id'],
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'picture' => $picture
            ];
            $result =  $this->userModel->updateUser($data);
            if($result){
                $this->renderClient('profile',['successUpdate'=>'User updated successfully']);
            } else {
                $this->renderClient('profile',['failedUpdate'=>'User updated Failed']);
            }
            
        }


        public function profile(){
            $email = $_SESSION['user_email'];
            $user = $this->userModel->getUserByEmail($email);
            $this->renderClient('profile' , $user);
        }

        


    }



?>