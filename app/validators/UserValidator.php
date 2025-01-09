<?php
require_once(__DIR__ . '/../controllers/AbstractValidator.php');

class UserValidator extends AbstractValidator {
    public function validate($data) {
       
        if (isset($data['user_id'])) {
            $this->validateRequired($data['user_id'], 'User ID');
            $this->validateNumeric($data['user_id'], 'User ID');
        }

        
        if ($this->validateRequired($data['name'] ?? '', 'Name')) {
            $this->validateLength($data['name'], 'Name', 2, 50);
           
            if (!preg_match('/^[a-zA-ZÀ-ÿ\s\'-]+$/', $data['name'])) {
                $this->errors[] = "Name contains invalid characters";
            }
        }

        if ($this->validateRequired($data['email'] ?? '', 'Email')) {
            $this->validateEmail($data['email']);
        }

        if (!empty($data['profile_pic'])) {
            $this->validateUrl($data['profile_pic'], 'Profile picture');
        }

        return !$this->hasErrors();
    }
} 