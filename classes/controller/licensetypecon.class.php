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
    }


