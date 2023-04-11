<?php

define("GENDER_INDEX", 0);
define("GENDER_LENGTH", 1);

define("YEAR_INDEX", GENDER_INDEX + GENDER_LENGTH);
define("YEAR_LENGTH", 2);

define("MONTH_INDEX", YEAR_INDEX + YEAR_LENGTH);
define("MONTH_LENGTH", 2);

define("DAY_INDEX", MONTH_INDEX + MONTH_LENGTH);
define("DAY_LENGTH", 2);

define("COUNTY_INDEX", DAY_INDEX + DAY_LENGTH);
define("COUNTY_LENGTH", 2);

define("PERSDAY_INDEX", COUNTY_INDEX + COUNTY_LENGTH);
define("PERSDAY_LENGTH", 3);

define("LAST_COUNTY_CODE", 52);

define("STANDARD", "279146358279");

/**
 * The function checks if a given CNP (personal identification number) is valid according to Romanian
 * regulations.
 * 
 * @param string value The CNP (Cod Numeric Personal) value that needs to be validated.
 * 
 * @return bool The function `isCnpValid` returns a boolean value indicating whether the given CNP
 * (personal identification number) is valid or not, based on various validation checks such as gender,
 * year, month and day of birth, county, person day, and checksum.
 */
function isCnpValid(string $value): bool {

    $hasOnlyDigits = preg_match('/^[0-9]+$/', $value);
    $hasCorrectLength = strlen($value) == 13;

    $isValid = $hasOnlyDigits && $hasCorrectLength;
    
    return $isValid && isGenderValid($value)
        && isYearValid($value)
        && isMonthAndDayValid($value)
        && isCountyValid($value)
        && isPersonDayValid($value)
        && isChecksumValid($value)

        ;

}

/**
 * The function checks if a given string's checksum is valid according to a specific algorithm.
 * 
 * @param string value The value parameter is a string that represents a 13-digit barcode.
 * 
 * @return bool a boolean value indicating whether the checksum of the given string is valid or not.
 */
function isChecksumValid(string $value): bool {

    $sum = 0;
    for ($i = 0; $i < 12; $i++) {
        $n = intval(substr(STANDARD, $i, 1));
        $c = intval(substr($value, $i, 1));

        $sum += $n * $c;
    }

    $r = $sum % 11;
    $checksum = ($r == 10) ? 1 : $r;

    return $checksum == intval(substr($value, 12, 1));
}

/**
 * The function checks if a given string represents a valid month and day of the month.
 * 
 * @param string value The input string that represents a date in the format "MM/DD/YYYY".
 * 
 * @return bool a boolean value indicating whether the input string represents a valid month and day of
 * the month.
 */
function isMonthAndDayValid(string $value): bool {

    $mv = getMonthToken($value);
    $m = intval($mv);
    $isMonthValid = $m < 13 && $m > 0;

    $dv = getDayToken($value);
    $d = intval($dv);
    $isDayOfMonthValid = (($m == 2 && $d < 30) 
                       || (in_array($m, array(1, 3, 5, 7, 8, 10, 12)) && ($d < 32))
                       || (!in_array($m, array(1, 3, 5, 7, 8, 10, 12)) && ($d < 31)))
                       && ($d > 0);

    return $isMonthValid 
        && $isDayOfMonthValid
    
    ;
}

/**
 * The function checks if a given county code is valid.
 * 
 * @param string value The input string that contains the county code token.
 * 
 * @return bool A boolean value indicating whether the county code extracted from the input string is
 * valid or not.
 */
function isCountyValid(string $value): bool {

    $cv = getCountyToken($value);
    $c = intval($cv);

    return ($c < LAST_COUNTY_CODE + 1) && ($c > 0);
}

/**
 * The function checks if a given string value contains a valid personal day token.
 * 
 * @param string value The parameter `` is a string that represents a date in the format
 * "YYYY-MM-DD".
 * 
 * @return bool The function `isPersonDayValid` is returning a boolean value (`true` or `false`). It
 * checks if the personal day token extracted from the input string is greater than 0, and returns
 * `true` if it is, and `false` otherwise.
 */
function isPersonDayValid(string $value): bool {
    return intval(getPersonalDayToken($value)) > 0;
}

/**
 * The function checks if a given gender value is valid.
 * 
 * @param string value The input string that contains the gender information.
 * 
 * @return bool A boolean value indicating whether the gender value passed as a string is valid or not.
 */
function isGenderValid(string $value): bool {

    $gt = getGenderToken($value);
    $g = intval($gt);

    $isValid = $g > 0;
    return $isValid;
}

