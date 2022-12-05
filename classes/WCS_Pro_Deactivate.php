<?php

namespace WCSPRO\classes;

defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');
/**
 * Deactivated plugin
 */
class WCS_Pro_Deactivate{
    public static function WCS_Pro_Deactivate(){  
        update_option( 'wcs_pro_options_value', "inactive",'', 'yes'); 
        flush_rewrite_rules();
    }
}