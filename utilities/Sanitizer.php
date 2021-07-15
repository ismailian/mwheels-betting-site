<?php

/**
 * This Class is For sanitizing Inputs and Outputs:
 */

class Sanitizer
{

    // sanitize input with default settings:
    public static function sanitize($input)
    {

        return filter_var($input, FILTER_DEFAULT); //

    }

    // sanitize array:
    public static function array(array $input, $filter_type = null)
    {

        return filter_var_array($input, $filter_type); //

    }


    // sanitize string input:
    public static function string(String $input)
    {

        return filter_var($input, FILTER_SANITIZE_STRING); //

    }

    // sanitize integer input:
    public static function integer(int $input)
    {

        return filter_var($input, FILTER_SANITIZE_NUMBER_INT); //

    }

    // sanitize url input:
    public static function url(String $input)
    {

        return filter_var($input, FILTER_SANITIZE_URL); //

    }

    // sanitize email:
    public static function post_email($input_name)
    {
        return filter_input(INPUT_POST, $input_name, FILTER_VALIDATE_EMAIL);
    }

    // sanitize username:
    public static function post_username($input_name)
    {
        return filter_input(INPUT_POST, $input_name, FILTER_SANITIZE_STRING);
    }

    // sanitise password:
    public static function post_password($input_name)
    {
        return filter_input(INPUT_POST, $input_name, FILTER_SANITIZE_STRING);
    }

    // sanitize string:
    public static function post_string($input_name)
    {
        return filter_input(INPUT_POST, $input_name, FILTER_SANITIZE_ADD_SLASHES);
    }

    // snitize integer:
    public static function post_integer($input_name)
    {
        return filter_input(INPUT_POST, $input_name, FILTER_VALIDATE_INT);
    }

    // snitize integer:
    public static function post_float($input_name)
    {
        return filter_input(INPUT_POST, $input_name, FILTER_VALIDATE_FLOAT);
    }

    // validate array:
    public static function post_array($input_name, $filter_type)
    {
        if (isset($_POST[$input_name])) {
            $data = $_POST[$input_name];
            return filter_var_array($data, $filter_type);
        }
        return [];
    }

    // integer from get query
    public static function get_integer($input_name)
    {
        return filter_input(INPUT_GET, $input_name, FILTER_VALIDATE_INT);
    }

    // string from get query
    public static function get_string($input_name)
    {
        return filter_input(INPUT_GET, $input_name, FILTER_SANITIZE_ADD_SLASHES);
    }
}
