<?php


class Spot
{


    // get info about spot //
    public static function info($find_by, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $bet = $db->getOne(BETS, $find_by, $fields);

        ## return ##
        return $bet;
    }

    // save new spot //
    public static function reserve($data)
    {
        ## database ##
        global $db;
        ## database ##

        ## put and return ##
        return $db->put(BETS, $data);
        ## put and return ##

    }

    // filter bets //
    public static function filter($find_by, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $bets = $db->getMany(BETS, $find_by, $fields);

        ## return ##
        return $bets;
    }

    // is taken //
    public static function is_taken($type, $number, $spot)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $taken = $db->getOne(BETS, ['wheel_type' => $type, 'wheel_number' => $number, 'wheel_spot' => $spot]);
        ## return ##

        return ($taken ? true : false);
    }

    // does bet exist //
    public static function exists($bet, $spot = null, $number = null, $type = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## params ##
        $params = ['id' => $bet];
        !is_null($type)   ? $params['wheel_type']   = $type   : null;
        !is_null($number) ? $params['wheel_number'] = $number : null;
        !is_null($spot)   ? $params['wheel_spot']   = $spot   : null;

        ## fetch ##
        $bet = $db->getOne(BETS, ['id' => $bet], $params);

        ## return ##
        return ($bet) ? true : false;
    }


    // get a free spot on a draw and a wheel number //
    public static function free($type, $number)
    {
        ## get a spot ##
        for ($i = 0; $i < 10; $i++) {

            ## debug 
            // echo "+ Checking Spot [{$i}] on  Wheel ({$number}) of [{$type}]...";

            ## return if not taken ##
            if (!Spot::is_taken($type, $number, $i)) {

                // echo "FREE.\n";
                return $i;
            } else {
                // echo "\n";
            };
            ## return if not taken ##
        }

        // die();
        return false;
    }


    // collect all bets //
    public static function collect()
    {
        ## database ##
        global $db;
        ## database ##

        ## all bets ##
        $all = $db->getMany(BETS, null, ['id', 'user_id', 'cid', 'wheel_type', 'wheel_number', 'wheel_spot', 'choice', 'paid']);
        return [
            'count' => $db->count,
            'bets' => $all,
        ];
    }

    // get bets count //
    public static function count()
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $db->getMany(BETS, null, ['id']);
        ## fetch ##

        ## return ##
        return $db->count;
        ## return ##

    }

    // move a bet to a new [type => wheel => spot] //
    public static function move($id, $type, $number, $spot)
    {
        ## database ##
        global $db;
        ## database ##

        ## check ##
        if (Spot::is_taken($type, $number, $spot)) return false;

        ## patch ##
        return $db->patch(BETS, ['id' => $id], ['wheel_type' => $type, 'wheel_number' => $number, 'wheel_spot' => $spot]);
        ## patch ##
    }

    // remove a bet //
    public static function remove($bet, $spot = null, $number = null, $type = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## params ##
        $params = ['id' => $bet];
        !is_null($type)   ? $params['wheel_type']   = $type   : null;
        !is_null($number) ? $params['wheel_number'] = $number : null;
        !is_null($spot)   ? $params['wheel_spot']   = $spot   : null;

        ## remove ##
        return $db->revoke(BETS, $params);
    }

    // truncate all //
    public static function truncate()
    {
        ## database ##
        global $db;
        ## database ##

        ## truncate and return ##
        return $db->empty(BETS);
    }
}
