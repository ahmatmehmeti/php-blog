<?php
class User{
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function register($data){
        $hash = md5(rand(0,1000));
        $this->db->query('INSERT INTO users(name,email,password,hash,created_at) VALUES (:name,:email,:password,:hash,:created_at)');
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':password',$data['password']);
        $this->db->bind(':hash',$hash);
        $this->db->bind(':created_at',$data['created_at']);

        if($this->db->execute()){
            $to      = $data['email'];
            $subject = 'Confirmation for your email';
            $message = "Confirm your Email by clicking this link,
               http://localhost/php-blog/users/verify?hash=$hash
            ";
            $headers = 'From: ahmat.mehmeti97@gmail.com';
            mail($to, $subject, $message, $headers);
        }else{
            return false;
        }
    }

    public function login($email,$password){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email',$email);
        $row = $this->db->single();

        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
            return $row;
        }else{
            return false;
        }
    }

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

    public  function verify()
    {
        $this->db->query('SELECT * FROM users WHERE active = :active and hash = :hash');
        $this->db->bind(':active', 0);
        $this->db->bind(':hash', $_GET['hash']);
        $user = $this->db->single();

        $this->db->query('UPDATE users SET active = :active WHERE hash = :hash');
        $this->db->bind(':active',1);
        $this->db->bind(':hash', $user->hash);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function send_link($data)
    {
        $email = md5($data['email']);
        $to      = $data['email'];
        $subject = 'Confirmation for resetting password';
        $message = "Reset your Password by clicking this link,
               http://localhost/php-blog/users/reset_pass_form?email=$email
            ";
        $headers = 'From: ahmat.mehmeti97@gmail.com';
        mail($to, $subject, $message, $headers);
    }

    public function reset_pass($data)
    {
        $this->db->query('SELECT * FROM users WHERE md5(email) = :email');
        $this->db->bind(':email', $data['email']);
        $user = $this->db->single();

        if($this->db->rowCount() > 0){
            $this->db->query('UPDATE users SET password = :password WHERE email = :email');
            $this->db->bind(':email',$user->email);
            $this->db->bind(':password', $data['password']);

            $this->db->execute();
        } else {
            return false;
        }
    }

    public function getUsers()
    {
        $this->db->query('SELECT * FROM users');
        $results = $this->db->resultSet();

        return $results;
    }
}