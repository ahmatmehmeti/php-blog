<?php

class Seeders extends Database
{
    /**
     * Insert data to specific tables.
     */
    public function allseders()
    {
        $password = password_hash(123456, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("Admin", "admin@admin.com", :password, "admin", 1, current_timestamp , :hash )');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();


        $password = password_hash(123456, PASSWORD_DEFAULT);
        $hash = md5( rand(0,1000) );
        $this->query('INSERT INTO users (name, email, password, role, active, created_at, hash) VALUES ("User", "user@user.com", :password, "user", 1, current_timestamp , :hash)');
        $this->bind(':password',$password);
        $this->bind(':hash',$hash);
        $this->execute();

        $this->query('INSERT INTO categories(name) VALUES ("Category One")');
        $this->execute();

        $this->query('INSERT INTO tags (name) VALUES ("Tag One")');
        $this->execute();
    }
}