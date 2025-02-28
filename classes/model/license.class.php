<?php

// set namespace
namespace Model;

// use all important classes
use General\Db as Db;
use General\Config as Config;
use General\Log as Log;
use General\Error as Error;

// create class
class License {

    // class properties
    public ?int $id;
    public ?string $name;
    public ?string $description;
    public ?string $docUrl;
    public ?int $monthly_price;
    public ?string $currency;

    // constructor
    public function __construct(int $id = null, string $name = null, string $description = null, string $docUrl = null, int $monthly_price = null, string $currency = null) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->docUrl = $docUrl;
        $this->monthly_price = $monthly_price;
        $this->currency = $currency;
    }

    // this method gets license from database by its id
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

    // this method gets all licenses from database
    protected function getLicenses() {
        try {
            return Db::FExec('data/sql/selectLicenses.sql');
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    // this method gets all licenses from database with couts how much license keys from one license does the user have
    protected function selectLicensesWithUserCount($user_id) {
        try {
            return Db::FExec('data/sql/selectLicenseWithUserCount.sql', ['user_id' => $user_id]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    // this method get license from database
    public function selectLicense() {
        try {
            return Db::FExec('data/sql/selectLicense.sql', ['license_id' => $this->id]);
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    // this method insert license to database
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

    // this method updates license in database
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

    // this method updates licenses activation in database
    public function updateLicenseActivation($bool) {
        try {
            return Db::FExec('data/sql/updateLicenseActivation.sql', ['license_id' => $this->id, 'activated' => $bool]);
        } catch (Throwable $e) {
            Log::Add($e);
            Error::add($e->GetMessage());
            return false;
        }
    }

    // this method gets license keys license in database by license keys id
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

    // this method gets license in database by its id
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
