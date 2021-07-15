<?php


## App constants ##
define("DEBUG_MODE", true);
## App constants ##


## database ##
define("HOSTNAME", "localhost");
define("USERNAME", "root");
define("PASSWORD", "");
define("DATABASE", "wheels");
## database ##


## directories ##
define("ROOT",      $_SERVER['DOCUMENT_ROOT'] . "/");
define("Modules",   ROOT . "modules/");
define("Utilities", ROOT . "utilities/");
define("Functions", ROOT . "functions/");
define("Handlers",  ROOT . "handlers/");
define("Models",    ROOT . "models/");
define("Vendor",    ROOT . "vendor/");
define("Archive",   ROOT . "storage/");
## directories ##


## tables ##
define("SETTINGS", "settings");
define("ARCHIVE",  "archive");

define("BETS",     "bets");
define("CREDIT",   "credit");

define("GROUPS",   "groups");
define("MEMBERS",  "members");
define("USERS",    "users");
define("WINNERS",  "winners");

define("TYPES",    "types");
define("WHEELS",   "wheels");
define("NUMBERS",  "numbers");
## tables ##