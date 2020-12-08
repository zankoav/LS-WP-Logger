<?php 
if( ! defined('WP_UNINSTALL_PLUGIN') )
	exit;

require __DIR__ . '/LS_WP_Logger.php';
LS_WP_Logger::removeTable();