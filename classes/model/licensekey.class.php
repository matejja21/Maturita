<?php

namespace Model;

use General\Db as Db;
use General\Config as Config;
use General\Log as Log;
use General\Error as Error;

class LicenseKey {
    public ?int $license_key_id; 
    public ?int $user_id; 
    public ?int $license_id; 
    public ?string $license_key; 
    public ?string $create_date; 
    public ?string $expiration_date;

    public function __construct(int $license_key_id = null, int $user_id = null, int $license_id = null, string $license_key = null, string $create_date = null, string $expiration_date = null) {
        $this->license_key_id = $license_key_id; 
        $this->user_id = $user_id; 
        $this->license_id = $license_id; 
        $this->license_key = $license_key; 
        $this->create_date = $create_date; 
        $this->expiration_date = $expiration_date;
    }

    public function insertLicenseKey($user_id, $license_key_id, $expiration_date, $license_key) {
        try {
            return Db::FExec('data/sql/addLicenseKey.sql', 
                ['user_id' => $user_id,
                'license_id' => $license_key_id,
                'expiration_date' => $expiration_date,
                'license_key' => openssl_encrypt($license_key, 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv'])
                ], true);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function getUserLicensesKey($user_id) {
        try {
            $data = Db::FExec('data/sql/selectUserLicenses.sql', ['user_id' => $user_id]);
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['license_key'] = openssl_decrypt($data[$i]['license_key'], 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv']);
            }
            return $data;
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function getUserLicenseKeysActivate($user_id) {
        try {
            $data = Db::FExec('data/sql/selectUserLicenseKeysActivate.sql', ['user_id' => $user_id]);
            if (is_countable($data)) {
                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['license_key'] = openssl_decrypt($data[$i]['license_key'], 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv']);
                }
            }
            return $data;
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function getUserLicenseKeysDeactivate($user_id) {
        try {
            $data = Db::FExec('data/sql/selectUserLicenseKeysDeactivate.sql', ['user_id' => $user_id]);
            if (is_countable($data)) {
                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['license_key'] = openssl_decrypt($data[$i]['license_key'], 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv']);
                }
            }
            return $data;
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function licenseKeyOwner() {
        //echo "this happened";
        if ($this->license_key_id) {
            try {
                $data = Db::FExec('data/sql/selectLicenseKeyOwner.sql', ['license_key_id' => $this->license_key_id]);
                var_dump($data);
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

    public function updateLicenseKey($license_key) {
        try {
            //echo "This happend too";
            return Db::FExec('data/sql/updateLicenseKey.sql', ['license_key' => openssl_encrypt($license_key, 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv']), 'license_key_id' => $this->license_key_id]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function selectExpirationDate() {
        try {
            //echo "This happend too";
            $data = Db::FExec('data/sql/selectLicenseKeyExpirationDate.sql', ['license_key_id' => $this->license_key_id]);
            if (isset($data[0]['expiration_date'])) {
                return $data[0]['expiration_date'];
            } else {
                return false;
            }
        } catch (Throwable $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function updateExpirationDate($expiration_date) {
        try {
            //echo "This happend too";
            return Db::FExec('data/sql/updateLicenseKeyExpirationDate.sql', ['license_key_id' => $this->license_key_id, 'expiration_date' => $expiration_date]);
        } catch (Throwable $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function updateLicenseKeyActivation($bool) {
        try {
            //echo "This happend too";
            return Db::FExec('data/sql/updateLicenseKeyActivation.sql', ['license_key_id' => $this->license_key_id, 'activated' => $bool]);
        } catch (Throwable $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    public function selectLicenseKeyByLicenseKey() {
        try {
            $data = Db::FExec('data/sql/selectLicenseKeyByLicenseKey.sql', ['license_key' => openssl_encrypt($this->license_key, 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv'])]);
            if (isset($data[0])) {
                $data[0]['license_key'] = openssl_decrypt($data[0]['license_key'], 'aes-256-cbc-hmac-sha256', Config::$general['secret_key'], 0, Config::$general['iv']);
                return $data[0];
            } else {
                return false;
            }
        } catch (Throwable $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }


}

?>