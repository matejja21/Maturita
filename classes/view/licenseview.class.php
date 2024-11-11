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
                            <th>License key</th>
                        </tr>';

            foreach($licenses as $license) {
                $table .= '
                        <tr>
                           <td>'.$license['license_key'].'</td>
                        </tr>';
            }

            $table .= '</table>';
            echo $table;
        }
}