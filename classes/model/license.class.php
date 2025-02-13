<?php

namespace Model;

use General\Db as Db;
use General\Config as Config;
use General\Log as Log;
use General\Error as Error;

class License {
    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?string $docUrl;
    public ?int $monthly_price;
    public ?string $currency;

    public function __construct(int $id = null, string $name = null, string $description = null, string $docUrl = null, int $monthly_price = null, string $currency = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->docUrl = $docUrl;
        $this->monthly_price = $monthly_price;
        $this->currency = $currency;
    }

    protected function getLicenseById($id) {
        try {
            $data = Db::FExec('data/sql/selectLicenseById.sql', ["id" => $id])[0];
            $this->id = $data['license_id'];
            $this->name = $data['name'];
            $this->description = $data['description'];
            $this->docUrl = $data['doc_url'];
            $this->monthly_price = $data['monthly_price'];
            $this->currency = $data['currency'];
            return $data;
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    protected function getLicenses() {
        try {
            return Db::FExec('data/sql/selectLicenses.sql');
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    protected function selectLicensesWithUserCount($user_id) {
        try {
            return Db::FExec('data/sql/selectLicenseWithUserCount.sql', ['user_id' => $user_id]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    public function selectLicense() {
        try {
            return Db::FExec('data/sql/selectLicense.sql', ['license_id' => $this->id]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    protected function insertLicense($name, $description, $doc_url, $month_price, $currency) {
        try {
            return Db::FExec('data/sql/insertLicense.sql', 
            [
                'name' => $name, 
                'description' => $description, 
                'doc_url' => $doc_url,
                'monthly_price' => $month_price,
                'currency' => $currency
            ]
            ,1);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    protected function updateLicense($name, $description, $doc_url, $month_price, $currency) {
        try {
            return Db::FExec('data/sql/updateLicense.sql', 
            [
                'license_id' => $this->id,
                'name' => $name, 
                'description' => $description, 
                'doc_url' => $doc_url,
                'monthly_price' => $month_price,
                'currency' => $currency
            ]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    public function updateLicenseActivation($bool) {
        try {
            //echo "This happend too";
            return Db::FExec('data/sql/updateLicenseActivation.sql', ['license_id' => $this->id, 'activated' => $bool]);
        } catch (Throwable $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    protected function selectLicenseByLicenseKeyId($license_key_id) {
        try {
            return Db::FExec('data/sql/selectLicenseByLicenseKeyId.sql', 
            [
                'license_key_id' => $license_key_id
            ]);
        } catch (Exception $e) {
            return false;
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    protected function selectLicenseById() {
        try {
            return Db::FExec('data/sql/selectLicenseById.sql', 
            [
                'id' => $this->id
            ]);
        } catch (Exception $e) {
            return false;
            Log::Add($e);
            Error::add($e->Message);
        }
    }
}
