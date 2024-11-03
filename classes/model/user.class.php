<?php

namespace Model;

use General\Db as Db;

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
            return Db::FExec('data/sql/addUser.sql', ["email" => $email, "level" => $level], true);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }
}

?>