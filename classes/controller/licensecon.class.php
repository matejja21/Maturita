<?php

namespace Controller;

use Model\License as License;
use General\App as App;
use General\Config as Config;
use General\Error as Error;

class LicenseCon
    extends License {
    
        public function createLicense($name, $description, $doc_url, $month_price, $currency) {
            $this->insertLicense($name, $description, $doc_url, $month_price, $currency);
        }

        public function changeLicense($name, $description, $doc_url, $month_price, $currency) {
            $this->updateLicense($name, $description, $doc_url, $month_price, $currency);
        }

        public function deactivateLicense() {
            try {
                $this->updateLicenseActivation(0);
            } catch (Throwable $e) {
                Error::add("You can not deactivate another users licenses");
            }
        }

        public function activateLicense() {
            try {
                $this->updateLicenseActivation(1);
            } catch (Throwable $e) {
                Error::add("You can not deactivate another users licenses");
            }
        }

        public function getLicense() {
            try {
                $data = $this->selectLicense();
                if (count($data) > 0) {
                    return $data[0];
                } else {
                    return false;
                }
            } catch (Throwable $e) {
                return false;
                Error::add("No license type");
            }
        }

        public function getLicenseByLicenseKey($license_key_id) {
            try {
                $data = $this->selectLicenseByLicenseKeyId($license_key_id);
                if (count($data) > 0) {
                    return $data[0];
                } else {
                    return false;
                }
            } catch (Throwable $e) {
                return false;
                Error::add("No license");
            }
        }
    }


