<?php

include_once('./cnp_valid.php');

$test_values = array(
    "1621126400074",
    "0621126400074", // Invalid gender
    "1621326400074", // Invalid month number
    "1621131400074", // Invalid day in month
    "1621232400074", // Invalid day in month
    "1620230400074", // Invalid number of days for Feb
    "1620026400074", // Invalid month number (0)
    "1621126530074", // Invalid county
    "1621126400075", // invalid last digit 
);

for ($i = 0; $i < count($test_values); $i++) {
    $r = isCnpValid($test_values[$i]);
    echo ($r ? "Valid CNP" : "Invalid CNP") . "\n\r";
}
