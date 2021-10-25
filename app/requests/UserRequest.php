<?php
    class UserRequest extends Controller
    {
        /**
         * @param $data
         * @return array
         * Validation for users data.
         */

        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function RegisterValidationFrom($data)
        {
            if($data['name'] == ""){
                $data['errors']['name_err'] = 'Please enter name';
            }

            if (empty($data['email'])) {
                $data['errors']['email_err'] = 'Please enter email!';
            }else {
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['errors']['email_err'] = 'Email is already taken!';
                }
            }

            if($data['password'] == ""){
                $data['errors']['password_err'] = 'Please enter password';
            }

            if(empty($data['confirm_password'])){
                $data['errors']['confirm_password_err'] = 'Please enter confirm password';
            }else{
                if($data['password'] != $data['confirm_password']){
                    $data['errors']['confirm_password_err'] = 'Passwords do not match';
                }
            }
            return $data;
        }

        public function SendLinkValidationFrom($data)
        {
            if($data['email'] == ""){
                $data['email_err'] = 'Please enter email';
            }
            return $data;
        }

        public function ResetPassValidationFrom($data)
        {
            if($data['password'] == ""){
                $data['errors']['password_err'] = 'Please enter password';
            }

            if(empty($data['confirm_password'])){
                $data['errors']['confirm_password_err'] = 'Please enter confirm password';
            }else{
                if($data['password'] != $data['confirm_password']){
                    $data['errors']['confirm_password_err'] = 'Passwords do not match';
                }
            }
            return $data;
        }

        public function LoginValidationFrom($data)
        {
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email!';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password!';
            }

            if(!($this->userModel->findUserByEmail($data['email']))) {
                $data['email_err'] = 'No user found';
            }
            return $data;
        }
    }