<?php
require_once '../app/requests/ArticleRequest.php';
class Articles extends Controller
{
    /**
     * Loads Models.
     */
    public function __construct()
    {
        $this->articleModel = $this->model('Article');
        $this->categoryModel = $this->model('Category');
        $this->tagModel = $this->model('Tag');
        $this->userModel = $this->model('User');
        $this->articleRequest = new ArticleRequest();
    }

    /**
     *Loads all articles.
     */
    public function index($page_nr = 1)
    {
        if(isAdmin()){
            $pagination = $this->articleModel->paginationArticlesAdmin($page_nr);
        }else{
            $pagination = $this->articleModel->paginationArticlesUser($page_nr);
        }

        $data = [
            'pagination' => $pagination,
        ];


        $this->view('articles/index', $data);
    }

    /**
     * Loads the create form.
     */
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

    /**
     * Validates the inputs,make sure there are no errors and creates the
     * article.Redirects to the articles page with the flash message.
     */
    public function store()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTags();

        if(($_POST['image'] == null))
        {
            $folder = "img/img.jpg";
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }else{
            $folder = "img";
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }

        $slug = preg_replace('/[^a-z0-9]+/i', '-',trim(rand(0,1000).'-'.strtolower($_POST['title'])));

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

    /**
     * @param $id
     * Calls the edit form with the data.
     */
    public function edit($id){

        $article = $this->articleModel->getArticlesById($id);
        $categories = $this->categoryModel->getCategories();
        $articleTags = $this->tagModel->getTagByArticle($id);
        $tags = $this->tagModel->getTags();

        if(!isAdmin() && $_SESSION['user_id'] != $article->user_id){
            redirect('home/index');
        }

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

    /**
     * @param $id
     * Validates the inputs,makes sure there are no errors and edits the
     * article.Redirects to the articles page with the flash message.
     */
    public function update($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tags = $this->tagModel->getTags();
        $categories = $this->categoryModel->getCategories();
        $articleTags = $this->tagModel->getTagByArticle($id);

        if(!$_POST['image'])
        {
            $folder = "img/img.jpg";
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
        }else{
            $folder = "img";
            $destination = $folder . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);
    }

        $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($_POST['title']) ));

        $data = [
            'title' => $_POST['title'],
            'id' => $id,
            'slug' => $slug,
            'image' => $destination,
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

    /**
     * @param $id
     * Deletes article.
     */
    public function delete($id)
    {
        $this->articleModel->deleteArticle($id);
        flash('articles_message', 'Article Deleted');
        redirect('articles');
    }

    /**
     * @param $id
     * Calls the method form model for approving articles.
     * When the user creates the article,the admin must approve that article
     * to be shown to the home page.
     */
    public function approveArticle($id)
    {
        if(!isAdmin()){
            redirect('home/index');
        }
        $this->articleModel->approveArticles($id);
        flash('articles_message', 'Article Approved');
        redirect('articles/index');
    }

    /**
     * @param $slug
     * Shows all the details of article.
     */
    public function show($slug){
        $article = $this->articleModel->getArticlesBySlug($slug);
        $categories = $this->categoryModel->getCategories();
        $tags = $this->tagModel->getTagByArticle($article->id);
        $users = $this->userModel->getUsers();
        $data = [
            'article' => $article,
            'categories' => $categories,
            'tags' => $tags,
            'users' =>$users
        ];
        $this->view('articles/show', $data);
    }

    /**
     * @param $id
     * Calls the method from model to get all the articles by category.
     */
    public function getArticlesByCategory($category_id,$page_nr = 1)
    {
        $articles = $this->articleModel->getArticlesByCategory($category_id);
        $categories = $this->categoryModel->getCategories();
        $pagination = $this->articleModel->paginationCat($category_id, $page_nr);

        $data = [
            'categories' => $categories,
            'articles' => $articles,
            'pagination' => $pagination,
        ];
        $this->view('home/index', $data);
    }

    /**
     *Calls the method form model for sorting articles(Drag & drop).
     */
    public function articlesSort()
    {
        $this->articleModel->articlesSort();
    }
}