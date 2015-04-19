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
        $sql = 'SELECT SBBolgeAdi,SBBolgeID FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin bölgeler kurum count
    public function bolgeKurum_Count($array = array()) {
        $sql = 'SELECT SBBolgeID FROM sbkurum WHERE SBBolgeID IN (' . implode(',', array_map('intval', $array)) . ')';
        return($this->db->select($sql));
    }

    //admin bölgeler arac count
    public function bolgeArac_Count($array = array()) {
        $sql = 'SELECT DISTINCT(SBTurAracID), SBBolgeID FROM sbtur WHERE SBBolgeID IN (' . implode(',', array_map('intval', $array)) . ') And SBTurFirmaID=' . $firmaID;
        return($this->db->select($sql));
    }

    //admin bölgeler öğrenci count
    public function bolgeOgrenci_Count($array = array()) {
        $sql = 'SELECT BSBolgeID FROM bsogrenci WHERE BSBolgeID IN (' . implode(',', array_map('intval', $array)) . ') And BSFirmaID=' . $firmaID;
        return($this->db->select($sql));
    }

    //admin bölgeler İŞÇİ count
    public function bolgeIsci_Count($array = array()) {
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
        $sql = 'SELECT SBBolgeID,SBBolgeAdi,SBBolgeAciklama FROM sbbolgeler WHERE SBBolgeID=' . $adminBolgeDetailID;
        return($this->db->select($sql));
    }

    //admin bölge kurum detail
    public function adminBolgeKurumDetail($adminBolgeDetailID) {
        $sql = 'SELECT SBKurumAdi,SBKurumLokasyon,SBKurumID FROM sbkurum WHERE SBBolgeID=' . $adminBolgeDetailID . ' ORDER BY SBKurumAdi ASC';
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
        return ($this->db->update("sbbolgeler", $data, "SBBolgeID=" . $adminBolgeDetailID));
    }

    //admin yeni bölge-> kurum kaydet
    public function addNewAdminBolgeKurum($data) {
        return ($this->db->insert("sbkurum", $data));
    }

    //admin kurum count
    public function kurumListeleCount() {
        $sql = "SELECT SBKurumID FROM sbkurum";
        return($this->db->select($sql));
    }

    //admin kurumlar rutbe count
    public function rutbeKurumCount($array = array()) {
        $sql = 'SELECT SBKurumID FROM sbkurum Where SBBolgeID IN (' . $array . ')';
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
        $sql = 'SELECT SBKurumAdi,SBKurumID,SBKurumAciklama,SBBolgeID,SBBolgeAdi FROM sbkurum Where SBBolgeID IN (' . $array . ') ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //admin kurum detail
    public function adminKurumDetail($adminKurumDetailID) {
        $sql = 'SELECT SBKurumID,SBKurumAdi,SBBolgeAdi,SBKurumTelefon,SBKurumEmail,SBKurumAdres,SBKurumAciklama,SBKurumLokasyon FROM sbkurum WHERE SBKurumID=' . $adminKurumDetailID;
        return($this->db->select($sql));
    }

    //admin kurum tur detail
    public function adminKurumTurDetail($adminKurumDetailID) {
        $sql = 'SELECT SBTurID,SBTurAdi,SBTurAktiflik,SBTurType,SBTurAciklama FROM sbtur WHERE SBKurumID=' . $adminKurumDetailID . ' ORDER BY SBTurAdi ASC';
        return($this->db->select($sql));
    }

    //admin kurum detail  delete
    public function adminKurumDelete($adminKurumDetailID) {
        return ($this->db->delete("sbkurum", "SBKurumID=$adminKurumDetailID"));
    }

    //admin kurum özellikleri düzenleme
    public function adminKurumOzelliklerDuzenle($data, $adminKurumDetailID) {
        return ($this->db->update("sbkurum", $data, "SBKurumID=" . $adminKurumDetailID));
    }

    //admin kurum bölge select listele
    public function kurumBolgeListele() {
        $sql = "SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admine göre kurum bölge select listele
    public function adminKurumBolgeListele($adminID) {
        $sql = "SELECT BSBolgeID FROM bsadminbolge Where BSAdminID=" . $adminID;
        return($this->db->select($sql));
    }

    //admin rütbe kurum bölge select listele
    public function adminRutbeKurumBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin yeni bölge-> kurum kaydet
    public function addNewAdminKurum($data) {
        return ($this->db->insert("sbkurum", $data));
    }

    //admin araç count
    public function aracListeleCount() {
        $sql = "SELECT SBAracID FROM sbarac";
        return($this->db->select($sql));
    }

    //admin aktif arac listele
    public function aracListele() {
        $sql = 'SELECT SBAracID,SBAracPlaka,SBAracMarka,SBAracModelYili,SBAracKapasite,SBAracKm,SBAracDurum FROM sbarac ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //rutbe tur aktif arac ID listele
    public function rutbearacIDListele($array = array()) {
        $sql = 'SELECT DISTINCT SBAracID FROM sbaracbolge WHERE SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //rubee göre araçlar
    public function aracRutbeListele($array = array()) {
        $sql = 'SELECT SBAracID,SBAracPlaka,SBAracMarka,SBAracModelYili,SBAracKapasite,SBAracKm,SBAracDurum FROM sbarac WHERE SBAracID IN (' . $array . ') ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function aracBolgeListele() {
        $sql = "SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admine göre arac bölge select listele
    public function adminAracBolgeListele($adminID) {
        $sql = "SELECT BSBolgeID FROM bsadminbolge Where BSAdminID=" . $adminID;
        return($this->db->select($sql));
    }

    //admin arac şoför bölge select listele
    public function aracSoforListele() {
        $sql = "SELECT BSSoforID,BSSoforAd,BSSoforSoyad FROM bssofor ORDER BY BSSoforAd ASC";
        return($this->db->select($sql));
    }

    //admin rütbe arac bölge select listele
    public function adminRutbeAracBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin rütbe arac ıd 
    public function adminRutbeSoforIDListele($array = array()) {
        $sql = 'SELECT DISTINCT BSSoforID FROM bssoforbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin rütbe arac bölge select listele
    public function adminRutbeSoforListele($array = array()) {
        $sql = 'SELECT BSSoforID , BSSoforAd , BSSoforSoyad FROM bssofor Where BSSoforID IN (' . $array . ') ORDER BY BSSoforAd ASC';
        return($this->db->select($sql));
    }

    //admin yeni araç kaydet
    public function addNewAdminArac($data) {
        return ($this->db->insert("sbarac", $data));
    }

    //admin araç şofor kaydet
    public function addNewAdminAracSofor($data) {
        return ($this->db->multiInsert('bsaracsofor', $data));
    }

    //admin araç bölge  kaydet
    public function addNewAdminBolgeSofor($data) {
        return ($this->db->multiInsert('sbaracbolge', $data));
    }

    //admin arac delete
    public function adminAracDelete($adminAracID) {
        return ($this->db->delete("sbarac", "SBAracID=$adminAracID"));
    }

    //admin arac şöfor çoklu delete delete
    public function adminAracSoforDelete($adminAracID) {
        return ($this->db->delete("bsaracsofor", "BSAracID=$adminAracID"));
    }

    //admin seçili arac bolge listele
    public function adminDetailAracBolge($aracID) {
        $sql = 'SELECT SBBolgeID,SBBolgeAdi FROM sbaracbolge WHERE SBAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminDetailAracSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID,SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin seçili arac şoför listele
    public function adminDetailAracSofor($aracID) {
        $sql = 'SELECT BSSoforID,BSSoforAd FROM bsaracsofor WHERE BSAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //admin select dışı şoför listele
    public function adminDetailAracSSofor($array = array()) {
        $sql = 'SELECT BSSoforID,BSSoforAd,BSSoforSoyad FROM bssofor WHERE BSSoforID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin arac detail özellik
    public function adminDetailAracOzellik($aracID) {
        $sql = 'SELECT SBAracID,SBAracPlaka,SBAracMarka,SBAracModelYili,SBAracKapasite,SBAracKm,SBAracDurum,SBAracAciklama FROM sbarac WHERE SBAracID=' . $aracID . ' ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //admin rutbe select dışı bölge listele
    public function adminRutbeDetailAracSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID,SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin rutbe select dışı arac listele
    public function adminRutbeDetailAracSSofor($array = array()) {
        $sql = 'SELECT BSSoforID,BSSoforAd,BSSoforSoyad FROM bssofor WHERE BSSoforID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin rutbe bölgesindeki şoförler
    public function adminAracBolgeSofor($array = array()) {
        $sql = 'SELECT BSSoforID FROM bssoforbolge WHERE BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin arac detail  delete
    public function adminDetailAracDelete($adminAracDetailID) {
        return ($this->db->delete("sbarac", "SBAracID=$adminAracDetailID"));
    }

    //admin arac bolge detail  delete
    public function adminDetailAracBolgeDelete($adminAracDetailID) {
        return ($this->db->delete("sbaracbolge", "SBAracID=$adminAracDetailID"));
    }

    //admin arac sofor detail  delete
    public function adminDetailAracSoforDelete($adminAracDetailID) {
        return ($this->db->delete("bsaracsofor", "BSAracID=$adminAracDetailID"));
    }

    //admin arac özellikleri düzenleme
    public function adminAracOzelliklerDuzenle($data, $aracID) {
        return ($this->db->update("sbarac", $data, "SBAracID=" . $aracID));
    }

    //admin seçili arac aktif tur listele
    public function adminDetailAracTur($aracID) {
        $sql = 'SELECT SBTurAktiflik FROM sbtur WHERE SBTurAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //admin rutbe bölgesindeki şoförler
    public function adminDetailRutbeAracTur($array = array(), $aracID) {
        $sql = 'SELECT SBTurAktiflik FROM sbtur WHERE BSBolgeID IN (' . $array . ') AND SBTurAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //admin arac detail 
    public function adminAracTurDetail($adminAracDetailID) {
        $sql = 'SELECT SBTurID,SBTurAdi,SBTurAktiflik,SBTurType,SBTurAciklama,SBKurumID,SBBolgeID FROM sbtur WHERE SBTurAracID=' . $adminAracDetailID;
        return($this->db->select($sql));
    }

    //admin arac tur kurum
    public function adminAracTurKurum($sql) {
        //$sql = 'SELECT SBKurumID,SBKurumAdi FROM sbkurum WHERE SBKurumID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin arac tur kurum
    public function adminAracTurBolge($sql) {
        //$sql = 'SELECT SBBolgeID,SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin aktif arac listele
    public function adminCountListele($adminID) {
        $sql = 'SELECT COUNT(*) FROM bsadmin WHERE BSAdminID NOT IN(' . $adminID . ')';
        return($this->db->select($sql));
    }

    //admin listele
    public function adminListele($adminID) {
        $sql = "SELECT BSAdminID,BSAdminAd,BSAdminSoyad,BSAdminPhone,BSAdminEmail,BSAdminStatus,BSAdminAciklama FROM bsadmin WHERE BSAdminID NOT IN($adminID)  ORDER BY BSAdminAd ASC";
        return($this->db->select($sql));
    }

    //yeni admin Kaydet
    public function addNewAdmin($data) {
        return ($this->db->insert("bsadmin", $data));
    }

    //admin araç bölge  kaydet
    public function addNewBolgeAdmin($data) {
        return ($this->db->multiInsert('bsadminbolge', $data));
    }

    //admin delete
    public function adminDelete($adminID) {
        return ($this->db->delete("bsadmin", "BSAdminID=$adminID"));
    }

    //admin arac şöfor çoklu delete delete
    public function adminMultiBolgeDelete($adminID) {
        return ($this->db->delete("bsadminbolge", "BSAdminID=$adminID"));
    }

}

?>
