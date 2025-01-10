<?php

class UserValidator {
    private $errors = [];

    public function validate($data) {
        $this->errors = [];

        // Validate name
        if (empty($data['name'])) {
            $this->errors[] = "Name is required";
        } elseif (!preg_match("/^[a-zA-Z ]*$/", $data['name'])) {
            $this->errors[] = "Name can only contain letters and spaces";
        }

        // Validate email
        if (empty($data['email'])) {
            $this->errors[] = "Email is required";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid email format";
        }

        // Validate role if present
        if (isset($data['role']) && !in_array($data['role'], ['user', 'admin'])) {
            $this->errors[] = "Invalid role specified";
        }

        // Validate profile picture URL if present
        if (!empty($data['profile_pic']) && !filter_var($data['profile_pic'], FILTER_VALIDATE_URL)) {
            $this->errors[] = "Invalid profile picture URL";
        }

        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }
} 