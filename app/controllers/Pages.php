<?php
     class Pages extends Controller
    {
        public function __construct()
        {

        }
         public function index(){

            $data = [
                'title' => 'Welcome',
                'description'=>'Description about this post'
            ];
             $this->view('pages/index', $data);
         }
        public function about(){
            $data = [
                'title'=>'About us',
                'description'=>'Description about this post '
            ];
            $this->view('pages/about', $data);
        }

    }