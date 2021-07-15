<?php

/*
* This class handles delete requests.
*/

class Delete
{

  public static function Start()
  {

    # delete group #
    if (Request::post_has('delete_group')) Delete::delete_group();
    # delete group #

    # delete agent #
    if (Request::post_has('delete_agent')) Delete::delete_agent();
    # delete agent #

    # delete user #
    if (Request::post_has('delete_user')) Delete::delete_user();
    # delete user #

    # delete bet #
    if (Request::post_has('delete_bet')) Delete::delete_bet();
    # delete bet #

    # reset all #
    if (Request::post_has('reset_all')) Delete::reset_all();
    # reset all #

    ## reset balance ##
    if (Request::post_has('reset_balance')) Delete::reset_balance();
    ## reset balance ##

    ## delete credit log ##
    if (Request::post_has('delete_creditlog')) Delete::delete_creditlog();
    ## delete credit log ##

    ## delete winner log ##
    if (Request::post_has('delete_winner')) Delete::delete_winner();
    ## delete winner log ##

    ## delete an archive ##
    if (Request::post_has('delete_archive')) Delete::delete_archive();
    ## delete an archive ##

  }

  // delete an agent //
  private static function delete_agent()
  {

    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("delete_agent")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $agent = Sanitizer::post_integer('id');
      ## input ##

      ## remove ##
      $patch = $db->patch(USERS, ['id' => $agent, 'user_type' > 2], ['user_type' => 3]);
      ## remove ##

      ## release group & members ##
      $group   = Agent::group($agent);
      $release = ($group) ? Group::release(($group)->id) : true;
      ## release group & members ##

      $status = ($patch && $release) ? 'success' : 'error';
      $info   = ($patch && $release) ? "Agent Successfully removed." : "Failed to remove agent.";

      ## response ##
      Response::json($status, ['info' => $info]);
      ## response ##

    }
  }

  // delete user
  private static function delete_user()
  {
    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("delete_user")) {

      ## authentication ##
      Action::permit(["admin", "agent"]);
      ## authentication ##

      ## input ##
      $user = Sanitizer::post_integer('id');
      ## input ##

      ## exisits ##
      if (!User::get($user)) Response::default_error();
      ## exisits ##

      ## admin
      if (Sessioneer::user_role() === "admin") {

        ## remove ##
        $patch = $db->revoke(USERS, ['id' => $user, 'user_type' => 3]);
        ## remove ##

        ## release group & members ##
        $release = Member::remove($user);
        ## release group & members ##

        ## response ##
        $status = ($patch && $release) ? 'success' : 'error';
        $info   = ($patch && $release) ? "User Successfully removed." : "Failed to remove user.";
        ## response ##

      }

      ## agent
      if (Sessioneer::user_role() === "agent") {

        // check if agent own manage that user //
        $gid = Agent::group(Sessioneer::user()->id, null, ['id']);
        $gid = ($gid) ? ($gid)->id : null;

        // check if he is a member:
        if (Group::member($gid, $user)) {

          ## remove ##
          $patch = $db->revoke(USERS, ['id' => $user, 'user_type' => 3]);
          ## remove ##

          ## release group & members ##
          $release = Member::remove($user);
          ## release group & members ##

          ## response ##
          $status = ($patch && $release) ? 'success' : 'error';
          $info   = ($patch && $release) ? "User Successfully removed." : "Failed to remove user.";
          ## response ##

        } else {
          ## error ##
          Response::default_error();
          ## error ##
        }
      }

      ## response ##
      Response::json($status, ['info' => $info]);
      ## response ##

    }
  }

  // delete group //
  private static function delete_group()
  {
    ## database ##
    global $db;
    ## database ##

    if (Request::post_has("delete_group")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $group = Sanitizer::post_integer('id');
      ## input ##

      ## exisits ##
      if (!Group::get($group)) Response::default_error();
      ## exisits ##

      ## release members ##
      $release_members = Group::release($group);
      ## release members ##

      ## remove group ##
      $release_group = $db->revoke(GROUPS, ['id' => $group]);
      ## remove group ##

      ## response ##
      $status = ($release_group && $release_members) ? "success" : "error";
      $info   = ($release_group && $release_members) ? "Group successfully removed." : "Failed to remove group.";
      Response::json($status, ["info" => $info]);
      ## response ##

    }
  }

  // delete bet //
  private static function delete_bet()
  {

    if (Request::post_has("delete_bet")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $bet = Sanitizer::post_integer('id');
      ## input ##

      ## check ##
      if (!Spot::exists($bet)) Response::default_error();
      ## check ##

      ## delete ##
      $removal = Spot::remove($bet);
      if (!$removal) Response::default_error();
      ## delete ##

      ## response ##
      Response::json("success", ['info' => "Bet Successfully deleted."]);
      ## response ##

    }
  }

  // reset all //
  private static function reset_all()
  {

    if (Request::post_has("reset_all")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## truncate bets ##
      Spot::truncate();
      ## truncate bets ##

      ## truncate winners ##
      Winner::truncate();
      ## truncate winners ##

      ## reset wheels ##
      Wheel::reset();
      ## reset wheels ##

      ## reset numbers ##
      Number::reset();
      ## reset numbers ##

      ## reset mode ##
      Settings::mode("play");
      ## reset mode ##

      ## response ##
      Response::json("success", ['info' => "Everything Has Been Reset successfully."]);
      ## response ##

    }
  }


  // reset balance //
  private static function reset_balance()
  {

    ## database ##
    global $db;
    ## database ##

    if (Request::post_has('reset_balance')) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## reset ##
      $reset = $db->query("UPDATE `users` SET BALANCE = 0.00");
      if (!$reset) Response::default_error("Ooops, Couldn't reset balance.");
      ## reset ##

      ## response ##
      Response::json("success", [
        "info" => "Balance was Successfully Reset."
      ]);
      ## response ##

    }
  }

  // delete credit log //
  private static function delete_creditlog()
  {
    if (Request::post_has('delete_creditlog')) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $id = Sanitizer::post_integer('id');
      ## input ##

      ## check ##
      if (!Credit::exists($id)) Response::default_error();
      ## check ##

      ## delete ##
      $removal = Credit::remove($id);
      if (!$removal) Response::default_error();
      ## delete ##

      ## response ##
      Response::json("success", ['info' => "Credit Log Successfully deleted."]);
      ## response ##

    }
  }

  // delete winner log //
  private static function delete_winner()
  {
    if (Request::post_has('delete_winner')) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $id = Sanitizer::post_integer('id');
      ## input ##

      ## check ##
      if (!Winner::exists($id)) Response::default_error();
      ## check ##

      ## delete ##
      $removal = Winner::remove($id);
      if (!$removal) Response::default_error();
      ## delete ##

      ## response ##
      Response::json("success", ['info' => "Winner Log Successfully deleted."]);
      ## response ##

    }
  }

  // delete and archive //
  private static function delete_archive()
  {
    if (Request::post_has('delete_archive')) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $id = Sanitizer::post_integer('id');
      ## input ##

      ## check ##
      if (!Archive::exists($id)) Response::default_error();
      ## check ##

      ## remove ##
      if (!Archive::remove($id)) Response::default_error();
      ## remove ##

      ## reposne ##
      Response::json('success', ['info' => "Archive Successfully Removed."]);
      ## reposne ##

    }
  }
}
