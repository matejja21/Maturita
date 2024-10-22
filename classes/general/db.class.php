<?php

namespace General; // Namespace for general classes

// Static class for work with database
class Db {

    // CLASS PROPERTIES from configuration
    private static string $host;
    private static string $name;
    private static string $user;
    private static string $password;

    // CLASS METHODS

    // Method for loading data from configuration static class into this static class
    public static function Load() { 
        self::$host = Config::$db['host'];
        self::$name = Config::$db['name'];
        self::$user = Config::$db['user'];
        self::$password = Config::$db['password'];
    }

    // Method for creating mysql connection
    public static function Conn() {
        $dns = "mysql:host=".self::$host.";dbname=".self::$name.";charset=UTF8";
        try {
            $pdo = new \PDO($dns, self::$user, self::$password );
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            if ($pdo) {
                return $pdo;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            Log::Add($e);
            return false;
        }
    }

    // Method for execute sql query
    public static function Exec($query, $data = null) {
        $conn = self::Conn(); // setting up connection
        $stmt = $conn->prepare($query);
        $stmt->execute($data);
        return $stmt->fetchAll(); // return data
    }

    // Method for executing sql query from file
    public static function FExec($sqlFile, $data = null) {
        try {
            $conn = self::Conn();
            $stmt = $conn->prepare(file_get_contents($sqlFile));
            $stmt->execute($data);
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

}

?>