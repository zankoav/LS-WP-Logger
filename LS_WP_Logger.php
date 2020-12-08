<?php 

class LS_WP_Logger {
    
    const TABLE_NAME = 'ls_wp_logger';


    private static function initWPDB(){
        global $wpdb;
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        maybe_create_table(
            self::TABLE_NAME, 
            "CREATE TABLE " . self::TABLE_NAME . " (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                type ENUM('error', 'info'),
                message TEXT,
                reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) CHARSET=utf8 COLLATE=utf8_general_ci"
        );
        return $wpdb;
    }
    
    private static function createLog($message, $type = 'info') {
        return self::initWPDB()->query("INSERT INTO `ls_wp_logger`(`type`,`message`) VALUES ('$type', '$message')");
    }

    public static function removeTable() {
        self::initWPDB()->query( 'DROP TABLE ' . self::TABLE_NAME);
    }

    public static function getLogs($type = false) {
        $logs = [
            'header' => [],
            'body' => []
        ];
        
        $queryByType = $type === 'error' ? ' WHERE type = \'error\' ' : 
                    ( $type === 'info' ? ' WHERE type = \'info\' ' : '' );
        $logs['header'] = self::initWPDB()->get_results('SELECT type, COUNT(type) as number FROM ' . self::TABLE_NAME . ' GROUP BY type');
        $logs['body'] = self::initWPDB()->get_results('SELECT type, message, reg_date FROM ' . self::TABLE_NAME . $queryByType .' ORDER BY reg_date DESC LIMIT 300');
        
        return $logs;
    }

    public static function deleteLogs() {
        self::initWPDB()->query('DELETE FROM ' . self::TABLE_NAME);
    }

    public static function info($message) {
        self::createLog($message);
    }

    public static function error($message) {
        self::createLog($message, 'error');
    }
}