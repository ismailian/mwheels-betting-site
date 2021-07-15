<?php

## error logging..
// error_reporting(false);

## Session
session_start();

## constants ##
require_once __DIR__ . "/Constants.php";


## vendor autoloader:
require_once Vendor . 'autoload.php';


## imports ##
require_once Modules   . "main.php";
require_once Utilities . "main.php";
require_once Functions . "main.php";
require_once Models    . "main.php";
require_once Handlers  . "main.php";


## database ##
$db = new Connector(HOSTNAME, USERNAME, PASSWORD, DATABASE);


## session ##
Sessioneer::guest();
## session ##

// Handlers calls:
Watch::monitor();   # monitore site condition

Login::Start();     # Login users.
Logout::Start();    # Logout users.
Register::Start();  # Register new entries.

Fetch::Start();     # Fetch data from database.
Create::Start();    # Insert into database.
Update::Start();    # Update to database.
Delete::Start();    # Delete from database.

Export::Start();    # Export SpreadSheets. 
