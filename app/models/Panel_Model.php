<?php

class Panel_Model extends Model {
    public function __construct() {
        parent::__construct();
    }

    public function susersLogin($array = array(), $Kadi, $Sifre, $KullaniciID, $tableName) {
        $sql = "SELECT " . $Kadi . "," . $KullaniciID . " FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre LIMIT 1";
        return ($count = $this->db->select($sql, $array));
    }
   
    
    //admin firma özellikleri getirme
    public function datatable() {
         $sql = "SELECT SBBolgeAdi, SBBolgeAciklama FROM sbbolgeler";
        return($this->db->select($sql));
    }

    //admin firma özellikleri getirme
    public function firmaOzellikler() {
        $sql = "SELECT * FROM bsfirma Where BSFirmaID=1 LIMIT 1";
        return ($this->db->select($sql));
    }

    //admin firma özellikleri düzenleme
    public function firmaOzelliklerDuzenle($data, $FirmaID) {
        return ($this->db->update("bsfirma", $data, "BSFirmaID=1"));
    }

    //admin bölgeler listele
    public function bolgeListele() {
        $sql = "SELECT * FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admine göre bölge getirme
    public function AdminbolgeListele($adminID) {
        $sql = "SELECT BSBolgeID FROM bsadminbolge Where BSAdminID=" . $adminID;
        return($this->db->select($sql));
    }

    //admin bölgeler listele
    public function rutbeBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeAdi,SBBolgeID FROM sbbolgeler Where SBBolgeID IN ('.$array.') ORDER BY SBBolgeAdi ASC' ;
        return($this->db->select($sql));
    }

    //admin bölgeler kurum count
    public function bolgeKurum_Count($array = array(), $firmaID) {
        $sql = 'SELECT SBBolgeID FROM sbkurum WHERE SBBolgeID IN (' . implode(',', array_map('intval', $array)) . ')';
        error_log("zsql".$sql);
        return($this->db->select($sql));
    }

    //admin bölgeler arac count
    public function bolgeArac_Count($array = array(), $firmaID) {
        $sql = 'SELECT DISTINCT(SBTurAracID), SBBolgeID FROM sbtur WHERE SBBolgeID IN (' . implode(',', array_map('intval', $array)) . ') And SBTurFirmaID=' . $firmaID;
        return($this->db->select($sql));
    }
    
    //admin bölgeler öğrenci count
    public function bolgeOgrenci_Count($array = array(), $firmaID) {
        $sql = 'SELECT BSBolgeID FROM bsogrenci WHERE BSBolgeID IN (' . implode(',', array_map('intval', $array)) . ') And BSFirmaID=' . $firmaID;
        return($this->db->select($sql));
    }
    
    //admin bölgeler İŞÇİ count
    public function bolgeIsci_Count($array = array(), $firmaID) {
        $sql = 'SELECT SBBolgeID FROM sbisci WHERE SBBolgeID IN (' . implode(',', array_map('intval', $array)) . ') And SBFirmaID=' . $firmaID;
        return($this->db->select($sql));
    }
    
    //admin yeni bölge kaydet
    public function addNewAdminBolge($data) {
        return ($this->db->insert("sbbolgeler", $data));
    }
    
    //admin-bölge kaydet
    public function addAdminBolge($data) {
        return ($this->db->insert("bsadminbolge", $data));
    }

    //admin bölge detail
    public function adminBolgeDetail($adminBolgeDetailID) {
        $sql = 'SELECT * FROM sbbolgeler WHERE SBBolgeID=' . $adminBolgeDetailID;
        return($this->db->select($sql));
    }
    
