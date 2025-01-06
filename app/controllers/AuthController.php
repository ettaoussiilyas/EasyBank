<?php

    // require_once '../core/BaseController.php';

    class AuthController extends BaseController {



        public function showHome(){
            if($_SERVER['REQUEST_URI'] !== '/home'){
                header('Location: /home');
                exit;
            }
            $this->render('Home');
        }

    }



?>