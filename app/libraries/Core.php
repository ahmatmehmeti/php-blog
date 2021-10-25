<?php
    class Core
    {
        /**
         * Set Default controller,
         * Default method,
         * Set initial empty params array.
         */
        protected $currentController = 'Home';
        protected $currentMethod = 'index';
        protected $params = [];

        /**
         * Look in controllers folder for controller
         * If exists, set as controller
         * Unset 0 index
         * Require the current controller
         * Instantiate the current controller
         * Check if second part of url is set (method)
         * Check if method/function exists in current controller class
         * Set current method if it exists
         * Unset 1 index
         * Get params - Any values left over in url are params
         * Call a callback with an array of parameters
         */
        public function __construct(){
            $url = $this->getUrl();
            if (isset($url[0]) && !empty($url[0]) && $url[0] != 'home.php') {
                if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                    $this->currentController = ucwords($url[0]);
                    unset($url[0]);
                }
            }
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this ->currentController = new $this->currentController;

            if(isset($url[1]))
            {
                if(method_exists($this->currentController, $url[1]))
                {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }
            $this->params = $url ? array_values($url) : [];
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        /**
         * Construct URL From $_GET['url'],
         * puts the '/' at the end of url ,
         * and the function explode make this url as an array.
         */
        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);

                return $url;
            }
        }
    }