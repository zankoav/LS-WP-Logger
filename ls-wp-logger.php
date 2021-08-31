<?php
   /*
    Plugin Name: LS WP Logger
    Plugin URI: https://wordpress.org/plugins/ls-wp-logger
    Description: This plugin stores logs for your application
    Version: 2.0.0
    Author: Lightning Soft  
    Author URI: https://lightning-soft.com/
    License: GPL2
   */

define('LS_WP_LOGGER_NAME', basename( __DIR__ ));

require __DIR__ . '/Log.php';

if(class_exists('Ls\Wp\Log')){

    register_activation_hook( __FILE__, function() {
        Ls\Wp\Log::info('Plugin has activated');
    });
    
    add_action( 'admin_menu', function() {
        add_menu_page(
            'LS WP Logger',
            'LS WP Logger',
            'manage_options',
            LS_WP_LOGGER_NAME .'/ls-wp-logger-page.php',
            '',
            plugins_url( 'images/menu-icon.svg', __FILE__ ),
            81
        );
    });
    
    add_action( 'wp_ajax_delete_logs', function () {
        Ls\Wp\Log::deleteLogs();
        $logs = Ls\Wp\Log::getLogs(sanitize_text_field($_POST['type']));
        echo json_encode($logs);
        wp_die();
    });
    
    add_action( 'wp_ajax_get_logs', function () {
        $logs = Ls\Wp\Log::getLogs(sanitize_text_field($_POST['type']));
        echo json_encode($logs);
        wp_die();
    });
    
    add_action( 'admin_enqueue_scripts', function($hook_suffix) {
        if(is_admin() and $hook_suffix === LS_WP_LOGGER_NAME.'/ls-wp-logger-page.php') {
            wp_enqueue_style('ls_wp_css', plugins_url('css/style.css',__FILE__ ));
            wp_enqueue_script('ls_wp_js', plugins_url('js/main.js',__FILE__ ));
            wp_localize_script( 'jquery', 'lsWpAjax', 
                array(
                    'url' => admin_url('admin-ajax.php'),
                    'logs' => json_encode(Ls\Wp\Log::getLogs())
                )
            );  
        }
    } );
}