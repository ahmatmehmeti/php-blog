<?php
   class Database extends Controller
    {
       /**
        *  Connects database Using PDO
        *  Creates prepared Statements
        * 	Binds params to values
        *  Returns rows and results
        */

        private $host = DB_HOST;
        private $user = DB_USER;
        private $pass = DB_PASS;
        private $dbname = DB_NAME;

        private $stmt;
        private $dbh;
        private $error;

       /**
        * Set DSN
        * Create a new PDO instance
        * // Catch any errors
        */
       public function __construct()
        {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $options = array(
                PDO::ATTR_PERSISTENT,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );

            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            } catch (Exception $e) {
                if ($e) {
                    $this->view('db/error');
                    die();
                }
            }
        }

       /**
        * @param $sql
        * Prepare statement with query
        */
       public function query($sql)
        {
            $this->stmt = $this->dbh->prepare($sql);
        }

       /**
        * @param $param
        * @param $value
        * @param null $type
        * Bind values
        */
       public function bind($param, $value, $type = null)
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

       /**
        * @return mixed
        * Execute the prepared statement
        */
       public function execute()
        {
            return $this->stmt->execute();
        }

       /**
        * @return mixed
        * Get result set as array of objects
        */
       public function resultSet()
        {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

       /**
        * @return mixed
        * Get result as associative array.
        */
       public function resultSetAssoc()
       {
           $this->execute();
           return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
       }

       /**
        * @return mixed
        * Get single record as object
        */
       public function single()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

       /**
        * @return mixed
        * Get record row count
        */
       public function rowCount()
        {
            return $this->stmt->rowCount();
        }

       /**
        * Migrating all database tables.
        */
       public function migrate()
       {

          /* $dbQuery = "CREATE DATABASE php_blog";

           $this->query($dbQuery);
           $this->execute();*/

           $usersQuery = "
        
        DROP TABLE IF EXISTS users;
        CREATE TABLE users  (
          id int(11) NOT NULL AUTO_INCREMENT,
          name varchar(255) NOT NULL,
          email varchar(255) NOT NULL,
          password varchar(255) NOT NULL,
          role enum('user','admin')  NOT NULL DEFAULT 'user',
          hash varchar(255) NOT NULL,
          active tinyint(1) DEFAULT 0,
          created_at datetime  ON UPDATE CURRENT_TIMESTAMP(0),
          PRIMARY KEY (id)
        )               
        
        ";

           $this->query($usersQuery);
           $this->execute();

           $categoriesQuery = "
        DROP TABLE IF EXISTS categories;
        CREATE TABLE categories  (
          id int(11) NOT NULL AUTO_INCREMENT,
          name varchar(255) NOT NULL,
          PRIMARY KEY (id) 
          )
        
        ";
           $this->query($categoriesQuery);
           $this->execute();





           $tagsQuery="
                DROP TABLE IF EXISTS tags;
                CREATE TABLE tags  (
                  id int(11) NOT NULL AUTO_INCREMENT,
                  name varchar(255) NOT NULL,
                  PRIMARY KEY (id) 
                )                   
            ";

           $this->query($tagsQuery);
           $this->execute();




           $articlesQuery = "
        
        DROP TABLE IF EXISTS articles;
        CREATE TABLE articles  (
          id int(11) NOT NULL AUTO_INCREMENT,
          title varchar(255) NOT NULL,
          slug varchar(255) NOT NULL,
          body varchar(255) NOT NULL,
          image varchar(255) NOT NULL,
          user_id int(11) NOT NULL,
          category_id int(11) NOT NULL,
          status tinyint(1) DEFAULT 0,
          created_at datetime NULL DEFAULT NULL,
          position int(255) DEFAULT 0,
          PRIMARY KEY (id),
          CONSTRAINT category_id FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
        )
        
        ";


           $this->query($articlesQuery);
           $this->execute();


           $article_tagQuery = "
        
        DROP TABLE IF EXISTS article_tag;
        CREATE TABLE article_tag  (
          article_id int(11) NOT NULL,
          tag_id int(11) NOT NULL,
          CONSTRAINT article_id FOREIGN KEY (article_id) REFERENCES articles (id) ON DELETE CASCADE ON UPDATE CASCADE,
          CONSTRAINT tag_id FOREIGN KEY (tag_id) REFERENCES tags (id) ON DELETE CASCADE ON UPDATE CASCADE
        )
        
        ";

           $this->query($article_tagQuery);
           $this->execute();



       }
    }