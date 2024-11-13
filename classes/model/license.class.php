<?php

namespace Model;

use General\Db as Db;
use General\Config as Config;
use General\Log as Log;
use General\Error as Error;

class License {
    public ?int $license_id; 
    public ?int $user_id; 
    public ?int $license_type_id; 
    public ?string $license_key; 
    public ?string $create_date; 
    public ?string $expiration_date;

    public function __construct(int $license_id = null, int $user_id = null, int $license_type_id = null, string $license_key = null, string $create_date = null, string $expiration_date = null) {
        $this->license_id = $license_id; 
        $this->user_id = $user_id; 
        $this->license_type_id = $license_type_id; 
        $this->license_key = $license_key; 
        $this->create_date = $create_date; 
        $this->expiration_date = $expiration_date;
    }

    public function insertLicense($user_id, $license_id, $expiration_date, $license_key) {
        try {
            return Db::FExec('data/sql/addLicense.sql', 
                ['user_id' => $user_id,
                'license_type_id' => $license_id,
                'expiration_date' => $expiration_date,
                'license_key' => openssl_encrypt($license_key, 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, "abcdefghchijklmn")
                ], true);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function getUserLicenses($user_id) {
        try {
            $data = Db::FExec('data/sql/selectUserLicenses.sql', ['user_id' => $user_id]);
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['license_key'] = openssl_decrypt($data[$i]['license_key'], 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, "abcdefghchijklmn");
            }
            return $data;
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function licenseOwner() {
        //echo "this happened";
        if ($this->license_id) {
            try {
                $data = Db::FExec('data/sql/selectLicenseOwner.sql', ['license_id' => $this->license_id]);
                return $data[0]['user_id'];
            } catch (Exception $e) {
                Log::Add($e);
                Error::add($e->GetMessage());
                return false;
            }
        } else {
            return false;
        }
    }

    public function updateLicense($license) {
        try {
            //echo "This happend too";
            return Db::FExec('data/sql/updateLicense.sql', ['license_key' => openssl_encrypt($license, 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, "abcdefghchijklmn"), 'license_id' => $this->license_id]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

}

?>