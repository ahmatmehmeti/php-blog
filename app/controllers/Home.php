<?php
     class Home extends Controller
    {
        public function __construct()
        {
            $this->articleModel = $this->model('Article');
            $this->categoryModel = $this->model('Category');

        }
         public function index(){
             $articles = $this->articleModel->getArticles();
             $categories = $this->categoryModel->getCategories();
            $data = [
                'categories' => $categories,
                'articles' => $articles
            ];
             $this->view('home/index', $data);
         }

        public function about(){
            $data = [
            ];
            $this->view('home/about', $data);
        }

    }