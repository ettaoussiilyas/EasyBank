<?php
require_once(__DIR__ . '/../controllers/AbstractValidator.php');

class AccountValidator extends AbstractValidator {
    public function validate($data) {

        if (isset($data['account_id'])) {
            $this->validateRequired($data['account_id'], 'Account ID');
            $this->validateNumeric($data['account_id'], 'Account ID');
        }

        if (isset($data['user_id'])) {
            $this->validateRequired($data['user_id'], 'User ID');
            $this->validateNumeric($data['user_id'], 'User ID');
        }

        if (isset($data['account_type'])) {
            $this->validateRequired($data['account_type'], 'Account type');
            $this->validateInArray($data['account_type'], 'Account type', ['courant', 'epargne']);
        }


        if (isset($data['status'])) {
            $this->validateRequired($data['status'], 'Status');
            $this->validateInArray($data['status'], 'Status', ['active', 'inactive']);
        }

        return !$this->hasErrors();
    }
} 