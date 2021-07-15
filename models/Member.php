<?php

class Member
{


    // get member info //
    public static function get($params, $fields = ['id'])
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        return $db->getOne(MEMBERS, $params, $fields);
        ## fetch ##
    }


    // get all members //
    public static function all($params, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        return $db->getMany(MEMBERS, $params, $fields);
        ## fetch ##
    }

    // add new member to a group //
    public static function add($group_id, $agent_id, $user_id)
    {
        ## database ##
        global $db;
        ## database ##

        ## store and return ##
        return $db->put(MEMBERS, ['group_id' => $group_id, 'agent_id' => $agent_id, 'user_id' => $user_id]);
        ## store and return ##
    }

    // move members from one group to another //
    public static function move($source, $member = null, $destination)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $agent = Group::agent($destination, null, ['id']);
        ## fetch ##

        if (is_null($member)) {

            $multiple = $db->patch(MEMBERS, [
                'group_id' => ($source)
            ], [
                'group_id' => ($destination),
                'agent_id' => ($agent)->id
            ]);

            return $multiple;
        }

        $single = $db->patch(MEMBERS, [
            'group_id' => ($source),
            'user_id' => ($member)
        ], [
            'group_id' => ($destination),
            'agent_id' => ($agent)->id
        ]);

        return $single;
    }

    // remove a member from a group //
    public static function remove($member_id, $group_id = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## params ##
        $params = !is_null($group_id) ? ['group_id' => $group_id, 'user_id' => $member_id] : ['user_id' => $member_id];

        ## remove and return ##
        return $db->revoke(MEMBERS, $params);
    }
}
