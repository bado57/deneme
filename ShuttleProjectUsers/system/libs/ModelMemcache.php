<?php
   //ana model kullanma sebebi her dosya extends ile bağlanabilsin buna
   //memcache version 1.2.6
    class ModelMemcache {
       protected $dbmemcache=array();
       public function __construct() {
            $hostname='127.0.0.1';
            $port =11211;
            $this->dbmemcache=new MemcacheDatabase($hostname,$port);
       }

    }
?>