<?php

namespace View;

use Model\LicenseKey as LicenseKey;
use General\App as App;
use General\Config as Config;

class LicenseKeyView  
    extends LicenseKey {

        public function showAllUserLicenseKeys($user_id) {
            $license_keys = $this->getUserLicenseKeys($user_id);
        
            if (is_countable($license_keys) && count($license_keys) > 0) {
                $table = '<table class="table table-striped shadow">

                        

                            <tr>
                                <th scope="col">Activated</th>
                                <th scope="col">License</th>
                                <th scope="col">License key</th>
                                <th scope="col">Days to expiration</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">Number of months</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>';

                foreach($license_keys as $license_key) {
                    //var_dump($license_key);
                    if ($license_key['activated']) {
                        $activation_link = '<a class="btn btn-secondary" href="action/deactivateLicenseKey.php?license_key_id='.$license_key['license_key_id'].'" alt="deactivate license">Deactivate</a>';
                    } else {
                        $activation_link = '<a class="btn btn-secondary" href="action/activateLicenseKey.php?license_key_id='.$license_key['license_key_id'].'" alt="activate license">Activate</a>';
                    }

                    if (strtotime($license_key['expiration_date']) > strtotime(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")))) ) {
                        $expiration_date = '<span>'.$license_key['expiration_date'].'</span>';
                    } else if (strtotime($license_key['expiration_date']) < strtotime(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")))) && strtotime($license_key['expiration_date']) > time()) {
                        $expiration_date = '<span class="text-warning">'.$license_key['expiration_date'].'</span>';
                    } else {
                        $expiration_date = '<span class="text-danger">'.$license_key['expiration_date'].'</span>';
                    }

                    $num_of_days = round((strtotime($license_key['expiration_date']) - time()) / (60 * 60 * 24));
                    $table .= '
                            <tr>

                            <div class="modal fade" id="moreInfo'.$license_key['license_key_id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">More info: '.$license_key['name'].'</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>License key: </strong>'.$license_key['license_key'].'</p>
                                        <p><strong>Expiration date: </strong>'.$expiration_date.'</p>
                                        <div class="btn-toolbar">
                                            <a class="btn btn-primary mx-2" href="'.$license_key['doc_url'].'">Documentation</a>
                                            <a class="btn btn-primary mx-2" href="license.php?id='.$license_key['license_id'].'">License page</a>
                                        </div>                                    </div>
                                    </div>
                                </div>
                            </div>

                            <td >'.$license_key['activated'].'</td>
                            <td >'.$license_key['name'].'</td>
                            <td >'.\General\App::str_short($license_key['license_key'], 25).'</td>
                            <td >'.$num_of_days.'</td>
                            <td ><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#moreInfo'.$license_key['license_key_id'].'">
                                Show more
                            </button></td>
                            <td ><a class="btn btn-secondary" href="action/changeLicenseKey.php?license_key_id='.$license_key['license_key_id'].'">Change license key</td>
                            <form method="GET" action="action/checkout.php">
                                        <td >
                                            <input type="hidden" name="action_type" value="extend">
                                            <input type="number" min="1" max="36" name="month_num" value="1">
                                            <input type="hidden" name="license_key_id" value="'.$license_key['license_key_id'].'">
                                        </td>
                                        <td >
                                            <input type="submit" value="Extend license" class="btn btn-secondary">
                                        <td>
                                    </form>
                                <td >'.$activation_link.'</td>
                            </tr>';
                }

                $table .= '</table>';
                echo $table;
            } else {
                echo '<p>You have no license keys</p>';
            }
        }

        public function showAllUserLicenseKeysActivate($user_id) {
            $license_keys = $this->getUserLicenseKeysActivate($user_id);
        
            if (is_countable($license_keys) && count($license_keys) > 0) {
                $table = '<table class="table table-striped shadow">

                        

                            <tr>
                                <th scope="col">Activated</th>
                                <th scope="col">License</th>
                                <th scope="col">License key</th>
                                <th scope="col">Days to expiration</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">Number of months</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>';

                foreach($license_keys as $license_key) {
                    //var_dump($license_key);
                    if ($license_key['activated']) {
                        $activation_link = '<a class="btn btn-secondary" href="action/deactivateLicenseKey.php?license_key_id='.$license_key['license_key_id'].'" alt="deactivate license">Deactivate</a>';
                    } else {
                        $activation_link = '<a class="btn btn-secondary" href="action/activateLicenseKey.php?license_key_id='.$license_key['license_key_id'].'" alt="activate license">Activate</a>';
                    }

                    if (strtotime($license_key['expiration_date']) > strtotime(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")))) ) {
                        $expiration_date = '<span>'.$license_key['expiration_date'].'</span>';
                    } else if (strtotime($license_key['expiration_date']) < strtotime(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")))) && strtotime($license_key['expiration_date']) > time()) {
                        $expiration_date = '<span class="text-warning">'.$license_key['expiration_date'].'</span>';
                    } else {
                        $expiration_date = '<span class="text-danger">'.$license_key['expiration_date'].'</span>';
                    }

                    $num_of_days = round((strtotime($license_key['expiration_date']) - time()) / (60 * 60 * 24));
                    $table .= '
                            <tr>

                            <div class="modal fade" id="moreInfo'.$license_key['license_key_id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">More info: '.$license_key['name'].'</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>License key: </strong>'.$license_key['license_key'].'</p>
                                        <p><strong>Expiration date: </strong>'.$expiration_date.'</p>
                                        <div class="btn-toolbar">
                                            <a class="btn btn-primary mx-2" href="'.$license_key['doc_url'].'">Documentation</a>
                                            <a class="btn btn-primary mx-2" href="license.php?id='.$license_key['license_id'].'">License page</a>
                                        </div>                                    </div>
                                    </div>
                                </div>
                            </div>

                            <td >'.$license_key['activated'].'</td>
                            <td >'.$license_key['name'].'</td>
                            <td >'.\General\App::str_short($license_key['license_key'], 25).'</td>
                            <td >'.$num_of_days.'</td>
                            <td ><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#moreInfo'.$license_key['license_key_id'].'">
                                Show more
                            </button></td>
                            <td ><a class="btn btn-secondary" href="action/changeLicenseKey.php?license_key_id='.$license_key['license_key_id'].'">Change license key</td>
                            <form method="GET" action="action/checkout.php">
                                        <td >
                                            <input type="hidden" name="action_type" value="extend">
                                            <input type="number" min="1" max="36" name="month_num" value="1">
                                            <input type="hidden" name="license_key_id" value="'.$license_key['license_key_id'].'">
                                        </td>
                                        <td >
                                            <input type="submit" value="Extend license" class="btn btn-secondary">
                                        <td>
                                    </form>
                                <td >'.$activation_link.'</td>
                            </tr>';
                }

                $table .= '</table>';
                echo $table;
            } else {
                echo '<p>You have no active license keys</p>';
            }
        }

        public function showAllUserLicenseKeysDeactivate($user_id) {
            $license_keys = $this->getUserLicenseKeysDeactivate($user_id);

            if (is_countable($license_keys) && count($license_keys) > 0) {
                $table = '<table class="table table-striped shadow">

                        

                            <tr>
                                <th scope="col">Activated</th>
                                <th scope="col">License</th>
                                <th scope="col">License key</th>
                                <th scope="col">Days to expiration</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">Number of months</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>';

                foreach($license_keys as $license_key) {
                    //var_dump($license_key);
                    if ($license_key['activated']) {
                        $activation_link = '<a class="btn btn-secondary" href="action/deactivateLicenseKey.php?license_key_id='.$license_key['license_key_id'].'" alt="deactivate license">Deactivate</a>';
                    } else {
                        $activation_link = '<a class="btn btn-secondary" href="action/activateLicenseKey.php?license_key_id='.$license_key['license_key_id'].'" alt="activate license">Activate</a>';
                    }

                    if (strtotime($license_key['expiration_date']) > strtotime(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")))) ) {
                        $expiration_date = '<span>'.$license_key['expiration_date'].'</span>';
                    } else if (strtotime($license_key['expiration_date']) < strtotime(date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+14, date("Y")))) && strtotime($license_key['expiration_date']) > time()) {
                        $expiration_date = '<span class="text-warning">'.$license_key['expiration_date'].'</span>';
                    } else {
                        $expiration_date = '<span class="text-danger">'.$license_key['expiration_date'].'</span>';
                    }

                    $num_of_days = round((strtotime($license_key['expiration_date']) - time()) / (60 * 60 * 24));
                    $table .= '
                            <tr>

                            <div class="modal fade" id="moreInfo'.$license_key['license_key_id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">More info: '.$license_key['name'].'</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>License key: </strong>'.$license_key['license_key'].'</p>
                                        <p><strong>Expiration date: </strong>'.$expiration_date.'</p>
                                        <div class="btn-toolbar">
                                            <a class="btn btn-primary mx-2" href="'.$license_key['doc_url'].'">Documentation</a>
                                            <a class="btn btn-primary mx-2" href="license.php?id='.$license_key['license_id'].'">License page</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <td >'.$license_key['activated'].'</td>
                            <td >'.$license_key['name'].'</td>
                            <td >'.\General\App::str_short($license_key['license_key'], 25).'</td>
                            <td >'.$num_of_days.'</td>
                            <td ><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#moreInfo'.$license_key['license_key_id'].'">
                                Show more
                            </button></td>
                            <td ><a class="btn btn-secondary" href="action/changeLicenseKey.php?license_key_id='.$license_key['license_key_id'].'">Change license key</td>
                            <form method="GET" action="action/checkout.php">
                                        <td >
                                            <input type="hidden" name="action_type" value="extend">
                                            <input type="number" min="1" max="36" name="month_num" value="1">
                                            <input type="hidden" name="license_key_id" value="'.$license_key['license_key_id'].'">
                                        </td>
                                        <td >
                                            <input type="submit" value="Extend license" class="btn btn-secondary">
                                        <td>
                                    </form>
                                <td >'.$activation_link.'</td>
                            </tr>';
                }

                $table .= '</table>';
                echo $table;
            } else {
                echo '<p>You have no deactive license keys</p>';
            }
        
            
        }
}