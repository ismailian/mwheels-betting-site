<?php

class Wheel
{

    // get all wheels //
    public static function all($params = null, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        return $db->getMany(WHEELS, $params, $fields);
        ## fetch ##
    }


    // check if wheel is full //
    public static function is_full($type, $number)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $db->getMany(BETS, ['wheel_type' => $type, 'wheel_number' => $number], ['id']);
        ## fetch ##

        ## return ##
        return ($db->count === 10) ? true : false;
        ## return ##
    }


    // get count //
    public static function count($params = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $db->getMany(WHEELS, $params, ['id']);
        return $db->count;
        ## fetch ##
    }

    // check if wheel of a specific type exists //
    public static function exists($type, $number)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $wheel = $db->getOne(WHEELS, ['type_id' => $type, 'wheel_number' => $number], ['id']);
        ## fetch ##

        ## return ##
        return ($wheel) ? true : false;
        ## return ##
    }


    // register new wheel //
    public static function register($type, $number)
    {
        ## database ##
        global $db;
        ## database ##

        ## store and return ##
        return $db->put(WHEELS, ['type_id' => $type, 'wheel_number' => $number]);
        ## store and return ##
    }

    // reset wheel to default state //
    public static function reset()
    {
        ## database ##
        global $db;
        ## database ##

        ## truncate table ##
        $db->empty(WHEELS);
        ## truncate table ##

        ## restore type N.01 ##
        Wheel::register(1, "A1");
        Wheel::register(1, "A2");
        Wheel::register(1, "A3");
        Wheel::register(1, "A4");
        Wheel::register(1, "A5");
        Wheel::register(1, "A6");
        Wheel::register(1, "A7");

        ## restore type N.02 ##
        Wheel::register(2, "A1");
        Wheel::register(2, "A2");
        Wheel::register(2, "A3");
        Wheel::register(2, "A4");
        Wheel::register(2, "A5");
        Wheel::register(2, "A6");
        Wheel::register(2, "A7");

        ## restore type N.03 ##
        Wheel::register(3, "A1");
        Wheel::register(3, "A2");
        Wheel::register(3, "A3");
        Wheel::register(3, "A4");
        Wheel::register(3, "A5");
        Wheel::register(3, "A6");
        Wheel::register(3, "A7");

        ## return ##
        return true;
        ## return ##

    }
}
