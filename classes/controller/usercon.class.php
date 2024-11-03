<?php

namespace Controller;

use Model\User as User;
use General\App as App;
use General\Config as Config;
use General\Error as Error;
use Google\Client as GClient;

class UserCon
    extends User {

        public function handleLogin() {
            if (isset($_POST['credential']) && !is_null($_POST['credential'])) {
                $id_token = $_POST['credential'];
            } else {
                $id_token = false;
            }
            
            if ($id_token) {
                $client = new GClient(['client_id' => Config::$google['client_id']]);  // Specify the CLIENT_ID of the app that accesses the backend
                $payload = $client->verifyIdToken($id_token);
                if ($payload) {
                    $user = $payload['email'];
                    $data = $this->getUserByEmail($user);
                    if ($data) {
                        $_SESSION['user']['email'] = $data['email'];
                        $_SESSION['user']['id'] = $data['user_id'];
                        $_SESSION['user']['level'] = $data['level'];
                    } else {
                        $id = $this->addUser($user);
                        var_dump($id);
                        $_SESSION['user']['email'] = $user;
                        $_SESSION['user']['id'] = $id;
                        $_SESSION['user']['level'] = 0;

                    }
                } else {
                    Error::add('Fail to log in');
                }
            } else {
                Error::add('Fail to log in');
            }
        }

        public function handleLogout() {
            $_SESSION['user'] = null;
        }
    }

?>