<?php

namespace Controller;

use Model\LicenseType as LicenseType;
use General\App as App;
use General\Config as Config;
use General\Error as Error;

class LicenseTypeCon
    extends LicenseType {
    
        public function createLicenseType($name, $description, $doc_url, $month_price, $currency) {
            $this->insertLicenseType($name, $description, $doc_url, $month_price, $currency);
        }

        public function changeLicenseType($name, $description, $doc_url, $month_price, $currency) {
            $this->updateLicenseType($name, $description, $doc_url, $month_price, $currency);
        }

        public function deactivateLicenseType() {
            try {
                $this->updateLicenseTypeActivation(0);
            } catch (Throwable $e) {
                Error::add("You can not deactivate another users licenses");
            }
        }

        public function activateLicenseType() {
            try {
                $this->updateLicenseTypeActivation(1);
            } catch (Throwable $e) {
                Error::add("You can not deactivate another users licenses");
            }
        }

        public function getLicenseType() {
            try {
                $data = $this->selectLicenseType();
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

        public function getLicenseTypeByLicense($license_id) {
            try {
                $data = $this->selectLicensTypeByLicenseId($license_id);
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
    }


