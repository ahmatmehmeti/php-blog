<?php
     class Home extends Controller
    {
        private $db;
        private $seeders;
        public function __construct()
        {
            $this->db = new Database();
            $this->seeders = new Seeders();
            $this->articleModel = $this->model('Article');
            $this->categoryModel = $this->model('Category');

        }

         public function index(){
             $articles = $this->articleModel->getArticlesApproved();
             $categories = $this->categoryModel->getCategories();
            $data = [
                'categories' => $categories,
                'articles' => $articles
            ];
             $this->view('home/index', $data);
         }

         public function migrate()
         {
             $this->db->migrate();
             redirect('home/index');
         }

         public function seeders()
         {
             $this->seeders->allseders();
             redirect('home/index');
         }
    }