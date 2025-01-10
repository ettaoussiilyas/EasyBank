<?php

abstract class AbstractValidator {
    protected $errors = [];

    abstract public function validate($data);

    protected function validateRequired($value, $fieldName) {
        if (empty($value)) {
            $this->errors[] = "$fieldName is required";
            return false;
        }
        return true;
    }

    protected function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Invalid email format";
            return false;
        }
        return true;
    }

    protected function validateLength($value, $fieldName, $min, $max) {
        $length = strlen($value);
        if ($length < $min || $length > $max) {
            $this->errors[] = "$fieldName must be between $min and $max characters";
            return false;
        }
        return true;
    }

    protected function validateNumeric($value, $fieldName) {
        if (!is_numeric($value)) {
            $this->errors[] = "$fieldName must be a number";
            return false;
        }
        return true;
    }

    protected function validateInArray($value, $fieldName, $allowedValues) {
        if (!in_array($value, $allowedValues)) {
            $this->errors[] = "$fieldName must be one of: " . implode(', ', $allowedValues);
            return false;
        }
        return true;
    }

    protected function validateUrl($value, $fieldName) {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $this->errors[] = "$fieldName must be a valid URL";
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
} 