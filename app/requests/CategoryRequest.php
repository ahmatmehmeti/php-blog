<?php

class CategoryRequest{
    public function ValidateForm($data){
        if ($data['name'] == "") {
            $data['errors']['name_err'] = 'Please enter name';
        }
        return $data;
    }
}