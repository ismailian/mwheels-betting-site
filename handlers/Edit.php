<?php

/*
* This class handles edit requests.
*/

class Update
{

  public static function Start()
  {

    ## group update ##
    if (Request::post_has('update_group')) Update::group_update();
    ## group update ##

    ## agent update ##
    if (Request::post_has('update_agent')) Update::agent_update();
    ## agent update ##

    ## user update ##
    if (Request::post_has('update_user')) Update::user_update();
    ## user update ##

    ## admin update ##
    if (Request::post_has('update_admin_account')) Update::admin_update();
    ## admin update ##

    ## page update ##
    if (Request::post_has("update_page")) Update::page_upate();
    ## page update ## 

    ## page update ##
    if (Request::post_has("update_homepage")) Update::update_homepage();
    ## page update ## 

  }

  // agent update //
  private static function agent_update()
  {

    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("update_agent")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## user input ##
      $agent    = Sanitizer::post_integer('id');
      $email    = Sanitizer::post_email('email');
      $password = Sanitizer::post_password('password');
      $balance  = Sanitizer::post_float('credit');
      $group    = Sanitizer::post_integer('group');
      $users    = Sanitizer::post_array('users', FILTER_VALIDATE_INT);
      ## user input ##

      ## placeholder ##
      $data = [];
      ## placeholder ##

      ## filter input ##
      !empty($email)     ? ($data['email']    = $email)    : null;
      !empty($password)  ? ($data['password'] = $password) : null;
      !is_nan($balance)  ? ($data['credit']   = $balance)  : null;
      ## filter input ##

      ## hash password ##
      isset($data['password']) ? $data['password'] = Hash::make($password) : null;
      ## hash password ##

      ## check if agent is being given a new credit ##
      if (isset($data['credit'])) {

        ## current balance ##
        $targetUser = Agent::get($agent, ['username', 'balance', 'credit']);

        ## calculus ##
        if ($data['credit'] > $targetUser->credit) {

          ## log in credit logs ##
          $addedCredit = (float)($data['credit'] - $targetUser->credit);
          $data['credit'] = (float) ($targetUser->credit + $addedCredit);
          Credit::log($agent, Sessioneer::user()->id, $addedCredit);
          ## log in credit logs ##

        }
      }
      ## check if agent is being given a new credit ##

      ## update agents info. ##
      $patch = $db->patch(USERS, ['id' => $agent], $data);
      if (!$patch) Response::default_error();
      ## update agents info. ##


      ## No Group, No Users. ##
      if (empty($group) && empty($users)) Response::json("success", ['info' => "Agent updated Successfully."]);
      ## No Group, No Users. ##

      ## moving agent to a new group ## (remove 2nd check) !!!
      if (Group::is_unsigned($group)) {

        ## detect old group ##
        $current = Agent::group($agent, null, ['id']);
        $current = ($current) ? $current->id : null;
        if ($current) {

          ## release current group. ##
          Group::release($current, true, false);
          ## 
        }

        ## assign agent to new  group. ##
        $db->patch(GROUPS, ['id' => $group], ['agent_id' => $agent]);

        ## assign old group members to the new group. ##
        $db->patch(MEMBERS, ['agent_id' => $agent], ['group_id' => $group]);
      }

      ## add new users if any ##
      if (!empty($users)) {

        $group = Agent::group($agent, null, ['id']);
        $group = ($group)->id;

        // add the memebrs to group
        foreach ($users as $user) {

          # add if not assigned to another group.
          if (!Group::member($group, $user)) {

            ## store ##
            Member::add($group, $agent, $user);
            ## store ##

          }
        }
      }

      ## response ##
      Response::json('success', [
        'info'  => "Agent updated Successfully.",
      ]);
      ## response ##
    }
  }


  private static function user_update()
  {

    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("update_user")) {

      ## authentication ##
      Action::permit(["admin", "agent"]);
      ## authentication ##

      ## user input ##
      $user     = Sanitizer::post_integer('id');
      $email    = Sanitizer::post_email('email');
      $password = Sanitizer::post_password('password');
      $credit  = Sanitizer::post_float('credit');
      $group    = Sanitizer::post_integer('group');
      ## user input ##

      ## placeholder ##
      $data = [];
      ## placeholder ##

      ## filter input ##
      !empty($email)    ? ($data['email']    = $email)    : null;
      !empty($password) ? ($data['password'] = $password) : null;
      !empty($credit)   ? ($data['credit']   = $credit)   : null;
      ## filter input ##

      ## hash password ##
      isset($data['password']) ? $data['password'] = Hash::make($password) : null;
      ## hash password ##

      ## check if user is being given a new balance ##
      if (isset($data['credit'])) {

        ## current balance ##
        $targetUser = User::get($user, ['username', 'balance', 'credit']);

        ## calculus ##
        if ($data['credit'] > $targetUser->credit) {

          ## log in credit logs ##
          $addedCredit = (float)($data['credit'] - $targetUser->credit);
          $data['credit'] = (float) ($targetUser->credit + $addedCredit);
          Credit::log($user, Sessioneer::user()->id, $addedCredit);
          ## log in credit logs ##

        }
      }
      ## check if user is being given a new balance ##

      ## admin ##
      if (Sessioneer::user_role() === "admin") {

        ## update agents info. ##
        $patch = $db->patch(USERS, ['id' => $user, 'user_type' => 3], $data);
        if (!$patch) Response::default_error(); // error 01
        ## update agents info. ##

        ## user group ##
        $is_member = (Group::member($group, $user)) ? true : false;
        ## user group ##

        // if member do nothing, else move user to new group.
        if (!$is_member) {

          ## move user to new group ##
          $agent = Group::agent($group, null, ['id']);
          $move  = $db->patch(MEMBERS, ['user_id' => $user], ['group_id' => ($group), 'agent_id' => ($agent)->id]);
          if (!$move) Response::default_error(); // error 02
          ## move user to new group ##

        }
        ## response ##
        Response::json('success', ['info' => "User successfully Updated."]);
        ## response ##
      }

      ## agent ##
      if (Sessioneer::user_role() === "agent") {

        // check if agent own manage that user //
        $gid = Agent::group(Sessioneer::user()->id, null, ['id']);
        $gid = ($gid) ? ($gid)->id : null;

        if (Group::member($gid, $user)) {

          ## update agents info. ##
          $patch = $db->patch(USERS, ['id' => $user, 'user_type' => 3], $data);
          if (!$patch) Response::default_error(); // error 03
          ## update agents info. ##

          ## response ##
          Response::json('success', ['info' => "User successfully Updated."]);
          ## response ##

        }
      }

      ## response ##
      Response::default_error(); // error 04
      ## response ##

    }
  }


  // update group //
  private static function group_update()
  {
    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("update_group")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $group = Sanitizer::post_integer('id');
      $name  = Sanitizer::post_string('name');
      $limit = Sanitizer::post_integer('limit');
      $agent = Sanitizer::post_integer('agent');
      ## input ##

      $data = [];

      ## filter ##
      !empty($name)  ? $data['name']        = $name  : null;
      !empty($limit) ? $data['count_limit'] = $limit : null;
      ## filter ##

      ## patch group ##
      $result = $db->patch(GROUPS, ['id' => $group], $data);
      if (!$result) Response::default_error();
      ## patch group ##

      ## filter ##
      !empty($agent) ? $new_agent['agent_id'] = $agent : null;
      ## filter ##

      ## is agent free ##
      $is_ok = (!empty($agent) && Agent::is_unsigned($agent)) ? true : false;
      ## is agent free ##

      if ($is_ok) {

        ## make the new agent ADMIN ##
        $result = $db->patch(GROUPS, ['id' => $group], $new_agent);
        if (!$result) Response::json("error", ["info" => "failed to admin agent " . ($new_agent)['id']]);
        ## make the new agent ADMIN ##

        ## move members to new admin ##
        $transfer = $db->patch(MEMBERS, ['group_id' => $group], $new_agent);
        if (!$transfer) Response::json("error", ['info' => "failed to move member to agent " . ($new_agent)['agent_id']]);
        ## move members to new admin ##

      }

      $agent = Group::agent($group, null, ['username']);
      $agent = ($agent) ? strtoupper($agent->username) : null;

      ## response ##
      Response::json("success", ["info"  => "Group successfully updated."]);
      ## response ##

    }
  }


  // admin update //
  public static function admin_update()
  {
    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("update_admin_account")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $uid       = Sessioneer::user()->id;
      $username  = Sanitizer::post_username('username');
      $email     = Sanitizer::post_email('email');
      $password  = Sanitizer::post_password('password');
      $credit    = Sanitizer::post_float('credit');
      $site_name = Sanitizer::post_string('site_name');
      ## input ##

      $data = [];

      ## filter ##
      !empty($username) ? $data['username'] = $username  : null;
      !empty($email)    ? $data['email']    = $email     : null;
      !empty($password) ? $data['password'] = $password  : null;
      !empty($credit)   ? $data['balance']  = $credit    : null;
      ## filter ##

      ## hash password
      isset($data['password']) ? $data['password'] = Hash::make($password) : null;
      ## hash password

      if (!empty($data)) {

        ## patch ##
        $patch = $db->patch(USERS, ['id' => $uid, 'user_type' => 1], $data);
        if (!$patch) Response::default_error();
        ## patch ##

      }

      ## patch sitename ##
      $sitename = $db->patch(SETTINGS, ['id' => 1], ['sitename' => $site_name]);
      if (!$sitename) Response::default_error();
      ## patch sitename ##

      ## reponse ##
      Response::json("success", ['info' => "Admin Account Has Been Successfully Updated."]);
      ## reponse ##

    }
  }


  // update main wheel page //
  private static function page_upate()
  {
    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("update_page")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $pageId = Sanitizer::post_integer('id');
      $name   = Sanitizer::post_string('name');
      $odds   = Sanitizer::post_string('odds');
      $cost   = Sanitizer::post_float('cost');
      $prize  = Sanitizer::post_integer('prize');
      $status = Sanitizer::post_integer('status');
      ## input ##

      ## filter ##
      $data = [];
      !empty($name)    ? $data['name']    = $name    : null;
      !empty($odds)    ? $data['odds']    = $odds    : null;
      !empty($cost)    ? $data['amount']  = $cost    : null;
      !empty($prize)   ? $data['prize']   = $prize   : null;
      !is_nan($status) ? $data['allowed'] = $status  : null;
      ## filter ##

      ## push ##
      $patch = $db->patch(TYPES, ['id' => $pageId], $data);
      if (!$patch) Response::default_error("Oops, Could not Update Page.");
      ## push ##

      ## reponse ##
      Response::json("success", ["info" => "Page updated Successfully."]);
      ## reponse ##

    }
  }

  // UPDATE homepage //
  private static function update_homepage()
  {
    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("update_homepage")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $status = Sanitizer::post_string('status');
      $mode   = Sanitizer::post_integer('mode');
      $text   = Sanitizer::post_string('text');
      ## input ##

      ## filter ##
      $data = [];
      !empty($status) ? $data['status'] = $status : null;
      !empty($mode)   ? $data['mode']   = $mode   : null;
      !empty($text)   ? $data['text']   = $text   : null;
      ## filter ##

      ## filter ##
      if (isset($data['status']) && $data['status'] !== "online" && $data['status'] !== "offline") {

        ## unset ##
        unset($data['status']);
        ## unset ##

      }

      if (isset($data['mode']) && $data['mode'] === 1) $data['mode'] = "play";
      if (isset($data['mode']) && $data['mode'] === 2) $data['mode'] = "hold";
      ## filter ##

      ## patch ##
      if (!$db->patch('settings', ['id' => 1], $data)) Response::default_error();
      ## patch ##

      Response::json("success", ['info' => "Settings updated Successfully."]);
    }
  }
}
