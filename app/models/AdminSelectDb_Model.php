<?php

class AdminSelectDb_Model extends Model {

    protected $selectDbName = 'rootshuttledb';
    protected $selectDbUser = 'root';
    protected $selectDbSifre = '';
    protected $selectDbIp = '127.0.0.1';

    public function __construct() {
        //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
        parent::__construct();
    }

    //kullanıcı giriş kontrolü
    public function kullaniciSelectDb($loginfirmaID) {
        $sql = "SELECT rootfirmaID FROM rootfirma WHERE rootfirmaID=" . $loginfirmaID . ' LIMIT 1';
        $count = $this->db->affectedRows($sql);
        if ($count > 0) {
            $sql = "SELECT * FROM rootfirma WHERE rootfirmaID=" . $loginfirmaID . " LIMIT 1";
            return $this->db->select($sql);
        } else {
            return false;
        }
    }

    public function __destruct() {
        //echo 'Name değişken içeriği boşaltıldı.';
        //unset($this->name);
        parent::__destruct();
    }

}
