<?php
require_once '../app/requests/CategoryRequest.php';
    class Categories extends Controller
    {
        /**
         * Load Models
         * If the user is not admin,can not create,update or delete categories.
         */
        public function __construct()
        {
            if(!isAdmin()){
                redirect('users/login');
            }
            $this->categoryModel = $this->model('Category');
            $this->categoryRequest = new CategoryRequest();
        }

        /**
         * Load all Categories
         */
        public function index()
        {
            $categories = $this->categoryModel->getCategories();
            $data = [
                'categories'=>$categories,
            ];

            $this->view('categories/index', $data);
        }

        /**
         * Validate the inputs,make sure there are no errors and creates the
         * category.Redirects to the categories page with the flash message.
         */
        public function store(){
            $categories = $this->categoryModel->getCategories();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'categories' => $categories,
                'name_err' => '',
                'errors' => [],
            ];

            $data = $this->categoryRequest->ValidateForm($data);
            if(!empty($data['errors'])){
                $this->view('categories/index', $data);
            }else{
                $this->categoryModel->addCategories($data);
                flash('category_message', 'Category has been added');
                redirect('categories/index');
            }
        }

        /**
         * @param $id
         * Calls the edit form with the data.
         */
        public function edit($id)
        {
            $category = $this->categoryModel->getCategorieById($id);
            $data = [
                'id' =>$id,
                'name' =>$category->name,
                'name_err'=>''
            ];
            $this->view('categories/edit', $data);
        }

        /**
         * @param $id
         * Validates the inputs,makes sure there are no errors and edits the
         * category.Redirects to the categories page with the flash message.
         */
        public function update($id)
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'name_err' => '',
                'errors' => []
            ];

            $data = $this->categoryRequest->ValidateForm($data);

            if(!empty($data['errors'])){
                $this->view('categories/edit', $data);
            } else {
                $this->categoryModel->updateCategory($data);
                flash('category_message', 'Category has been updated');
                redirect('categories/index');
            }
        }

        /**
         * @param $id
         * Deletes the category.
         */
        public function delete($id)
        {
            $this->categoryModel->deleteCategory($id);
            flash('category_message', 'Category Deleted');
            redirect('categories');

        }
    }