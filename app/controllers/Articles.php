<?php
require_once '../app/requests/ArticleRequest.php';
class Articles extends Controller
{
    public function __construct()
    {

        $this->articleModel = $this->model('Article');
        $this->categoryModel = $this->model('Category');
        $this->tagModel = $this->model('Tag');
        $this->userModel = $this->model('User');
        $this->articleRequest = new ArticleRequest();
    }

    public function index()
    {
        if(isAdmin()){
            $articles = $this->articleModel->getArticlesNotApproved();
        }else{
            $articles = $this->articleModel->getArticles();
        }
        $data = [
            'articles' => $articles
        ];

        $this->view('articles/index', $data);
    }

    public function create(){
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

        ];
        $this->view('articles/create', $data);
    }

    public function store()
    {
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
            'categories' => $categories,
            'tags' =>$tags,
            'selectedTag' => $_POST['tags'],
            'created_at' => $_POST['created_at'],
            'title_err' => '',
            'category_id_err' => '',
            'created_at_err' => '',
            'tags_err' => '',
            'image_err' => '',
            'body_err' => '',
            'errors' => [],
        ];

        $data = $this->articleRequest->ValidationForm($data);

        if(!empty($data['errors'])){
            $this->view('articles/create', $data);
        } else{
            $this->articleModel->addArticles($data);
            $this->articleModel->tagsArticle($data);
            flash('articles_message','Article created successfully!');
            redirect('articles/index');
        }
    }

    public function edit($id){
        $article = $this->articleModel->getArticlesById($id);
        $categories = $this->categoryModel->getCategories();
        $articleTags = $this->tagModel->getTagByArticle($id);
        $tags = $this->tagModel->getTags();

        $data = [
            'id'=>$id,
            'title' => $article->title,
            'article' => $article,
            'articleTags' => $articleTags,
            'body'=> $article->body,
            'image' => '',
            'category_id' => $article->category_id,
            'created_at' => $article->created_at,
            'user_id' => '',
            'categories' => $categories,
            'tags' => $tags,
        ];
        $this->view('articles/edit', $data);
    }

    public function update($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tags = $this->tagModel->getTags();
        $categories = $this->categoryModel->getCategories();
        $articleTags = $this->tagModel->getTagByArticle($id);

        if(isset($_FILES['image']['name']))
        {
            $folder = "img/";
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);

        }

        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['title']) ));

        $data = [
            'title' => $_POST['title'],
            'id' => $id,
            'slug' => $slug,
            /*'image' => $destination,*/
            'categories' => $categories,
            'selectedTag' => $_POST['tags'],
            'articleTags' => $articleTags,
            'body' => $_POST['body'],
            'user_id' =>$_SESSION['user_id'],
            'category_id' =>$_POST['category_id'],
            'tags' => $tags,
            'created_at' => $_POST['created_at'],
            'title_err' => '',
            'slug_err' => '',
            'category_err' => '',
            'tags_err' => '',
            'image_err' => '',
            'body_err' => '',
        ];

        $data=$this->articleRequest->ValidationForm($data);
        if(!empty($data['errors'])){
            $this->view('articles/edit', $data);
        } else{


            $this->articleModel->updateArticle($data);
            $this->articleModel->updateTagsArticle($data);
            flash('articles_message','Article updated successfully');
            redirect('articles/index');
        }
    }

    public function delete($id)
    {
        $this->articleModel->deleteArticle($id);
        flash('articles_message', 'Article Deleted');
        redirect('articles');
    }

    public function approveArticle($id)
    {
        if(!isAdmin()){
            redirect('home/index');
        }
        $this->articleModel->approveArticles($id);
        flash('articles_message', 'Article Approved');
        redirect('articles/index');
    }

    public function show($id){
        $article = $this->articleModel->getArticlesById($id);
        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTagByArticle($id);
        $users = $this->userModel->getUsers();
        $data = [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
            'users' =>$users
        ];
        $this->view('articles/show', $data);
    }

    public function getArticlesByCategory($id)
    {
        $articles = $this->articleModel->getArticlesByCategory($id);
        $categories = $this->categoryModel->getCategories();
        $data = [
            'categories' => $categories,
            'articles' => $articles
        ];
        $this->view('home/index', $data);
    }

    public function articlesSort()
    {
        $this->articleModel->articlesSort();
    }
}