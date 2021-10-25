<?php
    class Article extends Controller
    {
        private $db;

        /**
         * Load the database.
         */
        public function __construct()
        {
            if(!isLoggedIn()){
                redirect('users/login');
            }
            $this->db = new Database();
        }

        /**
         * @return mixed
         * Select all the articles created form one user.
         */
        public function getArticles()
        {
            $user_loggedIn = $_SESSION['user_id'];
            $this->db->query('SELECT * FROM articles WHERE user_id = :user_id ORDER BY position ');
            $this->db->bind(':user_id',$user_loggedIn);
            $results = $this->db->resultSet();

            return $results;
        }

        /**
         * @return mixed
         * Select all the articles
         */
        public function getArticlesAdmin()
        {
            $this->db->query('SELECT * FROM articles');
            $results = $this->db->resultSet();

            return $results;
        }

        /**
         * @return mixed
         * Select all the articles where are approved form admin.
         */
        public function getArticlesApproved()
        {
            $this->db->query('SELECT * FROM articles WHERE status = :status');
            $this->db->bind(':status',1);
            $results = $this->db->resultSet();

            return $results;
        }

        /**
         * @param $data
         * @return bool
         * Add article.
         */
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

        /**
         * @param $data
         * Add tags that are specific for one article in table article_tag.
         */
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

        /**
         * @param $data
         * @return bool
         * Update articles.
         */
        public  function updateArticle($data)
        {
            $this->db->query('UPDATE articles set title = :title,slug = :slug,body = :body,image = :image,category_id = :category_id WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':slug', $data['slug']);
            $this->db->bind(':body', $data['body']);
            $this->db->bind(':image', $data['image']);
            $this->db->bind(':category_id', $data['category_id']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        /**
         * @param $data
         * Update tags.
         */
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

        /**
         * @param $id
         * @return mixed
         * Select all articles by id.
         */
        public function getArticlesById($id)
        {
            $this->db->query('SELECT * FROM articles WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        /**
         * @param $slug
         * @return mixed
         * Select all articles by tag.
         */
        public function getArticlesBySlug($slug)
        {
            $this->db->query('SELECT * FROM articles WHERE slug = :slug');
            $this->db->bind(':slug', $slug);
            $row = $this->db->single();
            return $row;
        }


        /**
         * @param $id
         * @return bool
         * Delete article.
         */
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

        /**
         * @param $id
         * @return bool
         * Approve article,status 0 is not approved,status 1 is approved.
         */
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

        /**
         * @param $id
         * @return mixed
         * Select all articles that have same category and are approved.
         */
        public function getArticlesByCategory($id)
        {
            $this->db->query('SELECT * FROM articles WHERE category_id = :id AND status = :status');
            $this->db->bind(':id',$id);
            $this->db->bind(':status',1);
            return $this->db->resultSet();
        }


        /**
         * Sorting articles(Drag & drop).
         */
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


        /**
         * @param int $page_nr
         * @return array
         * Pagination for  Articles in home page.
         */
        public function pagination($page_nr = 1)
        {
            $postsForPage = 8;

            $this->db->query('SELECT * FROM articles WHERE status = :status');
            $this->db->bind(':status',1);
            $db = $this->db->resultSet();

            $countPosts = count($db);

            $result = ceil($countPosts / $postsForPage);
            $offset = ($page_nr - 1) * $postsForPage;

            $this->db->query('SELECT * FROM articles WHERE status = :status ORDER BY `created_at` DESC LIMIT :limit OFFSET :offset');
            $this->db->bind('status',1);
            $this->db->bind(':limit',(int) $postsForPage , PDO::PARAM_INT);
            $this->db->bind(':offset',(int) $offset, PDO::PARAM_INT );
            $sql = $this->db->resultSet();

            return[
                'totalAll' => $result,
                'articles' =>$sql
            ];
        }

        /**
         * @param $category_id
         * @param int $page_nr
         * @return array
         * Pagination by category in home page
         */
        public function paginationCat($category_id, $page_nr = 1){
            $postForPage = 8;

            $this->db->query("SELECT * FROM categories WHERE id = :id");
            $this->db->bind(':id', $category_id);
            $category = $this->db->single();
            $id = $category->id;

            $this->db->query("SELECT * FROM articles WHERE status = :status and category_id = :category_id");
            $this->db->bind(':status', 1);
            $this->db->bind(':category_id', $category_id);

            $db = $this->db->resultset();
            $countPosts = count($db);
            $result = ceil($countPosts /$postForPage );

            $offset = ($page_nr - 1) * $postForPage;

            $this->db->query("SELECT * FROM articles WHERE status = :status and category_id = :category_id LIMIT :limit OFFSET :offset");
            $this->db->bind(':status', 1);
            $this->db->bind(':category_id', $category_id);
            $this->db->bind(':limit', (int) $postForPage, PDO::PARAM_INT);
            $this->db->bind(':offset', (int) $offset, PDO::PARAM_INT);
            $this->db->execute();
            $sql = $this->db->resultset();

            return [
                'totalCat' => $result,
                'articles' => $sql,
                'id' => $id
            ];
        }

        /**
         * @param $page_nr
         * @return array
         * Pagination for admin articles list
         */
        public function paginationArticlesAdmin($page_nr)
        {
            $postsForPage = 10;

            $this->db->query('SELECT * FROM articles');
            $db = $this->db->resultSet();

            $countPosts = count($db);

            $result = ceil($countPosts / $postsForPage);
            $offset = ($page_nr - 1) * $postsForPage;

            $this->db->query('SELECT * FROM articles ORDER BY position LIMIT :limit OFFSET :offset');
            $this->db->bind(':limit',(int) $postsForPage , PDO::PARAM_INT);
            $this->db->bind(':offset',(int) $offset, PDO::PARAM_INT );
            $sql = $this->db->resultSet();

            return[
                'totalAll' => $result,
                'articles' =>$sql
            ];
        }

        /**
         * @param $page_nr
         * @return array
         * Pagination for user articles list
         */
        public function paginationArticlesUser($page_nr)
        {
            $postsForPage = 10;

            $user_loggedIn = $_SESSION['user_id'];
            $this->db->query('SELECT * FROM articles WHERE user_id = :user_id');
            $this->db->bind(':user_id',$user_loggedIn);
            $db = $this->db->resultSet();

            $countPosts = count($db);

            $result = ceil($countPosts / $postsForPage);
            $offset = ($page_nr - 1) * $postsForPage;

            $this->db->query('SELECT * FROM articles WHERE user_id = :user_id ORDER BY position LIMIT :limit OFFSET :offset');
            $this->db->bind(':user_id',$user_loggedIn);
            $this->db->bind(':limit',(int) $postsForPage , PDO::PARAM_INT);
            $this->db->bind(':offset',(int) $offset, PDO::PARAM_INT );
            $sql = $this->db->resultSet();

            return[
                'totalAll' => $result,
                'articles' =>$sql
            ];
        }

    }