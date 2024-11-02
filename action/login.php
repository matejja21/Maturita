<?php

include_once "../include/autoload.php";
include_once "../data/config.php";

include_once "../lib/google-api-php-client--PHP7.0/vendor/autoload.php";

SetLevel(1);

$user = new Controller\UserCon();
$user->handleLogin();