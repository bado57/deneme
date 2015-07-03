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

    //hostes cihaz kayıt
    public function shuttleHostesCihazInsert($data) {
        return ($this->db->insert("bshostescihaz", $data));
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

    //şoför profil
    public function soforProfil($soforID) {
        $sql = 'SELECT BSSoforAd,BSSoforSoyad,BSSoforKadi,BSSoforPhone,BSSoforEmail,BSSoforDetayAdres,BSSoforLocation FROM bssofor WHERE BSSoforID=' . $soforID;
        return($this->db->select($sql));
    }

    //şoför profil düzenle
    public function soforProfilDuzenle($data, $soforID) {
        return ($this->db->update("bssofor", $data, "BSSoforID=" . $soforID));
    }

    //şoför profil düzenle1
    public function soforProfilDuzenle1($data, $soforID) {
        return ($this->db->update("bsturtip", $data, "BSTurSoforID=" . $soforID));
    }

    //şoför profil düzenle2
    public function soforProfilDuzenle2($data, $soforID) {
        return ($this->db->update("bssoforbolge", $data, "BSSoforID=" . $soforID));
    }

    //şoför profil düzenle3
    public function soforProfilDuzenle3($data, $soforID) {
        return ($this->db->update("bsaracsofor", $data, "BSSoforID=" . $soforID));
    }

    //şoför şifre
    public function soforSifre($soforID) {
        $sql = 'SELECT BSSoforRSifre FROM bssofor WHERE BSSoforID=' . $soforID;
        return($this->db->select($sql));
    }

    //şoför şifre düzenle
    public function soforSifreDuzenle($data, $soforID) {
        return ($this->db->update("bssofor", $data, "BSSoforID=" . $soforID));
    }

    //şoför harita düzenle
    public function soforMapDuzenle($data, $soforID) {
        return ($this->db->update("bssofor", $data, "BSSoforID=" . $soforID));
    }

    //şoför tur ıd
    public function soforTurKurum($soforID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsturtip WHERE BSTurSoforID=' . $soforID;
        return($this->db->select($sql));
    }

    //şoför tur kurumlar
    public function soforTurKurumlar($array = array()) {
        $sql = 'SELECT DISTINCT SBTurID,SBTurAd FROM sbtur Where SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur detay
    public function soforTurDetay($turID) {
        $sql = 'SELECT SBTurAd,SBTurAciklama,SBTurAktiflik,SBKurumID,SBKurumAd,SBKurumLocation,SBBolgeAd,SBBolgeID,SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,SBTurGidis,SBTurDonus,SBTurTip,SBTurKm FROM sbtur WHERE SBTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur gidiş
    public function soforTurGidis($turID) {
        $sql = 'SELECT BSTurTipID,BSTurAracID,BSTurAracPlaka,BSTurSoforAd,BSTurSoforID,BSTurHostesAd,BSTurHostesID,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurID=' . $turID . ' AND BSTurGidisDonus=0';
        return($this->db->select($sql));
    }

    //şoför tur dönüş
    public function soforTurDonus($turID) {
        $sql = 'SELECT BSTurTipID,BSTurAracID,BSTurAracPlaka,BSTurSoforAd,BSTurSoforID,BSTurHostesAd,BSTurHostesID,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurID=' . $turID . ' AND BSTurGidisDonus=1';
        return($this->db->select($sql));
    }

    //şoför tur öğrenci yolcu
    public function soforTurOgrenci($turID) {
        $sql = 'SELECT BSOgrenciID,BSOgrenciAd FROM bsogrencitur WHERE BSTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur işçi yolcu
    public function soforTurIsci($turID) {
        $sql = 'SELECT SBIsciID,SBIsciAd FROM sbiscitur WHERE SBTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur öğrenci işçi yolcu
    public function soforTurIsciOgrenci($turID) {
        $sql = 'SELECT BSOgrenciIsciID,BSOgrenciIsciAd,BSKullaniciTip FROM bsogrenciiscitur WHERE BSTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur şoför
    public function soforTurDiger($turID) {
        $sql = 'SELECT DISTINCT BSTurSoforID,BSTurSoforAd FROM bsturtip WHERE BSTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur hostes
    public function soforTurHostes($turID) {
        $sql = 'SELECT DISTINCT BSTurHostesID,BSTurHostesAd FROM bsturtip WHERE BSTurID=' . $turID . ' AND BSTurHostesID!=0';
        return($this->db->select($sql));
    }

    //şoför tur yöneticiler
    public function soforTurYonetici($bolgeID) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge  WHERE BSBolgeID=' . $bolgeID;
        return($this->db->select($sql));
    }

    //admin select dışı öğrenci listele
    public function soforTurYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID, BSAdminAd, BSAdminSoyad FROM bsadmin WHERE BSAdminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför yolcu öğrenci detay
    public function soforOYolcu($kisiID) {
        $sql = 'SELECT BSOgrenciAd,BSOgrenciSoyad,BSOgrenciPhone,BSOgrenciEmail,BSOgrenciLocation,BSOgrenciDetayAdres FROM bsogrenci WHERE BSOgrenciID=' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu öğrenci-veli id detay
    public function soforOVIDYolcu($kisiID) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci WHERE BSOgrenciID=' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu öğrenci-veli detay
    public function soforOVYolcu($array = array()) {
        $sql = 'SELECT SBVeliAd,SBVeliSoyad,SBVeliPhone,SBVeliEmail FROM sbveli  WHERE SBVeliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför yolcu personel detay
    public function soforPYolcu($kisiID) {
        $sql = 'SELECT SBIsciAd,SBIsciSoyad,SBIsciPhone,SBIsciEmail,SBIsciLocation,SBIsciDetayAdres FROM sbisci WHERE SBIsciID=' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu şoför detay
    public function soforSYolcu($kisiID) {
        $sql = 'SELECT BSSoforAd,BSSoforSoyad,BSSoforPhone,BSSoforEmail,BSSoforLocation,BSSoforDetayAdres FROM bssofor WHERE BSSoforID=' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu hostes detay
    public function soforHYolcu($kisiID) {
        $sql = 'SELECT BSHostesAd,BSHostesSoyad,BSHostesPhone,BSHostesEmail,BSHostesLocation,BSHostesDetayAdres FROM bshostes WHERE BSHostesID=' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu yönetici detay
    public function soforYYolcu($kisiID) {
        $sql = 'SELECT BSAdminAd,BSAdminSoyad,BSAdminPhone,BSAdminEmail,BSAdminLocation,BSAdminDetayAdres FROM bsadmin WHERE BSAdminID=' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu arac detay
    public function soforArac($aracID) {
        $sql = 'SELECT SBAracMarka,SBAracModelYili,SBAracPlaka,SBAracKapasite,SBAracKm,SBAracDurum,SBAracAciklama FROM sbarac WHERE SBAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //şoför tur harita öğrenci yolcu
    public function soforHTurOgrenci($turID) {
        $sql = 'SELECT BSOgrenciID,BSOgrenciAd,BSOgrenciLocation FROM bsogrencitur WHERE BSTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur harita işçi yolcu
    public function soforHTurIsci($turID) {
        $sql = 'SELECT SBIsciID,SBIsciAd,SBIsciLocation FROM sbiscitur WHERE SBTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur harita öğrenci işçi yolcu
    public function soforHTurIsciOgrenci($turID) {
        $sql = 'SELECT BSOgrenciIsciID,BSOgrenciIsciAd,BSOgrenciIsciLocation,BSKullaniciTip FROM bsogrenciiscitur WHERE BSTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför araçlar
    public function soforAraclar($soforID) {
        $sql = 'SELECT DISTINCT BSAracID,BSAracPlaka FROM bsaracsofor WHERE BSSoforID=' . $soforID;
        return($this->db->select($sql));
    }

    //şoför aracın dahil olduğu turlar
    public function soforAracTur($aracID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsturtip WHERE BSTurAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //şoför tur kurumlar
    public function soforAracTurlar($array = array()) {
        $sql = 'SELECT DISTINCT SBTurID,SBTurAd FROM sbtur Where SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför araçlar-şoförler
    public function soforAraclarS($aracID) {
        $sql = 'SELECT DISTINCT BSSoforID,BSSoforAd FROM bsaracsofor WHERE BSAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //şoför araçlar-hostesler
    public function soforAraclarH($aracID) {
        $sql = 'SELECT DISTINCT BSHostesID,BSHostesAd FROM bsarachostes WHERE BSAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //şoför araçlar-yoneticiler
    public function soforAracY($aracID) {
        $sql = 'SELECT DISTINCT SBBolgeID FROM sbaracbolge WHERE SBAracID=' . $aracID;
        return($this->db->select($sql));
    }

    //arac bölge admin
    public function soforAracYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge WHERE BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //arac adminler
    public function soforYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID,BSAdminAd,BSAdminSoyad FROM bsadmin WHERE BSAdminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //araç takvim özellikleri
    public function soforAracTakvim($aracID) {
        $sql = 'SELECT SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //şoför takvim özellikleri
    public function soforTakvim($soforID) {
        $sql = 'SELECT SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //hostes takvim özellikleri
    public function hostesTakvim($hostesID) {
        $sql = 'SELECT SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurHostesID = ' . $hostesID;
        return($this->db->select($sql));
    }

}

?>