    //admin bölge kurum detail
    public function adminBolgeKurumDetail($adminBolgeDetailID) {
        $sql = 'SELECT SBKurumAdi,SBKurumLokasyon,SBKurumID FROM sbkurum WHERE SBBolgeID=' . $adminBolgeDetailID. ' ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }
    
    //admin bölge detail bölge delete
    public function adminBolgeDelete($adminBolgeDetailID) {
        return ($this->db->delete("sbbolgeler", "SBBolgeID=$adminBolgeDetailID"));
    }
    
    //admin bölge detail bölge delete--idlerin tutulduğu tablo
    public function adminBolgeIDDelete($adminBolgeDetailID) {
        return ($this->db->delete("bsadminbolge", "BSBolgeID=$adminBolgeDetailID"));
    }
    
    //admin bölge özellikleri düzenleme
    public function adminBolgeOzelliklerDuzenle($data, $adminBolgeDetailID) {
        return ($this->db->update("sbbolgeler", $data, "SBBolgeID=".$adminBolgeDetailID));
    }
    
    //admin yeni bölge-> kurum kaydet
    public function addNewAdminBolgeKurum($data) {
        return ($this->db->insert("sbkurum", $data));
    }
    
    //kurumliste
    
    //admin kurum count
    public function kurumListeleCount() {
        $sql = "SELECT SBKurumID FROM sbkurum";
        return($this->db->select($sql));
    }
    
    //admin kurumlar rutbe count
    public function rutbeKurumCount($array = array()) {
        $sql = 'SELECT SBKurumID FROM sbkurum Where SBBolgeID IN ('.$array.')' ;
        return($this->db->select($sql));
    }
    
    //admin kruum listele
    public function kurumListele() {
        $sql = "SELECT SBKurumAdi,SBKurumID,SBKurumAciklama,SBBolgeID,SBBolgeAdi FROM sbkurum ORDER BY SBKurumAdi ASC";
        return($this->db->select($sql));
    }
    
    //admin bölgeler kurum count
    public function kurumTur_Count($array = array()) {
        $sql = 'SELECT SBKurumID FROM sbtur WHERE SBKurumID IN (' . implode(',', array_map('intval', $array)) . ')';
        return($this->db->select($sql));
    }
    
    //admin bölgeye öre kurum listele
    public function rutbeKurumBolgeListele($array = array()) {
        $sql = 'SELECT SBKurumAdi,SBKurumID,SBKurumAciklama,SBBolgeID,SBBolgeAdi FROM sbkurum Where SBBolgeID IN ('.$array.') ORDER BY SBKurumAdi ASC' ;
        return($this->db->select($sql));
    }
    
    
    public function updateNewProject($data, $gelenlabel) {
        return ($this->db->update("insaat_projeler", $data, "insaat_proje_id=$gelenlabel"));
    }

    public function gayri_benzersiz_deger_kodu($array = array()) {
        $sql = "SELECT * FROM insaat_projeler WHERE insaat_proje_kodu = :InputPkodu";
        return ($count = $this->db->affectedRows($sql, $array));
    }

    public function gayri_benzersiz_deger_adi($array = array()) {
        $sql = "SELECT * FROM insaat_projeler WHERE insaat_proje_adi = :InputPadi";
        return ($count = $this->db->affectedRows($sql, $array));
    }

    public function addNewProjectBuildingInsert($datam) {
        return ($this->db->insert("insaat_proje_yapi", $datam));
    }

    public function addBuildingDelete($gelenbloklabell) {
        return ($this->db->delete("insaat_proje_yapi_blok", "insaat_proje_yapi_id=$gelenbloklabell"));
    }

    public function updateNewBlokProject($datam, $gelenbloklabell) {
        return ($this->db->update("insaat_proje_yapi", $datam, "insaat_proje_yapi_id=$gelenbloklabell"));
    }

    public function addBuildingInsert($data) {
        return ($this->db->insert("insaat_proje_yapi_blok", $data));
    }

    public function addBuildingUpdateInsert($data, $gelenyapi_id) {
        return ($this->db->insert("insaat_proje_yapi_blok", $data, "insaat_proje_yapi_id=$gelenyapi_id"));
    }

    public function projeIlListele() {
        $sql = "SELECT * FROM insaat_proje_il";
        return $this->db->select($sql);
    }

    public function projeIlceListele($array = array()) {
        $sql = "Select * from insaat_proje_ilce WHERE il_id=:proje_il_id";
        return $this->db->select($sql, $array);
    }

    public function projeSemtListele($array = array()) {
        $sql = "Select * from insaat_proje_semt WHERE ilceID=:proje_ilce_id";
        return $this->db->select($sql, $array);
    }

    public function projeMahalleListele($array = array()) {
        $sql = "Select * from insaat_proje_mahalle WHERE semtID=:proje_semt_id";
        return $this->db->select($sql, $array);
    }

    public function projePostaKoduGoster($array = array()) {
        $sql = "Select * from insaat_proje_postakodu WHERE mahalleID=:proje_mahalle_id";
        return $this->db->select($sql, $array);
    }

    public function addNewProjectAdressInsert($data) {
        return ($this->db->insert("insaat_proje_yapi_adres", $data));
    }

    public function updateProjectAdressInsert($data, $gelenadres_id) {
        return ($this->db->insert("insaat_proje_yapi_adres", $data, "insaat_proje_yapi_adres_id=$gelenadres_id"));
    }

    public function projeModalDetayIcon($array = array()) {
        $sql = "SELECT * FROM insaat_projeler LEFT JOIN insaat_proje_yapi ON insaat_proje_yapi.insaat_yapi_proje=insaat_projeler.insaat_proje_id LEFT JOIN insaat_proje_yapi_blok ON insaat_proje_yapi_blok.insaat_proje_yapi_id=insaat_proje_yapi.insaat_proje_yapi_id LEFT JOIN insaat_proje_yapi_adres ON insaat_proje_yapi_adres.insaat_proje_yapi_id=insaat_proje_yapi.insaat_proje_yapi_id WHERE insaat_proje_id=:projeModalDtyID";
        return $this->db->select($sql, $array);
    }

    public function dataTableListCount() {
        $sql = "SELECT * FROM insaat_projeler";
        return($this->db->affectedRows($sql));
    }

    public function tableListele($data) {
        //ORDER BY insaat_proje_id ASC LIMIT 0,3
        $sql = "SELECT * FROM insaat_projeler " . $data . "";
        return ($this->db->select($sql));
    }

}

?>
