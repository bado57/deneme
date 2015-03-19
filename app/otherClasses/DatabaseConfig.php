<?php

class DatabaseConfig {

    public function __construct() {
        //parent::__construct();
    }

    public function configDb($dbName, $dbip, $dbuser, $dbpassword) {
        
        define('definedbEncryption', 'ShutteBSDb');
        define('selectName', $dbName);
        define('selectDbIp', $dbip);
        define('selectDbUser', $dbuser);
        define('selectDbPassword', $dbpassword);
        
        return TRUE;
    }

}

?>
