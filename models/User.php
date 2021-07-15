<?php

class User
{

    private static $find_by = "id";

    // Current User Relations //
    public static function __callStatic($name, $arguments)
    {

        ## database ##
        global $db;
        ## database ##

        ## check if user provides tables and info ##
        if (!empty($arguments)) {

            ## fetch using {arg[0] as table name}
            $db->dumpQuery = true;
            $data = $db->getOne($name, [User::$find_by => Sessioneer::user()->id], $arguments);
            return $data;
            ## fetch ##
        }

        return false;
        ## check if user provides tables and info ##
    }

    // Current User Relations //
    public static function all($fields = null)
    {

        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $fields = is_null($fields) ? ['id', 'username'] : $fields;
        $users = $db->getMany(USERS, ['user_type' => '2'], $fields, ['user_type' => '>']);
        ## fetch ##

        return $users;
    }

    // get all unmanaged users //
    public static function unsigned()
    {
        ## get users ##
        $users = User::all();

        $users = array_filter($users, function ($user) {

            return (Group::member(null, ($user)->id));
        });
        ## get users ##

        return $users;
    }

    // get users //
    public static function available()
    {
        ## get users ##
        $users    = User::all();
        $av_users = [];

        foreach ($users as $user) {

            ## push ##
            if (empty(Group::member(null, $user->id))) array_push($av_users, $user);
            ## push ##

        }
        ## get users ##

        return $av_users;
    }

    // get user by id :
    public static function get($id, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $user = $db->getOne(USERS, ['id' => $id], $fields);
        ## fetch ##

        return $user;
    }

    // Refund User //
    public static function refund($user_id, $amount)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $user_balance = (float) User::get($user_id, ['balance'])->balance;
        $credit = (float) ($user_balance + $amount);

        ## patch ##
        return $db->patch(USERS, ['id' => $user_id], ['balance' => $credit]);
    }

    // add new user //
    public static function add($data)
    {
        ## database ##
        global $db;
        ## database ##

        ## store & return ##
        return $db->put(USERS, $data);
        ## store & return ##

    }
}
