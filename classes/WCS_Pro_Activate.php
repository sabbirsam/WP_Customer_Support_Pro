<?php
namespace WCSPRO\classes;

defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');
/**
 * Activate class here
 */
class WCS_Pro_Activate{

    /**
     * Activation hook- and It create support pages with shortcode
     */
    public static function WCS_Pro_Activate(){ 
        add_option( 'wcs_pro_options_value', "active", '', 'yes' );
        update_option( 'wcs_pro_options_value', "active",'', 'yes'); 
        flush_rewrite_rules();
    }
}