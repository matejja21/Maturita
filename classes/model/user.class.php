<?php

namespace Model;

use General\Db as Db;
use General\Config as Config;
use General\Log as Log;
use General\Error as Error;

class User {
    public $id;
    public $email;
    public $level;

    public function __construct() {
        if (isset($_SESSION['user']['id']) && !is_null($_SESSION['user']['id'])) {
            $this->id = $_SESSION['user']['id'];
        } else {
            $this->id = null;
        }
        if (isset($_SESSION['user']['email']) && !is_null($_SESSION['user']['email'])) {
            $this->email = $_SESSION['user']['email'];
        } else {
            $this->email = null;
        }
        if (isset($_SESSION['user']['level']) && !is_null($_SESSION['user']['level'])) {
            $this->level = $_SESSION['user']['level'];
        } else {
            $this->level = null;
        }
    }

    public function isLoggedIn() : bool {
        if ($this->id != null) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdmin() : bool {
        if ($this->level >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function changeLevel($level) {
        try {
            return Db::FExec('data/sql/updateUserLevel.sql', ["user_id" => $this->id, "level" => $level]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
        }
    }

    public function getUserByEmail($email) {
        $data = Db::FExec("data/sql/selectUserByEmail.sql", ["email" => $email]);

        if (!is_null($data) && count($data) == 1) {
            return $data[0];
        } else {
            return false;
        }
    }

    protected function addUser($email, $level = 0) {
        try {
            return Db::FExec('data/sql/addUser.sql', ["email" => $email, "level" => $level, "secret_key" => openssl_encrypt(bin2hex(random_bytes(16)), 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv'])], true);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
        }
    }

    protected function getSecretKey() {
        try {
            return openssl_decrypt(Db::FExec('data/sql/selectUserSecretKey.sql', ['user_id' => $this->id])[0]['secret_key'], 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv']);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
        }
    }

    protected function updateSecretKey(string $key) {
        echo "I am happening";
        try {
            $data = [
                "secret_key" => openssl_encrypt($key, 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv']),
                "user_id" => $this->id
            ];
            Db::FExec('data/sql/updateUserSecretKey.sql', $data);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
        }
    }

}

?>