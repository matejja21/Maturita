<?php

    // This code inspired by: https://www.youtube.com/watch?v=z3pZdmJ64jo&list=PL0eyrZgxdwhypQiZnYXM7z7-OTkcMgGPh&index=9

    spl_autoload_register('AutoLoad');

    function AutoLoad($className) {
        $path = "classes/";
        $extension = ".class.php";
        $fullPath = $path . $className . $extension;

        if (!file_exists($fullPath)) {
            return false;
        } else {
            include_once $fullPath;
        }

    }

?>