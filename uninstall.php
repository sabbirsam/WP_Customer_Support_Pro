<?php

if(! defined('WP_UNINSTALL_PLUGIN')){
    die(); 
}

delete_option( 'wcs_pro_options_value' );