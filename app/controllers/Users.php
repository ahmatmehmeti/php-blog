<?php
    class Users extends Controller
    {
        public function __construct()
        {
            $this->userModel = $this->model('User');
        }

        public function register()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
                    'confirm_password_err' => ''
                ];
                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter email!';
                } else {
                    if ($this->userModel->findUserByEmail($data['email'])) {
                        $data['email_err'] = 'Email is already taken!';
                    }
                }

                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter name!';
                }

                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password!';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters!';
                }

                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please enter confirm password!';
                } elseif (($data['password']) != ($data['confirm_password!'])) {
                    $data['confirm_password_err'] = 'Password do not match!';
                }

                if (empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) &&
                    empty($data['confirm_password_err'])) {

                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $this->userModel->register($data);
                        flash('register_success', 'Please check your email to activate the account!');
                        redirect('users/login');

                } else {
                    $this->view('users/register', $data);
                }

            } else {
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
        }

        public function login()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'remember' => $_POST['remember'],
                    'email_err' => '',
                    'password_err' => '',
                ];


                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter email!';
                }

                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password!';
                }

                if ($this->userModel->findUserByEmail($data['email'])) {

                } else {
                    $data['email_err'] = 'No user found';
                }

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

                if (empty($data['email_err']) && empty($data['password_err'])) {
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                    if ($loggedInUser) {
                        $this->createUserSession($loggedInUser);
                    } else {
                        $data['password_err'] = 'Password incorrect';
                    }
                    $this->view('users/login', $data);
                } else {
                    $this->view('users/login', $data);
                }
            } else {
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];

                $this->view('users/login', $data);
            }
        }

        public function createUserSession($user)
        {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_email'] = $user->email;
            $_SESSION['user_password'] = $user->password;
            $_SESSION['user_role'] = $user->role;
            redirect('posts');
        }

        public function logout()
        {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_password']);
            unset($_SESSION['user_role']);
            session_destroy();

            redirect('users/login');
        }

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

        public function send_link()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'email' => $_POST['email'],
                    'email_err' => ''
                ];

                if (empty($data['email'])) {
                    $data['email_err'] = 'Please enter email!';
                }
                if (empty($data['email_err'])) {
                    $this->userModel->send_link($data);
                    flash('send_link_message', 'Please check your email to reset the password!');
                }else{
                    $this->view('users/send_link', $data);
                }

            }else{
                $data = [
                    'email' => '',
                    'email_err'=>''
                ];
                $this->view('users/send_link', $data);
            }
        }

        public function reset_pass()
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = [
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'confirm_password' => $_POST['confirm_password']
                ];

                if (empty($data['password'])) {
                    $data['password_err'] = 'Please enter password!';
                } elseif (strlen($data['password']) < 6) {
                    $data['password_err'] = 'Password must be at least 6 characters!';
                }

                if (empty($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Please enter confirm password!';
                } elseif (($data['password']) != ($data['confirm_password'])) {
                    $data['confirm_password_err'] = 'Password do not match!';
                }

                if (empty($data['password_err']) && empty($data['confirm_password_err'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                    $this->userModel->reset_pass($data);
                    flash('reset_pass_message', 'Your Password have been changed,Please log in!');
                    redirect('users/login');
                }else{
                    $this->view('users/reset_pass' ,$data);
                }

            }else{
                $data = [
                    'email' => '',
                    'password' => '',
                    'confirm_password'=> ''
                    ];

                $this->view('users/reset_pass' ,$data);
            }
        }

    }