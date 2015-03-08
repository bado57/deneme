<?php
   //ana model kullanma sebebi her dosya extends ile bağlanabilsin buna
    class Model{
       protected $db=array();
       public function __construct() {
            $dsn = 'mysql:dbname=shuttledb;host=127.0.0.1';
            $user = 'root';
            $password = '';
            $this->db=new Database($dsn,$user,$password);
       }

    }
?>
