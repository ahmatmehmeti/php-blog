<?php
   class Database
    {
        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $stmt;
        private $dbh;
        private $error;

        public function __construct()
        {
            $dns = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try{
                $this->dbh = new PDO($dns,$this->user,$this->pass, $options);
            }catch(PDOException $e) {
                $this -> error = $e->getMessage();
                echo $this->error;
            }
        }

        public function query($sql)
        {
            $this->stmt = $this->dbh->prepare($sql);
        }
        public function bind($param,$value,$type = null)
        {
            if(is_null($type)){
                switch (true){
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param,$value,$type);
        }

        public function execute()
        {
            return $this->stmt->execute();
        }

        public function resultSet()
        {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }
       public function resultSetAssoc()
       {
           $this->execute();
           return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
       }

        public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        public function rowCount()
        {
            return $this->stmt->rowCount();
        }

       public function migrate()
       {
           $usersQuery="
                DROP TABLE IF EXISTS `users`;
                CREATE TABLE `users`  (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `email` varchar(255) NOT NULL,
                  `password` varchar(255) NOT NULL,
                  `role` enum('user','admin') NOT NULL DEFAULT ('user'),
                  `hash` varchar(32) NOT NULL,
                  `active` tinyint(1) DEFAULT 0,
                  `created_at` datetime ON UPDATE CURRENT_TIMESTAMP(0),
                  PRIMARY KEY (`id`)
                )
           ";

           $this->query($usersQuery);
           $this->execute();


            $categoriesQuery="
                DROP TABLE IF EXISTS `categories`;
                CREATE TABLE `categories`  (
                  `id` int(11) AUTO_INCREMENT,
                  `name` varchar(255)NOT NULL,
                  `created_at` datetime NOT NULL,
                  PRIMARY KEY (`id`)
                )      
            ";

           $this->query($categoriesQuery);
           $this->execute();


           $tagsQuery="
                DROP TABLE IF EXISTS `tags`;
                CREATE TABLE `tags`  (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `created_at` datetime NOT NULL,
                  PRIMARY KEY (`id`) 
                )                   
            ";

           $this->query($tagsQuery);
           $this->execute();


           $articlesQuery="
                DROP TABLE IF EXISTS `articles`;
                CREATE TABLE `articles`  (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `title` varchar(255) NOT NULL,
                  `slug` varchar(255) NOT NULL,
                  `body` varchar(255) NOT NULL,
                  `image` varchar(255) NOT NULL,
                  `user_id` int(11) NOT NULL,
                  `category_id` int(11) NOT NULL,
                  `status` tinyint(1)DEFAULT 0,
                  `position` int(11)DEFAULT 0,
                  `created_at` date NOT NULL,
                  PRIMARY KEY (`id`),
                  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
                )               
            ";

           $this->query($articlesQuery);
           $this->execute();


           $articleTagQuery="
                DROP TABLE IF EXISTS `article_tag`;
                CREATE TABLE `article_tag`  (
                  `article_id` int(11) NOT NULL,
                  `tag_id` int(11) ,
                  CONSTRAINT `article_id` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                  CONSTRAINT `tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
                )       
            ";

           $this->query( $articleTagQuery);
           $this->execute();
       }
    }