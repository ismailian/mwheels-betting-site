<?php

class Uuid
{

    // uuid version 1.0 // 6-char id: #xxxxxx
    public static function v1()
    {
        ## return ##
        return strtoupper(bin2hex(random_bytes(3)));
        ## return ##
    }


    // uuid version 2.0 // 12-char id: #xxxxxxxxxxxx
    public static function v2()
    {
        ## return ##
        return strtoupper(bin2hex(random_bytes(4)));
        ## return ##
    }


    // uuid version 1.0 // 3-parts six-char id: #xxxxxx
    public static function v3()
    {
        ## parts ##
        $p01 = strtoupper(bin2hex(random_bytes(2)));
        $p02 = strtoupper(bin2hex(random_bytes(2)));
        $p03 = strtoupper(bin2hex(random_bytes(2)));
        ## parts ##

        ## return ##
        return ($p01 . "-" . $p02 . "-" . $p03);
        ## return ##
    }


    // uuid version 1.0 // 4-parts six-char id: #xxxxxx
    public static function v4()
    {
        ## parts ##
        $p01 = strtoupper(bin2hex(random_bytes(2)));
        $p02 = strtoupper(bin2hex(random_bytes(2)));
        $p03 = strtoupper(bin2hex(random_bytes(2)));
        $p04 = strtoupper(bin2hex(random_bytes(2)));
        ## parts ##

        ## return ##
        return ($p01 . "-" . $p02 . "-" . $p03 . "-" . $p04);
        ## return ##
    }
}
