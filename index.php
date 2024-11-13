<?php

include_once "include/autoload.php";
include_once "data/config.php";

//var_dump($_SESSION);

//echo General\Config::$db['host'];

//var_dump(General\Db::FExec("data/sql/selectUsers.sql"));

//echo date('m_Y', mktime(0, 0, 0, date('m'), 1, date('Y')));

//General\Log::Add(new Exception());

$user = new View\UserView();
$licenseTypes = new View\LicenseTypeView();

//var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://accounts.google.com/gsi/client" async></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
    <header>
        <div class="left"><h1>License Key Store</h1></div>
        <div class="right"><?php $user->userButton();?></div>
    </header>

    <br>
    <h2>Available licenses</h2>
    <?php $licenseTypes->showAllLicenseTypes();?>

    <?php 
        if ($user->isLoggedIn()) {
            echo '<h2>Your licenses</h2>';
            $licenses = new View\LicenseView();
            $licenses->showAllUserLicenses($_SESSION['user']['id']);
        }
    ?> 
</body>
</html>

<?php General\Error::show(); ?>