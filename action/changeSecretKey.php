<?php

/*************************************************************************************************
 * This script is not use in this application, but the technology could be useful for the future *
 *************************************************************************************************/

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
SetLevel(1);

// if user is logged in, change his secret key
$user = new Controller\UserCon();
if ($user->isLoggedIn()) {
    $user->changeSecretKey();
} else {
    General\Error::add('You must be logged in to change secret key');
}

// redirect user to home page
header('location: '.General\App::leveledPath("index.php"));