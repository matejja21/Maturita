<?php

namespace View;

use Model\License as License;
use General\App as App;
use General\Config as Config;
use General\Error as Error;
use General\User as User;

class LicenseView  
    extends License {

        public function showLicenseInfo() {
            if ($this->id == 0) {
                echo 'There is no license type with this ID!';
            } else {
                $license = $this->selectLicenseById();
                if ($license) {
                    $license = $license[0];
                    echo '
    
                        <h1>'.$license['name'].'</h1>
                        <p>'.$license['description'].'</p>
                        <a href="'.$license['doc_url'].'" class="btn btn-primary">Documentation</a>
                        <div class="container mt-5">
                            <form action="action/checkout.php" method="GET">
                                <p>price per month: '.$license['monthly_price'].' '.$license['currency'].'</p>
                                <input type="hidden" name="license_id" value="'.$license['license_id'].'">
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

        public function showAllLicenses($user) {
            if ($user->isLoggedIn()) {
                $licenses = $this->selectLicensesWithUserCount($user->id);
            } else {
                $licenses = $this->getLicenses();
            }
            $cards = "";
            if ($licenses) {
                foreach($licenses as $license) {

                    if (isset($license['user_num_licenses'])) {
                        $user_num_licenses = '<p>'.$license['user_num_licenses'].'</p>';
                    } else {
                        $user_num_licenses = "";
                    }

                    $cards .= '
                            <div class="col justify-center">
                                <div class="card shadow" style="width: 18rem;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-10">
                                                <h5 class="card-title">'.$license['name'].'</h5>
                                            </div>
                                            <div class="col">                                       
                                                <p>'.$user_num_licenses.'</p>
                                            </div>
                                        </div>
                                        <p class="card-text">'.App::str_short($license['description'], 50, 0, '...').'</p>
                                        <a href="license.php?id='.$license['license_id'].'" class="card-link">Show more</a>
                                    </div>
                                </div>
                            </div>';
                }

                echo $cards;
            } else {
                Error::show();
            }
        
            
        }

        public function showAllLicensesAdmin() {
            $licenses = $this->getLicenses();

            if ($licenses) {
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

                foreach($licenses as $license) {

                    if ($license['activated'] == 1) {
                        $activation_link = '<a class="btn btn-primary" href="action/deactivateLicense.php?license_id='.$license['license_id'].'">Deactivate</a>';
                    } else {
                        $activation_link = '<a class="btn btn-primary" href="action/activateLicense.php?license_id='.$license['license_id'].'">Activate</a>';
                    }

                    $table .= '
                            <tr>
                                <td>'.$license['license_id'].'</td>
                                <td>'.$license['name'].'</td>
                                <td>'.$license['description'].'</td>
                                <td>'.$license['doc_url'].'</td>
                                <td>'.$license['monthly_price'].'</td>
                                <td>'.$license['currency'].'</td>
                                <td><a class="btn btn-primary" href="update.php?license_id='.$license['license_id'].'">Update</a></td>
                                <td >'.$activation_link.'</td>
                            </tr>';
                }

                $table .= '</table></div>';
                echo $table;
            } else {
                Error::show();
            }
        
            
        }

        public function licenseUpdateForm() {
            $license = $this->selectLicense();

            if ($license) {
                $license = $license[0];

                switch ($license['currency']) {
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
                <form method="POST" action="action/updateLicense.php">
                    <input type="hidden" name="license_id" value="'.$this->id.'">

                    <div class="form-group">
                        <lable for="create_name">Name: </lable>
                        <input type="text" id="create_name" name="name" value="'.$license['name'].'" class="form-control">
                    </div>

                    <div class="form-group">
                        <lable for="create_description">Description: </lable>
                        <textarea id="create_description" name="description" class="form-control">'.$license['description'].'</textarea>
                    </div>

                    <div class="form-group">
                        <lable for="create_doc_url">Documentation URL: </lable>
                        <input type="text" id="create_doc_url" name="doc_url" value="'.$license['doc_url'].'" class="form-control">
                    </div>

                    <div class="form-group">
                        <lable for="create_monthly_price">Monthley price: </lable>
                        <input type="number" min="0" max="100" id="create_name" name="month_price" value="'.$license['monthly_price'].'" class="form-control">
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