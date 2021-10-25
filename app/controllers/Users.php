<?php
require_once '../app/requests/UserRequest.php';
    class Users extends Controller
    {
        /**
         * Loads user model and requests for validation.
         */
        public function __construct()
        {
            $this->userModel = $this->model('User');
            $this->userRequest = new UserRequest();
        }

        /**
         * Loads the register form.
         */
        public function register()
        {
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err'
            ];
            $this->view('users/register', $data);
        }

        /**
         * Validate the inputs,make sure there are no errors and creates the
         * user.Redirects to the login page with the flash message.
         */
        public function registerUser()
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'created_at' => date('Y-m-d H:i:s'),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'errors' => []
            ];

            $data = $this->userRequest->RegisterValidationFrom($data);

            if (!empty($data['errors'])) {
                $this->view('users/register', $data);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->userModel->register($data);
                flash('register_success', 'Please check your email to activate the account!');
                redirect('users/login');
            }
        }

        /**
         * Loads the login form.
         */
        public function login()
        {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            $this->view('users/login', $data);
        }

        /**
         * Validate the inputs,make sure there are no errors and login the
         * user.Creates the session for this user.
         */
        public function loginUser()
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'remember' => isset($_POST['remember']) ? $_POST['remember'] : "",
                'email_err' => '',
                'password_err' => '',
            ];

            if (!empty($_POST["remember"])) {
                setcookie("email", $_POST["email"], time() + (10 * 365 * 24 * 60 * 60));
                setcookie("password", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
            } else {
                if (isset($_COOKIE["email"])) {
                    setcookie("email", "");
                }
                if (isset($_COOKIE['password'])) {
                    setcookie("password", "");
                }
            }

            $data = $this->userRequest->LoginValidationFrom($data);


            if (empty($data['email_err']) && empty($data['password_err'])){
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    if(!($this->userModel->verified($data['email']))){
                        flash('login_err_message','Your account is not verified!');
                    }else{
                        $this->createUserSession($loggedInUser);
                    }
                } else {
                    $data['password_err'] = 'Password incorrect';
                }
                $this->view('users/login', $data);
            } else {
                $this->view('users/login', $data);
            }
        }

        /**
         * @param $user
         * Creates session for the user.
         */
        public function createUserSession($user)
        {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_password'] = $user->password;
            $_SESSION['user_role'] = $user->role;
            redirect('home/index');
        }

        /**
         * Logout
         */
        public function logout()
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_name']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_password']);
            unset($_SESSION['user_role']);
            session_destroy();

            redirect('users/login');
        }

        /**
         * Calls the method form model to verify.
         * After the registration,user must verify
         * the account to his email.
         */
        public function verify()
        {
            $this->userModel->verify();
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => '',
            ];
            flash('register_success', 'Your account have been activated!');
             $this->view('users/login', $data);
        }

        /**
         *
         * Loads the send-link form to send email.
         */
        public function send_link_form()
        {
            $data = [
                'email' => '',
                'email_err'=>''
            ];
            $this->view('users/send_link', $data);
        }

        /**
         * Validation for input.
         * Sends email to user for resetting password.
         */
        public function send_link()
        {
            $data = [
                'email' => $_POST['email'],
                'email_err' => '',
            ];

            $data = $this->userRequest->SendLinkValidationFrom($data);

            if (!empty($data['email_err'])) {
                $this->view('users/send_link', $data);
            }else{
                $this->userModel->send_link($data);
                flash('send_link_message', 'Please check your email to reset the password!');
                $this->view('users/send_link',$data);
            }
        }

        /**
         * Loads the form for resetting password.
         */
        public function reset_pass_form()
        {
            $data = [
                'email' => '',
                'password' => '',
                'confirm_password'=> ''
            ];

            $this->view('users/reset_pass' ,$data);
        }

        /**
         * Validation for inputs.
         * Resets the password.
         */
        public function reset_pass()
        {
            $data = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'confirm_password' => $_POST['confirm_password'],
                'errors' =>[]
            ];

            $data = $this->userRequest->ResetPassValidationFrom($data);

            if (!empty($data['errors'])) {
                $this->view('users/reset_pass' ,$data);
            }else{
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                $this->userModel->reset_pass($data);
                flash('reset_pass_message', 'Your Password have been changed,Please log in!');
                redirect('users/login');
            }
        }

    }