<?php
    class Category extends Controller
    {
        public function __construct()
        {
            $this->db = new Database;


        }

        public function getCategories()
        {
            $this->db->query('SELECT * FROM categories');
            $results = $this->db->resultSet();

            return $results;
        }
        public function addCategories($data)
        {
            $this->db->query('INSERT INTO categories (name,created_at) VALUE (:name, :created_at)');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':created_at',$data['created_at']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function updateCategory($data)
        {
            $this->db->query('UPDATE categories SET name = :name,created_at = :created_at WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':created_at',$data['created_at']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function getCategorieById($id)
        {
            $this->db->query('SELECT * FROM categories WHERE id = :id');
            $this->db->bind(':id', $id);

            $row = $this->db->single();

            return $row;
        }

        public function deleteCategory($id)
        {
            $this->db->query('DELETE FROM categories WHERE id = :id');
            $this->db->bind(':id', $id);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }
    }