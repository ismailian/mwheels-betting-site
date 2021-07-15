<?php

class Settings
{

    // grab info //
    public static function info($fields = ['id', 'status'])
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $settings = $db->getOne(SETTINGS, ['id' => 1], $fields);
        ## fetch ##

        ## return ##
        return $settings;
    }

    // set mode //
    public static function mode($mode = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        if (!is_null($mode)) {
            // set new mode //
            $mode = $db->patch(SETTINGS, ['id' => 1], ['mode' => $mode]);
            // set new mode //
        } else {
            // grab current mode//
            $mode = $db->getOne(SETTINGS, ['id' => 1], ['mode'])->mode;
            // grab current mode//
        }
        ## fetch ##

        ## return ##
        return $mode;
    }

    // set sitename //
    public static function sitename($sitename = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        if (!is_null($sitename)) {
            //
            $sitename = $db->patch(SETTINGS, ['id' => 1], ['sitename' => $sitename]);
            //
        } else {
            //
            $sitename = $db->getOne(SETTINGS, ['id' => 1], ['sitename'])->sitename;
            //
        }
        ## fetch ##

        ## return ##
        return $sitename;
    }

    // set status //
    public static function status($status = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        if (!is_null($status)) {
            //
            $status = $db->patch(SETTINGS, ['id' => 1], ['status' => $status]);
            //
        } else {
            //
            $status = $db->getOne(SETTINGS, ['id' => 1], ['status'])->status;
            //
        }
        ## fetch ##

        ## return ##
        return $status;
    }

    // set text //
    public static function text($text = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        if (!is_null($text)) {
            //
            $text = $db->patch(SETTINGS, ['id' => 1], ['text' => $text]);
            //
        } else {
            //
            $text = $db->getOne(SETTINGS, ['id' => 1], ['text'])->text;
            //
        }
        ## fetch ##

        ## return ##
        return $text;
    }
}
