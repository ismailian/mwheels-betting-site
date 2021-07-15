<?php


class Viewer
{


    // Renders The View:
    public static function view($view_name, $status_code = 200)
    {
        # view #
        if (Viewer::exists($view_name)) {

            http_response_code($status_code);
            @include Viewer::match($view_name);
            // exit();
        }
        # view #
    }

    // Matches View To File:
    private static function match($view_name)
    {
        # match #
        if (file_exists(VIEWS . $view_name . ".php")) {
            return (VIEWS . $view_name . ".php");
        }
        return false;
        # match #
    }

    // Checks if View Exists:
    public static function exists($view_name)
    {
        # exists #
        return (file_exists(VIEWS . $view_name . ".php"));
        # exists #
    }
}




/**
 * Viewer.php
 * ==========
 * 
 * 
 * description:
 *      Viewer handles the rendering of the views as well as performing other checks.
 * 
 * 
 *  ex:
 *      -> Viewer::view('view_name');
 *      -> Viewer::exists('view_name');
 *      -> Viewer::match('view_name'); [private] (matches a view name to its equivalent filename.)
 */
