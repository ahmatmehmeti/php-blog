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
            $this->db->query('SELECT * FROM articles');
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

            foreach ($data['tags'] as $tag) {
                $this->db->query('INSERT INTO article_tag (article_id, tag_id) VALUES (:article_id, :tag_id)');
                $this->db->bind(':article_id', $row->id);
                $this->db->bind(':tag_id', $tag);
                $this->db->execute();
            }
        }

        public  function updateArticle($data)
        {
            $this->db->query('UPDATE articles set title = :title,body = :body,image = :image,category_id = :category_id WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':image', $data['image']);
            $this->db->bind(':category_id', $data['category_id']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
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

    }