<?php

class MemcacheDeneme_Model extends ModelMemcache {

    public function __construct() {
        //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
        parent::__construct();
    }

    //get fonksiyonu yani memecache getirme
    public function get($key) {
        return $this->dbmemcache->get($key);
    }

    //set fonksiyonu yani memecache kaydetme
    public function set($key, $data, $statu, $time) {
        return $this->dbmemcache->set($key, $data, $statu, $time);
    }

    //replace onksiyonu yani ke deki dataları değiştirme
    public function replace($key, $data, $statu, $time) {
        return $this->dbmemcache->replace($key, $data, $statu, $time);
    }

    //istenilen keyi silmeye yaramaktadır
    public function deleteKey($key) {
        return $this->dbmemcache->deleteKey($key);
    }

    //bellekteki tüm keyleri siler
    public function deleteAllKey() {
        return $this->dbmemcache->deleteAllKey();
    }

    //server status server açık yada kapalımı.1->açık null->kapalı
    public function serverStatus() {
        return $this->dbmemcache->serverStatus();
    }

}
?>

