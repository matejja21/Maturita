<?php 

$config = [
    //database
    "database" => [
        "host" => "", // name of the database host
        "name" => "", // name of the database
        "user" => "", // name of the database user
        "password" => "" // password for the database user
    ],
    //stripe
    "stripe" => [
        "secret_key" => "" // secret key for stripe api
    ],
    // google
    "google" => [
        "client_id" => "", // client id for your google authentication prject
        "client_secret" => "" // client secret key of yout google authentication project
    ],
    // general
    "general" => [
        "app_root_url" => "", // root path of the application
        "secret_key" => "",
        "iv" => "",
        "license_type" => ""
    ],
    // email
    "email" => [
        "smtp" => "" // smtp server
    ]
];


// Load confguration data to Config static class
General\Config::Load($config);



?>
