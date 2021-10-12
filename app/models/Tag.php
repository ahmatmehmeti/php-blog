<?php
class Tag extends Controller
{
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getTags()
    {
        $this->db->query('SELECT * FROM tags');
        $results = $this->db->resultSet();

        return $results;
    }
    public function addTags($data)
    {
        $this->db->query('INSERT INTO tags (name,created_at) VALUE (:name, :created_at)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':created_at',$data['created_at']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function updateTag($data)
    {
        $this->db->query('UPDATE tags SET name = :name,created_at = :created_at WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':created_at',$data['created_at']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getTagById($id)
    {
        $this->db->query('SELECT * FROM tags WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function deleteTag($id)
    {
        $this->db->query('DELETE FROM tags WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
}