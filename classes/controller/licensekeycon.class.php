<?php

namespace Controller;

use Model\LicenseKey as LicenseKey;
use General\App as App;
use General\Config as Config;
use General\Error as Error;

class LicenseKeyCon
    extends LicenseKey {

        public function validateLicenseKeyOwner($user_id) {
            if ($this->licenseKeyOwner() == $user_id) {
                return true;
            } else {
                return false;
            }
        }
    
        public function createLicenseKey($user_id, $license_id, $month_num) {
            $this->insertLicenseKey(
                $user_id,
                $license_id,
                date('Y-m-d', strtotime("+".$month_num." months", time())),
                bin2hex(random_bytes(32))
            );
        }

        public function changeLicenseKey(int $user_id) {
            $license_key_owner = $this->licenseKeyOwner();
            if ($license_key_owner && $license_key_owner == $user_id) {
                $this->updateLicenseKey(bin2hex(random_bytes(32)));
            } else {
                Error::add("You can not change another users licenses");
            }
        }

        public function changeExpirationDate(int $user_id, int $month_num) {
            $license_key_owner = $this->licenseKeyOwner();
            if ($license_key_owner && $license_key_owner == $user_id) {
                $expiration_date = $this->selectExpirationDate();
                if ($expiration_date) {
                    $exp_date_int = strtotime($expiration_date);
                    if ($exp_date_int > time()) {
                        $expiration_date = date('Y-m-d', strtotime("+".$month_num." months", $exp_date_int));
                    } else {
                        $expiration_date = date('Y-m-d', strtotime("+".$month_num." months", time()));
                    }
                    $this->updateExpirationDate($expiration_date);
                } else {
                    Error::add("You Cant get licenses key expiration date");
                }
                
            } else {
                Error::add("You can not change another users license key expiration date");
            }
        }

        public function deactivateLicenseKey(int $user_id) {
            $license_key_owner = $this->licenseKeyOwner();
            echo "License key owner = ".$license_key_owner;
            if ($license_key_owner && $license_key_owner == $user_id) {
                $this->updateLicenseKeyActivation(0);
            } else {
                Error::add("You can not deactivate another users license keys");
            }
        }

        public function activateLicenseKey(int $user_id) {
            $license_key_owner = $this->licenseKeyOwner();
            echo "License key owner = ".$license_key_owner;
            if ($license_key_owner && $license_key_owner == $user_id) {
                $this->updateLicenseKeyActivation(1);
            } else {
                Error::add("You can not activate another users license keys");
            }
        }

        public function validateLicenseKey(string $license_key, bool $info = false) {
            $return = [];
            $errors = [];
            if (Config::$general['license_type'] == 'secret') {
                
            } else if (Config::$general['license_type'] == 'basic') {
                try {
                    $data = $this->selectLicenseKeyByLicenseKey($license_key);
                    if ($data) {
                        if (strtotime($data['expiration_date']) >= time()) {
                            $return['valid'] = true;
                        } else {
                            $return['valid'] = false;
                            $errors[] = ["message" => "license key expired"];
                        }

                        if ($info) {
                            $return['info'] = [
                                'user' => $data['email'],
                                'license' => $data['name'],
                                'expiration_date' => $data['expiration_date']
                            ];
                        }
                    } else {
                        $return['valid'] = false;
                        $errors[] = ["message" => 'this license key is not in database'];
                    }
                } catch (Throwable $e) {
                    $return['valid'] = false;
                    $errors[] = ["message" => $e->GetMeddage()];
                }

                

            } else {

            }
            if (count($errors) > 0) {
                $return['errors'] = $errors;
            }
            return $return;
        }

}