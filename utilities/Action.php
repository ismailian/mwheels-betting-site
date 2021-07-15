<?php



class Action
{


    // constrain action permissions:
    public static function permit($role)
    {
        ## authentication ##
        if (is_array($role)) {
            if (!Sessioneer::logged_in() or array_search(Sessioneer::user_role(), $role) === false) {
                ## not authorized ##
                Response::notAuthorized();
                ## not authorized ##
            }
        } else {
            if (!Sessioneer::logged_in() or Sessioneer::user_role() !== $role) {
                ## not authorized ##
                Response::notAuthorized();
                ## not authorized ##
            }
        }
        ## authentication ##
    }
}
