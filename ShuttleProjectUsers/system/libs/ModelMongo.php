<?php
   //ana model kullanma sebebi her dosya extends ile bağlanabilsin buna
    class ModelMongo{
       protected $dbmongo=array();
       public function __construct() {
            $username='shuttle';
            $password='123456';
            $hostname='127.0.0.1';
            $port ='27017';
            $databaseName='Shuttle';
            $this->dbmongo=new MongoDatabase($username,$password,$hostname,$port,$databaseName);
       }

    }
?>