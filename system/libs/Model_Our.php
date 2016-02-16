<?php

//ana model kullanma sebebi her dosya extends ile bağlanabilsin buna
class Model_Our {

    protected $db = array();

    public function __construct() {
        $dsn = 'mysql:dbname=rootshuttledb;host=127.0.0.1';
        $user = 'root';
        $password = '';
        $this->db = new Database_Our($dsn, $user, $password);
    }

}

?>
