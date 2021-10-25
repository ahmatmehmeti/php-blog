<?php
    session_start();

    /**
     * Flash message helper.
     * If there is no message,create it.
     * If message exists,display it.
     */
    function flash($name = '', $message = '', $class = 'alert alert-success'){
        if(!empty($name)){
            if(!empty($message) && empty($_SESSION[$name])){
                if(!empty($_SESSION[$name])){
                    unset($_SESSION[$name]);
                }

                if(!empty($_SESSION[$name. '_class'])){
                    unset($_SESSION[$name. '_class']);
                }

                $_SESSION[$name] = $message;
                $_SESSION[$name. '_class'] = $class;
            } elseif(empty($message) && !empty($_SESSION[$name])){
                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
                echo '<div class="'.$class.'" id="msg-flash">'.$_SESSION[$name].'</div>';
                unset($_SESSION[$name]);
                unset($_SESSION[$name. '_class']);
            }
        }
    }

    /**
     * @return bool
     * Check is user is logged in.
     */
    function isLoggedIn()
    {
        if(isset($_SESSION['user_id'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @return bool
     * Check if user is Admin.
     */
    function isAdmin()
    {
        if($_SESSION['user_role'] == 'admin')
        {
            return true;
        }else{
            return false;
        }
    }