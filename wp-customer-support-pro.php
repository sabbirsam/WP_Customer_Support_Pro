<?php
/**
 * Plugin Name: WP Customer Support System Pro
 *
 * @author            Sabbir Sam, devsabbirahmed
 * @copyright         2022- devsabbirahmed
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: WP Customer Support System Pro
 * Plugin URI: 
 * Description: WP Customer Support System Pro is mainly used to easily chat via own local store which is connected local/server database without using any third party application/API, Its quick conversation plugin between customer/vendor and admin.
 * Version:           1.0.0
 * Requires at least: 5.9 or higher
 * Requires PHP:      5.4 or higher
 * Author:            SABBIRSAM
 * Author URI:        https://github.com/sabbirsam/
 * Text Domain:       wcs
 * Domain Path: /languages/
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * 
 */
defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');
if (file_exists(dirname(__FILE__).'/vendor/autoload.php')) {
    require_once dirname(__FILE__).'/vendor/autoload.php';
}
/**
 * All Namespace 
 */

use WCSPRO\classes\WCS_Pro_Enqueue;
use WCSPRO\classes\WCS_Pro_Activate;
use WCSPRO\classes\WCS_Pro_Deactivate;
use WCSPRO\classes\WCS_Pro_BaseController;
use WCSPRO\classes\WCS_Pro_React_Rest_Route;
/**
 * Main Class
 */
if(!class_exists('WCSPRO_WPCustomerSupport')){
    class WCSPRO_WPCustomerSupport{
        public $wp_customer_support_pro;
        public function __construct(){
            $this->classesludes();
            $this->wp_customer_support_pro = plugin_basename(__FILE__); 
        }
        /**
         * Register
         */
        function register(){
            add_action("plugins_loaded", array( $this, 'WCS_Proload' )); 
            add_action("activated_plugin", array( $this, 'WCS_pro_plugin_activation' )); 
            
            if ( !class_exists( 'WCS_WPCustomerSupport' ) ) {
                /**
                 * Notice
                 */
                add_action( 'admin_notices', array( $this,'wcspro_deactivate_free_version_notice' ));
                /**
                 * Deactivated the pro without free
                 */
                add_action( 'admin_init', array( $this, 'wcs_plugin_deactivate' ) );
            }
        }
        /**
         * Language load
         */
        function WCS_Proload(){
            load_plugin_textdomain('wcs', false,dirname(__FILE__)."languages"); 
        }
        /**
         * Classes 
         */
        public function classesludes() {
            $enqueue= new WCS_Pro_Enqueue();
            $enqueue->register();  
            new WCS_Pro_BaseController();
            new WCS_Pro_React_Rest_Route();
            
        }
        /**
         * Redirection
         */
        function WCS_pro_plugin_activation($plugin){
            if ( class_exists( 'WCS_WPCustomerSupport' ) ) {  
                if (plugin_basename(__FILE__) == $plugin) {
                    wp_redirect(admin_url('admin.php?page=dashboard_status'));
                    die();
                }
            }
        }

        /**
         * Pro check and deactivate
         */
        function wcspro_deactivate_free_version_notice() {
            ?>
<div class="notice notice-error is-dismissible">
    <p><?php echo sprintf( __( 'WP Customer Support System PRO has been deactived. It requires WP Customer Support System plugin on the %splugins page%s', 'wp_customer_support' ), '<a href="' . wp_nonce_url( 'plugins.php?action=activate&amp;plugin=wp_customer_support%2Fwp-customer-support.php&amp;plugin_status=all&amp;paged=1&amp;s=', 'activate&amp;plugin=wp_customer_support%2Fwp-customer-support.php' ) . '">', '</a>'); ?>
    </p>
</div><?php }
        function wcs_plugin_deactivate() {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            if ( isset( $_GET['activate'] ) )
            unset( $_GET['activate'] );
        }
        
        /**
         * Activation Hook
         */
        function wcs_pro_activate(){   
            WCS_Pro_Activate::wcs_pro_activate();
        }
        /**
         * Deactivation Hook
         */
        function wcs_pro_deactivate(){ 
            WCS_Pro_Deactivate::wcs_pro_deactivate(); 
        }
    }
    /**
     * Instantiate an Object Class 
     */
    $wcspro = new WCSPRO_WPCustomerSupport;
    $wcspro ->register();
    register_activation_hook (__FILE__, array( $wcspro, 'wcs_pro_activate' ) );
    register_deactivation_hook (__FILE__, array( $wcspro, 'wcs_pro_deactivate' ) );
}