<?php

namespace General; // Namespace for general classes


// Static class for configuration data
class Config {

    // Class properties
    public static array $db; // array of database data
    public static array $stripe; // array of data for Stripe
    public static array $google; // array of data for Google login

    // Class methods

    // method for loading data from config array
    public static function Load($config) {
        self::$db = $config['database']; // assigning db data
        self::$stripe = $config['stripe']; // assigning Stripe data
        self::$google = $config['google']; // assigning Google login data

        // Loading data into Database static class
        Db::Load();
    }

}

?>