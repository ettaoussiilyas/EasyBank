<?php

    // require_once '../core/BaseController.php';

    require_once '../app/models/User.php';

    class AuthController extends BaseController {

        private $userModel;

        public function __construct(){
            $this->userModel = new User();
        }

        public function showHome(){
            if($_SERVER['REQUEST_URI'] !== '/home'){
                header('Location: /home');
                exit;
            }
            $this->render('Home');
        }

        //shoing login page
        public function showLogin(){
            // $this->render('auth/login', ['error' => 'Invalid password']);
            $this->render('auth/login');
        }

        //showing register page
        public function showRegister(){
            $this->render('auth/register');
        }

        public function loginChecker(){
            if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])){
                $email = $_POST['email'];
                $password = $_POST['password'];

                if(empty($email) || empty($password)){
                    return $this->render('auth/login', ['emptyError' => 'Please fill all fields']);
                }

                $user = $this->userModel->getUserByEmail($email);

                if(!$user){
                    return $this->render('auth/login', ['notFoundError' => 'User not found']);
                }

                // if(!password_verify($password, $user['password'])){
                if($password !== $user['password']){
                    $this->render('auth/login', ['invalidPasswordError' => 'Invalid password']);
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['profile_pic'] = $user['profile_pic'];
                header('Location: /home');
                exit;
            }
            
            $this->render('auth/login');
        }

        public function registerChecker(){
            $this->render('auth/register');
        }

    }



?>