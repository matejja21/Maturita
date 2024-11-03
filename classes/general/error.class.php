<?php

namespace General; // Namespace for general classes

// Static class for logging exceptions
class Error {

    public static function show() {
        if (isset($_SESSION['errors']) && !is_null($_SESSION['errors'])) {
            echo '<script>';
            foreach($_SESSION['errors'] as $error) {
                echo 'alert("'.$error.'")';
            }
            echo '</script>';
        }
        $_SESSION['errors'] = null;
    }

    public static function add(string $error) {
        $_SESSION['errors'][] = $error;
    }
}

?>