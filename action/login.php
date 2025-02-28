<?php

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
include_once "../lib/google-api-php-client--PHP7.0/vendor/autoload.php";
SetLevel(1);

// handle user login
$user = new Controller\UserCon();
$user->handleLogin();

// redirect user to the homepage
header('location: '.General\App::leveledPath("index.php"));