<?php
    class Controller
    {
        /**
         * Lets us load model from controllers
         * Require model file
         * Instantiate model
         */
        public function model($model)
        {
            require_once '../app/models/' .$model . '.php';

            return new $model();
        }

        /**
         * Lets us load view from controllers
         * Check for view file
         * Require view file
         */
        public function view($view, $data = [])
        {
            if(file_exists('../app/views/' . $view . '.php'))
            {
                require_once ('../app/views/' . $view . '.php');
            }
            else
            {
                die('view does not exists');
            }
        }
    }