<?php
    class Category extends Controller
    {
        private $db;

        /**
         * Load the database.
         */
        public function __construct()
        {
            $this->db = new Database;
        }

        /**
         * @return mixed
         * Select all form categories
         */
        public function getCategories()
        {
            $this->db->query('SELECT * FROM categories');
            $results = $this->db->resultSet();
            return $results;
        }

        /**
         * @param $data
         * @return bool
         * Add categories.
         */
        public function addCategories($data)
        {
            $this->db->query('INSERT INTO categories (name) VALUE (:name)');
            $this->db->bind(':name', $data['name']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        /**
         * @param $data
         * @return bool
         * Update categories.
         */
        public function updateCategory($data)
        {
            $this->db->query('UPDATE categories SET name = :name WHERE id = :id');
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':name', $data['name']);

            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }

        /**
         * @param $id
         * @return mixed
         * Select all categories by id.
         */
        public function getCategorieById($id)
        {
            $this->db->query('SELECT * FROM categories WHERE id = :id');
            $this->db->bind(':id', $id);
            $row = $this->db->single();
            return $row;
        }


        /**
         * @param $id
         * @return bool
         * Delete the category.
         */
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