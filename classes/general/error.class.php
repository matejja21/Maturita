<?php

namespace General; // Namespace for general classes

// Static class for logging exceptions
class Error {

    // this method shows user all errors in PHP session in alerts
    public static function show() {
        if (isset($_SESSION['errors']) && !is_null($_SESSION['errors'])) {
            echo '<script>';
            foreach($_SESSION['errors'] as $error) {
                echo   'alert("'.$error.'");';
            }
            echo '</script>';
        }
        $_SESSION['errors'] = null;
    }

    // this method adds error to PHP session
    public static function add(?string $error) {
        $_SESSION['errors'][] = $error;
    }
}

?>