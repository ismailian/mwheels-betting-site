<?php

// import Init file:
require_once '../config/Init.php';



##############################################################
######################### middleware #########################
##############################################################

## Guard Admin Dashboard ##
Middleware::access('admin', 'user_role', ['admin', 'agent']);
## Guard Admin Dashboard ##

## shared pages ## (admin, agent)
Middleware::access(['admin', 'users.php'],   'user_role', ['admin', 'agent']);
## shared pages ## (admin, agent)


## restrict agents to users page ##
if (Sessioneer::user_role() === "agent") {

    if (Cleaner::array2string(UrlParser::segments(), "/") !== "admin/users.php") {

        ## agent can only access users page ##
        Redirector::route("admin/users.php");
        ## agent can only access users page ##

    }
}
## restrict agents to users page ##

##############################################################
######################### middleware #########################
##############################################################


# debuggin only #
if (DEBUG_MODE) {

    if (Request::is_get(['admin', 'App.php'])) {

        echo Cleaner::array2string(UrlParser::segments(), "/");
    }
}
