<?php

/*
* This class handles logout requests.
*/

class Logout
{

  public static function Start()
  {

    # user logout #
    if (Request::post_has('logout')) Logout::user_logout();
    # user logout #

  }

  // user Logout 
  private static function user_logout()
  {

    ## logout ##
    if (Request::post_has('logout')) {

      ## login check ##
      if (Sessioneer::logged_in()) {

        ## release session ##
        Sessioneer::destroy();
        Redirector::home();
        ## release session ##

      }
      return;
      ## login check ##

    }
    ## logout ##
  }
}
