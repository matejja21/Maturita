<?php

include_once "../include/autoload.php";
include_once "../data/config.php";

SetLevel(1);
//echo General\Config::$db['host'];

var_dump(General\Db::FExec("../data/sql/selectUsers.sql"));

//echo date('m_Y', mktime(0, 0, 0, date('m'), 1, date('Y')));

General\Log::Add(new Exception());
$user = new View\UserView();
$user->verifyAdmin();

?>