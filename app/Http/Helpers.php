<?php

use Carbon\Carbon;
use Vinkla\Hashids\Facades\Hashids;

/**
 * Sanitize string variable
 *
 * @param string $string
 * @param string $stringType
 *
 * @return string
 */
function sanitizeString(string $string, string $stringType)
{
    $value = null;
    switch ($stringType) {
        case \SanitizeStringType::SPECIAL_CHARACTER:
            $value = preg_replace ('/[^a-zA-Z0-9\']/', ' ', $string);
            break;
        case \SanitizeStringType::NUMERIC:
            $value = preg_replace ('/[^0-9,.]+/', '', $string);
            break;        
        default:
            // ----- remove HTML TAGs ----- 
            $value = preg_replace ('/<[^>]*>/', ' ', $string); 
            // ----- remove control characters ----- 
            $value = str_replace("\r", '', $string);    // --- replace with empty space
            $value = str_replace("\n", ' ', $string);   // --- replace with space
            $value = str_replace("\t", ' ', $string);   // --- replace with space
            // ----- remove multiple spaces ----- 
            $value = trim(preg_replace('/ {2,}/', ' ', $string));
            break;
    }

    return $value;
}

/**
 * Trim & Filter string variable
 *
 * @param $string
 * @param int|null $sanitizeType
 *
 * @return string
 */
function trimFilterString($string, $sanitizeType=null)
{
    $filteredString =  (string) trim(filter_var($string, FILTER_SANITIZE_STRING));
    if ($sanitizeType) {
        return sanitizeString($filteredString, $sanitizeType);
    }
    return $filteredString;
}