<?php
    class Home extends Controller
    {
        private $db;
        private $seeders;

         /**
          * Loads the database,seeders and models.
          * User should login to see the articles and caegories.
          */
         public function __construct()
        {
            if(!isLoggedIn()){
                redirect('users/login');
            }
            $this->db = new Database();
            $this->seeders = new Seeders();
            $this->articleModel = $this->model('Article');
            $this->categoryModel = $this->model('Category');

        }

         /**
          * Loads all the categories.
          * Loads all the approved articles form admin.
          */
         public function index($page_nr = 1){
             $articles = $this->articleModel->getArticlesApproved();
             $categories = $this->categoryModel->getCategories();
             $pagination = $this->articleModel->pagination($page_nr);
             $data = [
                'categories' => $categories,
                'articles' => $articles,
                'pagination' => $pagination
             ];
             $this->view('home/index', $data);
         }

        /**
         * Calls the function form libraries to migrate
         * all the database tables.
         */
        public function migrate()
         {
             $this->db->migrate();
             redirect('home/index');
         }

        /**
         * Calls the function form models to migrate
         * all the seeders.
         */
        public function seeders()
         {
             $this->seeders->allseders();
             redirect('home/index');
         }
    }