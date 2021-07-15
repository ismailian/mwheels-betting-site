<?php

/*
* This class handles logout requests.
*/

class Fetch
{

    public static function Start()
    {

        # fetch users #
        if (Request::query_has('fetch_users')) Fetch::fetch_users();
        # fetch users #

        # fetch available users #
        if (Request::query_has('fetch_available_users')) Fetch::fetch_available_users();
        # fetch available users #

        # fetch agents #
        if (Request::query_has('fetch_agents')) Fetch::fetch_agents();
        # fetch agents #

        ## fetch unsigned agnets ##
        if (Request::query_has('fetch_available_agents')) Fetch::fetch_available_agents();
        ## fetch unsigned agnets ##

        # fetch signed groups #
        if (Request::query_has('fetch_groups')) Fetch::fetch_groups();
        # fetch signed groups #

        # fetch groups #
        if (Request::query_has('fetch_all_groups')) Fetch::fetch_all_groups();
        # fetch groups #

        # fetch group info #
        if (Request::query_has('fetch_group_info')) Fetch::fetch_group_info();
        # fetch group info #

        # fetch unsigned groups #
        if (Request::query_has('fetch_available_groups')) Fetch::fetch_available_groups();
        # fetch unsigned groups #

        # fetch unsigned groups #
        if (Request::query_has('fetch_auditlogs')) Fetch::fetch_auditlogs();
        # fetch unsigned groups #

        ## fetch played bets ##
        if (Request::query_has('fetch_played_spots')) Fetch::fetch_played_spots();
        ## fetch played bets ##

        ## fetch mode info ##
        if (Request::query_has('fetch_mode')) Fetch::fetch_mode();
        ## fetch mode info ## 

        ## fetch pages info ##
        if (Request::query_has('fetch_pages_info')) Fetch::fetch_pages_info();
        ## fetch pages info ## 

        ## fetch admin info ##
        if (Request::query_has('fetch_admin_info')) Fetch::fetch_admin_info();
        ## fetch admin info ## 

        ## fetch credit logs ## 
        if (Request::query_has('fetch_creditlogs')) Fetch::fetch_creditlogs();
        ## fetch credit logs ## 

        ## fetch winners ## 
        if (Request::query_has('fetch_winners')) Fetch::fetch_winners();
        ## fetch winners ## 

        ## fetch wheels ##
        if (Request::query_has('fetch_wheels')) Fetch::fetch_wheels();
        ## fetch wheels ##

        ## fetch archive ##
        if (Request::query_has('fetch_archives')) Fetch::fetch_archives();
        ## fetch archive ##
    }

    // user Logout 
    private static function fetch_users()
    {

        ## fetch users ##
        if (Request::is_get() && Request::query_has('fetch_users')) {

            ## authentication ##
            Action::permit(["admin", "agent"]);
            ## authentication ##

            ## output ##                
            $tmp_users = [];
            ## output ##                

            ## Admin || Agent  ##
            if (Sessioneer::user_role() === "admin") {

                ## all users ## 
                $tmp_users = User::all(['id', 'username', 'email', 'fullname', 'balance', 'credit', 'user_type']);
            }

            if (Sessioneer::user_role() === "agent") {

                ## all users ## 
                $tmp_users = Agent::users(Sessioneer::user()->id);
            }



            $users = [];

            foreach ($tmp_users as $user) {

                if ($user) {
                    // add role
                    $user->user_type = $user->user_type < 3 ? 'AGENT' : 'USER';

                    // determine cluster
                    $uid = $user->id;
                    $cluster = Member::get(['user_id' => $uid], ['group_id', 'agent_id']);

                    if ($cluster) {

                        $group = Group::get($cluster->group_id, ['name']);
                        $agent = Agent::get($cluster->agent_id, ['username']);

                        if ($group && $agent) {

                            $user->group = strtoupper($group->name);
                            $user->agent = strtoupper($agent->username);
                        }
                    }
                    //

                    // conciel:
                    $user->password = "HIDDEN";

                    // append //
                    array_push($users, $user);
                }
            }

            ## return ##
            Response::json('success', [
                'users' => $users,
            ]);
            ## return ##

        }
        ## fetch users ##
    }

