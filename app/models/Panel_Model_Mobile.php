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
        $sql = 'SELECT DISTINCT SBTurID,SBTurAd,SBTurTip,SBBolgeID FROM sbtur Where SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat tur ıdler
    public function soforTurBaslatID($soforID, $gun) {
        $sql = 'SELECT BSTurID,BSTurAracID,BSTurGidisDonus,BsTurBitis,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurSoforID=' . $soforID . ' AND ' . $gun . '=1 ORDER BY BSTurBslngc ASC';
        return($this->db->select($sql));
    }

    //şoför tur başla detay tur gidiş ve dönüşler
    public function soforTurBaslatIlk($turID) {
        $sql = 'SELECT SBTurID,SBTurAd,SBTurTip,SBTurKm FROM sbtur WHERE SBTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur başla tur ıdler
    public function soforTurID($soforID, $gun) {
        $sql = 'SELECT DISTINCT BSTurID,BSTurAracPlaka FROM bsturtip WHERE BSTurSoforID=' . $soforID . ' AND ' . $gun . '=1 ORDER BY BSTurBslngc ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat turlar
    public function soforTurBaslat($array = array()) {
        $sql = 'SELECT DISTINCT SBTurID,SBTurAd,SBKurumAd,SBTurTip FROM sbtur Where SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başla detay tur gidiş ve dönüşler
    public function soforTurBaslatDetay($turID, $gun) {
        $sql = 'SELECT BSTurID,BSTurTip,BSTurAracPlaka,BSTurBslngc,BSTurBts,BSTurGidisDonus FROM bsturtip WHERE BSTurID=' . $turID . ' AND ' . $gun . '=1 ORDER BY BSTurBslngc ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre öğrenci idler 
    public function soforTurBaslatOgrenciID($turID) {
        $sql = 'SELECT DISTINCT BSOgrenciID,BSKurumID,BSKurumAd,BSKurumLocation FROM bsogrencitur WHERE BSTurID=' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre gelemyen öğrenci idler 
    public function soforTurBaslatOgrenciGID($turID, $gun, $turTur) {
        $sql = 'SELECT DISTINCT BSOgrenciID FROM bsseferogrenci WHERE BSTurID=' . $turID . ' AND ' . $gun . '=1' . ' AND BSTurTip=' . $turTur;
        return($this->db->select($sql));
    }

    //tura binenler
    public function soforTurOgrGidisBinen($turID) {
        $sql = 'SELECT DISTINCT BSKisiSira FROM bsturgidis WHERE BSTurID=' . $turID;
        return($this->db->select($sql));
    }

    //turdan inenler
    public function soforTurOgrDonusInen($turID) {
        $sql = 'SELECT DISTINCT BSKisiSira FROM bsturdonus WHERE BSTurID=' . $turID;
        return($this->db->select($sql));
    }

    //şoför turu için hostes var sa sorgu gelmektedir
    public function soforTurBaslatHostes($turID, $turTur) {
        $sql = 'SELECT BSTurHostesID,BSTurHostesAd,BSTurHostesLocation FROM bsturtip WHERE BSTurID=' . $turID . ' AND BSTurGidisDonus=' . $turTur;
        return($this->db->select($sql));
    }

    //şoför tur öğrenci idl ye göre işlemler
    public function soforTurBaslatOgrenciIID($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID,BSOgrenciAd,BSOgrenciSoyad,BSOgrenciPhone FROM bsogrenci Where BSOgrenciID IN (' . $array . ') ORDER BY field(BSOgrenciID,' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur öğrenci idl ye göre işlemler
    public function soforTBMapsOgrenciIID($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID,BSOgrenciAd,BSOgrenciSoyad,BSOgrenciPhone,BSOgrenciLocation FROM bsogrenci Where BSOgrenciID IN (' . $array . ') ORDER BY field(BSOgrenciID,' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre işçi idler 
    public function soforTurBaslatIsciID($turID) {
        $sql = 'SELECT DISTINCT SBIsciID,SBKurumID,SBKurumAd,SBKurumLocation FROM sbiscitur WHERE SBTurID=' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre gelemyen işçi idler 
    public function soforTurBaslatIsciGID($turID, $gun, $turTur) {
        $sql = 'SELECT DISTINCT BSIsciID FROM bsseferisci WHERE BSTurID=' . $turID . ' AND ' . $gun . '=1' . ' AND BSTurTip=' . $turTur;
        return($this->db->select($sql));
    }

    //şoför tur işçi     idl ye göre işlemler
    public function soforTurBaslatIsciIID($array = array()) {
        $sql = 'SELECT DISTINCT SBIsciID,SBIsciAd,SBIsciSoyad,SBIsciPhone FROM sbisci Where SBIsciID IN (' . $array . ') ORDER BY field(SBIsciID,' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur işçi     idl ye göre işlemler
    public function soforTBMapsIsciIID($array = array()) {
        $sql = 'SELECT DISTINCT SBIsciID,SBIsciAd,SBIsciSoyad,SBIsciPhone,SBIsciLocation FROM sbisci Where SBIsciID IN (' . $array . ') ORDER BY field(SBIsciID,' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre öğrenci ve işçi idler 
    public function soforTurBaslatOgrenciIsciID($turID) {
        $sql = 'SELECT DISTINCT BSOgrenciIsciID,BSKullaniciTip,BSKurumID,BSKurumAd,BSKurumLocation FROM bsogrenciiscitur WHERE BSTurID=' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre gelemyen öğrenci ve işçi idler 
    public function soforTurBaslatOgrenciIsciGID($turID, $gun, $turTur) {
        $sql = 'SELECT DISTINCT BSKisiID,BSKullaniciTip,BSKurumID,BSKurumAd,BSKurumLocation FROM bsseferogrenciisci WHERE BSTurID=' . $turID . ' AND ' . $gun . '=1' . ' AND BSTurTip=' . $turTur;
        return($this->db->select($sql));
    }

    //şoför tur başlat öğrenci detay
    public function soforTurBaslatKOgrenciDetay($kid) {
        $sql = 'SELECT DISTINCT BSOgrenciID,BSOgrenciAd,BSOgrenciSoyad,BSOgrenciPhone FROM bsogrenci Where BSOgrenciID=' . $kid;
        return($this->db->select($sql));
    }

    //şoför tur başlat öğrenci-veli id
    public function soforTurBaslatKOgrVeliID($kid) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID=' . $kid;
        return($this->db->select($sql));
    }

    //şoför tur başlat öğrenci detay
    public function soforTurBaslatKVeliDetay($array = array()) {
        $sql = 'SELECT DISTINCT SBVeliID,SBVeliAd,SBVeliSoyad,SBVeliPhone FROM sbveli Where SBVeliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat işçi detay
    public function soforTurBaslatKIsciDetay($kid) {
        $sql = 'SELECT DISTINCT SBIsciID,SBIsciAd,SBIsciSoyad,SBIsciPhone FROM sbisci Where SBIsciID=' . $kid;
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

    //şoför tur öğrenci yolcu
    public function soforTurVeli($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID,BSVeliAd FROM bsveliogrenci WHERE BSOgrenciID IN (' . $array . ')';
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
        $sql = 'SELECT BSTurID,SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //araç takvim özellikleri
    public function takvimTitle($sql) {
        return($this->db->select($sql));
    }

    //şoför takvim özellikleri
    public function soforTakvim($soforID) {
        $sql = 'SELECT BSTurID,SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //hostes takvim özellikleri
    public function hostesTakvim($hostesID) {
        $sql = 'SELECT BSTurID,SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurHostesID = ' . $hostesID;
        return($this->db->select($sql));
    }

    //admin duyuru save
    public function addAdminDuyuru($data) {
        return ($this->db->multiInsert('bsadminduyuru', $data));
    }

    //diğer admin cihazlar
    public function digerAdminCihaz($array = array()) {
        $sql = 'SELECT bsadmincihazRecID FROM bsadmincihaz Where bsadminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //sofor duyuru save
    public function addSoforDuyuru($data) {
        return ($this->db->multiInsert('bssoforduyuru', $data));
    }

    //sofor log duyuru save
    public function addSoforLogDuyuru($data) {
        return ($this->db->insert('bssoforduyurulog', $data));
    }

    //şoför cihazlar
    public function digerSoforCihaz($array = array()) {
        $sql = 'SELECT sbsoforcihazRecID FROM sbsoforcihaz Where sbsoforID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //hostes duyuru save
    public function addHostesDuyuru($data) {
        return ($this->db->multiInsert('bshostesduyuru', $data));
    }

    //hostes cihazlar
    public function digerHostesCihaz($array = array()) {
        $sql = 'SELECT bshostescihazRecID FROM bshostescihaz Where bshostesID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //veli duyuru save
    public function addVeliDuyuru($data) {
        return ($this->db->multiInsert('bsveliduyuru', $data));
    }

    //veli cihaz
    public function veliCihaz($array = array()) {
        $sql = 'SELECT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenci duyuru save
    public function addOgrenciDuyuru($data) {
        return ($this->db->multiInsert('bsogrenciduyuru', $data));
    }

    //öğrenci cihaz
    public function ogrenciCihaz($array = array()) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //işçi duyuru save
    public function addIsciDuyuru($data) {
        return ($this->db->multiInsert('sbisciduyuru', $data));
    }

    //işçi cihaz
    public function isciCihaz($array = array()) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför gelen duyurular
    public function soforGelenDuyuru($soforID) {
        $sql = 'SELECT BSDuyuruText,BSSoforDuyuruID,BSGonderenAdSoyad,BSGonderenTip,BSOkundu,BSDuyuruTarih FROM bssoforduyuru Where BSAlanID=' . $soforID . ' ORDER BY BSDuyuruTarih DESC';
        return($this->db->select($sql));
    }

    //duyurular okundu
    public function soforGelenOkundu($data, $duyuruID) {
        return ($this->db->update("bssoforduyuru", $data, "BSSoforDuyuruID=" . $duyuruID));
    }

    //şoför önderilen duyurular
    public function soforGonderilenDuyuru($soforID) {
        $sql = 'SELECT BSSoforLogID,BSLogText,BSLogHedef,BsLogTarih FROM  bssoforduyurulog Where BSEkleyenID=' . $soforID . ' ORDER BY BsLogTarih DESC';
        return($this->db->select($sql));
    }

    //öğrencinin velileri
    public function ogrenciTurVeli($ogrID) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID=' . $ogrID;
        return($this->db->select($sql));
    }

    //öğrencinin velileri
    public function ogrenciTurVeliler($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrenciVeliIDler($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID FROM  bsveliogrenci Where BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrenciVeliTurCihaz($array = array()) {
        $sql = 'SELECT DISTINCT bsvelicihazRecID FROM  bsvelicihaz Where bsveliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirim  cihaz
    public function ogrenciTumTurCihaz($array = array()) {
        $sql = 'SELECT DISTINCT bsogrencicihazRecID FROM  bsogrencicihaz Where bsogrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirim  cihaz
    public function isciTumTurCihaz($array = array()) {
        $sql = 'SELECT DISTINCT sbiscicihazRecID FROM  sbiscicihaz Where sbisciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-öğrenci cihaz
    public function ogrenciTurCihaz($ogrID) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID=' . $ogrID;
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-öğrenci cihazlar
    public function ogrenciTurCihazlar($array = array()) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //işçiye gönderilecek tur bildirimi-işçi cihaz
    public function isciTurCihaz($isciID) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID=' . $isciID;
        return($this->db->select($sql));
    }

    //işçiye gönderilecek tur bildirimi-işçi cihazlar
    public function isciTurCihazlar($array = array()) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //turdaki binenleri kaydetme alanı
    public function addNewBinisTur($data) {
        return ($this->db->insert("bsturgidis", $data));
    }

    //turdaki inenleri kaydetme alanı
    public function addNewInisTur($data) {
        return ($this->db->insert("bsturdonus", $data));
    }

    //tur başlat
    public function soforTurBaslatUpdate($data, $turID) {
        return ($this->db->update("sbtur", $data, "SBTurID=" . $turID));
    }

    //tur tip başlat
    public function soforTurTipUpdate($data, $turID) {
        return ($this->db->update("bsturtip", $data, "BSTurID=" . $turID));
    }

    //turtip tablosundaki bilgiler
    public function turTipOzellik($turID, $turGidisDonus) {
        $sql = 'SELECT BSTurTip,BSTurKurumID,BSTurKurumAd,BSTurKurumLocation,BSTurAracID,BSTurAracPlaka,BSTurSoforID,BSTurHostesID,BSTurKm FROM  bsturtip Where BSTurID=' . $turID . ' AND BSTurGidisDonus=' . $turGidisDonus;
        return($this->db->select($sql));
    }

    //tur bitiş bilgilerini kaydetme
    public function addNewTurBitis($data) {
        return ($this->db->insert("bsturlog", $data));
    }

    //tur gidiş öğrenci kayıt log
    public function addGidisOgrenciLog($data) {
        return ($this->db->insert("bsogrenciturgidislog", $data));
    }

    //tur dönüş öğrenci kayıt log
    public function addDonusOgrenciLog($data) {
        return ($this->db->insert("bsogrenciturdonuslog", $data));
    }

    //tur gidiş işçi kayıt log
    public function addGidisIsciLog($data) {
        return ($this->db->insert("bsisciturgidislog", $data));
    }

    //tur dönüş işçi kayıt log
    public function addDonusIsciLog($data) {
        return ($this->db->insert("bsisciturdonuslog", $data));
    }

    //tur gidiş öğrenci kayıt log
    public function addGidisOgrenciIsciLog($data) {
        return ($this->db->insert("bsogrenciisciturgidislog", $data));
    }

    //tur dönüş öğrenci kayıt log
    public function addDonusOgrenciIsciLog($data) {
        return ($this->db->insert("bsogrenciisciturdonuslog", $data));
    }

    //tur gidiş delete
    public function turGidisDelete($turID) {
        return($this->db->delete("bsturgidis", "BSTurID=$turID"));
    }

    //tur dönüş delete
    public function turDonusDelete($turID) {
        return($this->db->delete("bsturdonus", "BSTurID=$turID"));
    }

    //tur dönüş delete
    public function aracAnlikLocDel($turID) {
        return($this->db->delete("bsaraclokasyon", "BSAracTurID=$turID"));
    }

    //aracın kayıtı varsa o anda
    public function aracAnlikLoc($aracID, $turID) {
        $sql = 'SELECT BSAracLokasyonID FROM bsaraclokasyon Where BSAracID=' . $aracID . ' AND BSAracTurID=' . $turID;
        return($this->db->select($sql));
    }

    //araç anlık lokasyon güncelleme 
    public function aracAnlikUpdate($data, $aracID) {
        return ($this->db->update("bsaraclokasyon", $data, "BSAracLokasyonID=" . $aracID));
    }

    //araç anlık lokasyon kaydetme
    public function addNewAnlikLoc($data) {
        return ($this->db->insert("bsaraclokasyon", $data));
    }

}

?>
