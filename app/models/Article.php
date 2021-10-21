<?php
    class Article extends Controller
    {
        private $db;

        public function __construct()
        {

            $this->db = new Database();
        }

        public function getArticles()
        {
            $user_loggedIn = $_SESSION['user_id'];
            $this->db->query('SELECT * FROM articles WHERE user_id = :user_id ORDER BY position ');
            $this->db->bind(':user_id',$user_loggedIn);
            $results = $this->db->resultSet();

            return $results;
        }

        public function getArticlesNotApproved()
        {
            $this->db->query('SELECT * FROM articles WHERE status = :status');
            $this->db->bind(':status',0);
            $results = $this->db->resultSet();

            return $results;
        }

        public function getArticlesApproved()
        {
            $this->db->query('SELECT * FROM articles WHERE status = :status');
            $this->db->bind(':status',1);
            $results = $this->db->resultSet();

            return $results;
        }


        public function addArticles($data)
        {
            $this->db->query('INSERT INTO articles (title,slug,body,image,created_at,category_id,user_id) VALUE (:title,:slug,:body,:image,:created_at,:category_id,:user_id)');
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':slug', $data['slug']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':category_id', $data['category_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':image', $data['image']);
            $this->db->bind(':created_at',$data['created_at']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function tagsArticle($data)
        {
            $this->db->query('SELECT id FROM articles WHERE slug = :slug');
            $this->db->bind(':slug', $data['slug']);
            $row = $this->db->single();

            foreach ($data['selectedTag'] as $tag) {
                $this->db->query('INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)');
                $this->db->bind(':article_id', $row->id);
                $this->db->bind(':tag_id', $tag);
                $this->db->execute();
            }
        }

        public  function updateArticle($data)
        {
            $this->db->query('UPDATE articles set title = :title,slug = :slug,body = :body/*,image = :image*/,category_id = :category_id WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':slug', $data['slug']);
            $this->db->bind(':body', $data['body']);
            /*$this->db->bind(':image', $data['image']);*/
            $this->db->bind(':category_id', $data['category_id']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function updateTagsArticle($data)
        {
            $this->db->query('SELECT id FROM articles WHERE slug = :slug');
            $this->db->bind(':slug', $data['slug']);
            $article = $this->db->single();

            $this->db->query('DELETE FROM article_tag WHERE article_id = :id');
            $this->db->bind(':id', $article->id);
            $this->db->execute();

            foreach ($data['selectedTag'] as $tag) {
                $this->db->query('INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)');
                $this->db->bind(':article_id', $article->id);
                $this->db->bind(':tag_id', $tag);
                $this->db->execute();
            }
        }

        public function getArticlesById($id)
        {
            $this->db->query('SELECT * FROM articles WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }


        public function deleteArticle($id)
        {
            $this->db->query('DELETE FROM articles WHERE id = :id');
            $this->db->bind(':id', $id);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public  function approveArticles($id)
        {
            $this->db->query('UPDATE articles SET status = :status WHERE id = :id');
            $this->db->bind(':status',1);
            $this->db->bind(':id', $id);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function getArticlesByCategory($id)
        {
            $this->db->query('SELECT * FROM articles WHERE category_id = :id AND status = :status');
            $this->db->bind(':id',$id);
            $this->db->bind(':status',1);
            return $this->db->resultSet();
        }


        public function articlesSort()
        {
        foreach ($_POST['positions'] as $position){
            $index = $position[0];
            $newPosition = $position[1];

            $this->db->query('UPDATE articles SET position = :position WHERE id = :id');
            $this->db->bind(':position',$newPosition);
            $this->db->bind(':id',$index);
            $this->db->execute();
            }
        }
    }