<?php

class Seeders extends Database
{
    public function allseders()
    {
        $password = password_hash(123456, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("Admin", "admin@admin.com", :password, "admin", 1, CURRENT_TIME , :hash )');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();


        $password = password_hash(12345678, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("User", "user@user.com", :password, "user", 1, CURRENT_TIME , :hash)');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();

        $this->query('INSERT INTO categories(name, created_at) VALUES ("Category One",CURRENT_TIME)');
        $this->execute();

        $this->query('INSERT INTO tags (name, created_at) VALUES ("Tag One",CURRENT_TIME )');
        $this->execute();
    }
}