<?php

/*
* This class handles create requests.
*/

class Create
{

  public static function Start()
  {

    # user login #
    if (Request::post_has('create_user')) Create::user_create();
    # user login #

    ## agent create ##
    if (Request::post_has('create_agent')) Create::agent_create();
    ## agent create ##

    ## create group ##
    if (Request::post_has('create_group')) Create::group_create();
    ## create group ##

    ## Bet Create ##
    if (Request::post_has('push_betting')) Create::bet_push();
    ## Bet Create ##

  }


  // create user //
  private static function user_create()
  {

    ## database ##
    global $db;
    ## database ##

    ## user_create ##
    if (Request::post_has('create_user')) {

      ## Not authorized ##
      Action::permit(["admin", "agent"]);
      ## Not authorized ##

      ## user input ##
      $email    = Sanitizer::post_email('email');
      $username = Sanitizer::post_username('username');
      $password = Sanitizer::post_password('password');
      $balance  = Sanitizer::post_float('credit');
      $group    = Sanitizer::post_integer('group');
      ## user input ##

      ## hash password
      $password = Hash::make($password);
      ## hash password

      ## filter ##
      $data = [];
      !empty($email)    ? $data['email']    = $email    : Response::default_error("Email is required!");
      !empty($username) ? $data['username'] = $username : Response::default_error("Username is required!");
      !empty($password) ? $data['password'] = $password : Response::default_error("Password is required!");
      !empty($balance)  ? $data['balance']  = $balance  : null;
      ## filter ##

      ## store ##
      if (!User::add($data)) Response::default_error();
      ## store ##

      ## admin
      if (Sessioneer::user_role() === "admin") {

        // check if agent has a group //
        if (!Group::is_unsigned($group)) {

          ## fetch ## 
          $agent_id = Group::get($group, ['agent_id'])->agent_id;
          ## fetch ## 

          ## grab user ##
          $user = $db->getOne(USERS, ['username' => $username, 'email' => $email], ['id']);
          ## grab user ##

          ## add user to group.
          $membership = Member::add($group, $agent_id, ($user)->id);
          if (!$membership) Response::default_error();
          ## add user to group.

          ## response ##
          Response::json('success', ['info' => "User Created Successfully."]);
          ## response ##

        }
      }

      ## agent
      if (Sessioneer::user_role() === "agent") {

        // check if agent owns the group //
        if (!Group::is_unsigned($group)) {

          ## fetch ## 
          $agent = Group::agent($group, Sessioneer::user()->id, ['id']);
          $agent = ($agent) ? $agent->id : null;

          ## grab user ##
          $user = $db->getOne(USERS, ['username' => $username, 'email' => $email], ['id']);

          ## add user to group.
          $membership = Member::add($group, $agent, ($user)->id);
          if (!$membership) Response::default_error();

          ## response ##
          Response::json('success', ['info' => "User Created Successfully."]);
          ## response ##

        }
      }
      ## store ##
    }
    ## user_create ##

  }

