<?php
    class ArticleRequest
    {
        /**
         * @param $data
         * @return array
         * Validation for article data.
         */
        public function ValidationForm($data)
        {
            if($data['title'] == ""){
                $data['errors']['title_err'] = 'Please enter title';
            }
            if($data['body'] == ""){
                $data['errors']['body_err'] = 'Please enter body';
            }
            if($data['category_id'] == ""){
                $data['errors']['category_id_err'] = 'Please enter category';
            }
            if($data['tags'] == ""){
                $data['errors']['tags_err'] = 'Please select tags';
            }
            if($data['created_at'] == ""){
                $data['errors']['created_at_err'] = 'Please enter date';
            }
            return $data;
        }
    }