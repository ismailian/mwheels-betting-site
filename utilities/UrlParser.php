<?php

class UrlParser
{

    // get absolute path:
    public static function absolutePath()
    {
        # absolutePath #
        $REDIRECT_URL = !empty(Server::header('REDIRECT_URL')) ? Server::header('REDIRECT_URL') : Server::header('SCRIPT_NAME');
        $REDIRECT_URL = substr($REDIRECT_URL, 1);
        return explode('/', $REDIRECT_URL)[0];
        # absolutePath #
    }

    // check if it has certain element:
    public static function has($input)
    {
        # has #
        if (preg_match("/({$input})/", UrlParser::absolutePath(), $match) === 1) {

            return true;
        }
        return false;
        # has #
    }

    // return all segments of request uri in array:
    public static function segments()
    {
        # segments #
        $REDIRECT_URL = !empty(Server::header('REDIRECT_URL')) ? Server::header('REDIRECT_URL') : Server::header('SCRIPT_NAME');
        $REDIRECT_URL = substr($REDIRECT_URL, 1);
        return Cleaner::clean_array(explode('/', $REDIRECT_URL));
        # segments #
    }
}



/**
 * 
 * UrlParser.php
 * =============
 *  * 
 * description:
 *      This class handles url parsing and data extraction (method, path, query, body..etc.)
 *      
 * ex:
 *      -> UrlParser::absolutePath();
 *      -> UrlParser::segments();
 *      -> UrlParser::has_uri();
 * 
 */
