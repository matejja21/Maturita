<?php

namespace View;

use Model\User as User;
use General\App as App;
use General\Config as Config;

class UserView 
    extends User {

        public function userButton() {
            if ($this->isLoggedIn()) {
                echo '
                    <h1>'.$this->email.'</h1>
                    <a href="action/logout.php" alt="log out">Log out</a>
                    <a href="action/changeSecretKey.php" alt="change secret key">Change secret key</a> 
                    <h2>secret key: '.$this->getSecretKey().'</h2>
                ';
            } else {
                echo '<div id="g_id_onload"
                        data-client_id="'.Config::$google['client_id'].'"
                        data-context="signin"
                        data-ux_mode="redirect"
                        data-login_uri="'.Config::$general['app_root_url'].'action/login.php"
                        data-auto_prompt="false">
                    </div>

                    <div class="g_id_signin"
                        data-type="standard"
                        data-shape="pill"
                        data-theme="outline"
                        data-text="signin_with"
                        data-size="large"
                        data-logo_alignment="left">
                    </div>';
            }
        }

        public function verifyAdmin() {
            if (!($this->isAdmin())) {
                header("Location: ".App::leveledPath("index.php"));
            }
        }

    }

?>