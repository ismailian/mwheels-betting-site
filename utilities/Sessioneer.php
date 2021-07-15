<?php

class Sessioneer
{


    // setup the sessioneer
    public static function setup($session = null, $identifier = null)
    {
        ## keys ##
        $keys = [];
        ## keys ##

        if (!is_null($session) && is_array($session)) {

            foreach ($session as $sKey => $sValue) {

                if (!is_null($identifier) && $identifier === $sKey) {

                    # store identifier #
                    $_SESSION['identifier'] = $identifier;
                    # store identifier #
                }

                ## store session ##
                $_SESSION[$sKey] = $sValue;
                ## store session ##

                array_push($keys, $sKey); # store for later disposal.
            }

            ## store session ##
            $_SESSION['keys'] = $keys;
            ## store session ##
        }
    }

    // guest session
    public static function guest()
    {
        ## session ##
        if (!Sessioneer::logged_in()) {
            # setup #
            Sessioneer::setup(['user_role' => 'guest'], 'user_role');
            # setup #
        }
        ## session ##
    }

    // update an entry in the session:
    public static function update($input, $value)
    {

        ## update session ##
        $_SESSION[$input] = ($value);
        ## update session ##

    }

    // get value by key:
    public static function get($input_name)
    {
        ## get ##
        if (Sessioneer::has($input_name)) {
            return $_SESSION[$input_name];
        }
        return false;
        ## get ##
    }

    // refresh session
    public static function refresh()
    {

        ## refresh session ##
        session_regenerate_id();
        ## refresh session ##

    }

    // destroy session
    public static function destroy($input_name = null)
    {

        if (!is_null($input_name)) {

            ## release ##
            unset($_SESSION[$input_name]);
            ## release ##
            return;
        }

        ## release session ##
        session_unset();
        session_destroy();
        ## release session ##

        ## restore ##
        Sessioneer::setup(['user_role' => 'guest'], 'user_role');
        ## restore ##

    }


    // checks if session has an entry:
    public static function has($input_name)
    {
        ## check ##
        return isset($_SESSION[$input_name]);
        ## check ##
    }

    // dump all session input:
    public static function dump()
    {
        ## dump session ##
        echo json_encode($_SESSION);
        ## dump session ##
    }

    // get/set session input: 
    public static function __callStatic($name, $arguments)
    {
        ## dynamic property call ##
        if (Sessioneer::has($name)) {

            $content = $_SESSION[$name];

            ## is auto delete ##
            if (!empty($arguments) && $arguments[0] === true) {

                ## destroy ##
                Sessioneer::destroy($name);
                ## destroy ##
            }
            ## is auto delete ##
            return $content;
        }

        return false;
        ## dynamic property call ##
    }
}


# all the property names pertain to whatever you give to the construct
