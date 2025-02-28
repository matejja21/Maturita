<?php

// set namespace
namespace Controller;

// use all important classes
use Model\User as User;
use General\App as App;
use General\Config as Config;
use General\Error as Error;
use Google\Client as GClient;

// create class
class UserCon
    extends User {

        // this method handles users login
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
                        if ($id == 1) {
                            $this->changeLevel(1);
                        }
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

        // this method logouts user
        public function handleLogout() {
            $_SESSION['user'] = null;
        }

        // this method changes users secret key
        public function changeSecretKey() {
            $secret_key = bin2hex(random_bytes(16));
            try {
                $this->updateSecretKey($secret_key);
            } catch (\Throwable $e) {
                Error::add($e->GetMessage());
            }
        }
    }

?>