<?php


class Number
{

    // reset all numbers to null
    public static function reset()
    {
        ## database ##
        global $db;
        ## database ##

        ## truncate and return ##
        return $db->query("UPDATE `numbers` SET number = null");
    }

    // set number value //
    public static function fill($id, $value)
    {
        ## database ##
        global $db;
        ## database ##

        ## store ##
        return $db->patch(NUMBERS, ['id' => $id], ['number' => $value]);
        ## store ##
    }
}
