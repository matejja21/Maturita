<?php

// includes for this script + setting level of the script
include_once "../include/autoload.php";
IncludeOnPath(1);
include_once "../data/config.php";
SetLevel(1);

// validating GET parameter 'error'
if (isset($_GET['error']) && !is_null($_GET['error'])) {
    $error = $_GET['error'];
} else {
    $error = false;
}

// if error exists, add it to the error static class to show up in the other page 
if ($error) {
    General\Error::add($error);
}

// redirect user to the homepage
header('location: '.General\App::leveledPath("index.php"));