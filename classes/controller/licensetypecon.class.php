<?php

namespace Controller;

use Model\License as License;
use General\App as App;
use General\Config as Config;
use General\Error as Error;

class LicenseCon
    extends License {
    
        public function createLicenseType($name, $description, $doc_url, $month_price, $currency) {
            $this->insertLicenseType($name, $description, $doc_url, $month_price, $currency);
        }
    }


