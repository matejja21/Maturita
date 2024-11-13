<?php

include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);

$user = new Controller\UserCon();
if ($user->isLoggedIn()) {
    $user->changeSecretKey();
} else {
    General\Error::add('You must be logged in to change secret key');
}

header('location: '.General\App::leveledPath("index.php"));