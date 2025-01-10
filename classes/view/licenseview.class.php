<?php

namespace View;

use Model\License as License;
use General\App as App;
use General\Config as Config;

class LicenseView  
    extends License {

        public function showAllUserLicenses($user_id) {
            $licenses = $this->getUserLicenses($user_id);
        
            $table = '<table>
                        <tr>
                            <th>Activated</th>
                            <th>License key</th>
                            <th>License type</th>
                            <th>Expiration date</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>';

            foreach($licenses as $license) {
                //var_dump($license);
                if ($license['activated']) {
                    $activation_link = '<a href="action/deactivateLicense.php?license_id='.$license['license_id'].'" alt="deactivate license">Deactivate</a>';
                } else {
                    $activation_link = '<a href="action/activateLicense.php?license_id='.$license['license_id'].'" alt="activate license">Activate</a>';
                }
                $table .= '
                        <tr>
                           <td>'.$license['activated'].'</td>
                           <td>'.$license['license_key'].'</td>
                           <td>'.$license['name'].'</td>
                           <td>'.$license['expiration_date'].'</td>
                           <td><a href="action/changeLicense.php?license_id='.$license['license_id'].'">Change license key</td>
                           <form method="GET" action="action/checkout.php">
                                    <td>
                                        <input type="hidden" name="action_type" value="extend">
                                        <input type="number" min="1" max="36" name="month_num" value="1">
                                        <input type="hidden" name="license_id" value="'.$license['license_id'].'">
                                    </td>
                                    <td>
                                        <input type="submit" value="Get license">
                                    <td>
                                </form>
                            <td>'.$activation_link.'</td>
                        </tr>';
            }

            $table .= '</table>';
            echo $table;
        }
}