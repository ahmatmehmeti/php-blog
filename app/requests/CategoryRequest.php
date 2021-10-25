<?php

class CategoryRequest{
    /**
     * @param $data
     * @return array
     * Validation for category data.
     */
    public function ValidateForm($data){
        if ($data['name'] == "") {
            $data['errors']['name_err'] = 'Please enter name';
        }
        return $data;
    }
}