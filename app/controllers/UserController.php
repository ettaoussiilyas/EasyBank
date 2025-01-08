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

        public function updateProfile(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // First get the current user data
                $email = $_SESSION['user_email'];
                $currentUser = $this->userModel->getUserByEmail($email);
                
                // Create data array with current user info
                $data = $currentUser; // This keeps all current user data
                
                // Now check validation and add error messages if needed
                if(empty($_POST['name']) || empty($_POST['cdn']) || empty($_POST['email']) || empty($_POST['password'])){
                    $data['errorEmptyFields'] = 'Please fill all fields';
                    return $this->renderClient('profile', $data);
                }

                if(strlen($_POST['name']) < 6){
                    $data['errorNameLength'] = 'Name must be at least 6 characters long';
                    return $this->renderClient('profile', $data);
                }

                if(strlen($_POST['password']) < 8){
                    $data['errorPassLength'] = 'Password must be at least 8 characters long';
                    return $this->renderClient('profile', $data);
                }

                $checkEmail = $this->userModel->getUserByEmail($_POST['email']);
                if($checkEmail && $checkEmail['id'] !== $_SESSION['user_id']){
                    $data['errorEmailExists'] = 'Email already exists';
                    return $this->renderClient('profile', $data);
                }
                
                $updateData = [
                    'id' => $_SESSION['user_id'],
                    'name' => $_POST['name'],
                    'picture' => $_POST['cdn'],
                    'email' => $_POST['email'],
                    'password' => $_POST['password']
                ];

                $result = $this->userModel->updateUser($updateData);
                if($result){
                    $data['successProfileUpdate'] = 'Profile updated successfully';
                } else {
                    $data['failedProfileUpdate'] = 'Profile update failed';
                }
                
                return $this->renderClient('profile', $data);
            }
        }

    }



?>