  // create agent //
  public static function agent_create()
  {

    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("create_agent")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## user input ##
      $email    = Sanitizer::post_email('email');
      $username = Sanitizer::post_username('username');
      $password = Sanitizer::post_password('password');
      $balance  = Sanitizer::post_integer('credit');
      $group    = Sanitizer::post_integer('group');
      $users    = Sanitizer::post_array('users', FILTER_VALIDATE_INT);
      ## user input ##

      ## hash password
      $password = Hash::make($password);
      ## hash password

      ## filter ##
      $data = ['user_type' => 2];
      !empty($email)    ? $data['email']    = $email    : Response::default_error("Email is required!");
      !empty($username) ? $data['username'] = $username : Response::default_error("Username is required!");
      !empty($password) ? $data['password'] = $password : Response::default_error("Password is required!");
      !empty($balance)  ? $data['balance']  = $balance  : null;
      ## filter ##

      ## store as agent ##
      if (User::add($data)) {

        $group_check = Group::is_unsigned($group);

        ## grab user ##
        $user = $db->getOne(USERS, [
          'username' => $username,
          'email'    => $email
        ], ['id', 'email', 'username', 'balance']);
        ## grab user ##

        if ($group_check) { # if group actually exists and is not taken. 

          ## make agent an admin ##
          $db->patch(GROUPS, ['id' => $group, 'agent_id' => 0], ['agent_id' => ($user)->id]);
          ## make agent an admin ##

          // add the list of users to group.
          foreach ($users as $user_id) {

            ## check if memeber is in another group ##
            $member_exists = Group::member(null, $user_id);
            ## check if memeber is in another group ##

            if (!$member_exists) {

              ## add member ##
              Member::add($group, ($user)->id, $user_id);
            }
          }
        }

        ## fetch ##
        $group = Agent::group($user->id, $group, ['name']); //not complete.
        $group = ($group) ? ($group)->name : "N/A";
        ## fetch ##

        ## response ##
        Response::json('success', [
          'info'  => "Agent created Successfully.",
          'agent' => [
            'id'       => ($user)->id,
            'username' => ($user)->username,
            'email'    => ($user)->email,
            'credit'   => ($user)->balance,
            'group'    => ($group),
            'members'  => (Group::members_count($group)),
          ],
        ]);
        ## response ##

      }
      ## error response ##
      Response::default_error();
      ## error response ##
    }
  }
  // create agent //


  // Create new Group //
  private static function group_create()
  {

    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("create_group")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $name  = Sanitizer::post_string('name');
      $limit = Sanitizer::post_integer('limit');
      $agent = Sanitizer::post_integer('agent');
      ## input ##

      $data = [];

      ## filter ##
      !empty($name)  ? $data['name']        = $name  : Response::default_error("Name is required!");;
      !empty($limit) ? $data['count_limit'] = $limit : null;
      !empty($agent) ? $data['agent_id']    = $agent : null;
      ## filter ##

      ## store ##
      $result = $db->put(GROUPS, $data);
      if (!$result) Response::default_error();
      ## store ##

      ## response ##
      Response::json("success", ['info' => "Group created successfully.",]);
    }
  }

  // push bet //
  private static function bet_push()
  {

    ## database ##
    global $db;
    ## database ##

    ## bet_push ##
    if (Request::post_has("push_betting")) {

      ## authentication ##
      Action::permit(["admin", "agent", "user"]);
      ## authentication ##

      ## mode ##
      if (Settings::mode() === "pending") Response::default_error(
        "Betting is withheld at the moment.<br />Please wait for Winning Numbers to be published."
      );
      ## mode ##

      ## user input ## 
      $uid    = Sessioneer::user()->id;
      $type   = Sanitizer::post_integer('type');
      $number = Sanitizer::post_string('number');
      $spot   = Sanitizer::post_integer('spot');
      $choice = Sanitizer::post_string('choice');
      $date   = Sanitizer::post_string('date');
      ## user input ##

      ## check user ##
      if (!User::get($uid)) Response::default_error();
      ## check user ##

      ## check if wheel exists ##
      if (!Wheel::exists($type, $number)) Response::default_error();
      ## check if wheel exists ##

      ## check if Draw is allowed ##
      if (!Type::info($type, ['allowed'])->allowed) Response::default_error("Draw is Not Available.");
      ## check if Draw is allowed ##

      ## check if spot is not taken ##
      if (Spot::is_taken($type, $number, $spot)) Response::default_error("Sorry, This Spot is already taken.");
      ## check if spot is not taken ##

      ## check credit ##
      $balance   = (float) User::get($uid, ['balance'])->balance;
      $price     = (float) $db->getOne(TYPES, ['type' => $type], ['amount'])->amount;
      $remainder = (float) ($balance - $price);
      ## check credit ##

      ## confirmation ID ##
      $cid = ("#" . Uuid::v1());
      ## confirmation ID ##

      ## put in db ##
      Spot::reserve([
        'cid'          => $cid,
        'user_id'      => $uid,
        'wheel_type'   => $type,
        'wheel_number' => $number,
        'wheel_spot'   => $spot,
        'choice'       => $choice,
        'paid'         => $price,
        'updated_at'   => (new DateTime($date))->format('Y-m-d H:i:s'),
      ]);

      ## cut the fee ##
      $patch = $db->patch(USERS, ['id' => $uid], ['balance' => $remainder]);
      if (!$patch) Response::default_error("couldn't update your balance.");
      ## cut the fee ##

      ## is wheel full ##
      $wheel = null;
      if (Wheel::is_full($type, $number)) {

        ## compose new wheel ##
        $chars      = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $wheelChar  = strval($number[0]);
        $wheelIndex = intval($number[1]);

        if ($chars[strpos($chars, $wheelChar) + 1]) {

          ## create ##
          $newWheel = $chars[strpos($chars, $wheelChar) + 1] . $wheelIndex;
          Wheel::register($type, $newWheel);
          $wheel = $newWheel;
          ## create ##

        }
        ## compose new wheel ##
      }

      ## is wheel full ##

      ## response ##
      Response::json('success', [
        'info'    => ("<div><span>Your confirmation ID: <span class='text-success'>{$cid}</span></span><br/><br/><small class='label text-danger'>Please Save It.</small></div>"),
        'balance' => $remainder,
        'is_full' => Wheel::is_full($type, $number),
        'wheel'   => $wheel,
      ]);
      ## response ##

    }
    ## bet_push ##

  }
}
