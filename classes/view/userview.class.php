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

                if ($this->isAdmin()) {
                    $admin_page = '<li class="nav-item mx-2"><a href="admin/index.php" alt="admin" class="text-light">Admin</a></li>';
                } else {
                    $admin_page = "";
                }

                echo $admin_page.'
                        <li class="nav-item mx-2"><a href="dashboard.php" alt="dashboard" class="text-light">Dashboard</a></li>
                        <li class="nav-item mx-2"><a href="action/logout.php" alt="log out - '.$this->email.'" class="text-light">'.$this->email.'<br>Log out</a></li>
                    
                ';
            } else {
                echo '
                    <div class="container">
                        <div id="g_id_onload"
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
                        </div>
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