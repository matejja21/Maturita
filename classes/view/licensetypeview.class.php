<?php

namespace View;

use Model\LicenseType as LicenseType;
use General\App as App;
use General\Config as Config;

class LicenseTypeView  
    extends LicenseType {

        public function showAllLicenseTypes() {
            $licenseTypes = $this->getLicenseTypes();
        
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
        }

}