<?php

class Router
{

    // Handles Get Method:
    public static function get($route, $view)
    {
        # get #
        if (Request::is_get($route)) {

            // check if view exists:
            if (Viewer::exists($view)) {

                # View #
                @Viewer::view($view);
                # View #

            }
        }
        # get #
    }

    // Handles Post Method:
    public static function post($route, $view)
    {
        # post #
        if (Request::is_post($route)) {

            // check if view exists:
            if (Viewer::exists($view)) {

                # View #
                @Viewer::view($view);
                # View #

            }
        }
        # post #
    }

    // Handles Unhandled Routes:
    public static function
    default($route, $view = null)
    {
        # default #
        if (!Viewer::exists($route)) {

            # view # 404 page
            @Viewer::view('errors/404', 404);
            # view # 404 page

        }
        # default #
    }
}



/**
 * Router.php
 * ==========
 * 
 * 
 * description:
 *      Router should handle the absolute url using request method as a static method in router
 *      and then forward that to Viewer accordingly. With proper checks of course.
 * 
 * 
 *  ex:
 *      -> Router::get('home',        'the_view_to_forward_to');
 *      -> Router::post('user/login', 'the_view_to_forward_to');
 *      -> Router::default('{name}',  'the_view_to_forward_to');
 */
