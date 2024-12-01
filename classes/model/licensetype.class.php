<?php

namespace Model;

use General\Db as Db;
use General\Config as Config;
use General\Log as Log;
use General\Error as Error;

class LicenseType {
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

    protected function getLicenseTypeById($id) {
        try {
            $data = Db::FExec('data/sql/selectLicenseTypeById.sql', ["id" => $id])[0];
            $this->id = $data['license_type_id'];
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

    protected function getLicenseTypes() {
        try {
            return Db::FExec('data/sql/selectLicenseTypes.sql');
        } catch (Exception $e) {
            Log::Add($e);
            Error::add($e->Message);
        }
    }

    protected function insertLicenseType($name, $description, $doc_url, $month_price, $currency) {
        try {
            return Db::FExec('data/sql/insertLicenseType.sql', 
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
}