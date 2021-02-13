<?php

function between(int $number, int $min, int $max): bool {
    /**
     * Basic check if a number is between two other numbers
     * 
     * @param int $number
     * @param int $min
     * @param int $max
     * 
     * @return bool
     */
    return $number >= $min && $number <= $max;
}

if (!function_exists("str_starts_with")) {
    function str_starts_with(string $haystack, string $needle): bool {
        /**
         * Creates the function if it doesn't exists in php version
         * 
         * @param string $haystack string to look up
         * @param string $needle key to be found
         * 
         * @return bool
         */

        $length = strlen($needle);

        if ($length > strlen($haystack)) {
            return FALSE;
        }

        $subs = substr($haystack, 0, $length);

        return $subs === $needle;
    }
}

?>