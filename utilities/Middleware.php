<?php


// This class controls access to pages by user_role

class Middleware
{

    // allow access based on user_role:
    public static function allow($user_role)
    {
        ## allow ##
        if (!Sessioneer::user_role() === $user_role) {

            ## redirect ##
            Redirector::home();
            ## redirect ##
        }
        ## allow ##
        return;
    }

    // allow access based on auth level:
    public static function auth($route = null, $redirect_to = null, $required = true)
    {
        ## auth ##
        if (is_null($route)) {

            if (!Sessioneer::logged_in()) {

                ## redirect ##
                Redirector::home();
                ## redirect ##
            }
            return;
        }

        ## if route typeof array ## 
        if (is_array($route)) {

            if (Request::is_get($route) && !Sessioneer::logged_in() === $required) {

                ## redirect ##
                is_null($redirect_to) ? Redirector::home() : Redirector::route($redirect_to);
                ## redirect ##

            }
            return;
        }
        ## if route typeof array ## 

        if (Request::is_get($route) && !Sessioneer::logged_in() === $required) {

            ## redirect ##
            is_null($redirect_to) ? Redirector::home() : Redirector::route($redirect_to);
            ## redirect ##

        }
        return;
        ## auth ##
    }


    // allow access to a certain page based on terms:
    public static function access($route, $id, $value)
    {
        ## access ##
        if (is_array($value)) {

            if (Request::is_get($route) &&  array_search(Sessioneer::get($id), $value) === false) {

                ## redirect ##
                Redirector::home();
                ## redirect ##
            }
        } else {

            if (Request::is_get($route) &&  Sessioneer::get($id) !== $value) {

                ## redirect ##
                Redirector::home();
                ## redirect ##
            }
        }
        ## access ##
        return;
    }
}


/**
 * Middleware.php
 * --------------
 */
