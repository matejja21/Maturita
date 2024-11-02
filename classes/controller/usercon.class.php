<?php

namespace Controller;

use Model\User as User;
use General\App as App;
use General\Config as Config;
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
                    $userid = $payload['sub'];
                    //var_dump($payload);
                    var_dump($payload);
                } else {
                    
                }
            } else {
                //var_dump($_POST);
            }
        }


    }

?>