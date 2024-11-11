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

}