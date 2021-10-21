<?php
require_once '../app/requests/TagRequest.php';
class Tags extends Controller
{
    public function __construct()
    {
        if(!isAdmin()){
            redirect('users/login');
        }

        $this->tagModel = $this->model('Tag');
        $this->tagsRequest = new TagRequest();
    }

    public function index()
    {
        $tags = $this->tagModel->getTags();
        $data = [
            'tags'=>$tags,
        ];

        $this->view('tags/index', $data);
    }

    public function store()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tags = $this->tagModel->getTags();

        $data = [
            'name' => $_POST['name'],
            'created_at'=>date('Y-m-d H:i:s'),
            'name_err' => '',
            'tags'=>$tags,
            'errors' => []
        ];

        $data = $this->tagsRequest->ValidateForm($data);

        if(!empty($data['errors'])){
            $this->view('tags/index', $data);
        }else{
            $this->tagModel->addTags($data);
            flash('tags_message','Tag created successfully');
            redirect('tags/index');
        }
    }

    public function edit($id)
    {
        $tag = $this->tagModel->getTagById($id);
        $data = [
            'id' => $id,
            'name' => $tag->name,
            'name_err' => ''
        ];
        $this->view('tags/edit', $data);
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

        $data  = $this->tagsRequest->ValidateForm($data);

        if (!empty($data['errors'])) {
            $this->view('tags/edit', $data);
        } else {
            $this->tagModel->updateTag($data);
            flash('tags_message', 'Tag has been updated');
            redirect('tags/index');
        }
    }

    public function delete($id)
    {
        $this->tagModel->deleteTag($id);
        flash('tags_message', 'Tag Deleted');
        redirect('tags');
    }
}

