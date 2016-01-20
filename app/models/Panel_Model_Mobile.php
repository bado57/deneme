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
        $sql = "SELECT " . $Kadi . "," . $KullaniciID . ",Status FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre";
        return ($count = $this->db->select($sql, $array));
    }

    //admin süper admini çeksin diye 
    public function shuttleKullaniciLoginA($array = array(), $Kadi, $Sifre, $KullaniciID, $tableName) {
        $sql = "SELECT " . $Kadi . "," . $KullaniciID . ",BSSuperAdmin,Status FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre";
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

    //veli profil
    public function veliProfil($veliID) {
        $sql = 'SELECT SBVeliAd,SBVeliSoyad,SBVeliKadi,SBVeliPhone,SBVeliEmail,SBVeliLocation,SBVeliDetayAdres FROM sbveli WHERE SBVeliID=' . $veliID;
        return($this->db->select($sql));
    }

    //Öğrenci profil
    public function ogrProfil($ogrID) {
        $sql = 'SELECT BSOgrenciAd,BSOgrenciSoyad,BSOgrenciKadi,BSOgrenciPhone,BSOgrenciEmail,BSOgrenciLocation,BSOgrenciDetayAdres FROM bsogrenci WHERE BSOgrenciID=' . $ogrID;
        return($this->db->select($sql));
    }

    //veli öğrenciler
    public function veliOgrenciler($veliID) {
        $sql = 'SELECT DISTINCT BSOgrenciID,BSOgrenciAd FROM bsveliogrenci WHERE BSVeliID=' . $veliID;
        return($this->db->select($sql));
    }

    //veli öğrenciler
    public function veliOgrenciDetay($ID) {
        $sql = 'SELECT BSOgrenciID,BSOgrenciAd,BSOgrenciSoyad,BSOgrenciPhone,BSOgrenciEmail,BSOgrenciLocation,BSOgrenciDetayAdres,Status FROM bsogrenci WHERE BSOgrenciID=' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci veli detay
    public function ogrVeliDetay($ID) {
        $sql = 'SELECT SBVeliID,SBVeliAd,SBVeliSoyad,SBVeliPhone,SBVeliEmail,SBVeliLocation,SBVeliDetayAdres,Status FROM sbveli WHERE SBVeliID=' . $ID;
        return($this->db->select($sql));
    }

    //veli öğrenci kurum
    public function veliOgrenciKurum($ID) {
        $sql = 'SELECT BSKurumID,BSKurumAd FROM  bsogrencikurum WHERE BSOgrenciID=' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci bakiye listesi
    public function ogrenciBakiyeListe($ID) {
        $sql = 'SELECT BSOdemeID,BSOdemeAlanTip,BSOdemeTutar,BSOdemeTarih,BSOdemeAciklama,BSDovizTip FROM bsogrenciodeme WHERE BSOdenenID=' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci bakiye detay ödemesi
    public function ogrenciBakiyeListDetay($ID) {
        $sql = 'SELECT * FROM bsogrenciodeme WHERE BSOdemeID=' . $ID;
        return($this->db->select($sql));
    }

    //öğrencinin ödenen bakiyeleri
    public function bakiyeOgrenciOdenen($ID) {
        $sql = "SELECT OdemeTutar,OdenenTutar FROM bsogrenci WHERE BSOgrenciID=" . $ID;
        return($this->db->select($sql));
    }

    //öğrenciler veli bilgileri
    public function ogrenciVeli($ID) {
        $sql = 'SELECT BSVeliID,BSVeliAd FROM  bsveliogrenci WHERE BSOgrenciID=' . $ID;
        return($this->db->select($sql));
    }

    //veli kurum detay
    public function veliKurumDetay($ID) {
        $sql = 'SELECT SBKurumAdi,SBKurumLokasyon,SBKurumTelefon,SBKurumDetayAdres,SBKurumEmail,SBKurumWebsite FROM sbkurum WHERE SBKurumID=' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci kurum detay
    public function ogrKurumDetay($ID) {
        $sql = 'SELECT SBKurumAdi,SBKurumLokasyon,SBKurumTelefon,SBKurumDetayAdres,SBKurumEmail,SBKurumWebsite FROM sbkurum WHERE SBKurumID=' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci tur idler
    public function veliOgrenciTurID1($ID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsogrencitur WHERE BSOgrenciID = ' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci tur idler
    public function veliOgrenciTurID2($ID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsogrenciiscitur WHERE BSOgrenciIsciID = ' . $ID . ' AND BSKullaniciTip=0';
        return($this->db->select($sql));
    }

    //aktif lokasyonu olan araç
    public function veliAracLokasyon($aracID) {
        $sql = 'SELECT BSAracLokasyon FROM bsaraclokasyon Where BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //öğrencinin tura göre id listesi
    public function vturOgrenciIDListele($turID) {
        $sql = 'SELECT BSOgrenciID FROM bsogrencitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrencinin tur güne göre idler
    public function vturOgrenciGunIDListele($turID, $gun, $turGidisDonus) {
        $sql = 'SELECT BSOgrenciID FROM bsseferogrenci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 0 AND BSTurTip = ' . $turGidisDonus;
        return($this->db->select($sql));
    }

    //tura gidişte binenler kimler
    public function vturOgrenciBinenIDListele($turID) {
        $sql = 'SELECT BSKisiID FROM bsturgidis WHERE BSTurID = ' . $turID . ' AND BSKisiDurum=1';
        return($this->db->select($sql));
    }

    //öğrenci tur gidişte araca binmiş olanlar
    public function vturGidisOgrenciBinenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //öğrenci tur gidişte araca binmemiş olanlar
    public function vturGidisOgrenciBinmeyenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //işçinin tura göre id listesi
    public function vturIsciIDListele($turID) {
        $sql = 'SELECT SBIsciID FROM sbiscitur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //işçinin tur güne göre idler
    public function vturIsciGunIDListele($turID, $gun, $turGidisDonus) {
        $sql = 'SELECT BSIsciID FROM bsseferisci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 0 AND BSTurTip = ' . $turGidisDonus;
        return($this->db->select($sql));
    }

    //tura gidişte binenler kimler
    public function vturIsciBinenIDListele($turID) {
        $sql = 'SELECT BSKisiID FROM bsturgidis WHERE BSTurID = ' . $turID . ' AND BSKisiDurum=1';
        return($this->db->select($sql));
    }

    //işçi tur gidişte araca binmiş olanlar
    public function vturGidisIsciBinenListele($turID, $array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID . ' AND SBIsciID IN (' . $array . ') ORDER BY SBTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi tur gidişte araca binmemiş olanlar
    public function vturGidisIsciBinmeyenListele($turID, $array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID . ' AND SBIsciID IN (' . $array . ') ORDER BY SBTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi ve öğrenci tura göre id listesi
    public function vturIsciOgrenciIDListele($turID) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip FROM bsogrenciiscitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrenci ve işçinin tur güne göre idler
    public function vturIsciOgrenciGunIDListele($turID, $gun, $turGidisDonus) {
        $sql = 'SELECT BSKisiID, BSKullaniciTip FROM bsseferogrenciisci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 0 AND BSTurTip = ' . $turGidisDonus;
        return($this->db->select($sql));
    }

    //tura gidişte binenler kimler
    public function vturIsciOgrenciBinenIDListele($turID) {
        $sql = 'SELECT BSKisiID, BSKisiTip FROM bsturgidis WHERE BSTurID = ' . $turID . ' AND BSKisiDurum=1';
        return($this->db->select($sql));
    }

    //işçi öğrenci tur gidişte araca binmiş olanlar
    public function vturGidisIsciOgrenciBinenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi öğrenci tur gidişte araca binmemiş olanlar
    public function vturGidisOgrenciIsciBinmeyenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //tura dönüşte binenler kimler
    public function vturOgrenciInenIDListele($turID) {
        $sql = 'SELECT BSKisiID FROM bsturdonus WHERE BSTurID = ' . $turID . ' AND BSKisiDurum=1';
        return($this->db->select($sql));
    }

    //öğrenci tur dönüşte araca binmiş olanlar
    public function vturDonusOgrenciInenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //öğrenci tur dönüşte araca binmemiş olanlar
    public function vturDonusOgrenciInmeyenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //tura dönüşte inenler kimler
    public function vturIsciOgrenciInenIDListele($turID) {
        $sql = 'SELECT BSKisiID, BSKisiTip FROM bsturdonus WHERE BSTurID = ' . $turID . ' AND BSKisiDurum=1';
        return($this->db->select($sql));
    }

    //işçi öğrenci tur dönüşte araca binmiş olanlar
    public function vturDonusIsciOgrenciInenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi öğrenci tur dönüşte araca binmemiş olanlar
    public function vturDonusOgrenciIsciInmeyenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //araç ıd listele
    public function veliAktfLocAracIDListele($array = array()) {
        $sql = 'SELECT BSAracID, BSAracTurTip,BSAracTurID,BSTurGidisDonus FROM bsaraclokasyon WHERE BSAracTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //tura kayıtlı araçlar
    public function veliAktifTurListele($array = array()) {
        $sql = 'SELECT DISTINCT BSTurID,BSTurAracID, BSTurAracPlaka, BSTurSoforID, BSTurSoforAd, BSTurSoforLocation, BSTurKurumID, BSTurKurumAd, BSTurKurumLocation, BSTurBolgeID, BSTurBolgeAd, BSTurTip, BSTurAracKapasite, BSTurKm, BSTurGidisDonus FROM bsturtip WHERE BSTurID IN (' . $array . ') AND BsTurBasla=1';
        return($this->db->select($sql));
    }

    //araç lokasyon tur ad listele
    public function veliTurAdListe($array = array()) {
        $sql = 'SELECT SBTurAd FROM sbtur WHERE SBTurID IN (' . $array . ') AND SBTurAktiflik=1';
        return($this->db->select($sql));
    }

    //öğrenci tur detail
    public function veliOgrenciTurDetail($ID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsogrencitur WHERE BSOgrenciID = ' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci tur detail
    public function ogrenciTurDetail($ID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsogrencitur WHERE BSOgrenciID = ' . $ID;
        return($this->db->select($sql));
    }

    //öğrenci tur detail
    public function veliOgrenciTurDetail2($ID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsogrenciiscitur WHERE BSOgrenciIsciID = ' . $ID . ' AND BSKullaniciTip = 0';
        return($this->db->select($sql));
    }

    //öğrenci tur detail
    public function ogrenciTurDetail2($ID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsogrenciiscitur WHERE BSOgrenciIsciID = ' . $ID . ' AND BSKullaniciTip = 0';
        return($this->db->select($sql));
    }

    //öğrenciye ait tur bilgileri
    public function veliOgrenciTurList($array = array()) {
        $sql = 'SELECT DISTINCT SBTurID, SBTurAd, SBKurumAd FROM sbtur WHERE SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye ait tur detay bilgileri
    public function veliOgrenciTurDetayList($turID) {
        $sql = 'SELECT SBTurID, SBTurAd, SBTurAciklama, SBTurAktiflik, SBKurumID, SBKurumAd, SBKurumLocation, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr, SBTurGidis, SBTurDonus, SBTurTip, SBTurKm FROM sbtur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrenciye ait tur detay bilgileri
    public function ogrenciTurDetayList($turID) {
        $sql = 'SELECT SBTurID, SBTurAd, SBTurAciklama, SBTurAktiflik, SBKurumID, SBKurumAd, SBKurumLocation, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr, SBTurGidis, SBTurDonus, SBTurTip, SBTurKm FROM sbtur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrenciye ait tur detay bilgileri
    public function veliOgrTurTipDetayList($turID, $turgd) {
        $sql = 'SELECT BSTurTipID, BSTurAracID, BSTurAracPlaka, BSTurSoforID, BSTurSoforAd, BSTurHostesID, BSTurHostesAd, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurID = ' . $turID . ' AND BSTurGidisDonus = ' . $turgd;
        return($this->db->select($sql));
    }

    //öğrenciye ait tur detay bilgileri
    public function ogrTurTipDetayList($turID, $turgd) {
        $sql = 'SELECT BSTurTipID, BSTurAracID, BSTurAracPlaka, BSTurSoforID, BSTurSoforAd, BSTurHostesID, BSTurHostesAd, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurID = ' . $turID . ' AND BSTurGidisDonus = ' . $turgd;
        return($this->db->select($sql));
    }

    //veli öğrenci bildirim mesafe ayarlama
    public function veliOgrBilMes($data, $ogrID) {
        return ($this->db->update("bsogrenci", $data, "BSOgrenciID=" . $ogrID));
    }

    //veli öğrenci bildirim mesafe ayarlama
    public function ogrBilMes($data, $ogrID) {
        return ($this->db->update("bsogrenci", $data, "BSOgrenciID=" . $ogrID));
    }

    //veli duyuru kaydetme
    public function veliDuyrAyarKaydet($data, $veliID) {
        return ($this->db->update("bsvelicihaz", $data, "bsveliID=" . $veliID));
    }

    //öğrenci duyuru kaydetme 
    public function ogrDuyrAyarKaydet($data, $ogrID) {
        return ($this->db->update("bsogrencicihaz", $data, "bsogrenciID=" . $ogrID));
    }

    //şoför profil düzenle
    public function soforProfilDuzenle($data, $soforID) {
        return ($this->db->update("bssofor", $data, "BSSoforID=" . $soforID));
    }

    //veli profil düzenle
    public function veliProfilDuzenle($data, $veliID) {
        return ($this->db->update("sbveli", $data, "SBVeliID=" . $veliID));
    }

    //öğrenci profil düzenle
    public function ogrProfilDuzenle($data, $ogrID) {
        return ($this->db->update("bsogrenci", $data, "BSOgrenciID=" . $ogrID));
    }

    //veli profil düzenle
    public function veliOzellikDuzenle($data, $veliID) {
        return ($this->db->update("bsveliduyuru", $data, "BSGonderenID=" . $veliID));
    }

    //öğrenci profil düzenle
    public function ogrOzellikDuzenle($data, $ogrID) {
        return ($this->db->update("bsogrenciduyuru", $data, "BSGonderenID=" . $ogrID));
    }

    //veli profil düzenle3
    public function veliOzellikDuzenle1($data, $veliID) {
        return ($this->db->update("bsveliduyurulog", $data, "BSEkleyenID=" . $veliID));
    }

    //öğrenci profil düzenle3
    public function ogrOzellikDuzenle1($data, $ogrID) {
        return ($this->db->update("bsogrenciduyurulog", $data, "BSEkleyenID=" . $ogrID));
    }

    //veli profil düzenle3
    public function veliOzellikDuzenle2($data, $veliID) {
        return ($this->db->update("bsveliogrenci", $data, "BSVeliID=" . $veliID));
    }

    //öğrenci profil düzenle3
    public function ogrOzellikDuzenle2($data, $ogrID) {
        return ($this->db->update("bsveliogrenci", $data, "BSOgrenciID=" . $ogrID));
    }

    //veli profil düzenle3
    public function veliOzellikDuzenle3($data, $veliID) {
        return ($this->db->update("bsvelikurum", $data, "BSVeliID=" . $veliID));
    }

    //öğrenci profil düzenle3
    public function ogrOzellikDuzenle3($data, $ogrID) {
        return ($this->db->update("bsogrencikurum", $data, "BSOgrenciID=" . $ogrID));
    }

    //veli profil düzenle3
    public function veliOzellikDuzenle4($data, $veliID) {
        return ($this->db->update("bsvelibolge", $data, "BSVeliID=" . $veliID));
    }

    //öğrenci profil düzenle3
    public function ogrOzellikDuzenle4($data, $ogrID) {
        return ($this->db->update("bsogrencibolge", $data, "BSOgrenciID=" . $ogrID));
    }

    //öğrenci işçi tur düzenle3
    public function ogrOzellikDuzenle5($data, $ogrID) {
        return ($this->db->update("bsogrenciiscitur", $data, "BSOgrenciIsciID=" . $ogrID . " AND BSKullaniciTip=0"));
    }

    //öğrenci tur  düzenle3
    public function ogrOzellikDuzenle6($data, $ogrID) {
        return ($this->db->update("bsogrencitur", $data, "BSOgrenciID=" . $ogrID));
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
        $sql = 'SELECT BSSoforRSifre FROM bssofor WHERE BSSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //veli şifre
    public function veliSifre($veliID) {
        $sql = 'SELECT SBVeliRSifre FROM sbveli WHERE SBVeliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //öğrenci şifre
    public function ogrSifre($ogrID) {
        $sql = 'SELECT BSOgrenciRSifre FROM bsogrenci WHERE BSOgrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //şoför şifre düzenle
    public function soforSifreDuzenle($data, $soforID) {
        return ($this->db->update("bssofor", $data, "BSSoforID=" . $soforID));
    }

    //veli şifre düzenle
    public function veliSifreDuzenle($data, $veliID) {
        return ($this->db->update("sbveli", $data, "SBVeliID=" . $veliID));
    }

    //öğrenci şifre düzenle
    public function ogrSifreDuzenle($data, $ogrID) {
        return ($this->db->update("bsogrenci", $data, "BSOgrenciID=" . $ogrID));
    }

    //şoför harita düzenle
    public function soforMapDuzenle($data, $soforID) {
        return ($this->db->update("bssofor", $data, "BSSoforID=" . $soforID));
    }

    //veli harita düzenle
    public function veliMapDuzenle($data, $veliID) {
        return ($this->db->update("sbveli", $data, "SBVeliID=" . $veliID));
    }

    //öğrenci harita düzenle
    public function ogrMapDuzenle($data, $ogrID) {
        return ($this->db->update("bsogrenci", $data, "BSOgrenciID=" . $ogrID));
    }

    //veli tur harita öğrenci yolcu
    public function veliHTurOgrenci($turID) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //veli tur harita işçi yolcu
    public function veliHTurIsci($turID) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //veli tur harita öğrenci işçi yolcu
    public function veliHTurIsciOgrenci($turID) {
        $sql = 'SELECT BSOgrenciIsciID, BSOgrenciIsciAd, BSOgrenciIsciLocation, BSKullaniciTip FROM bsogrenciiscitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //veli yolcu şoför detay
    public function veliSYolcu($kisiID) {
        $sql = 'SELECT BSSoforAd, BSSoforSoyad, BSSoforPhone, BSSoforEmail, BSSoforLocation, BSSoforDetayAdres FROM bssofor WHERE BSSoforID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //veli yolcu hostes detay
    public function veliHYolcu($kisiID) {
        $sql = 'SELECT BSHostesAd, BSHostesSoyad, BSHostesPhone, BSHostesEmail, BSHostesLocation, BSHostesDetayAdres FROM bshostes WHERE BSHostesID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //veli yolcu arac detay
    public function veliArac($aracID) {
        $sql = 'SELECT SBAracMarka, SBAracModelYili, SBAracPlaka, SBAracKapasite, SBAracKm, SBAracDurum, SBAracAciklama FROM sbarac WHERE SBAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //veli öğrenci gidiş ayar
    public function veliOgrGidisAyar($ogrID) {
        $sql = 'SELECT BildirimMesafeGidis FROM bsogrenci WHERE BSOgrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //veli öğrenci gidiş ayar
    public function ogrGidisAyar($ogrID) {
        $sql = 'SELECT BildirimMesafeGidis FROM bsogrenci WHERE BSOgrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //veli duyuru al alma
    public function veliDuyuruAyar($veliID) {
        $sql = 'SELECT DISTINCT bsveliID,duyuruStatu FROM bsvelicihaz WHERE bsveliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //öğrenci duyuru al alma
    public function ogrDuyuruAyar($ogrID) {
        $sql = 'SELECT DISTINCT bsogrenciID,duyuruStatu FROM bsogrencicihaz WHERE bsogrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //veli öğrenci dönüş ayar
    public function veliOgrDonusAyar($ogrID) {
        $sql = 'SELECT BildirimMesafeDonus FROM bsogrenci WHERE BSOgrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //veli öğrenci dönüş ayar
    public function ogrDonusAyar($ogrID) {
        $sql = 'SELECT BildirimMesafeDonus FROM bsogrenci WHERE BSOgrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //öğrenci sefer takvimi
    public function ogrSefrTkvim($turid, $ogrid, $giddon) {
        $sql = 'SELECT SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr FROM bsseferogrenci WHERE BSTurID = ' . $turid . ' AND BSOgrenciID = ' . $ogrid . ' AND BSTurTip = ' . $giddon;
        return($this->db->select($sql));
    }

    //öğrenci sefer takvimi
    public function ogrSefrTkvimID($turid, $ogrid, $giddon) {
        $sql = 'SELECT BSOgrenciSeferID FROM bsseferogrenci WHERE BSTurID = ' . $turid . ' AND BSOgrenciID = ' . $ogrid . ' AND BSTurTip = ' . $giddon;
        return($this->db->select($sql));
    }

    //öğrenci ve işçi sefer takvimi
    public function ogrIsciSefrTkvim($turid, $ogrid, $giddon) {
        $sql = 'SELECT SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr FROM bsseferogrenciisci WHERE BSTurID = ' . $turid . ' AND BSKisiID = ' . $ogrid . ' AND BSKullaniciTip = 0 AND BSTurTip = ' . $giddon;
        return($this->db->select($sql));
    }

    //öğrenci ve işçi sefer takvimi
    public function ogrIsciSefrTkvimID($turid, $ogrid, $giddon) {
        $sql = 'SELECT BSSeferOgrenciIsciID FROM bsseferogrenciisci WHERE BSTurID = ' . $turid . ' AND BSKisiID = ' . $ogrid . ' AND BSKullaniciTip = 0 AND BSTurTip = ' . $giddon;
        return($this->db->select($sql));
    }

    //veli öğrenci bildirim mesafe ayarlama güncellemesi
    public function ogrTkvimUpdate($data, $ogrID) {
        return ($this->db->update("bsseferogrenci", $data, "BSOgrenciSeferID=" . $ogrID));
    }

    //veli öğrenci bildirim mesafe ayarlama güncellemesi
    public function ogrIscTkvimUpdate($data, $ogrID) {
        return ($this->db->update("bsseferogrenciisci", $data, "BSSeferOgrenciIsciID=" . $ogrID));
    }

    //veli öğrenci bildirim mesafe ayarlama inserti
    public function ogrTkvimInsert($data) {
        return ($this->db->insert("bsseferogrenci", $data));
    }

    //veli öğrenci bildirim mesafe ayarlama inserti
    public function ogrIscTkvimInsert($data) {
        return ($this->db->insert("bsseferogrenciisci", $data));
    }

    //hatalık bildirim gidiş
    public function veliHaftlikBildirimGid($veliID) {
        $sql = 'SELECT GidisTurBasladi, GidisAracYaklasti, GidisAracBindi, GidisKurumVardi FROM bsvelicihaz WHERE bsveliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //hatalık bildirim gidiş
    public function ogrHaftlikBildirimGid($ogrID) {
        $sql = 'SELECT GidisTurBasladi, GidisAracYaklasti, GidisAracBindi, GidisKurumVardi FROM bsogrencicihaz WHERE bsogrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //hatalık bildirim dönüş
    public function veliHaftlikBildirimDon($veliID) {
        $sql = 'SELECT DonusTurBasladi, DonusAracYaklasti, DonusAracIndi, DonusTurBitti FROM bsvelicihaz WHERE bsveliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //hatalık bildirim dönüş
    public function ogrHaftlikBildirimDon($ogrID) {
        $sql = 'SELECT DonusTurBasladi, DonusAracYaklasti, DonusAracIndi, DonusTurBitti FROM bsogrencicihaz WHERE bsogrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //veli cihaz sorgusu
    public function veliCihazSorgu($veliID) {
        $sql = 'SELECT bsvelicihazID FROM bsvelicihaz WHERE bsveliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //öğrenci cihaz sorgusu
    public function ogrCihazSorgu($ogrID) {
        $sql = 'SELECT bsogrencicihazID FROM bsogrencicihaz WHERE bsogrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //veli cihaz update etme
    public function veliCihazUpdate($data, $veliID) {
        return ($this->db->update("bsvelicihaz", $data, "bsveliID=" . $veliID));
    }

    //öğrenci cihaz update etme
    public function ogrCihazUpdate($data, $ogrID) {
        return ($this->db->update("bsogrencicihaz", $data, "bsogrenciID=" . $ogrID));
    }

    //veli cihaz insert
    public function veliCihazInsert($data) {
        return ($this->db->insert("bsvelicihaz", $data));
    }

    //öğrenci cihaz insert
    public function ogrCihazInsert($data) {
        return ($this->db->insert("bsogrencicihaz", $data));
    }

    //veli öğrenciler
    public function veliDuyuruOgrenciler($veliID) {
        $sql = 'SELECT DISTINCT BSOgrenciID,BSOgrenciAd,BSVeliAd FROM bsveliogrenci WHERE BSVeliID=' . $veliID;
        return($this->db->select($sql));
    }

    //öğrenci veliler
    public function ogrDuyuruVeliler($ogrID) {
        $sql = 'SELECT DISTINCT BSVeliID,BSVeliAd,BSOgrenciAd FROM bsveliogrenci WHERE BSOgrenciID=' . $ogrID;
        return($this->db->select($sql));
    }

    //şoför tur ıd
    public function soforTurKurum($soforID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsturtip WHERE BSTurSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //şoför tur kurumlar
    public function soforTurKurumlar($array = array()) {
        $sql = 'SELECT DISTINCT SBTurID, SBTurAd, SBTurTip, SBBolgeID FROM sbtur Where SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat tur ıdler
    public function soforTurBaslatID($soforID, $gun) {
        $sql = 'SELECT BSTurID, BSTurAracID, BSTurGidisDonus, BsTurBitis, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurSoforID = ' . $soforID . ' AND ' . $gun . ' = 1 AND BsTurBitis = 0 ORDER BY BSTurBslngc ASC';
        return($this->db->select($sql));
    }

    //şoför tur başla detay tur gidiş ve dönüşler
    public function soforTurBaslatIlk($turID) {
        $sql = 'SELECT SBTurID, SBTurAd, SBTurTip, SBTurKm FROM sbtur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur başla tur ıdler
    public function soforTurID($soforID, $gun) {
        $sql = 'SELECT DISTINCT BSTurID, BSTurAracPlaka FROM bsturtip WHERE BSTurSoforID = ' . $soforID . ' AND ' . $gun . ' = 1 ORDER BY BSTurBslngc ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat turlar
    public function soforTurBaslat($array = array()) {
        $sql = 'SELECT DISTINCT SBTurID, SBTurAd, SBKurumAd, SBTurTip FROM sbtur Where SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başla detay tur gidiş ve dönüşler
    public function soforTurBaslatDetay($turID, $gun) {
        $sql = 'SELECT BSTurID, BSTurTip, BSTurAracPlaka, BSTurBslngc, BSTurBts, BSTurGidisDonus FROM bsturtip WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 1 ORDER BY BSTurBslngc ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre öğrenci idler 
    public function soforTurBaslatOgrenciID($turID) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSKurumID, BSKurumAd, BSKurumLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre gelemyen öğrenci idler 
    public function soforTurBaslatOgrenciGID($turID, $gun, $turTur) {
        $sql = 'SELECT DISTINCT BSOgrenciID FROM bsseferogrenci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 1' . ' AND BSTurTip = ' . $turTur;
        return($this->db->select($sql));
    }

    //tura binenler
    public function soforTurOgrGidisBinen($turID) {
        $sql = 'SELECT DISTINCT BSKisiSira FROM bsturgidis WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //turdan inenler
    public function soforTurOgrDonusInen($turID) {
        $sql = 'SELECT DISTINCT BSKisiSira FROM bsturdonus WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför turu için hostes var sa sorgu gelmektedir
    public function soforTurBaslatHostes($turID, $turTur) {
        $sql = 'SELECT BSTurHostesID, BSTurHostesAd, BSTurHostesLocation FROM bsturtip WHERE BSTurID = ' . $turID . ' AND BSTurGidisDonus = ' . $turTur;
        return($this->db->select($sql));
    }

    //şoför tur öğrenci idl ye göre işlemler
    public function soforTurBaslatOgrenciIID($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd, BSOgrenciSoyad, BSOgrenciPhone FROM bsogrenci Where BSOgrenciID IN (' . $array . ') ORDER BY field(BSOgrenciID, ' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur öğrenci idl ye göre işlemler
    public function soforTBMapsOgrenciIID($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd, BSOgrenciSoyad, BSOgrenciPhone, BSOgrenciLocation FROM bsogrenci Where BSOgrenciID IN (' . $array . ') ORDER BY field(BSOgrenciID, ' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre işçi idler 
    public function soforTurBaslatIsciID($turID) {
        $sql = 'SELECT DISTINCT SBIsciID, SBKurumID, SBKurumAd, SBKurumLocation FROM sbiscitur WHERE SBTurID = ' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre gelemyen işçi idler 
    public function soforTurBaslatIsciGID($turID, $gun, $turTur) {
        $sql = 'SELECT DISTINCT BSIsciID FROM bsseferisci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 1' . ' AND BSTurTip = ' . $turTur;
        return($this->db->select($sql));
    }

    //şoför tur işçi     idl ye göre işlemler
    public function soforTurBaslatIsciIID($array = array()) {
        $sql = 'SELECT DISTINCT SBIsciID, SBIsciAd, SBIsciSoyad, SBIsciPhone FROM sbisci Where SBIsciID IN (' . $array . ') ORDER BY field(SBIsciID, ' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur işçi     idl ye göre işlemler
    public function soforTBMapsIsciIID($array = array()) {
        $sql = 'SELECT DISTINCT SBIsciID, SBIsciAd, SBIsciSoyad, SBIsciPhone, SBIsciLocation FROM sbisci Where SBIsciID IN (' . $array . ') ORDER BY field(SBIsciID, ' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre öğrenci ve işçi idler 
    public function soforTurBaslatOgrenciIsciID($turID) {
        $sql = 'SELECT DISTINCT BSOgrenciIsciID, BSKullaniciTip, BSKurumID, BSKurumAd, BSKurumLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //şoför tur başlat tura göre gelemyen öğrenci ve işçi idler 
    public function soforTurBaslatOgrenciIsciGID($turID, $gun, $turTur) {
        $sql = 'SELECT DISTINCT BSKisiID, BSKullaniciTip, BSKurumID, BSKurumAd, BSKurumLocation FROM bsseferogrenciisci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 1' . ' AND BSTurTip = ' . $turTur;
        return($this->db->select($sql));
    }

    //şoför tur başlat öğrenci detay
    public function soforTurBaslatKOgrenciDetay($kid) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd, BSOgrenciSoyad, BSOgrenciPhone FROM bsogrenci Where BSOgrenciID = ' . $kid;
        return($this->db->select($sql));
    }

    //şoför tur başlat öğrenci-veli id
    public function soforTurBaslatKOgrVeliID($kid) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID = ' . $kid;
        return($this->db->select($sql));
    }

    //şoför tur başlat öğrenci detay
    public function soforTurBaslatKVeliDetay($array = array()) {
        $sql = 'SELECT DISTINCT SBVeliID, SBVeliAd, SBVeliSoyad, SBVeliPhone FROM sbveli Where SBVeliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur başlat işçi detay
    public function soforTurBaslatKIsciDetay($kid) {
        $sql = 'SELECT DISTINCT SBIsciID, SBIsciAd, SBIsciSoyad, SBIsciPhone FROM sbisci Where SBIsciID = ' . $kid;
        return($this->db->select($sql));
    }

    //şoför tur detay
    public function soforTurDetay($turID) {
        $sql = 'SELECT SBTurAd, SBTurAciklama, SBTurAktiflik, SBKurumID, SBKurumAd, SBKurumLocation, SBBolgeAd, SBBolgeID, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr, SBTurGidis, SBTurDonus, SBTurTip, SBTurKm FROM sbtur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur gidiş
    public function soforTurGidis($turID) {
        $sql = 'SELECT BSTurTipID, BSTurAracID, BSTurAracPlaka, BSTurSoforAd, BSTurSoforID, BSTurHostesAd, BSTurHostesID, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurID = ' . $turID . ' AND BSTurGidisDonus = 0';
        return($this->db->select($sql));
    }

    //şoför tur dönüş
    public function soforTurDonus($turID) {
        $sql = 'SELECT BSTurTipID, BSTurAracID, BSTurAracPlaka, BSTurSoforAd, BSTurSoforID, BSTurHostesAd, BSTurHostesID, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurID = ' . $turID . ' AND BSTurGidisDonus = 1';
        return($this->db->select($sql));
    }

    //şoför tur öğrenci yolcu
    public function soforTurOgrenci($turID) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd FROM bsogrencitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur öğrenci yolcu
    public function soforTurVeli($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID, BSVeliAd FROM bsveliogrenci WHERE BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför tur işçi yolcu
    public function soforTurIsci($turID) {
        $sql = 'SELECT SBIsciID, SBIsciAd FROM sbiscitur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur öğrenci işçi yolcu
    public function soforTurIsciOgrenci($turID) {
        $sql = 'SELECT BSOgrenciIsciID, BSOgrenciIsciAd, BSKullaniciTip FROM bsogrenciiscitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur şoför
    public function soforTurDiger($turID) {
        $sql = 'SELECT DISTINCT BSTurSoforID, BSTurSoforAd FROM bsturtip WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur hostes
    public function soforTurHostes($turID) {
        $sql = 'SELECT DISTINCT BSTurHostesID, BSTurHostesAd FROM bsturtip WHERE BSTurID = ' . $turID . ' AND BSTurHostesID!=0';
        return($this->db->select($sql));
    }

    //şoför tur yöneticiler
    public function soforTurYonetici($bolgeID) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge WHERE BSBolgeID = ' . $bolgeID;
        return($this->db->select($sql));
    }

    //öğrenci tur yöneticiler
    public function ogrDuyuruBolge($ogrID) {
        $sql = 'SELECT DISTINCT BSBolgeID,BSOgrenciAd FROM bsogrencibolge WHERE BSOgrenciID=' . $ogrID;
        return($this->db->select($sql));
    }

    //öğrenci tur yöneticiler
    public function ogrrDuyuruBolge($array = array()) {
        $sql = 'SELECT DISTINCT BSBolgeID FROM bsogrencibolge WHERE BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenci tur yöneticiler
    public function veliDuyuruBolge($veliID) {
        $sql = 'SELECT DISTINCT BSBolgeID,BSVeliAd FROM bsvelibolge WHERE BSVeliID=' . $veliID;
        return($this->db->select($sql));
    }

    //öğrenci tur yöneticiler
    public function ogrDuyuruYonetici($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge WHERE BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin select dışı öğrenci listele
    public function veliDuyuruYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID, BSAdminAd, BSAdminSoyad FROM bsadmin WHERE BSAdminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin select dışı öğrenci listele
    public function ogrDuyuruYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID, BSAdminAd, BSAdminSoyad FROM bsadmin WHERE BSAdminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin select dışı öğrenci listele
    public function soforTurYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID, BSAdminAd, BSAdminSoyad FROM bsadmin WHERE BSAdminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför yolcu öğrenci detay
    public function soforOYolcu($kisiID) {
        $sql = 'SELECT BSOgrenciAd, BSOgrenciSoyad, BSOgrenciPhone, BSOgrenciEmail, BSOgrenciLocation, BSOgrenciDetayAdres FROM bsogrenci WHERE BSOgrenciID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu öğrenci-veli id detay
    public function soforOVIDYolcu($kisiID) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci WHERE BSOgrenciID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu öğrenci-veli detay
    public function soforOVYolcu($array = array()) {
        $sql = 'SELECT SBVeliAd, SBVeliSoyad, SBVeliPhone, SBVeliEmail FROM sbveli WHERE SBVeliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför yolcu personel detay
    public function soforPYolcu($kisiID) {
        $sql = 'SELECT SBIsciAd, SBIsciSoyad, SBIsciPhone, SBIsciEmail, SBIsciLocation, SBIsciDetayAdres FROM sbisci WHERE SBIsciID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu şoför detay
    public function soforSYolcu($kisiID) {
        $sql = 'SELECT BSSoforAd, BSSoforSoyad, BSSoforPhone, BSSoforEmail, BSSoforLocation, BSSoforDetayAdres FROM bssofor WHERE BSSoforID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu hostes detay
    public function soforHYolcu($kisiID) {
        $sql = 'SELECT BSHostesAd, BSHostesSoyad, BSHostesPhone, BSHostesEmail, BSHostesLocation, BSHostesDetayAdres FROM bshostes WHERE BSHostesID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu yönetici detay
    public function soforYYolcu($kisiID) {
        $sql = 'SELECT BSAdminAd, BSAdminSoyad, BSAdminPhone, BSAdminEmail, BSAdminLocation, BSAdminDetayAdres FROM bsadmin WHERE BSAdminID = ' . $kisiID;
        return($this->db->select($sql));
    }

    //şoför yolcu arac detay
    public function soforArac($aracID) {
        $sql = 'SELECT SBAracMarka, SBAracModelYili, SBAracPlaka, SBAracKapasite, SBAracKm, SBAracDurum, SBAracAciklama FROM sbarac WHERE SBAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //şoför tur harita öğrenci yolcu
    public function soforHTurOgrenci($turID) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur harita işçi yolcu
    public function soforHTurIsci($turID) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför tur harita öğrenci işçi yolcu
    public function soforHTurIsciOgrenci($turID) {
        $sql = 'SELECT BSOgrenciIsciID, BSOgrenciIsciAd, BSOgrenciIsciLocation, BSKullaniciTip FROM bsogrenciiscitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //şoför araçlar
    public function soforAraclar($soforID) {
        $sql = 'SELECT DISTINCT BSAracID, BSAracPlaka FROM bsaracsofor WHERE BSSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //şoför aracın dahil olduğu turlar
    public function soforAracTur($aracID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsturtip WHERE BSTurAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //şoför tur kurumlar
    public function soforAracTurlar($array = array()) {
        $sql = 'SELECT DISTINCT SBTurID, SBTurAd FROM sbtur Where SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför araçlar-şoförler
    public function soforAraclarS($aracID) {
        $sql = 'SELECT DISTINCT BSSoforID, BSSoforAd FROM bsaracsofor WHERE BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //şoför araçlar-hostesler
    public function soforAraclarH($aracID) {
        $sql = 'SELECT DISTINCT BSHostesID, BSHostesAd FROM bsarachostes WHERE BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //şoför araçlar-yoneticiler
    public function soforAracY($aracID) {
        $sql = 'SELECT DISTINCT SBBolgeID FROM sbaracbolge WHERE SBAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //arac bölge admin
    public function soforAracYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge WHERE BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //arac adminler
    public function soforYoneticiler($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID, BSAdminAd, BSAdminSoyad FROM bsadmin WHERE BSAdminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //araç takvim özellikleri
    public function soforAracTakvim($aracID) {
        $sql = 'SELECT BSTurID, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //araç takvim özellikleri
    public function takvimTitle($sql) {
        return($this->db->select($sql));
    }

    //şoför takvim özellikleri
    public function soforTakvim($soforID) {
        $sql = 'SELECT BSTurID, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //hostes takvim özellikleri
    public function hostesTakvim($hostesID) {
        $sql = 'SELECT BSTurID, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr, BSTurBslngc, BSTurBts FROM bsturtip WHERE BSTurHostesID = ' . $hostesID;
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

    //diğer admin cihazlar
    public function duyuruAdminCihaz($array = array()) {
        $sql = 'SELECT bsadmincihazRecID FROM bsadmincihaz Where bsadminID IN (' . $array . ') AND duyuruStatu=1';
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

    //veli log duyuru save
    public function addVeliLogDuyuru($data) {
        return ($this->db->insert('bsveliduyurulog', $data));
    }

    //öğrenci log duyuru save
    public function addOgrLogDuyuru($data) {
        return ($this->db->insert('bsogrenciduyurulog', $data));
    }

    //şoför cihazlar
    public function digerSoforCihaz($array = array()) {
        $sql = 'SELECT sbsoforcihazRecID FROM sbsoforcihaz Where sbsoforID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför cihazlar
    public function duyuruSoforCihaz($array = array()) {
        $sql = 'SELECT sbsoforcihazRecID FROM sbsoforcihaz Where sbsoforID IN (' . $array . ') AND duyuruStatu=1';
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

    //hostes cihazlar
    public function duyuruHostesCihaz($array = array()) {
        $sql = 'SELECT bshostescihazRecID FROM bshostescihaz Where bshostesID IN (' . $array . ') AND duyuruStatu=1';
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

    //veli cihaz
    public function duyuruVeliCihaz($array = array()) {
        $sql = 'SELECT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ') AND duyuruStatu=1';
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

    //öğrenci cihaz
    public function duyuruOgrenciCihaz($array = array()) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ') AND duyuruStatu=1';
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

    //işçi cihaz
    public function duyuruIsciCihaz($array = array()) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ') AND duyuruStatu=1';
        return($this->db->select($sql));
    }

    //şoför gelen duyurular
    public function soforGelenDuyuru($soforID) {
        $sql = 'SELECT BSDuyuruText, BSSoforDuyuruID, BSGonderenAdSoyad, BSGonderenTip, BSOkundu, BSDuyuruTarih FROM bssoforduyuru Where BSAlanID = ' . $soforID . ' ORDER BY BSDuyuruTarih DESC';
        return($this->db->select($sql));
    }

    //veli gelen duyurular
    public function veliGelenDuyuru($veliID) {
        $sql = 'SELECT BSDuyuruText, BSVeliDuyuruID, BSGonderenAdSoyad, BSGonderenTip, BSOkundu, BSDuyuruTarih FROM bsveliduyuru Where BSAlanID = ' . $veliID . ' ORDER BY BSDuyuruTarih DESC';
        return($this->db->select($sql));
    }

    //öğrenci gelen duyurular
    public function ogrGelenDuyuru($ogrID) {
        $sql = 'SELECT BSDuyuruText, BSOgrenciDuyuruID, BSGonderenAdSoyad, BSGonderenTip, BSOkundu, BSDuyuruTarih FROM bsogrenciduyuru Where BSAlanID = ' . $ogrID . ' ORDER BY BSDuyuruTarih DESC';
        return($this->db->select($sql));
    }

    //duyurular okundu
    public function soforGelenOkundu($data, $duyuruID) {
        return ($this->db->update("bssoforduyuru", $data, "BSSoforDuyuruID=" . $duyuruID));
    }

    //duyurular okundu
    public function veliGelenOkundu($data, $duyuruID) {
        return ($this->db->update("bsveliduyuru", $data, "BSVeliDuyuruID=" . $duyuruID));
    }

    //duyurular okundu
    public function ogrGelenOkundu($data, $duyuruID) {
        return ($this->db->update("bsogrenciduyuru", $data, "BSOgrenciDuyuruID=" . $duyuruID));
    }

    //şoför önderilen duyurular
    public function soforGonderilenDuyuru($soforID) {
        $sql = 'SELECT BSSoforLogID, BSLogText, BSLogHedef, BsLogTarih FROM bssoforduyurulog Where BSEkleyenID = ' . $soforID . ' ORDER BY BsLogTarih DESC';
        return($this->db->select($sql));
    }

    //veli önderilen duyurular
    public function veliGonderilenDuyuru($veliID) {
        $sql = 'SELECT BSVeliLogID, BSLogText, BSLogHedef, BsLogTarih FROM bsveliduyurulog Where BSEkleyenID = ' . $veliID . ' ORDER BY BsLogTarih DESC';
        return($this->db->select($sql));
    }

    //öğrenci gönderilen duyurular
    public function ogrGonderilenDuyuru($veliID) {
        $sql = 'SELECT BSOgrenciLogID, BSLogText, BSLogHedef, BsLogTarih FROM bsogrenciduyurulog Where BSEkleyenID = ' . $veliID . ' ORDER BY BsLogTarih DESC';
        return($this->db->select($sql));
    }

    //öğrencinin velileri
    public function ogrenciTurVeli($ogrID) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //öğrencinin velileri
    public function ogrenciTurVeliler($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrenciVeliIDler($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrenciVeliTurCihazGid($array = array()) {
        $sql = 'SELECT DISTINCT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ') AND GidisTurBasladi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrnciVliTurCihazBinGid($array = array()) {
        $sql = 'SELECT DISTINCT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ') AND GidisAracBindi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrnciVliTurCihazInDon($array = array()) {
        $sql = 'SELECT DISTINCT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ') AND DonusAracIndi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrenciVeliTurCihazDon($array = array()) {
        $sql = 'SELECT DISTINCT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ') AND DonusTurBasladi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrnciVliTrChzBitGid($array = array()) {
        $sql = 'SELECT DISTINCT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ') AND GidisKurumVardi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-veli cihaz
    public function ogrnciVliTrChzBitDon($array = array()) {
        $sql = 'SELECT DISTINCT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ') AND DonusTurBitti = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirim  cihaz
    public function ogrenciTumTurCihazGid($array = array()) {
        $sql = 'SELECT DISTINCT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ') AND GidisTurBasladi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirim  cihaz
    public function ogrenciTumTurCihazDon($array = array()) {
        $sql = 'SELECT DISTINCT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ') AND DonusTurBasladi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirim  cihaz
    public function isciTumTurCihazGid($array = array()) {
        $sql = 'SELECT DISTINCT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ') AND GidisTurBasladi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirim  cihaz
    public function isciTumTurCihazDon($array = array()) {
        $sql = 'SELECT DISTINCT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ') AND DonusTurBasladi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-öğrenci cihaz
    public function ogrenciTurCihaz($ogrID) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID = ' . $ogrID;
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-öğrenci cihazlar
    public function ogrenciTurCihazlar($array = array()) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-öğrenci cihazlar
    public function ogrenciTurBitGid($array = array()) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ') AND GidisKurumVardi = 1';
        return($this->db->select($sql));
    }

    //öğrenciye gönderilecek tur bildirimi-öğrenci cihazlar
    public function ogrenciTurBitDon($array = array()) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ') AND DonusTurBitti = 1';
        return($this->db->select($sql));
    }

    //işçiye gönderilecek tur bildirimi-işçi cihaz
    public function isciTurCihaz($isciID) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID = ' . $isciID;
        return($this->db->select($sql));
    }

    //işçiye gönderilecek tur bildirimi-işçi cihazlar
    public function isciTurCihazlar($array = array()) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //işçiye gönderilecek tur bildirimi-işçi cihazlar
    public function isciTurCihazlarBitGid($array = array()) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ') AND GidisKurumVardi = 1';
        return($this->db->select($sql));
    }

    //işçiye gönderilecek tur bildirimi-işçi cihazlar
    public function isciTurCihazlarBitDon($array = array()) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ') AND DonusTurBitti = 1';
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

    //tur başlat
    public function soforTurTipBaslatUpdate($data, $turID, $gidDon) {
        return ($this->db->update("bsturtip", $data, "BSTurID=" . $turID . " AND BSTurGidisDonus=" . $gidDon));
    }

    //tur tip başlat
    public function soforTurTipUpdate($data, $turID, $gidDon) {
        return ($this->db->update("bsturtip", $data, "BSTurID=" . $turID . " AND BSTurGidisDonus=" . $gidDon));
    }

    //turtip tablosundaki bilgiler
    public function turTipOzellik($turID, $turGidisDonus) {
        $sql = 'SELECT BSTurTip, BSTurKurumID, BSTurKurumAd, BSTurKurumLocation, BSTurAracID, BSTurAracPlaka, BSTurSoforID, BSTurHostesID, BSTurKm FROM bsturtip Where BSTurID = ' . $turID . ' AND BSTurGidisDonus = ' . $turGidisDonus;
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
        $sql = 'SELECT BSAracLokasyonID FROM bsaraclokasyon Where BSAracID = ' . $aracID . ' AND BSAracTurID = 

         

        ' . $turID;
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
