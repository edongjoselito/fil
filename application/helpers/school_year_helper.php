<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('school_year_range')) {
    /** Return an ending-year value as a school-year range, e.g. 2026 => 2025-2026. */
    function school_year_range($ending_year)
    {
        $ending_year = (int) $ending_year;
        if ($ending_year <= 0) {
            return '';
        }
        return ($ending_year - 1) . '-' . $ending_year;
    }
}
