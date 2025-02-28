<?php

    // start PHP session and disable showing errors
    session_start();
    ini_set('display_errors', 0);


    // this function include all classes into page 
    function IncludeOnPath($level) {
        
        $paths = [
            "classes/general/app.class.php",
            "classes/general/config.class.php",
            "classes/general/db.class.php",
            "classes/general/error.class.php",
            "classes/general/log.class.php",
            "classes/model/license.class.php",
            "classes/model/user.class.php",
            "classes/model/licensekey.class.php",
            "classes/view/licenseview.class.php",
            "classes/view/userview.class.php",
            "classes/view/licensekeyview.class.php",
            "classes/controller/licensecon.class.php",
            "classes/controller/usercon.class.php",
            "classes/controller/licensekeycon.class.php",
        ];


        foreach ($paths as $path) {
            include_once(leveledPath($path, $level));
        }
    }

    // this method leveles path relativly to the root directory
    function leveledPath($path, int $level) {
        $leveledPath = "";

        // adding to the start of the path number of stepbacks by given level
        for ($i = 0; $i < $level; $i++) {
            $leveledPath .= "../";
        }

        // appending actual path into our leveled path (now on root level)
        $leveledPath .= $path;

        // return leveled path string
        return $leveledPath;
    }

    // this function set level of the page to the leveling method
    function SetLevel(int $level = 0) {
        General\App::$level = $level;
    }

?>