<?php

class Panel_Model_Mobile extends ModelMobile {

    public function __construct() {
        parent::__construct();
    }

    public function shuttleKullaniciLogin($array = array(), $Kadi, $Sifre,$KullaniciID, $tableName) {
        $sql = "SELECT ".$Kadi.",".$KullaniciID." FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre";
        return ($count = $this->db->select($sql, $array));
    }
    
    //admin süper admini çeksin diye 
    public function shuttleKullaniciLoginA($array = array(), $Kadi, $Sifre,$KullaniciID, $tableName) {
        $sql = "SELECT ".$Kadi.",".$KullaniciID.", BSSuperAdmin FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre";
        return ($count = $this->db->select($sql, $array));
    }
    
    //admin firma özellikleri düzenleme
    public function MfirmaOzelliklerDuzenle($data, $FirmaID) {
        return ($this->db->update("bsfirma", $data, "BSFirmaID=1"));
    }
 
    //admin firma özellikleri getirme
    public function MfirmaOzellikler() {
        $sql = "SELECT * FROM bsfirma Where BSFirmaID=1 LIMIT 1";
        return ($this->db->select($sql));
    }
    
    
}

?>
