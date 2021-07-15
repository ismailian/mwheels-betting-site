<?php

/*
* This class handles login requests.
*/

class Login
{


  public static function Start()
  {

    # user login #
    if (Request::post_has('login')) Login::user_login();
    # user login #


  }

  // User Login //
  private static function user_login()
  {

    global $db;

    if (Request::is_post("login.php") && Request::post_has('login')) {

      ## is logged in already? ##
      if (Sessioneer::logged_in()) {

        ## redirect ##
        Redirector::route("index.php");
        return;
        ## redirect ##

      }

      ## user inputs ##
      $is_email = preg_match("/(@\S+)/", $_POST['username']);
      $user     = ($is_email) ? Sanitizer::post_email('username') : Sanitizer::post_username('username');
      $pass     = Sanitizer::post_password('password');
      ## user inputs ##

      ## db search ##
      $user = $db->getOne(USERS, [$is_email ? 'email' : 'username' => $user], ['id', 'fullname', 'email', 'username', 'password', 'user_type']);
      ## db search ##

      if ($user) {

        ## password verification ##
        if (Hash::verify($pass, $user->password) === true) {

          ## user role ##
          if ((int)($user)->user_type === 1) $role = "admin";
          if ((int)($user)->user_type === 2) $role = "agent";
          if ((int)($user)->user_type === 3) $role = "user";
          ## user role ##

          ## session ##
          Sessioneer::setup([

            'user'      => (object) [

              'id'       => ($user)->id,
              'email'     => ($user)->email,
              'fullname' => ($user)->fullname,
              'username' => ($user)->username,

            ],                     # user info.

            'user_role' => $role,  # user role.
            'active'    => true,   # user status.
            'logged_in' => true,   # login status.

          ], 'user_role');
          ## session ##

          ## response ##
          Sessioneer::update('message', "You have successfully logged in!");
          Redirector::route("index.php");
          return;
          ## response ##

        }
      }

      ## errors ##
      Sessioneer::update('message', "<div class='alert alert-danger justify-content-center' style='width:100%;' role='alert'>Email/Password is Incorrect<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span></button></div>");
      ## errors ##

      ## return ##
      return;
      ## return ##

    }
  }
}
