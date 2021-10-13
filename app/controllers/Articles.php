<?php
    class Articles extends Controller
    {
        public function __construct()
        {

            $this->articleModel = $this->model('Article');
            $this->categoryModel = $this->model('Category');
            $this->tagModel = $this->model('Tag');
            $this->userModel = $this->model('User');
        }

        public function index()
        {
            $articles = $this->articleModel->getArticles();
            $data = [
                'articles' => $articles
            ];

            $this->view('articles/index', $data);
        }

        public function create(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $categories = $this->categoryModel->getCategories();
                $tags = $this->tagModel->getTags();

                if(isset($_FILES['image']['name']))
                {
                    $folder = "img/";
                    $destination = $folder . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                }

                $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['title'])));

                $data = [
                    'title' => $_POST['title'],
                    'slug' => $slug,
                    'body' => $_POST['body'],
                    'image' => $destination,
                    'user_id' =>$_SESSION['user_id'],
                    'category_id' =>$_POST['category_id'],
//                  'status' =>$_POST['status'],
                    'categories' => $categories,
                    'tags' => $_POST['tags'],
                    'created_at' => $_POST['created_at'],
                    'title_err' => '',
                    'slug_err' => '',
                    'category_err' => '',
                    'tags_err' => '',
                    'image_err' => '',
                    'body_err' => '',
                ];

                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title!';
                }

                if(empty($data['slug'])){
                    $data['slug_err'] = 'Please enter slug!';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body!';
                }

                if(empty($data['category_id'])){
                    $data['category_err'] = 'Please choose category!';
                }

                if(empty($data['image'])){
                    $data['image_err'] = 'Please choose image!';
                }

                if(empty($data['created_at'])){
                    $data['created_at_err'] = 'Please choose date!';
                }

                if(empty($data['title_err']) && empty($data['slug_err']) && empty($data['body_err']) && empty($data['category_err']) && empty($data['tags_err']) && empty($data['image_err']) && empty($data['created_at_err'])){
                    if($this->articleModel->addArticles($data)){
                        $this->articleModel->tagsArticle($data);
                        flash('articles _message','Article created successfully!');
                        redirect('articles/index');
                    }else{
                        die('Something went wrong!');
                    }
                } else{
                    $this->view('articles/create', $data);
                }
            }else{
                $categories = $this->categoryModel->getCategories();
                $tags = $this->tagModel->getTags();

                $data = [
                    'title' =>'',
                    'slug' => '',
                    'body' => '',
                    'categories' => $categories,
                    'tags' => $tags,
                    'date'=>'',
                    'image' => '',
                    'user_id' =>'',
                    'status' =>'',

                ];
                $this->view('articles/create', $data);
            }
        }

        public function edit($id){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $categories = $this->categoryModel->getCategories();
                /*$tags = $this->tagModel->getTags();*/

   /*             if(isset($_FILES['image']['name']))
                {
                    $folder = "img/";
                    $destination = $folder . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);
                }*/

                $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['title'])));

                $data = [
                    'title' => $_POST['title'],
                    'slug' => $slug,
                    'body' => $_POST['body'],
                    /*'image' => $destination,*/
                    'image' => $_POST['image'],
                    'user_id' =>$_SESSION['user_id'],
                    'category_id' =>$_POST['category_id'],
//                'status' =>$_POST['status'],
                    'categories' => $categories,
                    /* 'tags' => $_POST['tags'],*/
                    'created_at' => $_POST['created_at'],
                    'title_err' => '',
                    'slug_err' => '',
                    'category_err' => '',
                    'tags_err' => '',
                    'image_err' => '',
                    'body_err' => '',
                ];

                if(empty($data['title'])){
                    $data['title_err'] = 'Please enter title';
                }

                if(empty($data['slug'])){
                    $data['slug_err'] = 'Please enter slug';
                }

                if(empty($data['body'])){
                    $data['body_err'] = 'Please enter body';
                }

                if(empty($data['category_id'])){
                    $data['category_err'] = 'Please choose category';
                }

                if(empty($data['image'])){
                    $data['image_err'] = 'Please choose image';
                }

                if(empty($data['created_at'])){
                    $data['created_at_err'] = 'Please choose date!';
                }

                if(empty($data['title_err']) && empty($data['slug_err']) && empty($data['body_err']) && empty($data['category_err'])/* && empty($data['tags_err']) */&& empty($data['image_err']) && empty($data['created_at_err'])){
                    if($this->articleModel->updateArticle($data)){

                        flash('articles_message','Article updated successfully');
                        redirect('articles/index');
                    }else{
                        die('Something went wrong');
                    }
                } else{
                    $this->view('articles/create', $data);
                }
            }else{
                $articles = $this->articleModel->getArticlesById($id);
                $categories = $this->categoryModel->getCategories();
                /*$tags = $this->tagModel->getTags();*/

                $data = [
                    'id'=>$id,
                    'title' => $articles->title,
                    'body'=> $articles->body,
                    'image' => $articles->image,
                    'category_id' => $articles->category_id,
                    'created_at' => $articles->created_at,
                    'user_id' => '',
                    'categories' => $categories,
                    /*'tags' => $tags,*/
                ];
                $this->view('articles/edit', $data);
            }
        }

        public function delete($id)
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->articleModel->deleteArticle($id)){
                    flash('articles_message', 'Article Deleted');
                    redirect('articles');
                }else{
                    die('Something went wrong');
                }
            }else{
                redirect('articles');
            }
        }

        public function approveArticle($id)
        {
            $this->articleModel->approveArticles($id);
            $articles = $this->articleModel->getArticles();
            $data= [
                'articles' => $articles
            ];
            flash('articles_message', 'Article Approved');
            $this->view('articles/index', $data);
        }


    }