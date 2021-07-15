<?php

/**
 * Redirection Manager
 */
class Redirector
{

    // redirect strange requests to home page:
    public static function home()
    {
        ## home ##
        Request::clear();
        header("Location: /");
        return;
        ## home ##

    }

    // redirect somewhre else within public domain:
    public static function route(String $path)
    {
        ## route ##
        Request::clear();
        header(str_replace("_r_", $path, "Location: /_r_"));
        return;
        ## route ##
    }
}
