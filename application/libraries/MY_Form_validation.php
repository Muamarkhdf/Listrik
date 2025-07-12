<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {
    
    public function __construct($rules = array()) {
        parent::__construct($rules);
        
        // Load custom validation helper
        $this->CI->load->helper('custom_validation');
    }
    
    /**
     * Validate that meter_akhir is greater than or equal to meter_awal
     * 
     * @param string $str The meter_akhir value
     * @param string $field The meter_awal field name
     * @return bool
     */
    public function meter_akhir_valid($str, $field = 'meter_awal') {
        return validate_meter_akhir($str, $field);
    }
    
    /**
     * Validate that a field is greater than or equal to another field
     * 
     * @param string $str The field value to validate
     * @param string $compare_field The field to compare against
     * @return bool
     */
    public function greater_than_equal_to_field($str, $compare_field) {
        return validate_greater_than_equal_to_field($str, $compare_field);
    }
} 