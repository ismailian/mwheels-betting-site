<?php


class Hash
{


    // hash make //
    public static function make($input)
    {
        ## make ##
        return password_hash($input, PASSWORD_ARGON2ID);
        ## make ##
    }
    // hash make //


    // verify hash //
    public static function verify($password, $hash)
    {
        ## verify ##
        return password_verify($password, $hash);
        ## verify ##
    }
    // verify hash //


}
