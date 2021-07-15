<?php


// This class handles Server Headers Parsing and dumping.

class Server
{

    // Dump Server Heaers:
    public static function headers($keysOnly = true)
    {
        // loop through the headers and dump them:
        header('Content-Type: application/json');
        foreach ($_SERVER as $key => $value) {

            if ($keysOnly) {

                if ($key !== 'PATH') {

                    echo $key . "\n"; //
                }
            } else {

                if ($key !== 'PATH') {

                    echo "{$key} => {$value}"  . "\n"; //
                }
            }
        }
    }

    // returns header value by name:
    public static function header($header_name)
    {
        return isset($_SERVER[$header_name]) ? $_SERVER[$header_name] : null;
    }
}


// info:
    # REQUEST_URI  => always_on
    # QUERY_STRING => only_if_exists