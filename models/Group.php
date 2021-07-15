<?php

class Group
{

    // groups //
    public static function all($fields = null)
    {

        ## database ##
        global $db;
        ## database ##

        ## params ##
        $params = is_null($fields) ? ['id', 'agent_id', 'name'] : $fields;
        ## params ##

        ## fetch ##
        $groups = $db->getMany(GROUPS, null, $params);
        if ($groups) {

            foreach ($groups as $group) {

                $group->name = strtoupper($group->name);
            }
        }
        return $groups;
        ## fetch ##
    }


    // get only groups with agents //
    public static function signed()
    {
        ## fetch ##
        $all_groups = Group::all();
        $groups = [];
        ## fetch ##

        ## filter ##
        foreach ($all_groups as $group) {

            ## ##
            if (!empty($group->agent_id)) array_push($groups, $group);
            ## ##

        }
        ## filter ##

        return $groups;
    }

    // group by id //
    public static function get($id, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $group = $db->getOne(GROUPS, ['id' => $id], $fields);
        ## fetch ##

        return $group;
    }


    // get group by name:
    public static function getByName($name, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $group = $db->getOne(GROUPS, ['name' => $name], $fields);
        ## fetch ##

        return $group;
    }

    // get unmanaged groups //
    public static function unsigned()
    {

        ## fetch ##
        $groups = Group::all(['id', 'name', 'agent_id']);
        $groups = array_filter($groups, function ($group) {

            ## filter ##
            return empty(($group)->agent_id);
            ## filter ##

        });
        ## fetch ##

        return $groups;
    }

    // get group members //
    public static function member($group_id = null, $user_id = null, $fields = null)
    {
        ## params ##
        $params = [];
        !is_null($group_id) ? $params['group_id'] = ($group_id) : null;
        !is_null($user_id)  ? $params['user_id']  = ($user_id)  : null;
        ## params ##

        ## fetch ##
        $member = Member::get($params, $fields);
        ## fetch ##

        return $member;
    }

    // get group members:
    public static function members($id, $agent_id = null, $fields = null)
    {
        ## params
        $params = is_null($agent_id) ? ['group_id' => $id] : ['group_id' => $id, 'agent_id' => $agent_id];
        $fields = is_null($fields) ? ['user_id'] : $fields;
        ## params

        ## fetch ##
        $members101 = Member::all($params, $fields);
        $members102 = [];
        foreach ($members101 as $member) {
            ##
            if (User::get($member->user_id)) array_push($members102, $member);
            ##
        }
        ## fetch ##

        return $members102;
    }

    // get group members:
    public static function members_count($id)
    {
        return count(Group::members($id));
    }

    // get group admin/agent:
    public static function agent($group_id, $agent_id = null, $fields = null)
    {
        ## database ##
        global $db;
        ## database ##

        ## params ##
        $params = is_null($agent_id) ? ['id' => $group_id] : ['id' => $group_id, 'agent_id' => $agent_id];
        $fields = is_null($fields) ? ['id', 'username'] : $fields;
        ## params ##

        ## fetch ##
        $group = $db->getOne(GROUPS, $params, ['agent_id']);

        if ($group) {

            ## fetch ##
            $agent = Agent::get($group->agent_id, $fields);
            ## fetch ##

            return $agent;
        }
        ## fetch ##

        return null;
    }


    // check if groups is unsigned //
    public static function is_unsigned($group_id)
    {
        ## is unsigned ##
        $unsigned_groups =  Group::unsigned();
        foreach ($unsigned_groups as $unsigned_group) {

            ## check ##
            if ((int)($unsigned_group)->id === (int)$group_id) return true;
            ## check ##
        }

        return false;
        ## is unsigned ##
    }

    // remove group by id //
    public static function remove($group_id)
    {
        ## database ##
        global $db;
        ## database ##

        ## remove ##
        return $db->revoke(GROUPS, ['id' => $group_id]);
        ## remove ##
    }

    // release a single member by user_id //
    private static function remove_member($user_id)
    {
        ## remove ##
        return Member::remove($user_id);
        ## remove ##
    }

    // release all group member by id //
    public static function release($group_id, $release_group = true, $release_members = true)
    {
        ## database ##
        global $db;
        ## database ##

        ## fetch ##
        $members = Group::members($group_id);
        ## fetch ##

        if ($release_members) {
            foreach ($members as $member) {
                ## release ##
                Group::remove_member($member->user_id);
                ## release ##
            }
        }

        if ($release_group) {
            # release group from agent ##
            $db->patch(GROUPS, ['id' => $group_id], ['agent_id' => 0]);
            # release group from agent ##
        }

        return true;
    }
}
