<?php
    class TagRequest
    {
        /**
         * @param $data
         * @return array
         * Validation for tags data.
         */
        public function ValidateForm($data){
            if ($data['name'] == "") {
                $data['errors']['name_err'] = 'Please enter name';
            }
            return $data;
        }
    }