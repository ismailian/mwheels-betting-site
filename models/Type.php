<?php


class Type
{


    // get Wheel Type info //
    public static function info($wheel_id, $fields = null)
    {

        ## database ##    
        global $db;
        ## database ##   

        ## params ##
        $params = ['id', 'type', 'prize', 'amount'];
        !is_null($fields) ? $params = $fields : null;
        ## params ##

        ## fetch ##
        $wheel = $db->getOne(TYPES, ['id' => $wheel_id], $params);
        ## fetch ##

        ## return ## 
        if ($wheel) {
            return $wheel;
        }
        return null;
        ## return ## 
    }

    // get draw info by whatever you have //
    public static function get($find_by, $fields = null)
    {
        ## database ##    
        global $db;
        ## database ##   

        ## params ##
        $params = ['id', 'type', 'prize', 'amount'];
        !is_null($fields) ? $params = $fields : null;
        ## params ##

        ## fetch ##
        $wheel = $db->getOne(TYPES, $find_by, $params);
        ## fetch ##

        ## return ## 
        if ($wheel) {
            return $wheel;
        }
        return null;
        ## return ## 
    }

    // check if wheel type exists //
    public static function exists($wheel_id)
    {
        ## database ##    
        global $db;
        ## database ##   

        ## fetch ##
        $wheel = $db->getOne(TYPES, ['id' => $wheel_id], ['id']);
        ## fetch ##

        ## return ##
        return ($wheel) ? true : false;
        ## return ##

    }

    // get players count on a wheel number of a draw //
    public static function players($type, $number)
    {
        ## database ##    
        global $db;
        ## database ##   

        ## fetch ##
        if (is_integer($number)) {

            ## query ##
            $db->query("SELECT id FROM `bets` WHERE `wheel_type` = {$type} AND `wheel_number` REGEXP '^[A-Z]{$number}$'");
            ## query ##

        }

        if (is_string($number)) {

            ## query ##
            $db->getMany(BETS, ['wheel_type' => $type, 'wheel_number' => $number], ['id']);
            ## query ##

        }
        ## fetch ##

        ## return ##
        return $db->count;
    }

    // get unfilled wheels //
    public static function unfilled($array, $count = 10)
    {
        ## remove filled up wheels ##
        foreach ($array as $key => $value) {

            ## remove ##
            if ($array[$key] === $count) unset($array[$key]);
            ## remove ##

        }
        ## remove filled up wheels ##

        ## return ##
        return $array;
    }

    // get highest wheel item //
    public static function highest($array)
    {
        ## unfilled ##
        $unfilled = Type::unfilled($array);
        ## unfilled ##

        ## sort Wheels by the bets ##
        array_multisort($unfilled, SORT_DESC);
        ## sort Wheels by the bets ##

        ## get highest ##
        return array_keys($unfilled)[0];
    }

    // re-order autofill bets //
    public static function reorder($type)
    {

        ## fetch ##
        $players = Spot::filter(
            ['wheel_type' => $type, 'choice' => 'autofill'],
            ['id', 'user_id', 'wheel_type', 'wheel_number', 'wheel_spot', 'choice', 'paid']
        );
        ## fetch ##

        ## collect each wheel's players count ##
        foreach (Wheel::all(['type_id' => $type]) as $wheel) {

            ## get players count ##
            $wheels[$wheel->wheel_number] = Type::players($type, $wheel->wheel_number);
            ## get players count ##

        }

        ## sort Wheels by the bets ##
        array_multisort($wheels, SORT_DESC);
        ## sort Wheels by the bets ##

        ## unfilled ##
        $wheels = Type::unfilled($wheels);
        ## unfilled ##

        ## placeholders ##
        $moves     = [];
        $autofills = [];
        ## placeholders ##

        foreach ($players as $bet) {

            ## declare worthy of move if alone on that wheel ## 
            if (Type::players($bet->wheel_type, $bet->wheel_number) === 1) {

                // push
                array_push($autofills, $bet);
                // push

                ## move bet to the hightest rank wheel count but not filled ##
                $wheel = Type::highest($wheels);
                $spot  = Spot::free($bet->wheel_type, $wheel);

                if (Spot::move($bet->id, $bet->wheel_type, $wheel, $spot)) {
                    array_push($moves, "User ({$bet->user_id}) was moved to Spot [{$spot}] on Wheel ({$wheel}) of Type ({$bet->wheel_type})");
                } else {
                    array_push($moves, "Couldn't moved User ({$bet->user_id}) to Spot [{$spot}] on Wheel ({$wheel}) of Type ({$bet->wheel_type})");
                }
                ## move bet to the hightest bets count but not filled ##

            }
        }

        ## return ##
        return [$autofills, $moves];
    }
}
