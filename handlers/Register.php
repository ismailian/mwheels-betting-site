<?php

/*
* This class handles registeration requests.
*/

class Register
{

  public static function Start()
  {


    ## filter auto-fill players ##
    if (Request::post_has("filter_autofill")) Register::filter_autofill();
    ## filter auto-fill players ##

    ## publish winners ##
    if (Request::post_has("publish")) Register::publish();
    ## publish winners ##
  }


  private static function filter_autofill()
  {

    if (Request::post_has("filter_autofill")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## check bettings ##
      if (Spot::count() === 0) Response::default_error("There are no Bettings at the moment.");
      ## check bettings ##

      ## re-order ##
      $data01 = Type::reorder(1);
      $data02 = Type::reorder(2);
      $data03 = Type::reorder(3);
      ## re-order ##

      $count = (count($data01[1]) + count($data02[1]) + count($data03[1]));

      // dump
      Response::json("success", [
        "info" => "<strong>Autofill has finished Successfully.<br /><small>Now you can publish Winning Numbers.</small></strong>",
        "autofills" => $count,
      ]);
    }
  }


  // publish winners
  private static function publish()
  {

    if (Request::post_has("publish")) {

      ## authentication ##
      Action::permit("admin");
      ## authentication ##

      ## input ##
      $numbers = Sanitizer::post_array("numbers", FILTER_VALIDATE_INT);
      ## input ##

      ## parse ##
      !is_nan($numbers['n01']) ? $n01 = $numbers['n01'] : Response::default_error("You are missing the (1st) number.");
      !is_nan($numbers['n02']) ? $n02 = $numbers['n02'] : Response::default_error("You are missing the (2nd) number.");
      !is_nan($numbers['n03']) ? $n03 = $numbers['n03'] : Response::default_error("You are missing the (3rd) number.");
      !is_nan($numbers['n04']) ? $n04 = $numbers['n04'] : Response::default_error("You are missing the (4th) number.");
      !is_nan($numbers['n05']) ? $n05 = $numbers['n05'] : Response::default_error("You are missing the (5th) number.");
      !is_nan($numbers['n06']) ? $n06 = $numbers['n06'] : Response::default_error("You are missing the (6th) number.");
      !is_nan($numbers['n07']) ? $n07 = $numbers['n07'] : Response::default_error("You are missing the (7th) number.");
      ## parse ##

      #-----------------------------------------------------------------------------------------#
      #-----------------------------------------------------------------------------------------#
      if (!Number::fill(1, $n01)) Response::default_error("Oops, Couldn't insert number (1)."); #
      if (!Number::fill(2, $n02)) Response::default_error("Oops, Couldn't insert number (2)."); #
      if (!Number::fill(3, $n03)) Response::default_error("Oops, Couldn't insert number (3)."); #
      if (!Number::fill(4, $n04)) Response::default_error("Oops, Couldn't insert number (4)."); #
      if (!Number::fill(5, $n05)) Response::default_error("Oops, Couldn't insert number (5)."); #
      if (!Number::fill(6, $n06)) Response::default_error("Oops, Couldn't insert number (6)."); #
      if (!Number::fill(7, $n07)) Response::default_error("Oops, Couldn't insert number (7)."); #
      #-----------------------------------------------------------------------------------------#
      #-----------------------------------------------------------------------------------------#


      ## check betting list ##
      if (Spot::count() === 0) Response::default_error("There are not Bettings at the moment");
      ## check betting list ##

      ## see the betting list ##
      $stats = Spot::collect();

      $winner_ids = [];
      $loser_ids  = [];
      $refunded   = [];
      $winners    = 0;
      $losers     = 0;

      foreach ($stats['bets'] as $bet) {

        // check against the winning numbers:
        if (Winner::won($bet->wheel_number, $bet->wheel_spot)) {

          ## push to winners table ##
          Winner::add([
            'user_id'      => $bet->user_id,
            'cid'          => $bet->cid,
            'wheel_type'   => $bet->wheel_type,
            'wheel_number' => $bet->wheel_number,
            'wheel_spot'   => $bet->wheel_spot,
            'prize'        => Type::get(['type' => $bet->wheel_type], ['prize'])->prize,
          ]);
          ## push to winners table ##

          // check if won before //
          if (array_search($bet->user_id, $winner_ids) === false) {

            ## increment winners ## 
            $winners += 1;
            ## increment winners ## 

            array_push($winner_ids, $bet->user_id);
          }
        } else {

          // this is a loser, do other checks concerning refund.
          if ($bet->choice === "refund") {

            // check if he is the only one on that wheel of that type.
            if (Type::players($bet->wheel_type, $bet->wheel_number) === 1) {

              ## append refund list:
              array_push($refunded, [
                'id'                  => $bet->id,
                'user_id'             => $bet->user_id,
                'wheel_type'          => $bet->wheel_type,
                'wheel_number'        => $bet->wheel_number,
                'wheel_spot'          => $bet->wheel_spot,
                'cost_to_be_refunded' => $bet->paid,
              ]);
              ## refund list ##

              ## refund ##
              User::refund($bet->user_id, $bet->paid);
              ## refund ##

              // check if won before //
              if (array_search($bet->user_id, $loser_ids) === false) {

                ## increment losers ## 
                $losers += 1;
                ## increment losers ## 

                array_push($loser_ids, $bet->user_id);
              }
            }
          }
        }
      }

      ## set pending mode ##
      Settings::mode('pending');
      ## set pending mode ##

      ## reward winners ##
      Winner::reward();
      ## reward winners ##

      ## response ##
      Response::json("success", [
        "info" => "<strong>Winners Have Been Selected Successfully.<hr><small>{$winners} Win(s).<br />{$losers} Player(s) To be Refunded</small>.</strong>",
        'refuned' => $refunded,
      ]);
      ## response ##
    }
  }
}
