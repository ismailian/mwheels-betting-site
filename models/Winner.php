<?php

class Winner
{


    // truncate all winners //
    public static function truncate()
    {
        ## database ##
        global $db;
        ## database ##

        ## truncate and return ##
        return $db->empty(WINNERS);
    }

    // check if id with spot has won //
    public static function won($wheel,  $spot)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $check = $db->getOne(NUMBERS, ['wheel' => ("x" . $wheel[1]), 'number' => $spot]);

        ## return ##
        return ($check) ? true : false;
    }

    // add new winner //
    public static function add($data)
    {
        ## database ##
        global $db;
        ## database ##

        ## put ##
        return $db->put(WINNERS, $data);
        ## put ##

    }

    // reward all winers //
    public static function reward()
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $winners = $db->getMany(WINNERS, null, ['user_id', 'prize']);

        ## patch winners ##
        foreach ($winners as $winner) {

            ## patch ##
            $user_balance = $db->getOne(USERS, ['id' => $winner->user_id], ['balance'])->balance;
            $new_balance  = (float) ($user_balance + $winner->prize);
            $db->patch(USERS, ['id' => $winner->user_id], ['balance' => $new_balance]);
        }

        ## return ##
        return true;
    }

    // get all winning numbers //
    public static function number($wheel)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $number = $db->getOne(NUMBERS, ['wheel' => $wheel], ['number']);
        ## fetch ##

        return $number;
    }

    // get results date //
    public static function date()
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $date = null;
        !is_null((Winner::number("x1")->number)) ? $date = $db->getOne(NUMBERS, ['wheel' => "x1"], ['created_at']) : null;
        ## fetch ##

        ## return ##
        return !is_null($date) ? $date : "N/A";
        ## return ##

    }

    // get all winners from list //
    public static function all()
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $winners = $db->getMany(WINNERS, null, ['id', 'user_id', 'cid', 'wheel_number', 'wheel_spot', 'prize', 'created_at']);
        ## fetch ##

        return $winners;
    }

    // check if winner exsits //
    public static function exists($id)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $winner = $db->getOne(WINNERS, ['id' => $id]);
        ## fetch ##

        ## return ##
        return ($winner) ? true : false;
    }

    // remove a winner by id //
    public static function remove($id)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $remove = $db->revoke(WINNERS, ['id' => $id]);
        ## fetch ##

        ## return ##
        return ($remove);
    }
}
