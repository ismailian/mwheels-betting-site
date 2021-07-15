<?php


// This class Fixes Arrays and Dispose Empty variables.
class Cleaner
{

    // Clearn Empty Entries in Arrays:
    public static function clean_array($input_array)
    {
        # clean_array
        return array_filter($input_array, function ($element) {

            return !empty($element); //

        });
        # clean_array
    }

    // array to string:
    public static function array2string($array, $delimeter = ",")
    {
        $output = "";
        foreach ($array as $item) {

            ## append ##
            $output .= $item . $delimeter;
            ## append ##

        }
        return substr($output, 0, strlen($output) - 1);
    }

    // get hightest count rank //
    public static function highest($array)
    {
        // code..
    }
}
