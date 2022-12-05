<?php

namespace WCSPRO\classes;

use \WCSPRO\classes\WCS_Pro_BaseController;

defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');
/**
 * All Enqueue here
 */
class WCS_Pro_Enqueue extends WCS_Pro_BaseController{

    /**
     * Register all the enqueue scripts
     */
    function register(){
        add_action( 'admin_enqueue_scripts', array( $this, 'wcs_pro_admin_enqueue' ) ); 
        add_action( 'wp_enqueue_scripts', array( $this, 'wcs_pro_frondend_enqueue' ) ); 
    }
    /**
     * Admin Enqueue
     */
    public function wcs_pro_admin_enqueue(){
        wp_enqueue_style( 'wcs_pro_main_scss_style', $this->plugin_url . 'build/main.css' ); 
        wp_enqueue_script( 'wcs_pro_min_js', $this->plugin_url .'build/pro_index.js',array('jquery','wp-element'),1.0,true ); 
        wp_localize_script('wcs_pro_min_js', 'appLocalizer', [
            'apiUrl' => home_url( '/wp-json' ),
            'nonce' => wp_create_nonce( 'wp_rest'),
        ] );
        wp_enqueue_script('wcs_pro_min_js');      
    }
    /**
     *  Public/Frontend Enqueue
     */
    public function wcs_pro_frondend_enqueue(){
        $user = wp_get_current_user();
        $allowed_roles = array( 'editor', 'administrator','subscriber' );
        if (is_page( 'Get Support' ) ){
            if ( array_intersect( $allowed_roles, $user->roles ) ) {
                wp_enqueue_style( 'wcs_pro_fr_scss_style', $this->plugin_url . 'build/main.css' ); 
                wp_enqueue_script( 'wcs_pro_fr_js', $this->plugin_url .'build/pro_index.js',array('jquery','wp-element'),1.0,true ); 
                wp_localize_script('wcs_pro_fr_js', 'appLocalizer', [
                    'apiUrl' => home_url( '/wp-json' ),
                    'nonce' => wp_create_nonce( 'wp_rest'),
                ] );
                wp_enqueue_script('wcs_pro_fr_js');  
            }
        }
    }
}    