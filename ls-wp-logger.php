<?php
   /*
    Plugin Name: LS WP Logger
    Plugin URI: https://github.com/zankoav/LS-WP-Logger.git
    description: This plugin helps developers to store logs for your application
    Version: 0.0.1
    Author: Lightning Soft 
    Author URI: https://lightning-soft.com/
    License: GPL2
   */

class LS_WP_Logger {

    const DB_HOST = 'localhost';
	const DB_NAME = DB_NAME;
	const DB_USER = DB_USER;
    const DB_PASS = DB_PASSWORD;
    
    const TABLE_NAME = 'ls_wp_logger';

    private static $_link = null;
    
    private function __construct () {
        self::$_link = mysqli_connect(self::DB_HOST, self::DB_USER, self::DB_PASS, self::DB_NAME);
        if(!mysqli_query(self::$_link, "DESCRIBE `" . self::TABLE_NAME . "`")){
            mysqli_query(self::$_link, self::getSqlQueryToCreateTable());
        }
    }
    
    private static function connection()
	{
		if (self::$_link == null) {
			new self;
		}
		return self::$_link;
    }
    
    private static function getSqlQueryToCreateTable(){
        return "CREATE TABLE " . self::TABLE_NAME . " (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            type ENUM('error', 'info'),
            message TEXT,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    }
    
    private static function createLog($message, $type = 'info'){
        return mysqli_query(
            self::connection(), 
            "INSERT INTO `ls_wp_logger`(`type`,`message`) VALUES ('$type', '$message')"
        );
    }

    public static function info($message){
        self::createLog($message);
    }

    public static function error($message){
        self::createLog($message, 'error');
    }
}

register_activation_hook( __FILE__, function(){
    LS_WP_Logger::info('Plugin has activated');
});