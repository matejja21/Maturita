<?php

include_once "include/autoload.php";
include_once "data/config.php";

//var_dump($_SESSION);

//echo General\Config::$db['host'];

//var_dump(General\Db::FExec("data/sql/selectUsers.sql"));

//echo date('m_Y', mktime(0, 0, 0, date('m'), 1, date('Y')));

//General\Log::Add(new Exception());

$user = new View\UserView();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://accounts.google.com/gsi/client" async></script>

</head>
<body>
    <?php $user->userButton();?>
</body>
</html>

<?php General\Error::show(); ?>