<?php

class Admin_Model extends Model {

    public function __construct() {
        //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
        parent::__construct();
    }

    //kullanıcı giriş kontrolü
    public function userControl($array = array(), $Kadi, $Sifre, $KullaniciID, $tableName) {
        $sql = "SELECT * FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi AND " . $Sifre . " = :loginSifre";
        $count = $this->db->affectedRows($sql, $array);
        if ($count > 0) {
            $sql = "SELECT * FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi AND " . $Sifre . " = :loginSifre";
            return $this->db->select($sql, $array);
        } else {
            return false;
        }
    }

}

?>