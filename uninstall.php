<?php 
if( ! defined('WP_UNINSTALL_PLUGIN') )
	exit;

require __DIR__ . '/LS_WP_Logger.php';

if(class_exists('LS_WP_Logger')){
    LS_WP_Logger::removeTable();
}
