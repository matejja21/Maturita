<?php

include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);

General\Error::add('TEST ERROR');

header('location: '.General\App::leveledPath("index.php"));