    // fetch available users //
    private static function fetch_available_users()
    {
        ## fetch users ##
        if (Request::is_get() && Request::query_has('fetch_available_users')) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            $av_users = User::available();

            ## return ##
            Response::json('success', [
                'users' => $av_users,
            ]);
            ## return ##

        }
        ## fetch users ##
    }

    // fetch agent //
    private static function fetch_agents()
    {

        ## fetch users ##
        if (Request::is_get() && Request::query_has('fetch_agents')) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            $agents = Agent::all(['id', 'username', 'email', 'balance', 'credit']);

            foreach ($agents as $agent) {

                $group = Agent::group($agent->id);

                if ($group) {

                    ## fill ##
                    ($agent)->group = strtoupper(($group)->name);
                    ($agent)->members = Group::members_count($group->id);
                    ## fill ##

                } else {

                    ($agent)->group = "N/A";
                    ($agent)->members = "N/A";
                }
            }

            ## return ##
            Response::json('success', ['agents' => $agents]);
            ## return ##

        }
        ## fetch users ##
    }

    // fetch available agents //
    private static function fetch_available_agents()
    {
        if (Request::query_has("fetch_available_agents")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            $agents = Agent::all();
            $available = [];

            foreach ($agents as $agent) {
                ##
                if (Agent::is_unsigned($agent->id)) {

                    array_push($available, [
                        'id'       => ($agent)->id,
                        'username' => strtoupper(($agent)->username),
                    ]);
                }
                ##
            }

            ## response ##
            Response::json("success", ['agents' => $available]);
            ## response ##
        }
    }

    // fetch group info //
    private static function fetch_group_info()
    {

        ## fetch group info ##
        if (Request::is_get() && Request::query_has('fetch_group_info')) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## input ##
            $group_name = strtolower(Sanitizer::get_string('name'));
            ## input ##

            ## fetch ## 
            $group = Group::getByName($group_name);
            ## fetch ## 

            // group exists.
            if ($group) {

                ($group)->agent_id = empty($group->agent_id) ? null : ($group)->agent_id;

                Response::json('success', [
                    'group' => [
                        'id'           => ($group)->id,
                        'name'         => (strtoupper(($group)->name)),
                        'admin_id'     => ($group)->agent_id,
                        'member_count' => Group::members_count($group->id),
                    ]
                ]);
            }

            ## error ##
            Response::json('error', [
                'info' => "Group Not Found!",
            ]);
            ## error ##
        }
        ## fetch group info ##
    }

    // fetch available groups //
    private static function fetch_available_groups()
    {
        ## fetch available groups ##
        if (Request::query_has("fetch_available_groups")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $groups = Group::unsigned();
            ## fetch ##

            ## response ##
            Response::json('success', ['groups' => $groups]);
            ## response ##

        }
        ## fetch available groups ##
    }

    // fetch groups //
    private static function fetch_groups()
    {
        ## fetch available groups ##
        if (Request::is_get() && Request::query_has("fetch_groups")) {

            ## authentication ##
            Action::permit(["admin", "agent"]);
            ## authentication ##

            $groups = [];

            ## admin 
            if (Sessioneer::user_role() === "admin") {
                ## fetch ##
                $groups = Group::signed();
                ## fetch ##
            }

            ## agent
            if (Sessioneer::user_role() === "agent") {
                ## fetch ##
                array_push($groups, Agent::group(Sessioneer::user()->id));
                ## fetch ##
            }

            ## response ##
            Response::json('success', ['groups' => $groups]);
            ## response ##

        }
        ## fetch available groups ##
    }

    // fetch all groups //
    private static function fetch_all_groups()
    {
        ## fetch available groups ##
        if (Request::is_get() && Request::query_has("fetch_all_groups")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $all_groups = Group::all(['id', 'name', 'count_limit']);

            $groups = [];
            foreach ($all_groups as $group) {

                $agent = Group::agent($group->id, null, ['username']);
                $agent = ($agent) ? ($agent)->username : "N/A";

                array_push($groups, [
                    'id'      => ($group)->id,
                    'name'    => ($group)->name,
                    'agent'   => $agent,
                    'limit'   => ($group)->count_limit,
                    'members' => (Group::members_count($group->id))
                ]);
            }
            ## fetch ##

            ## response ##
            Response::json('success', ['groups' => $groups]);
            ## response ##

        }
        ## fetch available groups ##
    }

    // fetch auditlogs //
    private static function fetch_auditlogs()
    {

        ## database ##
        global $db;
        ## database ##

        if (Request::query_has("fetch_auditlogs")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $logs = $db->getMany(BETS, ['seen' => false], [
                'id', 'cid', 'user_id', 'wheel_type', 'wheel_number', 'wheel_spot', 'choice', 'paid', 'updated_at'
            ]);

            ## audit logs ##
            $auditlogs = [];

            foreach ($logs as $log) {

                // check user first 
                if ($user = User::get($log->user_id, ['username'])) {

                    array_push($auditlogs, [
                        'id'           => $log->id,
                        'cid'          => $log->cid,
                        'username'     => $user->username,
                        'wheel_type'   => $log->wheel_type,
                        'wheel_number' => $log->wheel_number,
                        'wheel_spot'   => $log->wheel_spot,
                        'choice'       => $log->choice,
                        'paid'         => $log->paid,
                        'date'         => (new DateTime($log->updated_at))->format('M d, Y H:i'),
                    ]);
                }
            }

            ## response ##
            Response::json("success", ['auditlogs' => $auditlogs]);
            ## response ##

        }
    }

    // fetch played spots //
    private static function fetch_played_spots()
    {

        if (Request::query_has("fetch_played_spots")) {

            ## authentication ##
            Action::permit(["admin", "agent", "user"]);
            ## authentication ##

            ## input ##
            $type = Sanitizer::get_string('type');
            ## input ##


            ## check ##
            if (empty($type)) Response::default_error("Type is required.");
            ## check ##

            ## fetch ##
            $played_spots = Spot::filter(['wheel_type' => $type], ['wheel_number', 'wheel_spot']);
            $count = count($played_spots);
            ## fetch ##

            ## return ##
            Response::json("success", [
                "info"  => "Found {$count} Spot(s).",
                "spots" => $played_spots,
            ]);
            ## return ##

        }
    }

    // fetch mode //
    private static function fetch_mode()
    {

        if (Request::query_has("fetch_mode")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $info = Settings::info(['status', 'mode', 'text']);
            ## fetch ##

            ## placeholders ##
            $status = $info->status;
            $mode = 0;
            $text = $info->text;
            ## placeholders ##

            ## set ##
            if ($info->mode === "play") $mode = 1;
            if ($info->mode === "hold") $mode = 2;
            ## set ##

            ## repsonse ##
            Response::json("success", ['condition' => $status, 'mode' => $mode, 'text' => $text]);
            ## repsonse ##

        }
    }

    // fetch pages info //
    private static function fetch_pages_info()
    {
        if (Request::query_has("fetch_pages_info")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $page01 = Type::info(1, ['id', 'type', 'name', 'odds', 'prize', 'amount', 'allowed']);
            $page02 = Type::info(2, ['id', 'type', 'name', 'odds', 'prize', 'amount', 'allowed']);
            $page03 = Type::info(3, ['id', 'type', 'name', 'odds', 'prize', 'amount', 'allowed']);
            $page04 = Type::info(4, ['id', 'type', 'name', 'odds', 'prize', 'amount', 'allowed']);
            $page05 = Type::info(5, ['id', 'type', 'name', 'odds', 'prize', 'amount', 'allowed']);
            $page06 = Type::info(6, ['id', 'type', 'name', 'odds', 'prize', 'amount', 'allowed']);
            ## fetch ##

            Response::json("success", [
                "pages" => [$page01, $page02, $page03, $page04, $page05, $page06],
            ]);
        }
    }

    // fetch admin info //
    private static function fetch_admin_info()
    {
        if (Request::query_has("fetch_admin_info")) {

            ## database ##
            global $db;
            ## database ##

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $admin = $db->getOne(USERS, ['id' => 1, 'user_type' => 1], ['username', 'email', 'balance']);
            $site  = Settings::info(['sitename']);
            ## fetch ##

            Response::json("success", [
                "admin" => $admin,
                "site"  => $site,
            ]);
        }
    }

    // fetch credit logs //
    private static function fetch_creditlogs()
    {
        if (Request::query_has("fetch_creditlogs")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $creditlogs = Credit::all(['id', 'user_id', 'agent_id', 'amount', 'created_at']);
            ## fetch ##

            ## fix ##
            foreach ($creditlogs as $creditlog) {

                ## agent ##
                $agent = Agent::get($creditlog->agent_id, ['username'], true);
                $agent = ($agent) ? $agent->username : "N/A";
                ($creditlog)->by = strtoupper($agent);

                ## user ##
                $user = User::get($creditlog->user_id, ['username']);
                $user = ($user) ? $user->username : "N/A";
                ($creditlog)->username = $user;

                ## credit ##
                ($creditlog)->received = ($creditlog)->amount;

                ## date ##
                ($creditlog)->on = (new DateTime(($creditlog)->created_at))->format("d M, Y");

                unset($creditlog->agent_id);
                unset($creditlog->user_id);
                unset($creditlog->amount);
                unset($creditlog->created_at);
            }
            ## fix ##

            ## response ##
            Response::json("success", ["creditlogs" => $creditlogs]);
            ## response ##

        }
    }

    // fetch all winners //
    private static function fetch_winners()
    {
        if (Request::query_has("fetch_winners")) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## fetch ##
            $winners = Winner::all();
            ## fetch ##

            ## fix ##
            foreach ($winners as $winner) {

                ## user ##
                $user = User::get($winner->user_id, ['username']);
                $user = ($user) ? $user->username : "N/A";
                ($winner)->username = $user;

                ## number ##
                ($winner)->number = ($winner)->wheel_number;

                ## spot ##
                ($winner)->spot = ($winner)->wheel_spot;

                ## date ##
                ($winner)->on = (new DateTime(($winner)->created_at))->format("M d, Y H:i");

                ## unset ##
                unset($winner->user_id);
                unset($winner->wheel_number);
                unset($winner->wheel_spot);
                unset($winner->created_at);
            }
            ## fix ##

            ## response ##
            Response::json("success", ["winners" => $winners]);
            ## response ##

        }
    }

    // fetch wheels //
    private static function fetch_wheels()
    {
        if (Request::query_has("fetch_wheels")) {

            ## authentication ##
            Action::permit(["admin", "agent", "user"]);
            ## authentication ##

            ## input ##
            $type = Sanitizer::get_integer('type');
            ## input ##

            ## filter ##
            if (is_null($type) or !is_numeric($type)) Response::default_error();
            ## filter ##

            ## fetch ##
            $wheels = Wheel::all(['type_id' => $type], ['id' => 'type_id', 'wheel_number']);

            foreach ($wheels as $wheel) {

                ## fetch taken spots (if any) ##
                $played_spots = Spot::filter(['wheel_type' => $type, 'wheel_number' => $wheel->wheel_number], ['wheel_spot']);
                ## fetch taken spots (if any) ##

                ## append to object ##
                $wheel->taken_spots = $played_spots;
                ## append to object ##

                ## check if full ##
                $wheel->is_full = Wheel::is_full($type, $wheel->wheel_number);
                ## check if full ##

            }
            ## fetch ##

            ## response ##
            Response::json("success", [
                'wheels' => $wheels,
            ]);
            ## response ##

        }
    }

    // fetch archives //
    private static function fetch_archives()
    {
        if (Request::query_has('fetch_archives')) {

            ## authentication ##
            Action::permit("admin");
            ## authentication ##

            ## archives ##
            $archives = Archive::all();
            ## archives ##

            ## response ##
            Response::json('success', ['archives' => $archives]);
            ## response ##

        }
    }
}
