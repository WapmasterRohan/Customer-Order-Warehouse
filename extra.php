<?php
    function random_string($prefix, $length) {
        for($count = 0; $count < $length; $count++) {
            $prefix .= random_char();
        }
        return $prefix;
    }

    function random_char() {
        $charset = "0123456789";
        $length = strlen($charset);
        $position = rand(0, $length-1);
        return ($charset[$position]);
    }
?>