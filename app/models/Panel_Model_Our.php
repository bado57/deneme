<?php

class Panel_Model_Our extends Model_Our {

    public function __construct() {
        parent::__construct();
    }

    public function insertIletisim($data) {
        return ($this->db->insert("rootiletisim", $data));
    }

    //rootdb firma bağlantıları
    public function rootFirmaConnect() {
        $sql = 'SELECT rootFirmaDbName,rootFirmaDbSifre,rootFirmaDbIp,rootFirmaDbUser FROM rootfirma Where rootfirmaDurum=1';
        return($this->db->select($sql));
    }

    //rootdb firma bağlantıları
    public function rootFirmaConnectSefer() {
        $sql = 'SELECT rootFirmaDbName,rootFirmaDbSifre,rootFirmaDbIp,rootFirmaDbUser,rootfirmaOgrServis,rootfirmaPersonelServis FROM rootfirma Where rootfirmaDurum=1';
        return($this->db->select($sql));
    }

    //rootdb firma bağlantıları
    public function rootFirmaConnectBackup() {
        $sql = 'SELECT rootfirmaKodu,rootFirmaDbName,rootFirmaDbSifre,rootFirmaDbIp,rootFirmaDbUser,rootfirmaAdi FROM rootfirma Where rootfirmaDurum=1';
        return($this->db->select($sql));
    }

    //araç count firma
    public function rootFirmaAracCount($firmID) {
        $sql = 'SELECT rootfirmaAracSayi FROM rootfirma Where rootfirmaID=' . $firmID;
        return($this->db->select($sql));
    }

    //admin firma özellikleri düzenleme
    public function rootFirmaDuzenle($data, $firmID) {
        return ($this->db->update("rootfirma", $data, "rootfirmaID=" . $firmID));
    }

}

?>
