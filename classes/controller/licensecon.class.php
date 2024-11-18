<?php

namespace Controller;

use Model\License as License;
use General\App as App;
use General\Config as Config;
use General\Error as Error;

class LicenseCon
    extends License {
    
        public function createLicense($user_id, $license_type_id, $month_num) {
            $this->insertLicense(
                $user_id,
                $license_type_id,
                date('Y-m-d', strtotime("+".$month_num." months", time())),
                bin2hex(random_bytes(32))
            );
        }

        public function changeLicense(int $user_id) {
            $license_owner = $this->licenseOwner();
            if ($license_owner && $license_owner == $user_id) {
                $this->updateLicense(bin2hex(random_bytes(32)));
            } else {
                Error::add("You can not change another users licenses");
            }
        }

        public function changeExpirationDate(int $user_id, int $month_num) {
            $license_owner = $this->licenseOwner();
            if ($license_owner && $license_owner == $user_id) {
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
                    Error::add("YCant get licenses expiration date");
                }
                
            } else {
                Error::add("You can not change another users license expiration date");
            }
        }

        public function deactivateLicense(int $user_id) {
            $license_owner = $this->licenseOwner();
            if ($license_owner && $license_owner == $user_id) {
                $this->updateLicenseActivation(0);
            } else {
                Error::add("You can not deactivate another users licenses");
            }
        }

        public function activateLicense(int $user_id) {
            $license_owner = $this->licenseOwner();
            if ($license_owner && $license_owner == $user_id) {
                $this->updateLicenseActivation(1);
            } else {
                Error::add("You can not activate another users licenses");
            }
        }

}