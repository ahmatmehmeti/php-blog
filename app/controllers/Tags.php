<?php
require_once '../app/requests/TagRequest.php';
class Tags extends Controller
{
    /**
     *Load Models
     * If the user is not admin,can not create,update or delete tags.
     */
    public function __construct()
    {
        if(!isAdmin()){
            redirect('users/login');
        }

        $this->tagModel = $this->model('Tag');
        $this->tagsRequest = new TagRequest();
    }

    /**
     * Load all Tags
     */
    public function index()
    {
        $tags = $this->tagModel->getTags();
        $data = [
            'tags'=>$tags,
        ];

        $this->view('tags/index', $data);
    }

    /**
     * Validate the inputs,make sure there are no errors and creates the
     * tag.Redirects to the tags page with the flash message.
     */
    public function store()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $tags = $this->tagModel->getTags();

        $data = [
            'name' => $_POST['name'],
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

    /**
     * @param $id
     * Calls the edit form with the data.
     */
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

    /**
     * @param $id
     * Validate the inputs,makes sure there are no errors and edits the
     * tag.Redirects to the tags page with the flash message.
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

        $data  = $this->tagsRequest->ValidateForm($data);

        if (!empty($data['errors'])) {
            $this->view('tags/edit', $data);
        } else {
            $this->tagModel->updateTag($data);
            flash('tags_message', 'Tag has been updated');
            redirect('tags/index');
        }
    }

    /**
     * @param $id
     * Deletes the tag.
     */
    public function delete($id)
    {
        $this->tagModel->deleteTag($id);
        flash('tags_message', 'Tag Deleted');
        redirect('tags');
    }
}

