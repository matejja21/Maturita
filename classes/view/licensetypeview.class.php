<?php

namespace View;

use Model\LicenseType as LicenseType;
use General\App as App;
use General\Config as Config;
use General\Error as Error;

class LicenseTypeView  
    extends LicenseType {

        public function showLicenseTypeInfo() {
            if ($this->id == 0) {
                echo 'There is no license type with this ID!';
            } else {
                $licenseType = $this->selectLicensTypeById();
                if ($licenseType) {
                    $licenseType = $licenseType[0];
                    echo '
    
                        <h1>'.$licenseType['name'].'</h1>
                        <p>'.$licenseType['description'].'</p>
                        <a href="'.$licenseType['doc_url'].'" class="btn btn-primary">Documentation</a>
                        <div class="container mt-5">
                            <form action="action/checkout.php" method="GET">
                                <p>price per month: '.$licenseType['monthly_price'].' '.$licenseType['currency'].'</p>
                                <input type="hidden" name="license_type_id" value="'.$licenseType['license_type_id'].'">
                                <input type="hidden" name="action_type" value="new">
                                <lable for="month_num">Month number: </lable>
                                <input type="number" min="1" max="36" value="1" name="month_num" id="month_num">
                                <input type="submit" value="Buy license" class="btn btn-primary">
                            </form>
                        </div>
                    ';
                } else {
                    echo 'Something wrong with database';
                }
            }
            
        }

        public function showAllLicenseTypes() {
            $licenseTypes = $this->getLicenseTypes();
            $cards = "";
            if ($licenseTypes) {
                foreach($licenseTypes as $licenseType) {

                
                    $cards .= '
                            <div class="col justify-center">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$licenseType['name'].'</h5>
                                        <p class="card-text">'.App::str_short($licenseType['description'], 50, 0, '...').'</p>
                                        <a href="license_type.php?id='.$licenseType['license_type_id'].'" class="card-link">Show more</a>
                                    </div>
                                </div>
                            </div>';
                }

                echo $cards;
            } else {
                Error::show();
            }
        
            
        }

        public function showAllLicenseTypesAdmin() {
            $licenseTypes = $this->getLicenseTypes();

            if ($licenseTypes) {
                $table = '<div class="container" style="overflow-x: auto;"><table class="table table-striped w-100">
                <tr>
                    <th>License Type Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Documentation URL</th>
                    <th>Monthly price</th>
                    <th>Currency</th>
                    <th></th>
                    <th></th>
                </tr>';

                foreach($licenseTypes as $licenseType) {

                    if ($licenseType['activated'] == 1) {
                        $activation_link = '<a class="btn btn-primary" href="action/deactivateLicenseType.php?license_type_id='.$licenseType['license_type_id'].'">Deactivate</a>';
                    } else {
                        $activation_link = '<a class="btn btn-primary" href="action/activateLicenseType.php?license_type_id='.$licenseType['license_type_id'].'">Activate</a>';
                    }

                    $table .= '
                            <tr>
                                <td>'.$licenseType['license_type_id'].'</td>
                                <td>'.$licenseType['name'].'</td>
                                <td>'.$licenseType['description'].'</td>
                                <td>'.$licenseType['doc_url'].'</td>
                                <td>'.$licenseType['monthly_price'].'</td>
                                <td>'.$licenseType['currency'].'</td>
                                <td><a class="btn btn-primary" href="update.php?license_type_id='.$licenseType['license_type_id'].'">Update</a></td>
                                <td >'.$activation_link.'</td>
                            </tr>';
                }

                $table .= '</table></div>';
                echo $table;
            } else {
                Error::show();
            }
        
            
        }

        public function licenseTypeUpdateForm() {
            $licenseType = $this->selectLicenseType();

            if ($licenseType) {
                $licenseType = $licenseType[0];

                switch ($licenseType['currency']) {
                    case 'eur':
                        $currency_options = '
                        <option value="eur" selected>EUR</option>
                        <option value="czk">CZK</option>
                        <option value="usd">USD</oprion>
                        ';
                        break;
                    case 'czk':
                        $currency_options = '
                        <option value="eur">EUR</option>
                        <option value="czk" selected>CZK</option>
                        <option value="usd">USD</oprion>
                        ';
                        break;
                    case 'usd':
                        $currency_options = '
                        <option value="eur">EUR</option>
                        <option value="czk">CZK</option>
                        <option value="usd" selected>USD</oprion>
                        ';
                        break;
                    default:
                    $currency_options = '
                        <option value="eur">EUR</option>
                        <option value="czk">CZK</option>
                        <option value="usd" selected>USD</oprion>
                        ';
                        break;
                }
                    

                $form = '
                <form method="POST" action="action/updateLicenseType.php">
                    <input type="hidden" name="license_type_id" value="'.$this->id.'">

                    <div class="form-group">
                        <lable for="create_name">Name: </lable>
                        <input type="text" id="create_name" name="name" value="'.$licenseType['name'].'" class="form-control">
                    </div>

                    <div class="form-group">
                        <lable for="create_description">Description: </lable>
                        <textarea id="create_description" name="description" class="form-control">'.$licenseType['description'].'</textarea>
                    </div>

                    <div class="form-group">
                        <lable for="create_doc_url">Documentation URL: </lable>
                        <input type="text" id="create_doc_url" name="doc_url" value="'.$licenseType['doc_url'].'" class="form-control">
                    </div>

                    <div class="form-group">
                        <lable for="create_monthly_price">Monthley price: </lable>
                        <input type="number" min="0" max="100" id="create_name" name="month_price" value="'.$licenseType['monthly_price'].'" class="form-control">
                    </div>

                    <div class="form-group">
                        <lable for="create_currency">Currency: </lable>
                        <select id="create_currency" name="currency" class="form-control">
                        '.$currency_options.'
                        </select>
                    </div>

                    <input type="submit" class="btn btn-primary mt-2">
                </form>
            ';


            } else {
                $form = "nah";
            }

            echo $form;
        }

}