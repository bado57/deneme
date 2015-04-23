<?php

class Admin_Model extends Model {

    public function __construct() {
        //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
        //parent->Üst sınıfın sabitlerine, statik özellik ve metotlarına erişmeyi sağlar.
        parent::__construct();
    }

    //kullanıcı giriş kontrolü
    public function userControl($array = array(), $Kadi, $Sifre, $KullaniciID, $tableName) {
        $sql = "SELECT BSAdminID , BSAdminKadi, BSSuperAdmin FROM " . $tableName . " WHERE " . $Kadi . " =:loginKadi AND " . $Sifre . "=:loginSifre LIMIT 1";
        $count = $this->db->affectedRows($sql, $array);
        if ($count > 0) {
            $sql = "SELECT BSAdminID , BSAdminKadi, BSSuperAdmin, BSAdminAd, BSAdminSoyad,Status FROM " . $tableName . " WHERE " . $Kadi . " =:loginKadi AND " . $Sifre . "=:loginSifre LIMIT 1";
            return $this->db->select($sql, $array);
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

?>