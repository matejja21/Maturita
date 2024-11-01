<?php

namespace General; // Namespace for general classes

// Static class for logging exceptions
class Log {

    // class properties
    private static $logFolder = "data/logs/"; // directory path for saving loggs
    public  static $level = 0;
    // class methods

    // Method for adding one log
    public static function Add(\Exception $e) {
        self::addToFile($e, self::$level); // Logging into file
        try { // Logging into database (try for database failure)
            self::addToDb($e, self::$level);
        } catch (Exception $e) {
            self::addToFile($e);
        }
    }

    // Method for logging into database
    private static function addToDb(\Exception $e) {
        // setting data
        $data = [
            ":code" => $e->GetCode(), // code of exception
            ":message" => $e->GetMessage(), // message of exception
            ":file" => $e->GetFile(), // file where was the exception caused
            ":time" => date('Y-m-d H:i:s', time()) // time when was the exception caused
        ];

        // execute data into database troug SQL query in separate file
        Db::FExec(self::leveledPath("data/sql/addLog.sql"), $data);
    }

    // Method for logging into file
    private static function addToFile(\Exception $e) {
        // leveling path for saving
        $path = self::leveledPath(self::$logFolder);
        
        // deleting old files 
        self::deleteOldFiles($path);

        // open (or create) csv file of this month for appending data
        $fp = fopen($path.date('m_Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).".csv", 'a');

        // appending logging data into opened file
        fputcsv($fp, [$e->GetCode(), $e->GetMessage(), $e->GetFile(), date('H:i:s d.m.Y', time())]);
        fclose($fp);
    }

    // Method for leveling directory path 
    //(if running script is not in the root level, the level number represents number of step backs "../" before path to get to the root level)
    private static function leveledPath($path) {
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

    // Method for deleting all files from log directory except of this and previous month (to save space)
    private static function deleteOldFiles($path) {
        foreach (array_diff(scandir($path), ['..', '.', date('m_Y', mktime(0, 0, 0, date('m')-1, 1, date('Y'))).".csv", date('m_Y', mktime(0, 0, 0, date('m'), 1, date('Y'))).".csv"]) as $file) {
            unlink($path . $file);
        }
    }
}

?>