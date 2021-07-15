<?php

class Agent
{

    ## PROPERTIES ##
    private static $USERS = "users";
    ## PROPERTIES ##

    // Current User Relations //
    public static function all($fields = null)
    {

        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $fields = is_null($fields) ? ['id', 'username'] : $fields;
        $agents = $db->getMany(USERS, ['user_type' => 2], $fields);
        ## fetch ##

        return $agents;
    }

    // agent by id //
    public static function get($id, $fields = null, $include_admin = false)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $fields = is_null($fields) ? ['id', 'username'] : $fields;
        if ($include_admin) {
            $agent = $db->getOne(USERS, ['id' => $id], $fields);
        } else {
            $agent = $db->getOne(USERS, ['id' => $id, 'user_type' => 2], $fields);
        }

        ## fetch ##

        return $agent;
    }


    // get non-agent users //
    public static function unsigned()
    {

        ## fetch ##
        $users = User::all(['id', 'username', 'user_type']);
        $users = array_filter($users, function ($user) {

            ## filter ##
            return ($user)->user_type > 2;
            ## filter ##

        });
        ## fetch ##

        return $users;
    }

    // get group by agent id //
    public static function group($agent_id, $group_id = null, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fields ##
        $fields = is_null($fields) ? ['id', 'name'] : $fields;
        $params = is_null($group_id) ? ['agent_id' => $agent_id] : ['id' => $group_id, 'agent_id' => $agent_id];
        ## fields ##

        ## fetch ##
        $group = $db->getOne(GROUPS, $params, $fields);
        ## fetch ##

        return $group;
    }

    // check if agent is unsigned to a group //
    public static function is_unsigned($agent_id)
    {
        ## check ##
        if (!Agent::group($agent_id)) return true;
        ## check ##

        return false;
        ## is unsigned ##
    }

    // Get Agent Users //
    public static function users($agent_id)
    {
        ## get group
        $group = Agent::group($agent_id, null, ['id']);
        $group = ($group) ? ($group)->id : null;
        $users = [];

        if ($group) {

            $members = Group::members($group, $agent_id);
            foreach ($members as $member) {

                array_push($users, User::get($member->user_id, ['id', 'username', 'email', 'fullname', 'balance', 'user_type']));
            }
        }

        return $users;
    }
}
