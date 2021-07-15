<?php

class Watch
{

    // watch site status //
    public static function monitor()
    {
        ## grab site status ##
        $status = Settings::info()->status;
        ## grab site status ##

        ## check ##
        if (Sessioneer::logged_in()) {

            if (UrlParser::absolutePath() !== "404.php") {

                if ($status === "offline") {

                    if (Sessioneer::user_role() !== "admin") {

                        ## redirect to construction page ##
                        Redirector::route("404.php");
                        return;
                        ##

                    } else {

                        if (UrlParser::absolutePath() !== "admin" && !Request::is_post("index.php") && empty((array)(Request::query_as_object()))) {

                            ## redirect to construction page ##
                            Redirector::route("404.php");
                            return;
                            ##
                        }
                    }
                }
            }
        }
        ## check ##

        ## retunr ##
        return;
    }
}
