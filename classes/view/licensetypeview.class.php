<?php

namespace View;

use Model\LicenseType as LicenseType;
use General\App as App;
use General\Config as Config;
use General\Error as Error;

class LicenseTypeView  
    extends LicenseType {

        public function showAllLicenseTypes() {
            $licenseTypes = $this->getLicenseTypes();

            if ($licenseTypes) {
                $table = '<table>
                <tr>
                    <th>License Type Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Documentation URL</th>
                    <th>Monthly price</th>
                    <th>Currency</th>
                    <th>number of month</th>
                    <th></th>
                </tr>';

                foreach($licenseTypes as $licenseType) {
                    $table .= '
                            <tr>
                                <td>'.$licenseType['license_type_id'].'</td>
                                <td>'.$licenseType['name'].'</td>
                                <td>'.$licenseType['description'].'</td>
                                <td>'.$licenseType['doc_url'].'</td>
                                <td>'.$licenseType['monthly_price'].'</td>
                                <td>'.$licenseType['currency'].'</td>
                                <form method="POST" action="action/createLicense.php">
                                    <td>
                                        <input type="number" min="1" max="36" name="month_num" value="1">
                                        <input type="hidden" name="license_type_id" value="'.$licenseType['license_type_id'].'">
                                    </td>
                                    <td>
                                        <input type="submit" value="Get license">
                                    <td>
                                </form>
                            </tr>';
                }

                $table .= '</table>';
                echo $table;
            } else {
                Error::show();
            }
        
            
        }

        public function showAllLicenseTypesAdmin() {
            $licenseTypes = $this->getLicenseTypes();

            if ($licenseTypes) {
                $table = '<table>
                <tr>
                    <th>License Type Id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Documentation URL</th>
                    <th>Monthly price</th>
                    <th>Currency</th>
                    <th></th>
                </tr>';

                foreach($licenseTypes as $licenseType) {
                    $table .= '
                            <tr>
                                <td>'.$licenseType['license_type_id'].'</td>
                                <td>'.$licenseType['name'].'</td>
                                <td>'.$licenseType['description'].'</td>
                                <td>'.$licenseType['doc_url'].'</td>
                                <td>'.$licenseType['monthly_price'].'</td>
                                <td>'.$licenseType['currency'].'</td>
                                <td><a href="update.php?license_type_id='.$licenseType['license_type_id'].'">Update</a></td>
                                <td><a href="action/activateLicenseType.php?license_type_id='.$licenseType['license_type_id'].'">Deactivate</a></td>
                            </tr>';
                }

                $table .= '</table>';
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

                    <lable for="create_name">Name: </lable>
                    <input type="text" id="create_name" name="name" value="'.$licenseType['name'].'">

                    <lable for="create_description">Description: </lable>
                    <textarea id="create_description" name="description">'.$licenseType['description'].'</textarea>

                    <lable for="create_doc_url">Documentation URL: </lable>
                    <input type="text" id="create_doc_url" name="doc_url" value="'.$licenseType['doc_url'].'">

                    <lable for="create_monthly_price">Monthley price: </lable>
                    <input type="number" min="0" max="100" id="create_name" name="month_price" value="'.$licenseType['monthly_price'].'">

                    <lable for="create_currency">Currency: </lable>
                    <select id="create_currency" name="currency">
                    '.$currency_options.'
                    </select>
                    <input type="submit">
                </form>
            ';


            } else {
                $form = "nah";
            }

            echo $form;
        }

}