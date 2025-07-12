<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Custom Validation Helper
 * 
 * Contains custom validation functions for the application
 */

/**
 * Validate that meter_akhir is greater than or equal to meter_awal
 * 
 * @param string $meter_akhir The meter akhir value
 * @param string $meter_awal_field The meter awal field name
 * @return bool
 */
function validate_meter_akhir($meter_akhir, $meter_awal_field = 'meter_awal') {
    $CI =& get_instance();
    $meter_awal = $CI->input->post($meter_awal_field);
    
    if (empty($meter_akhir) || empty($meter_awal)) {
        return TRUE; // Let other validation rules handle empty values
    }
    
    return (float)$meter_akhir >= (float)$meter_awal;
}

/**
 * Validate that a field is greater than or equal to another field
 * 
 * @param string $value The field value to validate
 * @param string $compare_field The field to compare against
 * @return bool
 */
function validate_greater_than_equal_to_field($value, $compare_field) {
    $CI =& get_instance();
    $compare_value = $CI->input->post($compare_field);
    
    if (empty($value) || empty($compare_value)) {
        return TRUE; // Let other validation rules handle empty values
    }
    
    return (float)$value >= (float)$compare_value;
} 