<?php

namespace View;

use Model\User as User;
use General\App as App;
use General\Config as Config;
use General\Error as Error;


class UserView 
    extends User {

        public function userButton() {
            if ($this->isLoggedIn()) {
                echo '
                    <li>'.$this->email.'</li>
                    <li><a href="action/logout.php" alt="log out" class="text-light">Log out</a></li>
                    <li><a href="action/changeSecretKey.php" alt="change secret key" class="text-light">Change secret key</a> </li>
                    <p class="text-light">secret key: '.$this->getSecretKey().'</p>
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
                Error::Add('You must be an Admin to enter this page');
                header("Location: ".App::leveledPath("index.php"));
            }
        }

    }

?>