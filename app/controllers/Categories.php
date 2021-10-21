<?php
require_once '../app/requests/CategoryRequest.php';
    class Categories extends Controller
    {
        public function __construct()
        {
            if(!isAdmin()){
                redirect('users/login');
            }
            $this->categoryModel = $this->model('Category');
            $this->categoryRequest = new CategoryRequest();
        }

        public function index()
        {
            $categories = $this->categoryModel->getCategories();
            $data = [
                'categories'=>$categories,
            ];

            $this->view('categories/index', $data);
        }

        public function store(){
            $categories = $this->categoryModel->getCategories();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'name' => trim($_POST['name']),
                'categories' => $categories,
                'created_at' => date('Y-m-d H:i:s'),
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

        public function update($id)
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'created_at'=>date('Y-m-d H:i:s'),
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

        public function delete($id)
        {
            $this->categoryModel->deleteCategory($id);
            flash('category_message', 'Category Deleted');
            redirect('categories');

        }
    }