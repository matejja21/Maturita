<?php

namespace View;

use Model\User as User;
use General\App as App;
class UserView 
    extends User {

        public function userButton() {
            if ($this->isLoggedIn()) {
                echo "
                    <h1>".$this->email."<h1>    
                ";
            } else {
                echo "<button>Log in</button>";
            }
        }

        public function verifyAdmin() {
            if (!($this->isAdmin())) {
                header("Location: ".App::leveledPath("index.php"));
            }
        }

    }

?>