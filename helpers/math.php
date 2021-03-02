<?php
require "./helpers/constants.php";

function calculate_celcius($temp){
    $temp = $temp - Constants::KELVIN;
    return round($temp, 2);
}

?>