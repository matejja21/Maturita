<?php

namespace General; // Namespace for general classes

// Static class for logging exceptions
class Error {

    public static function show() {
        if (isset($_SESSION['errors']) && !is_null($_SESSION['errors'])) {
            echo '<div class="container">';
            foreach($_SESSION['errors'] as $error) {
                echo   '<div class="alert alert-danger mt-2 alert-dismissible" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            '.$error.'
                        </div>';
                //echo $error;
            }
            echo '</div>';
        }
        $_SESSION['errors'] = null;
    }

    public static function add(?string $error) {
        $_SESSION['errors'][] = $error;
    }
}

?>