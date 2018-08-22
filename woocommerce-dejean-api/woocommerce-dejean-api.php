<?php

/*
Plugin Name: Woocommerce Dejean API
Plugin URI: http://dejean-api.com/woocommerce-dejean-api-example
Description: A brief description of the Plugin.
Version: 1.0
Author: Dejean
Author URI: http://dejean-api.com/example
License: GNU
Text Domain: woocommerce-dejean-api
*/

//Let's make sure we don't expose any info if directly called
if ( !function_exists( 'add_action' ) ) {
    echo 'Sorry! For safety reasons, direct access is not allowed :)';
    exit;
}
define( 'DAPI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'DAPI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

class Woocommerce_Dejean_Api
{

        public function __construct()
        {
            register_activation_hook( __FILE__, 'dapi_activation' );
            add_action( 'init', array($this,'dapi_new_endpoint') );
            add_action( 'woocommerce_account_settings_endpoint', array($this,'dapi_endpoint_content') );
            add_filter ( 'woocommerce_account_menu_items', array($this,'dapi_menu_order'));
            add_action( 'wp_enqueue_scripts', array($this,'dapi_enqueue_scripts'));
            /**
             * Let's register our widget
             * Note: The registration is in a separated file in order to ensure a good readability
             */
            require(DAPI_PLUGIN_DIR.'includes/register-widget.php');
        }

    /**
     * Activate our plugin and register an uninstall hook
     */
    public function dapi_activation(){
        register_uninstall_hook( __FILE__, 'dapi_uninstall' );
    }

    /**
     * Uninstall actions
     */
    public function dapi_uninstall(){
        delete_option("dapi_elements_list");
        delete_option("dapi_api_url");
    }

    /**
     * Register the endpoint Settings to be used inside of My Account page
     */
    public function dapi_new_endpoint() {
        add_rewrite_endpoint( 'settings', EP_ROOT | EP_PAGES );
    }

    /**
     * Get the Settings endpoint content
     */
    public function dapi_endpoint_content() {
        $preferences = new \Dejean\Api\Dapi_Preferences();
        $api = new \Dejean\Api\Dapi_Api();
        if(isset($_POST["alphanumeric_list"])){
            //Verifiy the nonce
            if(wp_verify_nonce($_POST["_wpnonce"], "alphanumeric_list_nonce")){
                $data['dapi_api_url'] = isset($_POST["api_url"]) ? sanitize_text_field($_POST["api_url"]) : "";
                $data['dapi_elements_list'] = (isset($_POST["alphanumeric_list"]) && (is_array($_POST["alphanumeric_list"]))) ? serialize($_POST["alphanumeric_list"]) : serialize( array());
                //Save the preferences and the list
                $preferences->save($data);
            }
        }
        //Load the data
        $dataLoaded = $preferences->load(); //Will be used in the frontend to display the previously loaded info
        //Providing an easier verification on the frontend
        if($dataLoaded['dapi_elements_list'] != false && !empty($dataLoaded['dapi_elements_list'])){
            $dataLoaded['need_fetch'] = true;
            //FETCH
            $api_response = $api->getContent($dataLoaded['dapi_elements_list']);
        }else{
            $dataLoaded['need_fetch'] = false;
        }
        require(DAPI_PLUGIN_DIR.'templates/settings_api.php');
    }

    /**
     * Edit the menu order
     */
    public function dapi_menu_order() {
        $menuOrder = array(
            'orders'             => __( 'Your Orders', 'woocommerce' ),
            'settings'             => __( 'Settings', 'woocommerce' ),
            'downloads'          => __( 'Download', 'woocommerce' ),
            'edit-address'       => __( 'Addresses', 'woocommerce' ),
            'edit-account'    	=> __( 'Account Details', 'woocommerce' ),
            'customer-logout'    => __( 'Logout', 'woocommerce' ),
            'dashboard'          => __( 'Dashboard', 'woocommerce' )
        );
        return $menuOrder;
    }

    /**
     * Let's enqueue some styles and scripts
     */
    public function dapi_enqueue_scripts() {
        wp_enqueue_style( 'dapi_styles', DAPI_PLUGIN_URL.'assets/css/styles.css');
        wp_enqueue_script( 'dapi_frontend', DAPI_PLUGIN_URL.'assets/js/frontend.js',array('jquery', 'jquery-ui-accordion'));
    }

} //End of class

/**
 * Autoload with PSR-4 compliant code
 */
spl_autoload_register(function ($class) {
    // Namespace prefix of our plugin
    $prefix = 'Dejean\\Api\\';

    // base directory
    $base_dir = DAPI_PLUGIN_DIR . DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'class/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', 'class-'.strtolower(str_replace('_','-', $relative_class))) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});

$WoocommerceDejeanApi = new Woocommerce_Dejean_Api();
