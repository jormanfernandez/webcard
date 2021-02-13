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

?>