/**
 * The function checks if a given string represents a valid year.
 * 
 * @param string value The input string that contains a year value.
 * 
 * @return bool A boolean value of `true`.
 */
function isYearValid(string $value): bool {

    $yt = getYearToken($value);
    $y = intval($yt);
    return true;
}

/**
 * The function returns a gender token extracted from a given string.
 * 
 * @param string value The input string from which the gender token needs to be extracted.
 * 
 * @return string The function `getGenderToken` is returning a string value. It is calling the
 * `getToken` function with three arguments: the input string ``, the constant `GENDER_INDEX`,
 * and the constant `GENDER_LENGTH`. The `getToken` function is expected to return a substring of
 * `` starting at index `GENDER_INDEX` and with a length of `GENDER_LENGTH`. Therefore
 */
function getGenderToken(string $value): string {
    return getToken($value, GENDER_INDEX, GENDER_LENGTH);
}

/**
 * The function returns a token representing the year from a given string.
 * 
 * @param string value The input string from which the year token needs to be extracted.
 * 
 * @return string The function `getYearToken` is returning a string value. It is returning the result
 * of calling the `getToken` function with the input string ``, the constant `YEAR_INDEX`, and
 * the constant `YEAR_LENGTH` as arguments.
 */
function getYearToken(string $value): string {
    return getToken($value, YEAR_INDEX, YEAR_LENGTH);
}

/**
 * The function returns a token representing the month from a given string.
 * 
 * @param string value The input string from which the month token needs to be extracted.
 * 
 * @return string a string that represents the month token extracted from the input string. The month
 * token is obtained by calling the `getToken` function with the input string, the `MONTH_INDEX`
 * constant, and the `MONTH_LENGTH` constant as arguments.
 */
function getMonthToken(string $value): string {
    return getToken($value, MONTH_INDEX, MONTH_LENGTH);
}

/**
 * The function returns a substring token from a given string based on predefined index and length
 * values.
 * 
 * @param string value The input string from which the county token needs to be extracted.
 * 
 * @return string The function `getCountyToken` is returning a string value. It is using the `getToken`
 * function with the parameters ``, `COUNTY_INDEX`, and `COUNTY_LENGTH` to extract a substring
 * from `` and return it.
 */
function getCountyToken(string $value): string {
    return getToken($value, COUNTY_INDEX, COUNTY_LENGTH);
}

/**
 * The function returns a substring token of a given string representing the day.
 * 
 * @param string value The input string from which the day token needs to be extracted.
 * 
 * @return string The function `getDayToken` is returning a string value. It is calling the function
 * `getToken` with three arguments: the input string ``, the constant `DAY_INDEX`, and the
 * constant `DAY_LENGTH`. The returned string is the token extracted from the input string using the
 * specified index and length.
 */
/**
 * The function returns a substring token of a given string representing the day.
 * 
 * @param string value The input string from which the day token needs to be extracted.
 * 
 * @return string The function `getDayToken` is returning a string value. It is calling the function
 * `getToken` with three arguments: the input string ``, the constant `DAY_INDEX`, and the
 * constant `DAY_LENGTH`. The returned string is the token extracted from the input string using the
 * specified index and length.
 */
function getDayToken(string $value): string {
    return getToken($value, DAY_INDEX, DAY_LENGTH);
}

/**
 * The function returns a token of a specific length from a given string at a specific index.
 * 
 * @param string value The input string from which the personal day token needs to be extracted.
 * 
 * @return string a string value which is the result of calling the `getToken()` function with three
 * arguments: the input string ``, the constant `PERSDAY_INDEX`, and the constant
 * `PERSDAY_LENGTH`. The purpose of this function is to extract a specific token from the input string,
 * which is related to a personal day.
 */
function getPersonalDayToken(string $value): string {
    return getToken($value, PERSDAY_INDEX, PERSDAY_LENGTH);
}

/**
 * The function returns a substring of a given string based on the provided index and length.
 * 
 * @param string value The string from which a substring needs to be extracted.
 * @param int idx The parameter "idx" in the function represents the starting index position from where
 * the substring needs to be extracted from the given string.
 * @param int l The parameter "l" is an integer representing the length of the substring that needs to
 * be extracted from the input string.
 * 
 * @return string The function `getToken` is returning a substring of the input string ``,
 * starting from the index `` and with a length of ``. The returned value is a string.
 */
function getToken(string $value, int $idx, int $l): string {
    return substr($value, $idx, $l);
}
