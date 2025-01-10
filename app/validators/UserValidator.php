<?php
require_once(__DIR__ . '/../controllers/AbstractValidator.php');

class UserValidator extends AbstractValidator {
    public function validate($data) {
        // Validate name
        if (isset($data['name'])) {
            $this->validateRequired($data['name'], 'Name');
            if (!preg_match("/^[a-zA-Z ]*$/", $data['name'])) {
                $this->errors[] = "Name can only contain letters and spaces";
            }
        }

        // Validate email
        if (isset($data['email'])) {
            $this->validateRequired($data['email'], 'Email');
            $this->validateEmail($data['email']);
        }

        // Validate role if present
        if (isset($data['role'])) {
            $this->validateRequired($data['role'], 'Role');
            $this->validateInArray($data['role'], 'Role', ['user', 'admin']);
        }

        // Validate profile picture URL if present
        if (!empty($data['profile_pic'])) {
            $this->validateUrl($data['profile_pic'], 'Profile picture');
        }

        return !$this->hasErrors();
    }
} 