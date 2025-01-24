<?php

class Validator
{
    public static function validateText($text, $minLength = 1, $maxLength = 255)
    {
        return strlen($text) >= $minLength && strlen($text) <= $maxLength;
    }

    public static function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validateNumber($number, $min = 0, $max = PHP_INT_MAX)
    {
        return filter_var($number, FILTER_VALIDATE_INT, ["options" => ["min_range" => $min, "max_range" => $max]]) !== false;
    }

    public static function sanitizeInput($input)
    {
        return htmlspecialchars(trim($input));
    }
}
