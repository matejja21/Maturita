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
}

?>