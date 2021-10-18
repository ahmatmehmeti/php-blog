<?php
    class Categories extends Controller
    {
        public function __construct()
        {
            if(!isAdmin()){
                redirect('users/login');
            }

            $this->categoryModel = $this->model('Category');
        }

        public function index()
        {
            $categories = $this->categoryModel->getCategories();
            $data = [
                'categories'=>$categories,
            ];

            $this->view('categories/index', $data);
        }

        public function add(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                $categories = $this->categoryModel->getCategories();

                $data = [
                    'name' => $_POST['name'],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'name_err' => '',
                    'categories'=>$categories
                ];

                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter title';
                }

                if(empty($data['name_err'])){
                    if($this->categoryModel->addCategories($data)){

                        flash('categories_message','Category created successfully');
                        redirect('categories/index');
                    }else{
                        die('Something went wrong');
                    }
                } else{
                    $this->view('categories/index', $data);
                }
            }else{
                $categories = $this->categoryModel->getCategories();
                $data = [
                    'name' =>'',
                ];
                $this->view('categories/index', $data);
            }
        }

        public function edit($id)
        {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'id' => $id,
                    'name' => trim($_POST['name']),
                    'created_at'=>date('Y-m-d H:i:s'),
                    'name_err' => ''
                ];

                if (empty($data['name'])) {
                    $data['name_err'] = 'Please enter name';
                }

                if (empty($data['name_err'])) {
                    if ($this->categoryModel->updateCategory($data)) {
                        flash('category_success', 'Category has been updated');
                        redirect('categories/index');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    $this->view('categories/index', $data);
                }
            }else{

                $category = $this->categoryModel->getCategorieById($id);
                $data = [
                    'id' =>$id,
                    'name' =>$category->name
                ];
            }
            $this->view('categories/edit', $data);
        }

        public function delete($id)
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                if($this->categoryModel->deleteCategory($id)){
                    flash('category_message', 'Category Deleted');
                    redirect('categories');
                }else{
                    die('Something went wrong');
                }
            }else{
                redirect('categories');
            }
        }
    }