<?php

class Panel_Model_Mobile extends ModelMobile {

    public function __construct() {
        parent::__construct();
    }

    //admin cihaz ıd select
    public function shuttleAdminCihaz($cihazID) {
        $sql = "SELECT bsadmincihazRecID FROM bsadmincihaz WHERE bsadmincihazRecID=" . "'$cihazID'";
        return ($count = $this->db->select($sql));
    }

    public function shuttleKullaniciLogin($array = array(), $Kadi, $Sifre, $KullaniciID, $tableName) {
        $sql = "SELECT " . $Kadi . "," . $KullaniciID . " FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre";
        return ($count = $this->db->select($sql, $array));
    }

    //admin süper admini çeksin diye 
    public function shuttleKullaniciLoginA($array = array(), $Kadi, $Sifre, $KullaniciID, $tableName) {
        $sql = "SELECT " . $Kadi . "," . $KullaniciID . ", BSSuperAdmin FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre";
        return ($count = $this->db->select($sql, $array));
    }

    //admin cihaz kayıt
    public function shuttleAdminCihazInsert($data) {
        return ($this->db->insert("bsadmincihaz", $data));
    }

    //sofor cihaz ıd select
    public function shuttleSoforCihaz($cihazID) {
        $sql = "SELECT sbsoforcihazRecID FROM sbsoforcihaz WHERE sbsoforcihazRecID=" . "'$cihazID'";
        return ($count = $this->db->select($sql));
    }

    //sofor cihaz kayıt
    public function shuttleSoforCihazInsert($data) {
        return ($this->db->insert("sbsoforcihaz", $data));
    }

    //veli cihaz ıd select
    public function shuttleVeliCihaz($cihazID) {
        $sql = "SELECT bsvelicihazRecID FROM bsvelicihaz WHERE bsvelicihazRecID=" . "'$cihazID'";
        return ($count = $this->db->select($sql));
    }

    //veli cihaz kayıt
    public function shuttleVeliCihazInsert($data) {
        return ($this->db->insert("bsvelicihaz", $data));
    }

    //öğrenci cihaz ıd select
    public function shuttleOgrenciCihaz($cihazID) {
        $sql = "SELECT bsogrencicihazRecID FROM bsogrencicihaz WHERE bsogrencicihazRecID=" . "'$cihazID'";
        return ($count = $this->db->select($sql));
    }

    //öğrenci cihaz kayıt
    public function shuttleOgrenciCihazInsert($data) {
        return ($this->db->insert("bsogrencicihaz", $data));
    }

    //öğrenci cihaz ıd select
    public function shuttleIsciCihaz($cihazID) {
        $sql = "SELECT sbiscicihazRecID FROM bsiscicihaz WHERE sbiscicihazRecID=" . "'$cihazID'";
        return ($count = $this->db->select($sql));
    }

    //işci cihaz kayıt
    public function shuttleIsciCihazInsert($data) {
        return ($this->db->insert("sbiscicihaz", $data));
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

    //admin id
    public function MbolgeAdminID($username) {
        $sql = "SELECT BSAdminID FROM bsadmin WHERE BSAdminKadi=" . $username;
        return($this->db->select($sql));
    }

    //admin bölgeler listele
    public function MbolgeListele($firmaID) {
        $sql = "SELECT * FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admine göre bölge getirme
    public function MAdminbolgeListele($adminID) {
        $sql = "SELECT BSBolgeID FROM bsadminbolge Where BSAdminID=" . $adminID;
        return($this->db->select($sql));
    }

    //admin bölgeler listele
    public function MrutbeBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeAdi,SBBolgeID FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin bölgeler kurum count
    public function MbolgeKurum_Count($array = array(), $firmaID) {
        $sql = 'SELECT SBBolgeID FROM sbkurum WHERE SBBolgeID IN (' . implode(',', array_map('intval', $array)) . ')';
        return($this->db->select($sql));
    }

    //admin yeni bölge kaydet
    public function MaddNewAdminBolge($data) {
        return ($this->db->insert("sbbolgeler", $data));
    }

    //admin-bölge kaydet
    public function MaddAdminBolge($data) {
        return ($this->db->insert("bsadminbolge", $data));
    }

    //admin bölge detail
    public function MadminBolgeDetail($adminBolgeDetailID) {
        $sql = 'SELECT * FROM sbbolgeler WHERE SBBolgeID=' . $adminBolgeDetailID;
        return($this->db->select($sql));
    }

    //admin bölge kurum var mi
    public function MadminBolgeDetailKurum($adminBolgeDetailID) {
        $sql = 'SELECT SBBolgeID FROM sbkurum WHERE SBBolgeID=' . $adminBolgeDetailID;
        return($this->db->select($sql));
    }

    //admin bölge kurum detail
    public function MadminBolgeKurumDetail($adminBolgeDetailID) {
        $sql = 'SELECT SBKurumAdi,SBKurumLokasyon,SBKurumID FROM sbkurum WHERE SBBolgeID=' . $adminBolgeDetailID . ' ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //admin bölge özellikleri düzenleme
    public function MadminBolgeOzelliklerDuzenle($data, $adminBolgeDetailID) {
        return ($this->db->update("sbbolgeler", $data, "SBBolgeID=" . $adminBolgeDetailID));
    }

    //admin bölge detail bölge delete
    public function MadminBolgeDelete($adminBolgeDetailID) {
        return ($this->db->delete("sbbolgeler", "SBBolgeID=$adminBolgeDetailID"));
    }

    //admin bölge detail bölge delete--idlerin tutulduğu tablo
    public function MadminBolgeIDDelete($adminBolgeDetailID) {
        return ($this->db->delete("bsadminbolge", "BSBolgeID=$adminBolgeDetailID"));
    }

    //admin yeni bölge-> kurum kaydet
    public function MaddNewAdminBolgeKurum($data) {
        return ($this->db->insert("sbkurum", $data));
    }

}

?>
