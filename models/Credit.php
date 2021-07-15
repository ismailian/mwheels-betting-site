<?php

class Credit
{

    // get user credit by id //
    public static function get($user_id, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## params ##
        $params = ['id', 'user_id', 'agent_id', 'credit'];
        !is_null($fields) ? $params = $fields : null;
        ## params ##

        ## fetch ##
        $credit = $db->getOne(CREDIT, ['user_id' => $user_id], $params);
        ## fetch ##

        ## return
        return $credit;
    }

    // get user credit by id //
    public static function all($fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## params ##
        $params = ['id', 'user_id', 'agent_id', 'amount'];
        !is_null($fields) ? $params = $fields : null;
        ## params ##

        ## fetch ##
        $credits = $db->getMany(CREDIT, null, $params);
        ## fetch ##

        ## return
        return $credits;
    }

    // check if credit exists by id //
    public static function exists($id)
    {
        ## database ##
        global $db;
        ## database ##

        ## check ##
        $credit = $db->getOne(CREDIT, ['id' => $id]);
        ## check ##

        ## return ##
        return ($credit) ? true : false;
    }

    // check if credit exists by id //
    public static function remove($id)
    {
        ## database ##
        global $db;
        ## database ##

        ## check ##
        $remove = $db->revoke(CREDIT, ['id' => $id]);
        ## check ##

        ## return ##
        return ($remove);
    }

    // log a newly added credit by admin and or agents //
    public static function log($user_id, $agent_id, $credit)
    {
        ## database ##
        global $db;
        ## database ##

        ## check ##
        $log = $db->put(CREDIT, [
            'user_id'  => $user_id,
            'agent_id' => $agent_id,
            'amount'   => $credit,
        ]);
        ## check ##

        ## return ##
        return ($log);
    }
}
