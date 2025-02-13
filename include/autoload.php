<?php

    session_start();
    ini_set('display_errors', 0);

    // This code inspired by: https://www.youtube.com/watch?v=z3pZdmJ64jo&list=PL0eyrZgxdwhypQiZnYXM7z7-OTkcMgGPh&index=9

    spl_autoload_register('AutoLoad');

    function AutoLoad($className) {
        for ($i = 0; $i < 3; $i++) {
            $path = leveledPath("classes/", $i);
            $extension = ".class.php";
            $fullPath = $path . $className . $extension;

            if (file_exists($fullPath)) {
                include_once $fullPath;
            }
        }
    }

    /*function leveledPath($path, int $level) {
        $leveledPath = "";

        // adding to the start of the path number of stepbacks by given level
        for ($i = 0; $i < $level; $i++) {
            $leveledPath .= "../";
        }

        // appending actual path into our leveled path (now on root level)
        $leveledPath .= $path;

        // return leveled path string
        return $leveledPath;
    }*/

    function SetLevel(int $level = 0) {
        General\App::$level = $level;
    }

?>