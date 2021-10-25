<?php
class Tag extends Controller
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
     * Select all form tags.
     */
    public function getTags()
    {
        $this->db->query('SELECT * FROM tags');
        $results = $this->db->resultSet();
        return $results;
    }

    /**
     * @param $data
     * @return bool
     * Add tags.
     */
    public function addTags($data)
    {
        $this->db->query('INSERT INTO tags (name) VALUE (:name)');
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
     * Update tags.
     */
    public function updateTag($data)
    {
        $this->db->query('UPDATE tags SET name = :name WHERE id = :id');
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
     * Select tags by id.
     */
    public function getTagById($id)
    {
        $this->db->query('SELECT * FROM tags WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    /**
     * @param $id
     * @return bool
     * Delete tag.
     */
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

    /**
     * @param $id
     * @return array
     * To get all the tags of one article.
     */
    public function getTagByArticle($id){
        $this->db->query("SELECT tag_id FROM article_tag WHERE article_id = :id");
        $this->db->bind(':id', $id);
        $tagsIds = $this->db->resultSetASSOC();

        $this->db->query("SELECT * FROM tags");
        $tags = $this->db->resultSetASSOC();

        foreach ($tags as $tag){
            foreach ($tagsIds as $tId){
                if(in_array($tag['id'], $tId)){
                    $tagNames[] = $tag['name'];
                }
            }
        }
        return $tagNames;
    }
}