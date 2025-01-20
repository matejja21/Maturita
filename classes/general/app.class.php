<?php

namespace General;

class App {
    public static $level;

    public static function leveledPath($path) {
        $leveledPath = "";

        // adding to the start of the path number of stepbacks by given level
        for ($i = 0; $i < self::$level; $i++) {
            $leveledPath .= "../";
        }

        // appending actual path into our leveled path (now on root level)
        $leveledPath .= $path;

        // return leveled path string
        return $leveledPath;
    }

    // tato funkce je podle: https://stackoverflow.com/a/63891351/20757818
    public static function str_short($string, $length, $lastLength = 0, $symbol = '...')
    {
        if (strlen($string) > $length) {
            $result = substr($string, 0, $length - $lastLength - strlen($symbol)) . $symbol;
            return $result . ($lastLength ? substr($string, - $lastLength) : '');
        }
    
        return $string;
    }
}

?>