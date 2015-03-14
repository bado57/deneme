<?php

class Admin_Model extends Model {

    public function __construct() {
        //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
        parent::__construct();
    }

    //kullanıcı giriş kontrolü
    public function userControl($array = array(), $Kadi, $Sifre, $KullaniciID, $tableName) {
        $sql = "SELECT BSAdminID , BSAdminKadi, BSSuperAdmin, BSFirmaID  FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi AND " . $Sifre . " = :loginSifre LIMIT 1";
        $count = $this->db->affectedRows($sql, $array);
        if ($count > 0) {
            $sql = "SELECT BSAdminID , BSAdminKadi, BSSuperAdmin, BSFirmaID FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi AND " . $Sifre . " = :loginSifre LIMIT 1";
            return $this->db->select($sql, $array);
        } else {
            return false;
        }
    }

    //admin firma özellikleri getirme
    public function firmaOzellikler($firmaID) {
        $sql = "SELECT * FROM firma Where BSFirmaID=" . $firmaID;
        return ($this->db->select($sql));
    }

}

?>