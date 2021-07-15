<?php

// import Init file:
require_once __DIR__ . '/config/Init.php';

##############################################################
######################### middleware #########################
##############################################################

## public site cluster ##
Middleware::auth('login.php',      'index.php', false);

Middleware::auth('index.php',      'login.php', true);
Middleware::auth('microdraw.php',  'login.php', true);
Middleware::auth('highstakes.php', 'login.php', true);
Middleware::auth('microdraws.php', 'login.php', true);

Middleware::auth('disclaimer.php', 'login.php', true);
Middleware::auth('privacy.php',    'login.php', true);
Middleware::auth('404.php',        'login.php', true);
## public site cluster ##


## status protected pages ##
if (UrlParser::absolutePath() === "microdraw.php"   && !Type::info(1, ['allowed'])->allowed) Redirector::home();
if (UrlParser::absolutePath() === "highstakes.php"  && !Type::info(2, ['allowed'])->allowed) Redirector::home();
if (UrlParser::absolutePath() === "microdraws.php"  && !Type::info(3, ['allowed'])->allowed) Redirector::home();
if (UrlParser::absolutePath() === "unkownpage.php"  && !Type::info(4, ['allowed'])->allowed) Redirector::home();
if (UrlParser::absolutePath() === "unkownpage.php"  && !Type::info(5, ['allowed'])->allowed) Redirector::home();
if (UrlParser::absolutePath() === "unkownpage.php"  && !Type::info(6, ['allowed'])->allowed) Redirector::home();
## status protected pages ##


##############################################################
####################### debuggin only ########################
##############################################################

if (DEBUG_MODE) {

    if (UrlParser::absolutePath() === "App.php") {

        echo Settings::mode();
    }
} else {

    if (UrlParser::absolutePath() === "App.php") {
        ## include 404 page ##
        http_response_code(404);
        include __DIR__ . "/404.php";
        ## include 404 page ##
    }
}
