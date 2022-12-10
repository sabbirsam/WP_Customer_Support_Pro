<?php
namespace WCSPRO\classes;

defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');
/**
 * WordPress Rest API and all routing
 */
class WCS_Pro_React_Rest_Route{
   
    function __construct(){
        add_action( 'rest_api_init', array( $this, 'create_rest_route' ) ); 
    }
    public function create_rest_route(){
        $get_pro_active_options_val = get_option('wcs_pro_options_value');
        if($get_pro_active_options_val == 'active'){
            register_rest_route( 'wcspro/v1', '/dashboard_tickets',[ //http://localhost/wppool/chatbox/wp-json/wcspro/v1/dashboard_tickets
                'methods'=>'GET',
                'callback'=>[$this, 'get_dashboard_tickets'],
                'permission_callback' => [$this, 'get_dashboard_tickets_permission']
            ] );
            register_rest_route( 'wcspro/v1', '/todays_tickets',[
                'methods'=>'GET',
                'callback'=>[$this, 'get_todays_tickets'],
                'permission_callback' => [$this, 'get_todays_tickets_permission']
            ] );
            register_rest_route( 'wcspro/v1', '/dashboard_users',[
                'methods'=>'GET',
                'callback'=>[$this, 'get_dashboard_users'],
                'permission_callback' => [$this, 'get_dashboard_users_permission']
            ] );
            register_rest_route( 'wcspro/v1', '/dashboard_staff',[
                'methods'=>'GET',
                'callback'=>[$this, 'get_dashboard_staff'],
                'permission_callback' => [$this, 'get_dashboard_staff_permission']
            ] );
            register_rest_route( 'wcspro/v1', '/dashboard_chart',[
                'methods'=>'GET',
                'callback'=>[$this, 'get_dashboard_chart'],
                'permission_callback' => [$this, 'get_dashboard_chart_permission']
            ] );
        }
        
    } 
        /**
         * GET Tickets for dashboard calculations
         */
        public function get_dashboard_tickets(){
            global $wpdb;
            $table_name = $wpdb->prefix . 'wcs_tickets';
            $results = $wpdb->get_results("SELECT * FROM $table_name"); //ORDER BY date_field ASC | DESC
            return rest_ensure_response($results);
            wp_die();
        } 
        public function get_dashboard_tickets_permission(){return true; } 
        /**
         * Todays Tickets
         */
        public function get_todays_tickets(){
            global $wpdb;
            $table_name = $wpdb->prefix . 'wcs_tickets';
            $results = $wpdb->get_results("SELECT * FROM $table_name WHERE DATE(`date_created`) = CURDATE()");
            return rest_ensure_response($results);
            wp_die();
            
        } 
        public function get_todays_tickets_permission(){return true; } 
        /**
         * Users info for Dashboard
         */
        public function get_dashboard_users(){
           
            global $wpdb;
            $capabilities_field=$wpdb->prefix.'capabilities';
            $qargs=[
                'role' => ['subscriber'],
                'meta_query'=>
                    [
                    'relation' => 'OR', 
                        [
                        'key' => $capabilities_field,
                           'value' => 'subscriber',
                        'compare' => 'LIKE',
                        ],
                    ],
                'number'=> -1 
            ];
            $usersQuery=new \WP_User_Query($qargs); 
            $users=$usersQuery->get_results();
            return rest_ensure_response($users);              
        } 
        public function get_dashboard_users_permission(){ return true;} 
        /**
         * Staff for dashboard
         */
        public function get_dashboard_staff(){        
            global $wpdb;
            $capabilities_field=$wpdb->prefix.'capabilities';
            $qargs=[
                'role' => ['editor'],
                'meta_query'=>
                    [
                    'relation' => 'OR',
                        [
                        'key' => $capabilities_field,
                        'value' => 'editor',
                        'compare' => 'LIKE',
                        ],
                    ],
                'number'=> -1 
            ];

            $editorQuery=new \WP_User_Query($qargs);
            $editor=$editorQuery->get_results();
            return rest_ensure_response($editor); 
        } 
        public function get_dashboard_staff_permission(){  return true; }

         /**
         * GET Dashboard chart for dashboard calculations
         */
        public function get_dashboard_chart(){
            global $wpdb;
            $table_wcs_tickets = $wpdb->prefix . 'wcs_tickets';
            $table_users = $wpdb->prefix . 'users';
            $results = $wpdb->get_results("SELECT $table_users.ID, $table_users.user_login,  $table_wcs_tickets.staff_id,  $table_wcs_tickets.id,  $table_wcs_tickets.status,  $table_wcs_tickets.date_created from $table_users JOIN  $table_wcs_tickets on $table_users.ID =  $table_wcs_tickets.staff_id WHERE $table_wcs_tickets.status = 2 OR $table_wcs_tickets.status = 3"); //ORDER BY date_field ASC | DESC
            return rest_ensure_response($results);
            wp_die();
        } 
        public function get_dashboard_chart_permission(){return true; } 

        
               
}

/**
 * 
 * SELECT wp_users.ID, wp_users.user_login, wp_wcs_tickets.staff_id, wp_wcs_tickets.id, wp_wcs_tickets.status, wp_wcs_tickets.date_created from wp_users JOIN wp_wcs_tickets on wp_users.ID = wp_wcs_tickets.staff_id;
 * 
 * SELECT wp_users.ID, wp_users.user_login, wp_wcs_tickets.staff_id, wp_wcs_tickets.id, wp_wcs_tickets.status, wp_wcs_tickets.date_created from wp_users JOIN wp_wcs_tickets on wp_users.ID = wp_wcs_tickets.staff_id WHERE `date_created` > DATE_SUB(NOW(), INTERVAL 1 WEEK);
 * 

 * 
 * 
 * SELECT wp_users.ID, wp_users.user_login, wp_wcs_tickets.staff_id, wp_wcs_tickets.id, wp_wcs_tickets.status, wp_wcs_tickets.date_created from wp_users JOIN wp_wcs_tickets on wp_users.ID = wp_wcs_tickets.staff_id WHERE YEARWEEK(`date_created`) = YEARWEEK(NOW());
 */