<?php

class Panel_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    //adminin bildirim ayarlarını çekiyorum
    public function adminBildirimAyar($adminID) {
        $sql = "SELECT BSAyarTip FROM bsadminbildirimayar Where BSAdminID=" . $adminID;
        return($this->db->select($sql));
    }

    //bildirimler okundu
    public function adminBildirimOkundu($data, $bildirimID) {
        return ($this->db->update("bsadminbildirim", $data, "BSAdminBildirimID=" . $bildirimID));
    }

    //duyurular okundu
    public function adminDuyuruOkundu($data, $duyuruID) {
        return ($this->db->update("bsadminduyuru", $data, "BSAdminDuyuruID=" . $duyuruID));
    }

    //tüm bildirimler okundu
    public function bildirimTumunuOkundu($data, $adminID) {
        return ($this->db->update("bsadminbildirim", $data, "BSAlanID=" . $adminID));
    }

    //tüm duyurular okundu
    public function duyuruTumunuOkundu($data, $adminID) {
        return ($this->db->update("bsadminduyuru", $data, "BSAlanID=" . $adminID));
    }

    //bildirimler görüldü
    public function adminBildirimGoruldu($data, $adminID) {
        return ($this->db->update("bsadminbildirim", $data, "BSAlanID=" . $adminID));
    }

    //duyurular görüldü
    public function adminDuyuruGoruldu($data, $adminID) {
        return ($this->db->update("bsadminduyuru", $data, "BSAlanID=" . $adminID));
    }

    //admin cihazlar
    public function adminBildirimAyarSelect($adminID) {
        $sql = 'SELECT BSAdminBildirimAyarID FROM bsadminbildirimayar Where BSAdminID=' . $adminID;
        return($this->db->select($sql));
    }

    //bildirimler ayarları düzenleme
    public function adminBildirimAyarDuzenle($data, $adminID) {
        return ($this->db->update("bsadminbildirimayar", $data, "BSAdminID=" . $adminID));
    }

    //bildirim ayar kaydet
    public function addNewAdminBildirimAyar($data) {
        return ($this->db->insert('bsadminbildirimayar', $data));
    }

    //bildirim kaydet
    public function addNewAdminBildirim($data) {
        return ($this->db->insert('bsadminbildirim', $data));
    }

    //bildirim kaydet
    public function addNewAdminMultiBildirim($data) {
        return ($this->db->multiInsert('bsadminbildirim', $data));
    }

    //log kaydet
    public function addNewAdminLog($data) {
        return ($this->db->insert('bsadminlog', $data));
    }

    //admin cihazlar
    public function adminCihaz() {
        $sql = 'SELECT bsadmincihazRecID FROM bsadmincihaz Where bsadminID=1';
        return($this->db->select($sql));
    }

    //diğer admin cihazlar
    public function digerAdminCihaz($array = array()) {
        $sql = 'SELECT bsadmincihazRecID FROM bsadmincihaz Where bsadminID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //işçi cihaz
    public function isciCihaz($array = array()) {
        $sql = 'SELECT sbiscicihazRecID FROM sbiscicihaz Where sbisciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenci cihaz
    public function ogrenciCihaz($array = array()) {
        $sql = 'SELECT bsogrencicihazRecID FROM bsogrencicihaz Where bsogrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //ÖrenciVELİ
    public function veliOgrenci($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsveliogrenci Where BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //veli cihaz
    public function veliCihaz($array = array()) {
        $sql = 'SELECT bsvelicihazRecID FROM bsvelicihaz Where bsveliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şoför cihaz
    public function soforCihaz($soforID) {
        $sql = 'SELECT sbsoforcihazRecID FROM sbsoforcihaz Where sbsoforID=' . $soforID;
        return($this->db->select($sql));
    }

    //şoför cihazlar
    public function digerSoforCihaz($array = array()) {
        $sql = 'SELECT sbsoforcihazRecID FROM sbsoforcihaz Where sbsoforID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //hostes cihaz
    public function hostesCihaz($hostesID) {
        $sql = 'SELECT bshostescihazRecID FROM bshostescihaz Where bshostesID=' . $hostesID;
        return($this->db->select($sql));
    }

    //hostes cihazlar
    public function digerHostesCihaz($array = array()) {
        $sql = 'SELECT bshostescihazRecID FROM bshostescihaz Where bshostesID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin bildirim
    public function adminBildirimler($array = array(), $adminID) {
        $sql = 'SELECT BSAdminBildirimID, BSBildirimText, BSBildirimIcon, BSBildirimUrl, BSBildirimRenk, BSBildirimTip, BSOkundu, BSBildirimTarih FROM bsadminbildirim WHERE BSBildirimTip NOT IN (' . $array . ') AND BSAlanID = ' . $adminID . ' ORDER BY BSAdminBildirimID DESC LIMIT 3';
        return($this->db->select($sql));
    }

    //admin duyruu
    public function adminDuyurular($adminID) {
        $sql = 'SELECT BSAdminDuyuruID, BSDuyuruText, BSOkundu, BSDuyuruTarih FROM bsadminduyuru WHERE BSAlanID = ' . $adminID . ' ORDER BY BSAdminDuyuruID DESC LIMIT 4';
        return($this->db->select($sql));
    }

    //loader bildirim
    public function loaderBildirimler($array = array(), $adminID, $bildirimID) {
        $sql = 'SELECT BSAdminBildirimID, BSBildirimText, BSBildirimIcon, BSBildirimUrl, BSBildirimRenk, BSBildirimTip, BSOkundu, BSBildirimTarih FROM bsadminbildirim WHERE BSBildirimTip NOT IN (' . $array . ') AND BSAlanID = ' . $adminID . ' AND BSAdminBildirimID < ' . $bildirimID . ' ORDER BY BSAdminBildirimID DESC LIMIT 3';
        return($this->db->select($sql));
    }

    //loader duyuru
    public function loaderDuyurular($adminID, $duyuruID) {
        $sql = 'SELECT BSAdminDuyuruID, BSDuyuruText,BSOkundu, BSDuyuruTarih FROM bsadminduyuru WHERE  BSAlanID = ' . $adminID . ' AND BSAdminDuyuruID < ' . $duyuruID . ' ORDER BY BSAdminDuyuruID DESC LIMIT 3';
        return($this->db->select($sql));
    }

    //admin bildirim listele
    public function tumbildirimListele($array = array(), $adminID) {
        $sql = 'SELECT BSAdminBildirimID, BSBildirimText, BSBildirimIcon, BSBildirimUrl, BSBildirimRenk, BSGonderenID, BSGonderenAdSoyad, BSBildirimTarih FROM bsadminbildirim WHERE BSBildirimTip NOT IN (' . $array . ') AND BSAlanID = ' . $adminID . ' ORDER BY BSBildirimTarih DESC';
        return($this->db->select($sql));
    }

    //admin bildirim Count
    public function adminBildirimlerCount($array = array(), $adminID) {
        $sql = 'SELECT COUNT(*) FROM bsadminbildirim WHERE BSBildirimTip NOT IN (' . $array . ') AND BSGoruldu = 0 AND BSAlanID = ' . $adminID;
        return($this->db->select($sql));
    }

    //admin duyurular Count
    public function adminDuyurularCount($adminID) {
        $sql = 'SELECT COUNT(*) FROM bsadminduyuru WHERE  BSGoruldu = 0 AND BSAlanID = ' . $adminID;
        return($this->db->select($sql));
    }

    //admin duyuru listele
    public function tumduyuruListele($adminID) {
        $sql = 'SELECT BSAdminDuyuruID,BSDuyuruText,BSDuyuruTarih,BSDuyuruHedef FROM bsadminduyuru WHERE BSAlanID = ' . $adminID . ' ORDER BY BSDuyuruTarih DESC';
        return($this->db->select($sql));
    }

    //duyuru count listele
    public function duyuruCountListele($adminID) {
        $sql = 'SELECT COUNT(*) FROM bsadminduyuru WHERE BSAlanID=' . $adminID;
        return($this->db->select($sql));
    }

    //ortak bölgeler
    public function ortakBolge($adminID) {
        $sql = 'SELECT BSBolgeID FROM bsadminbolge Where BSAdminID = ' . $adminID;
        return($this->db->select($sql));
    }

    //ortak bölgeler
    public function ortakAdminBolge($bolgeID) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge Where BSBolgeID = ' . $bolgeID . ' AND NOT BSAdminID = 1';
        return($this->db->select($sql));
    }

    //ortak bölgeler
    public function ortakDigerAdminBolge($array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge Where BSBolgeID IN (' . $array . ') AND NOT BSAdminID = 1';
        return($this->db->select($sql));
    }

    //admin diğer ortak bölgeler
    public function digerOrtakBolge($array = array(), $array1 = array()) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge Where BSBolgeID IN (' . $array . ') AND BSAdminID NOT IN (' . $array1 . ')';
        return($this->db->select($sql));
    }

    //admin diğer ortak bölgeler
    public function digerOrtakTekBolge($bolgeID, $array = array()) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge Where BSBolgeID = ' . $bolgeID . ' AND BSAdminID NOT IN (' . $array . ')';
        return($this->db->select($sql));
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

    //admin özellikler
    public function adminProfil($adminID) {
        $sql = "SELECT * FROM bsadmin Where BSAdminID=" . $adminID;
        return ($this->db->select($sql));
    }

    //admin profil düzenleme
    public function adminProfilDuzenle($data, $adminID) {
        return ($this->db->update("bsadmin", $data, "BSAdminID=" . $adminID));
    }

    //admin firma özellikleri getirme
    public function firmaOzellikler() {
        $sql = "SELECT * FROM bsfirma Where BSFirmaID=1 LIMIT 1";
        return ($this->db->select($sql));
    }

    //admin firma özellikleri düzenleme
    public function firmaOzelliklerDuzenle($data) {
        return ($this->db->update("bsfirma", $data, "BSFirmaID=1"));
    }

    //admin bölgeler listele
    public function bolgeListele() {
        $sql = "SELECT * FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admine göre bölge getirme
    public function AdminbolgeListele($adminID) {
        $sql = "SELECT DISTINCT BSBolgeID FROM bsadminbolge Where BSAdminID=" . $adminID;
        return($this->db->select($sql));
    }

    //admin bölgeler listele
    public function rutbeBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeAdi, SBBolgeID FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin bölgeler listele
    public function rutbeNotBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeAdi, SBBolgeID FROM sbbolgeler Where SBBolgeID NOT IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin bölgeler kurum count
    public function bolgeKurum_Count($array = array()) {
        $sql = 'SELECT SBBolgeID FROM sbkurum WHERE SBBolgeID IN (' . implode(', ', array_map('intval', $array)) . ')';
        return($this->db->select($sql));
    }

    //admin bölgeler arac count
    public function bolgeArac_Count($array = array()) {
        $sql = 'SELECT DISTINCT(SBTurAracID), SBBolgeID FROM sbtur WHERE SBBolgeID IN (' . implode(', ', array_map('intval', $array)) . ') And SBTurFirmaID = ' . $firmaID;
        return($this->db->select($sql));
    }

    //admin bölgeler öğrenci count
    public function bolgeOgrenci_Count($array = array()) {
        $sql = 'SELECT BSBolgeID FROM bsogrenci WHERE BSBolgeID IN (' . implode(', ', array_map('intval', $array)) . ') And BSFirmaID = ' . $firmaID;
        return($this->db->select($sql));
    }

    //admin bölgeler İŞÇİ count
    public function bolgeIsci_Count($array = array()) {
        $sql = 'SELECT SBBolgeID FROM sbisci WHERE SBBolgeID IN (' . implode(', ', array_map('intval', $array)) . ') And SBFirmaID = ' . $firmaID;
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
        $sql = 'SELECT SBBolgeID, SBBolgeAdi, SBBolgeAciklama FROM sbbolgeler WHERE SBBolgeID = ' . $adminBolgeDetailID;
        return($this->db->select($sql));
    }

    //admin bölge kurum detail
    public function adminBolgeKurumDetail($adminBolgeDetailID) {
        $sql = 'SELECT SBKurumAdi, SBKurumLokasyon, SBKurumID FROM sbkurum WHERE SBBolgeID = ' . $adminBolgeDetailID . ' ORDER BY SBKurumAdi ASC';
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
        $sql = "SELECT SBKurumAdi,SBKurumID,SBKurumAciklama,SBBolgeID,SBBolgeAdi,SBKurumTip FROM sbkurum ORDER BY SBKurumAdi ASC";
        return($this->db->select($sql));
    }

    //admin bölgeler kurum count
    public function kurumTur_Count($array = array()) {
        $sql = 'SELECT SBKurumID FROM sbtur WHERE SBKurumID IN (' . implode(', ', array_map('intval', $array)) . ')';
        return($this->db->select($sql));
    }

    //admin bölgeye öre kurum listele
    public function rutbeKurumBolgeListele($array = array()) {
        $sql = 'SELECT SBKurumAdi, SBKurumID, SBKurumAciklama, SBBolgeID, SBBolgeAdi, SBKurumTip FROM sbkurum Where SBBolgeID IN (' . $array . ') ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //admin kurum detail
    public function adminKurumDetail($adminKurumDetailID) {
        $sql = 'SELECT SBKurumID, SBKurumAdi, SBBolgeAdi, SBBolgeID, SBKurumTip, SBKurumTelefon, SBKurumEmail, SBKurumAdres, SBKurumAciklama, SBKurumLokasyon FROM sbkurum WHERE SBKurumID = ' . $adminKurumDetailID;
        return($this->db->select($sql));
    }

    //admin kurum tur detail
    public function adminKurumTurDetail($adminKurumDetailID) {
        $sql = 'SELECT SBTurID, SBTurAd, SBTurAktiflik, SBTurTip, SBTurAciklama FROM sbtur WHERE SBKurumID = ' . $adminKurumDetailID . ' ORDER BY SBTurAd ASC';
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
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
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
        $sql = 'SELECT SBAracID, SBAracPlaka, SBAracMarka, SBAracModelYili, SBAracKapasite, SBAracKm, SBAracDurum FROM sbarac ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //araç ıd listele
    public function aracIDListele() {
        $sql = 'SELECT BSAracID, BSAracTurTip, BSAracTurID FROM bsaraclokasyon';
        return($this->db->select($sql));
    }

    //araç lokasyon tur ad listele
    public function aracTurAdListele($array = array()) {
        $sql = 'SELECT SBTurAd FROM sbtur WHERE SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //araç rutbe ıd listele
    public function aracRutbeIDListele($array = array()) {
        $sql = 'SELECT BSAracID, BSAracTurTip, BSAracTurID FROM bsaraclokasyon WHERE BSAracID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //tura kayıtlı araçlar
    public function aracAktifTurListele($array = array(), $array1 = array(), $array2 = array()) {
        $sql = 'SELECT DISTINCT BSTurAracID, BSTurAracPlaka, BSTurSoforID, BSTurSoforAd, BSTurSoforLocation, BSTurKurumID, BSTurKurumAd, BSTurKurumLocation, BSTurBolgeID, BSTurBolgeAd, BSTurID, BSTurTip, BSTurAracKapasite, BSTurKm, BSTurGidisDonus FROM bsturtip WHERE BSTurAracID IN (' . $array . ') AND BSTurGidisDonus IN (' . $array1 . ') AND BSTurID IN (' . $array2 . ') GROUP BY BSTurAracID';
        return($this->db->select($sql));
    }

    //rutbe tur aktif arac ID listele
    public function rutbearacIDListele($array = array()) {
        $sql = 'SELECT DISTINCT SBAracID FROM sbaracbolge WHERE SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //rubee göre araçlar
    public function aracRutbeListele($array = array()) {
        $sql = 'SELECT SBAracID, SBAracPlaka, SBAracMarka, SBAracModelYili, SBAracKapasite, SBAracKm, SBAracDurum FROM sbarac WHERE SBAracID IN (' . $array . ') ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function aracBolgeListele() {
        $sql = "SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admin hostes bölge select listele
    public function hostesBolgeListelee() {
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
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin rütbe arac ıd 
    public function adminRutbeSoforIDListele($array = array()) {
        $sql = 'SELECT DISTINCT BSSoforID FROM bssoforbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin rütbe arac bölge select listele
    public function adminRutbeSoforListele($array = array()) {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor Where BSSoforID IN (' . $array . ') ORDER BY BSSoforAd ASC';
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

    //admin araç hostes kaydet
    public function addNewAdminAracHostes($data) {
        return ($this->db->multiInsert('bsarachostes', $data));
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

    //admin arac şöfor çoklu delete delete
    public function adminAracHostesDelete($adminAracID) {
        return ($this->db->delete("bsarachostes", "BSAracID=$adminAracID"));
    }

    //admin seçili arac bolge listele
    public function adminDetailAracBolge($aracID) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbaracbolge WHERE SBAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminDetailAracSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin seçili arac şoför listele
    public function adminDetailAracSofor($aracID) {
        $sql = 'SELECT DISTINCT BSSoforID, BSSoforAd FROM bsaracsofor WHERE BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //admin seçili arac hostes listele
    public function adminDetailAracHostes($aracID) {
        $sql = 'SELECT DISTINCT BSHostesID, BSHostesAd FROM bsarachostes WHERE BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectBolgeSofor($arraybolge = array(), $arraysofor = array()) {
        $sql = 'SELECT DISTINCT BSSoforID, BSSoforAd FROM bssoforbolge WHERE BSBolgeID IN (' . $arraybolge . ') AND BSSoforID NOT IN (' . $arraysofor . ')';
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectBolgeHostes($arraybolge = array(), $arrayhostes = array()) {
        $sql = 'SELECT DISTINCT BSHostesID, BSHostesAd FROM bshostesbolge WHERE BSBolgeID IN (' . $arraybolge . ') AND BSHostesID NOT IN (' . $arrayhostes . ')';
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectBolgeSoforr($arraybolge = array()) {
        $sql = 'SELECT DISTINCT BSSoforID, BSSoforAd FROM bssoforbolge WHERE BSBolgeID IN (' . $arraybolge . ')';
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectBolgeHostess($arraybolge = array()) {
        $sql = 'SELECT DISTINCT BSHostesID, BSHostesAd FROM bshostesbolge WHERE BSBolgeID IN (' . $arraybolge . ')';
        return($this->db->select($sql));
    }

    //admin select dışı şoför listele
    public function adminDetailAracSSofor($array = array()) {
        $sql = 'SELECT DISTINCT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor WHERE BSSoforID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminDetailAracBolgeSofor($array = array()) {
        $sql = 'SELECT DISTINCT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor WHERE BSSoforID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin arac detail özellik
    public function adminDetailAracOzellik($aracID) {
        $sql = 'SELECT SBAracID, SBAracPlaka, SBAracMarka, SBAracModelYili, SBAracKapasite, SBAracKm, SBAracDurum, SBAracAciklama FROM sbarac WHERE SBAracID = ' . $aracID . ' ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //admin arac detail özellik
    public function adminRutbeDetailAracOzellik($adminID) {
        $sql = 'SELECT SBAracID, SBAracPlaka, SBAracMarka, SBAracModelYili, SBAracKapasite, SBAracKm, SBAracDurum, SBAracAciklama FROM sbarac WHERE SBAdminID = ' . $adminID . ' ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //admin rutbe select dışı bölge listele
    public function adminRutbeDetailAracSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin rutbe select dışı arac listele
    public function adminRutbeDetailAracSSofor($array = array()) {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor WHERE BSSoforID IN (' . $array . ')';
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

    //admin arac sofor detail  delete
    public function adminDetailAracHostesDelete($adminAracDetailID) {
        return ($this->db->delete("bsarachostes", "BSAracID=$adminAracDetailID"));
    }

    //admin arac özellikleri düzenleme
    public function adminAracOzelliklerDuzenle($data, $aracID) {
        return ($this->db->update("sbarac", $data, "SBAracID=" . $aracID));
    }

    //admin seçili arac aktif tur listele
    public function adminDetailAracTur($aracID) {
        $sql = 'SELECT SBTurAktiflik FROM sbtur WHERE SBTurAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //admin rutbe bölgesindeki şoförler
    public function adminDetailRutbeAracTur($array = array(), $aracID) {
        $sql = 'SELECT SBTurAktiflik FROM sbtur WHERE BSBolgeID IN (' . $array . ') AND SBTurAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //admin arac detail 
    public function adminAracTurDetail($adminAracDetailID) {
        $sql = 'SELECT DISTINCT BSTurID FROM bsturtip WHERE BSTurAracID = ' . $adminAracDetailID;
        return($this->db->select($sql));
    }

    //araç takvim özellikleri
    public function adminAracTakvim($aracID) {
        $sql = 'SELECT BSTurID,SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //araç takvim özellikleri
    public function takvimTitle($sql) {
        return($this->db->select($sql));
    }

    //admin rutbe bölgesindeki şoförler
    public function adminAracDetailTur($array = array()) {
        $sql = 'SELECT SBTurID, SBTurAd, SBTurAciklama, SBTurAktiflik, SBKurumAd, SBTurTip, SBBolgeAd FROM sbtur WHERE SBTurID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin aktif arac listele
    public function adminCountListele($adminID) {
        $sql = 'SELECT COUNT(*) FROM bsadmin WHERE BSAdminID NOT IN(' . $adminID . ')';
        return($this->db->select($sql));
    }

    //admin listele
    public function adminListele($adminID) {
        $sql = "SELECT BSAdminID,BSAdminAd,BSAdminSoyad,BSAdminPhone,BSAdminEmail,Status,BSAdminAciklama FROM bsadmin WHERE BSAdminID NOT IN($adminID)  ORDER BY BSAdminAd ASC";
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

    //admin listele
    public function adminIDListele($adminID) {
        $sql = 'SELECT * FROM bsadmin WHERE BSAdminID = ' . $adminID . ' ORDER BY BSAdminAd ASC';
        return($this->db->select($sql));
    }

    //admin detail  delete
    public function adminDetailDelete($adminDetailID) {
        return ($this->db->delete("bsadmin", "BSAdminID=$adminDetailID"));
    }

    //admin bolge detail  delete
    public function adminDetailBolgeDelete($adminDetailID) {
        return ($this->db->delete("bsadminbolge", "BSAdminID=$adminDetailID"));
    }

    //admin özellikleri düzenleme
    public function adminOzelliklerDuzenle($data, $adminID) {
        return ($this->db->update("bsadmin", $data, "BSAdminID=" . $adminID));
    }

    //admin select dışı bölge listele
    public function adminBolge() {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler';
        return($this->db->select($sql));
    }

    //admin select dışı şoför listele
    public function adminAracSofor() {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor';
        return($this->db->select($sql));
    }

    //admin şoför listele
    public function soforCountListele() {
        $sql = 'SELECT COUNT(*) FROM bssofor';
        return($this->db->select($sql));
    }

    //admin  hostes listele
    public function hostesCountListele() {
        $sql = 'SELECT COUNT(*) FROM bshostes';
        return($this->db->select($sql));
    }

    //admin rutbeye göre şoför listele
    public function rutbeSoforCount($array = array()) {
        $sql = 'SELECT COUNT(DISTINCT(BSSoforID)) FROM bssoforbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin rutbeye göre hostes listele
    public function rutbeHostesCount($array = array()) {
        $sql = 'SELECT COUNT(DISTINCT(BSHostesID)) FROM bshostesbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //şofor listele
    public function soforListele() {
        $sql = "SELECT BSSoforID,BSSoforAd,BSSoforSoyad,BSSoforPhone,BSSoforEmail,Status,BSSoforAciklama FROM bssofor ORDER BY BSSoforAd ASC";
        return($this->db->select($sql));
    }

    //hostes listele
    public function hostesListele() {
        $sql = "SELECT BSHostesID,BSHostesAd,BSHostesSoyad,BSHostesPhone,BSHostesEmail,Status,BSHostesAciklama FROM bshostes ORDER BY BSHostesAd ASC";
        return($this->db->select($sql));
    }

    //şoför bölgeler listele
    public function soforBolgeListele($array = array()) {
        $sql = 'SELECT DISTINCT BSSoforID FROM bssoforbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //hostes bölgeler listele
    public function hostesBolgeListele($array = array()) {
        $sql = 'SELECT DISTINCT BSHostesID FROM bshostesbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //rutbe şofor listele
    public function rutbeSoforListele($array = array()) {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad, BSSoforPhone, BSSoforEmail, Status, BSSoforAciklama FROM bssofor Where BSSoforID IN (' . $array . ') ORDER BY BSSoforAd ASC';
        return($this->db->select($sql));
    }

    //rutbe hostes listele
    public function rutbeHostesListele($array = array()) {
        $sql = 'SELECT BSHostesID, BSHostesAd, BSHostesSoyad, BSHostesPhone, BSHostesEmail, Status, BSHostesAciklama FROM bshostes Where BSHostesID IN (' . $array . ') ORDER BY BSHostesAd ASC';
        return($this->db->select($sql));
    }

    //şoför bölgeler listele
    public function aracMultiSelectBolge($array = array()) {
        $sql = 'SELECT SBAracID FROM sbaracbolge Where SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function aracMultiSelect($array = array()) {
        $sql = 'SELECT SBAracID, SBAracPlaka FROM sbarac Where SBAracID IN (' . $array . ') ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function soforRutbeBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin hostes bölge select listele
    public function hostesRutbeBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //yeni şoför Kaydet
    public function addNewSofor($data) {
        return ($this->db->insert("bssofor", $data));
    }

    //yeni hostes Kaydet
    public function addNewHostes($data) {
        return ($this->db->insert("bshostes", $data));
    }

    //şoför  bölge  kaydet
    public function addNewBolgeSofor($data) {
        return ($this->db->multiInsert('bssoforbolge', $data));
    }

    //hostes  bölge  kaydet
    public function addNewBolgeHostes($data) {
        return ($this->db->multiInsert('bshostesbolge', $data));
    }

    //şoför  araç  kaydet
    public function addNewAracSofor($data) {
        return ($this->db->multiInsert('bsaracsofor', $data));
    }

    //hostes  araç  kaydet
    public function addNewAracHostes($data) {
        return ($this->db->multiInsert('bsarachostes', $data));
    }

    //şoör delete
    public function soforDelete($soforID) {
        return ($this->db->delete("bssofor", "BSSoforID=$soforID"));
    }

    //hostes delete
    public function hostesDelete($soforID) {
        return ($this->db->delete("bshostes", "BSHostesID=$soforID"));
    }

    //arac detail bölgeler listele
    public function aracDetailMultiSelectBolge($array = array()) {
        $sql = 'SELECT BSSoforID FROM bssoforbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function soforMultiSelect($array = array()) {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor Where BSSoforID IN (' . $array . ') ORDER BY BSSoforAd ASC';
        return($this->db->select($sql));
    }

    //arac detail bölgeler listele
    public function aracDetailMultiSelectBolgee($array = array()) {
        $sql = 'SELECT BSSoforID FROM bssoforbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //hostes bolge listele
    public function aracDetailHostesMultiSelectBolgee($array = array()) {
        $sql = 'SELECT BSHostesID FROM bshostesbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function soforMultiSelectt($array = array()) {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor Where BSSoforID IN (' . $array . ') ORDER BY BSSoforAd ASC';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function hostesMultiSelectt($array = array()) {
        $sql = 'SELECT BSHostesID, BSHostesAd, BSHostesSoyad FROM bshostes Where BSHostesID IN (' . $array . ') ORDER BY BSHostesAd ASC';
        return($this->db->select($sql));
    }

    //arac seçili şoförler
    public function aracDetailMultiSelectSofor($aracID) {
        $sql = 'SELECT BSSoforID FROM bsaracsofor WHERE BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //araç seçili şoförler dışındaki bölgeler
    public function aracDetailMultiNotSelectSofor($arraybolge = array(), $arraysofor = array()) {
        $sql = 'SELECT BSSoforID FROM bssoforbolge WHERE BSBolgeID IN (' . $arraybolge . ') AND BSSoforID NOT IN (' . $arraysofor . ')';
        return($this->db->select($sql));
    }

    //arac seçili olmayan şoförler
    public function adminDetailAracNotSelectSofor($array = array()) {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad FROM bssofor WHERE BSSoforID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //seçili şoför bolge listele
    public function soforDetailBolge($soforID) {
        $sql = 'SELECT BSBolgeID, BSBolgeAdi FROM bssoforbolge WHERE BSSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //seçili hostes bolge listele
    public function hostesDetailBolge($hostesID) {
        $sql = 'SELECT BSBolgeID, BSBolgeAdi FROM bshostesbolge WHERE BSHostesID = ' . $hostesID;
        return($this->db->select($sql));
    }

    //şoför select dışı bölge listele
    public function soforDetailSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //hostes select dışı bölge listele
    public function hostesDetailSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //seçili şoför arac listele
    public function adminDetailSoforArac($soforID) {
        $sql = 'SELECT BSAracID, BSAracPlaka FROM bsaracsofor WHERE BSSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //seçili hostes arac listele
    public function adminDetailHostesArac($hostesID) {
        $sql = 'SELECT BSAracID, BSAracPlaka FROM bsarachostes WHERE BSHostesID = ' . $hostesID;
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectSoforBolge($arraybolge = array(), $arrayarac = array()) {
        $sql = 'SELECT SBAracID, SBAracPlaka FROM sbaracbolge WHERE SBBolgeID IN (' . $arraybolge . ') AND SBAracID NOT IN (' . $arrayarac . ')';
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectHostesBolge($arraybolge = array(), $arrayarac = array()) {
        $sql = 'SELECT SBAracID, SBAracPlaka FROM sbaracbolge WHERE SBBolgeID IN (' . $arraybolge . ') AND SBAracID NOT IN (' . $arrayarac . ')';
        return($this->db->select($sql));
    }

    //select dışı bölge listele
    public function adminSelectBolgeArac($arraybolge = array()) {
        $sql = 'SELECT DISTINCT SBAracID, SBAracPlaka FROM sbaracbolge WHERE SBBolgeID IN (' . $arraybolge . ')';
        return($this->db->select($sql));
    }

    //şoför detail özellik
    public function soforDetail($soforID) {
        $sql = 'SELECT * FROM bssofor WHERE BSSoforID = ' . $soforID . ' ORDER BY BSSoforAd ASC';
        return($this->db->select($sql));
    }

    //hostes detail özellik
    public function hostesDetail($hostesID) {
        $sql = 'SELECT * FROM bshostes WHERE BSHostesID = ' . $hostesID . ' ORDER BY BSHostesAd ASC';
        return($this->db->select($sql));
    }

    //seçili şoför bolge listele
    public function adminDetailSoforBolge($soforID) {
        $sql = 'SELECT BSBolgeID, BSBolgeAdi FROM bssoforbolge WHERE BSSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //şoför takvim özellikleri
    public function adminSoforTakvim($soforID) {
        $sql = 'SELECT BSTurID,SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //seçili hostes bolge listele
    public function adminDetailHostesBolge($hostesID) {
        $sql = 'SELECT BSBolgeID, BSBolgeAdi FROM bshostesbolge WHERE BSHostesID = ' . $hostesID;
        return($this->db->select($sql));
    }

    //hostes takvim özellikleri
    public function adminHostesTakvim($soforID) {
        $sql = 'SELECT BSTurID,SBTurPzt,SBTurSli,SBTurCrs,SBTurPrs,SBTurCma,SBTurCmt,SBTurPzr,BSTurBslngc,BSTurBts FROM bsturtip WHERE BSTurHostesID = ' . $soforID;
        return($this->db->select($sql));
    }

    //şoför detail  delete
    public function detailSoforDelete($soforDetailID) {
        return ($this->db->delete("bssofor", "BSSoforID=$soforDetailID"));
    }

    //hostes detail  delete
    public function detailHostesDelete($hostesDetailID) {
        return ($this->db->delete("bshostes", "BSHostesID=$hostesDetailID"));
    }

    //sofor arac detail  delete
    public function detailSoforAracDelete($soforDetailID) {
        return ($this->db->delete("bsaracsofor", "BSSoforID=$soforDetailID"));
    }

    //hostes arac detail  delete
    public function detailHostesAracDelete($hostesDetailID) {
        return ($this->db->delete("bsarachostes", "BSHostesID=$hostesDetailID"));
    }

    //şoför bolge detail  delete
    public function detailSoforBolgeDelete($soforDetailID) {
        return ($this->db->delete("bssoforbolge", "BSSoforID=$soforDetailID"));
    }

    //hostes bolge detail  delete
    public function detailHostesBolgeDelete($hostesDetailID) {
        return ($this->db->delete("bshostesbolge", "BSHostesID=$hostesDetailID"));
    }

    //admin şoför özellikleri düzenleme
    public function soforOzelliklerDuzenle($data, $soforID) {
        return ($this->db->update("bssofor", $data, "BSSoforID=" . $soforID));
    }

    //şoför profil düzenle1
    public function soforOzelliklerDuzenle1($data, $soforID) {
        return ($this->db->update("bsturtip", $data, "BSTurSoforID=" . $soforID));
    }

    //şoför profil düzenle2
    public function soforOzelliklerDuzenle2($data, $soforID) {
        return ($this->db->update("bssoforbolge", $data, "BSSoforID=" . $soforID));
    }

    //şoför profil düzenle3
    public function soforOzelliklerDuzenle3($data, $soforID) {
        return ($this->db->update("bsaracsofor", $data, "BSSoforID=" . $soforID));
    }

    //admin hostes özellikleri düzenleme
    public function hostesOzelliklerDuzenle($data, $hostesID) {
        return ($this->db->update("bshostes", $data, "BSHostesID=" . $hostesID));
    }

    //şöfor arac çoklu delete delete
    public function adminSoforAracDelete($soforID) {
        return ($this->db->delete("bsaracsofor", "BSSoforID=$soforID"));
    }

    //hostes arac çoklu delete delete
    public function adminHostesAracDelete($hostesID) {
        return ($this->db->delete("bsarachostes", "BSHostesID=$hostesID"));
    }

    //admin  şofor araç kaydet
    public function addNewSoforArac($data) {
        return ($this->db->multiInsert('bsaracsofor', $data));
    }

    //admin  hostes araç kaydet
    public function addNewHostesArac($data) {
        return ($this->db->multiInsert('bsarachostes', $data));
    }

    //admin şoför bolge detail  delete
    public function adminDetailSoforBolgeDelete($soforDetailID) {
        return ($this->db->delete("bssoforbolge", "BSSoforID=$soforDetailID"));
    }

    //admin hostes bolge detail  delete
    public function adminDetailHostesBolgeDelete($hostesDetailID) {
        return ($this->db->delete("bshostesbolge", "BSHostesID=$hostesDetailID"));
    }

    //admin şoför  bölge  kaydet
    public function addNewSoforBolge($data) {
        return ($this->db->multiInsert('bssoforbolge', $data));
    }

    //admin hostes  bölge  kaydet
    public function addNewHostesBolge($data) {
        return ($this->db->multiInsert('bshostesbolge', $data));
    }

    //şoför seçili arac
    public function soforDetailMultiSelectSofor($soforID) {
        $sql = 'SELECT BSAracID FROM bsaracsofor WHERE BSSoforID = ' . $soforID;
        return($this->db->select($sql));
    }

    //hostes seçili arac
    public function hostesDetailMultiSelectHostes($hostesID) {
        $sql = 'SELECT BSAracID FROM bsarachostes WHERE BSHostesID = ' . $hostesID;
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectBolgeAracc($arraybolge = array()) {
        $sql = 'SELECT DISTINCT SBAracID, SBAracPlaka FROM sbaracbolge WHERE SBBolgeID IN (' . $arraybolge . ')';
        return($this->db->select($sql));
    }

    //arac seçili olmayan şoförler
    public function soforNotSelectArac($array = array()) {
        $sql = 'SELECT SBAracID, SBAracPlaka FROM sbarac WHERE SBAracID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //arac seçili olmayan hostesler
    public function hostesNotSelectArac($array = array()) {
        $sql = 'SELECT SBAracID, SBAracPlaka FROM sbarac WHERE SBAracID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //işçi listele
    public function isciCountListele() {
        $sql = 'SELECT COUNT(*) FROM sbisci';
        return($this->db->select($sql));
    }

    //admine göre işçi listeleme
    public function rutbeIsciCount($array = array()) {
        $sql = 'SELECT COUNT(DISTINCT(SBIsciID)) FROM sbiscibolge Where SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //işçi listele
    public function isciListele() {
        $sql = "SELECT SBIsciID,SBIsciAd,SBIsciSoyad,SBIsciPhone,SBIsciEmail,Status,SBIsciAciklama FROM sbisci ORDER BY SBIsciAd ASC";
        return($this->db->select($sql));
    }

    //işçi bölgeler listele
    public function isciBolgeListele($array = array()) {
        $sql = 'SELECT DISTINCT SBIsciID FROM sbiscibolge Where SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //rutbe işçi listele
    public function rutbeIsciListele($array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciSoyad, SBIsciPhone, SBIsciEmail, Status, SBIsciAciklama FROM sbisci Where SBIsciID IN (' . $array . ') ORDER BY SBIsciAd ASC';
        return($this->db->select($sql));
    }

    //admin arac bölge select listele
    public function isciNewBolgeListele() {
        $sql = "SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admin işçi kurum bölge select listele
    public function isciKurumMultiSelect($array = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum Where SBBolgeID IN (' . $array . ') AND (SBKurumTip = 1 OR SBKurumTip = 2) ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //yeni işçi Kaydet
    public function addNewIsci($data) {
        return ($this->db->insert("sbisci", $data));
    }

    //işçi  bölge  kaydet
    public function addNewBolgeIsci($data) {
        return ($this->db->multiInsert('sbiscibolge', $data));
    }

    //işçi  kurum  kaydet
    public function addNewIsciKurum($data) {
        return ($this->db->multiInsert('sbiscikurum', $data));
    }

    //işçi delete
    public function isciDelete($isciID) {
        return ($this->db->delete("sbisci", "SBIsciID=$isciID"));
    }

    //seçili işçi bolge listele
    public function isciDetailBolge($isciID) {
        $sql = 'SELECT SBBolgeID, SBBolgeAd FROM sbiscibolge WHERE SBIsciID = ' . $isciID;
        return($this->db->select($sql));
    }

    //işçi select dışı bölge listele
    public function isciDetailSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //seçili işçi kuurm listele
    public function adminDetailIsciKurum($isciID) {
        $sql = 'SELECT SBKurumID, SBKurumAd FROM sbiscikurum WHERE SBIsciID = ' . $isciID;
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectIsciBolge($arraybolge = array(), $arraykurum = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum WHERE SBBolgeID IN (' . $arraybolge . ') AND SBKurumID NOT IN (' . $arraykurum . ')';
        return($this->db->select($sql));
    }

    //select dışı bölge listele
    public function adminSelectBolgeKurum($arraybolge = array()) {
        $sql = 'SELECT DISTINCT SBKurumID, SBKurumAdi FROM sbkurum WHERE SBBolgeID IN (' . $arraybolge . ')';
        return($this->db->select($sql));
    }

    //işçi detail özellik
    public function isciDetail($isciID) {
        $sql = 'SELECT * FROM sbisci WHERE SBIsciID = ' . $isciID . ' ORDER BY SBIsciAd ASC';
        return($this->db->select($sql));
    }

    //işçi detail  delete
    public function detailIsciDelete($isciDetailID) {
        return ($this->db->delete("sbisci", "SBIsciID=$isciDetailID"));
    }

    //işçi arac detail  delete
    public function detailIsciKurumDelete($isciDetailID) {
        return ($this->db->delete("sbiscikurum", "SBIsciID=$isciDetailID"));
    }

    //İŞÇİ bolge detail  delete
    public function detailIsciBolgeDelete($isciDetailID) {
        return ($this->db->delete("sbiscibolge", "SBIsciID=$isciDetailID"));
    }

    //işçi özellikleri düzenleme
    public function isciOzelliklerDuzenle($data, $isciID) {
        return ($this->db->update("sbisci", $data, "SBIsciID=" . $isciID));
    }

    //işçi seçili kurum
    public function isciDetailMultiSelectIsci($isciID) {
        $sql = 'SELECT SBKurumID FROM sbiscikurum WHERE SBIsciID = ' . $isciID;
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectBolgeKurumm($arraybolge = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum WHERE SBBolgeID IN (' . $arraybolge . ') AND (SBKurumTip = 0 OR SBKurumTip = 2)';
        return($this->db->select($sql));
    }

    //admin select dışı bölge listele
    public function adminSelectBolgeIsciKurum($arraybolge = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum WHERE SBBolgeID IN (' . $arraybolge . ') AND (SBKurumTip = 1 OR SBKurumTip = 2)';
        return($this->db->select($sql));
    }

    //kurum seçili olmayan işçiler
    public function isciNotSelectKurum($array = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum WHERE SBKurumID IN (' . $array . ' ) AND (SBKurumTip = 1 OR SBKurumTip = 2)';
        return($this->db->select($sql));
    }

    //veli listele
    public function veliCountListele() {
        $sql = 'SELECT COUNT(*) FROM sbveli';
        return($this->db->select($sql));
    }

    //admine göre veli listeleme
    public function rutbeVeliCount($array = array()) {
        $sql = 'SELECT COUNT(DISTINCT(BSVeliID)) FROM bsvelibolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //veli listele
    public function veliListele() {
        $sql = "SELECT SBVeliID,SBVeliAd,SBVeliSoyad,SBVeliPhone,SBVeliEmail,Status,SBVeliAciklama FROM sbveli ORDER BY SBVeliAd ASC";
        return($this->db->select($sql));
    }

    //veli bölgeler listele
    public function veliBolgeListele($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID FROM bsvelibolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //rutbe işçi listele
    public function rutbeVeliListele($array = array()) {
        $sql = 'SELECT SBVeliID, SBVeliAd, SBVeliSoyad, SBVeliPhone, SBVeliEmail, Status, SBVeliAciklama FROM sbveli Where SBVeliID IN (' . $array . ') ORDER BY SBVeliAd ASC';
        return($this->db->select($sql));
    }

    //veli bölge select listele
    public function veliNewBolgeListele() {
        $sql = "SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //veli rutbe bölge select listele
    public function veliRutbeBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin veli kurum bölge select listele
    public function veliKurumMultiSelect($array = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum Where SBBolgeID IN (' . $array . ') AND (SBKurumTip = 0 OR SBKurumTip = 2) ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //admin veli öğrenci bölge select listele
    public function veliOgrenciMultiSelect($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd FROM bsogrencikurum Where BSKurumID IN (' . $array . ') ORDER BY BSOgrenciAd ASC';
        return($this->db->select($sql));
    }

    //yeni veli Kaydet
    public function addNewVeli($data) {
        return ($this->db->insert("sbveli", $data));
    }

    //veli  bölge  kaydet
    public function addNewBolgeVeli($data) {
        return ($this->db->multiInsert('bsvelibolge', $data));
    }

    //veli  kurum  kaydet
    public function addNewVeliKurum($data) {
        return ($this->db->multiInsert('bsvelikurum', $data));
    }

    //veli delete
    public function veliDelete($veliID) {
        return ($this->db->delete("sbveli", "SBVeliID=$veliID"));
    }

    //veli bölge delete
    public function veliBolgeDelete($veliID) {
        return ($this->db->delete("bsvelibolge", "SBVeliID=$veliID"));
    }

    //veli  öğrenci  kaydet
    public function addNewVeliOgrenci($data) {
        return ($this->db->multiInsert('bsveliogrenci', $data));
    }

    //seçili veli bolge listele
    public function veliDetailBolge($veliID) {
        $sql = 'SELECT BSBolgeID, BSBolgeAd FROM bsvelibolge WHERE BSVeliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //veli select dışı bölge listele
    public function veliDetailSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //seçili veli kurum listele
    public function adminDetailVeliKurum($veliID) {
        $sql = 'SELECT BSKurumID, BSKurumAd FROM bsvelikurum WHERE BSVeliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //seçili veli öğrenci listele
    public function adminDetailVeliOgrenci($veliID) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd FROM bsveliogrenci WHERE BSVeliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //admin select dışı öğrenci listele
    public function adminSelectVeliKurum($arraykurum = array(), $arrayogrenci = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd FROM bsogrencikurum WHERE BSKurumID IN (' . $arraykurum . ') AND BSOgrenciID NOT IN (' . $arrayogrenci . ')';
        return($this->db->select($sql));
    }

    //select dışı kurum öğrenci listele
    public function adminSelectKurumOgrenci($arraykurum = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd FROM bsogrencikurum WHERE BSKurumID IN (' . $arraykurum . ')';
        return($this->db->select($sql));
    }

    //veli detail özellik
    public function veliDetail($veliID) {
        $sql = 'SELECT * FROM sbveli WHERE SBVeliID = ' . $veliID . ' ORDER BY SBVeliAd ASC';
        return($this->db->select($sql));
    }

    //veli detail  delete
    public function detailVeliDelete($veliDetailID) {
        return ($this->db->delete("sbveli", "SBVeliID=$veliDetailID"));
    }

    //veli bölge delete
    public function detailVeliBolgeDelete($veliDetailID) {
        return ($this->db->delete("bsvelibolge", "BSVeliID=$veliDetailID"));
    }

    //veli kurum delete
    public function detailVeliKurumDelete($veliDetailID) {
        return ($this->db->delete("bsvelikurum", "BSVeliID=$veliDetailID"));
    }

    //veli öğrenci delete
    public function detailVeliOgrenciDelete($veliDetailID) {
        return ($this->db->delete("bsveliogrenci", "BSVeliID=$veliDetailID"));
    }

    //veli özellikleri düzenleme
    public function veliOzelliklerDuzenle($data, $veliID) {
        return ($this->db->update("sbveli", $data, "SBVeliID=" . $veliID));
    }

    //veli seçili kurum
    public function veliDetailMultiSelectVeli($veliID) {
        $sql = 'SELECT BSKurumID FROM bsvelikurum WHERE BSVeliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //kurum seçili olmayan veliler
    public function veliNotSelectKurum($array = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum WHERE SBKurumID IN (' . $array . ') AND SBKurumTip = 0';
        return($this->db->select($sql));
    }

    //veli seçili öğrenci
    public function veliDetailMultiSelectOgrenci($veliID) {
        $sql = 'SELECT BSOgrenciID FROM bsveliogrenci WHERE BSVeliID = ' . $veliID;
        return($this->db->select($sql));
    }

    //admin select dışı öğrenci listele
    public function adminSelectBolgeKurumOgrenci($arraykurum = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd FROM bsogrencikurum WHERE BSKurumID IN (' . $arraykurum . ')';
        return($this->db->select($sql));
    }

    //kurum seçili olmayan öğrenciler
    public function veliNotSelectOgrenci($array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd FROM bsogrenci WHERE BSOgrenciID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenci listele
    public function ogrenciCountListele() {
        $sql = 'SELECT COUNT(*) FROM bsogrenci';
        return($this->db->select($sql));
    }

    //admine göre öğrenci listeleme
    public function rutbeOgrenciCount($array = array()) {
        $sql = 'SELECT COUNT(DISTINCT(BSOgrenciID)) FROM bsogrencibolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrenci listele
    public function ogrenciListele() {
        $sql = "SELECT BSOgrenciID,BSOgrenciAd,BSOgrenciSoyad,BSOgrenciPhone,BSOgrenciEmail,Status,BSOgrenciAciklama FROM bsogrenci ORDER BY BSOgrenciAd ASC";
        return($this->db->select($sql));
    }

    //öğrenci bölgeler listele
    public function ogrenciBolgeListele($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID FROM bsogrencibolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //rutbe veli listele
    public function rutbeOgrenciListele($array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciSoyad, BSOgrenciPhone, BSOgrenciEmail, Status, BSOgrenciAciklama FROM bsogrenci Where BSOgrenciID IN (' . $array . ') ORDER BY BSOgrenciAd ASC';
        return($this->db->select($sql));
    }

    //öğrenci bölge select listele
    public function ogrenciNewBolgeListele() {
        $sql = "SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admin öğrenci kurum bölge select listele
    public function ogrenciKurumMultiSelect($array = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum Where SBBolgeID IN (' . $array . ') AND (SBKurumTip = 0 OR SBKurumTip = 2) ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //admin  öğrenci veli bölge select listele
    public function ogrenciVeliMultiSelect($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID, BSVeliAd FROM bsvelikurum Where BSKurumID IN (' . $array . ') ORDER BY BSVeliAd ASC';
        return($this->db->select($sql));
    }

    //yeni öğrenci Kaydet
    public function addNewOgrenci($data) {
        return ($this->db->insert("bsogrenci", $data));
    }

    //öğrenci delete
    public function ogrenciDelete($ogrenciID) {
        return ($this->db->delete("bsogrenci", "BSOgrenciID=$ogrenciID"));
    }

    //öğrenci bölge delete
    public function ogrenciBolgeDelete($ogrenciID) {
        return ($this->db->delete("bsogrencibolge", "BSOgrenciID=$ogrenciID"));
    }

    //öğrenci  bölge  kaydet
    public function addNewBolgeOgrenci($data) {
        return ($this->db->multiInsert('bsogrencibolge', $data));
    }

    //öğrenci  kurum  kaydet
    public function addNewOgrenciKurum($data) {
        return ($this->db->multiInsert('bsogrencikurum', $data));
    }

    //seçili öğrenci bolge listele
    public function ogrenciDetailBolge($ogrenciID) {
        $sql = 'SELECT BSBolgeID, BSBolgeAd FROM bsogrencibolge WHERE BSOgrenciID = ' . $ogrenciID;
        return($this->db->select($sql));
    }

    //öğrenci select dışı bölge listele
    public function ogrenciDetailSBolge($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler WHERE SBBolgeID NOT IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //seçili öğrenci kurum listele
    public function adminDetailOgrenciKurum($ogrenciID) {
        $sql = 'SELECT BSKurumID, BSKurumAd FROM bsogrencikurum WHERE BSOgrenciID = ' . $ogrenciID;
        return($this->db->select($sql));
    }

    //seçili  öğrenci veli listele
    public function adminDetailOgrenciVeli($ogrenciID) {
        $sql = 'SELECT BSVeliID, BSVeliAd FROM bsveliogrenci WHERE BSOgrenciID = ' . $ogrenciID;
        return($this->db->select($sql));
    }

    //admin select dışı veli listele
    public function adminSelectOgrenciKurum($arraykurum = array(), $arrayveli = array()) {
        $sql = 'SELECT DISTINCT BSVeliID, BSVeliAd FROM bsvelikurum WHERE BSKurumID IN (' . $arraykurum . ') AND BSVeliID NOT IN (' . $arrayveli . ')';
        return($this->db->select($sql));
    }

    //select dışı kurum veli listele
    public function adminSelectKurumVeli($arraykurum = array()) {
        $sql = 'SELECT DISTINCT BSVeliID, BSVeliAd FROM bsvelikurum WHERE BSKurumID IN (' . $arraykurum . ')';
        return($this->db->select($sql));
    }

    //öğrenci detail özellik
    public function ogrenciDetail($ogrenciID) {
        $sql = 'SELECT * FROM bsogrenci WHERE BSOgrenciID = ' . $ogrenciID . ' ORDER BY BSOgrenciAd ASC';
        return($this->db->select($sql));
    }

    //öğrenci detail  delete
    public function detailOgrenciDelete($ogrenciDetailID) {
        return ($this->db->delete("bsogrenci", "BSOgrenciID=$ogrenciDetailID"));
    }

    //öğrenci bölge delete
    public function detailOgrenciBolgeDelete($ogrenciDetailID) {
        return ($this->db->delete("bsogrencibolge", "BSOgrenciID=$ogrenciDetailID"));
    }

    //öğrenci kurum delete
    public function detailOgrenciKurumDelete($ogrenciDetailID) {
        return ($this->db->delete("bsogrencikurum", "BSOgrenciID=$ogrenciDetailID"));
    }

    //öğrenci veli delete
    public function detailOgrenciVeliDelete($ogrenciDetailID) {
        return ($this->db->delete("bsveliogrenci", "BSOgrenciID=$ogrenciDetailID"));
    }

    //öğrenci özellikleri düzenleme
    public function ogrenciOzelliklerDuzenle($data, $ogrenciID) {
        return ($this->db->update("bsogrenci", $data, "BSOgrenciID=" . $ogrenciID));
    }

    //öğrenci seçili kurum
    public function ogrenciDetailMultiSelectVeli($ogrenciID) {
        $sql = 'SELECT BSKurumID FROM bsogrencikurum WHERE BSOgrenciID = ' . $ogrenciID;
        return($this->db->select($sql));
    }

    //kurum seçili olmayan öğrenciler
    public function ogrenciNotSelectKurum($array = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum WHERE SBKurumID IN (' . $array . ') AND (SBKurumTip = 0 OR SBKurumTip = 2)';
        return($this->db->select($sql));
    }

    //öğrenci seçili veli 
    public function ogrenciDetailMultiSelect($ogrenciID) {
        $sql = 'SELECT BSVeliID FROM bsveliogrenci WHERE BSOgrenciID = ' . $ogrenciID;
        return($this->db->select($sql));
    }

    //admin select dışı veli listele
    public function adminSelectBolgeKurumVeli($arraykurum = array()) {
        $sql = 'SELECT DISTINCT BSVeliID, BSVeliAd FROM bsvelikurum WHERE BSKurumID IN (' . $arraykurum . ')';
        return($this->db->select($sql));
    }

    //kurum seçili olmayan veliler
    public function ogrenciNotSelectVeli($array = array()) {
        $sql = 'SELECT SBVeliID, SBVeliAd FROM sbveli WHERE SBVeliID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin tur listele
    public function turListele() {
        $sql = "SELECT SBTurID,SBTurAd,SBTurAktiflik,SBBolgeAd,SBKurumAd,SBTurTip,SBTurAciklama FROM sbtur ORDER BY SBTurAd ASC";
        return($this->db->select($sql));
    }

    //admin tur count
    public function turListeleCount() {
        $sql = "SELECT SBTurID FROM sbtur";
        return($this->db->select($sql));
    }

    //admin turlar rutbe count
    public function rutbeTurCount($array = array()) {
        $sql = 'SELECT SBTurID FROM sbtur Where SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //admin bölgeye göre tur listele
    public function rutbeTurBolgeListele($array = array()) {
        $sql = 'SELECT SBTurID, SBTurAd, SBTurAktiflik, SBBolgeAd, SBKurumAd, SBTurTip, SBTurAciklama FROM sbtur Where SBBolgeID IN (' . $array . ') ORDER BY SBTurAd ASC';
        return($this->db->select($sql));
    }

    //admin tur bölge select listele
    public function turBolgeListele() {
        $sql = "SELECT SBBolgeID , SBBolgeAdi FROM sbbolgeler ORDER BY SBBolgeAdi ASC";
        return($this->db->select($sql));
    }

    //admine göre tur bölge select listele
    public function adminTurBolgeListele($adminID) {
        $sql = "SELECT BSBolgeID FROM bsadminbolge Where BSAdminID=" . $adminID;
        return($this->db->select($sql));
    }

    //admin tur bölge select listele
    public function turRutbeBolgeListele($array = array()) {
        $sql = 'SELECT SBBolgeID, SBBolgeAdi FROM sbbolgeler Where SBBolgeID IN (' . $array . ') ORDER BY SBBolgeAdi ASC';
        return($this->db->select($sql));
    }

    //admin veli kurum bölge select listele
    public function turKurumSelect($bolgeID) {
        $sql = 'SELECT SBKurumID, SBKurumAdi, SBKurumTip, SBKurumLokasyon FROM sbkurum Where SBBolgeID = ' . $bolgeID . ' ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //tur aktif araç listele
    public function turAracSelect($sql) {
        $sql = 'SELECT DISTINCT BSTurAracID FROM bsturtip Where ' . $sql;
        return($this->db->select($sql));
    }

    //tur bölge araç listele
    public function turBolgeAracListele($bolgeID) {
        $sql = 'SELECT DISTINCT SBAracID FROM sbaracbolge WHERE SBBolgeID = ' . $bolgeID;
        return($this->db->select($sql));
    }

    //tur bölge pasif araç listele
    public function turBolgePasifAracListele($array = array()) {
        $sql = 'SELECT SBAracID, SBAracPlaka, SBAracKapasite FROM sbarac WHERE SBAracID IN (' . $array . ') ORDER BY SBAracPlaka ASC';
        return($this->db->select($sql));
    }

    //tur aktif şoför listele
    public function turSoforSelect($sql) {
        $sql = 'SELECT DISTINCT BSTurSoforID FROM bsturtip Where ' . $sql;
        return($this->db->select($sql));
    }

    //tur aktif hostes listele
    public function turHostesSelect($sql) {
        $sql = 'SELECT DISTINCT BSTurHostesID FROM bsturtip Where ' . $sql;
        return($this->db->select($sql));
    }

    //tur araç şoför listele
    public function turAracSoforListele($aracID) {
        $sql = 'SELECT DISTINCT BSSoforID FROM bsaracsofor WHERE BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //tur araç hostes listele
    public function turAracHostesListele($aracID) {
        $sql = 'SELECT DISTINCT BSHostesID FROM bsarachostes WHERE BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //tur araç pasif şoför listele
    public function turAracPasifSoforListele($array = array()) {
        $sql = 'SELECT BSSoforID, BSSoforAd, BSSoforSoyad, BSSoforLocation FROM bssofor WHERE BSSoforID IN (' . $array . ') ORDER BY BSSoforAd ASC';
        return($this->db->select($sql));
    }

    //tur araç pasif hostes listele
    public function turAracPasifHostesListele($array = array()) {
        $sql = 'SELECT BSHostesID, BSHostesAd, BSHostesSoyad, BSHostesLocation FROM bshostes WHERE BSHostesID IN (' . $array . ') ORDER BY BSHostesAd ASC';
        return($this->db->select($sql));
    }

    //tur kuruma göre kişiler
    public function turKurumOgrenci($kurumID) {
        $sql = 'SELECT DISTINCT BSOgrenciID FROM bsogrencikurum Where BSKurumID = ' . $kurumID;
        return($this->db->select($sql));
    }

    //tur kurum öğrenci
    public function turKurumOgrencii($array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciSoyad, BSOgrenciLocation FROM bsogrenci Where BSOgrenciID IN (' . $array . ') AND Status = 1';
        return($this->db->select($sql));
    }

    //tur kuruma göre kişiler
    public function turKurumIsci($kurumID) {
        $sql = 'SELECT DISTINCT SBIsciID FROM sbiscikurum Where SBKurumID = ' . $kurumID;
        return($this->db->select($sql));
    }

    //tur kurum işçi
    public function turKurumIscii($array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciSoyad, SBIsciLocation FROM sbisci Where SBIsciID IN (' . $array . ') AND Status = 1';
        return($this->db->select($sql));
    }

    //kurumda herhangi bi tura kayıtlı öğrenciler
    public function turKurumAitOgrenci($kurumID) {
        $sql = 'SELECT DISTINCT BSOgrenciID FROM bsogrencitur Where BSKurumID = ' . $kurumID;
        return($this->db->select($sql));
    }

    //kurumda herhangi bi tura kayıtlı işçiler
    public function turKurumAitIsci($kurumID) {
        $sql = 'SELECT DISTINCT SBIsciID FROM sbiscitur Where SBKurumID = ' . $kurumID;
        return($this->db->select($sql));
    }

    //kurumda herhangi bi tura kayıtlı personeller
    public function turKurumAitPersonel($kurumID) {
        $sql = 'SELECT DISTINCT BSOgrenciIsciID FROM bsogrenciiscitur Where BSKullaniciTip = 1 AND BSKurumID = ' . $kurumID;
        return($this->db->select($sql));
    }

    //kurumda herhangi bi tura kayıtlı öğrenciler
    public function turKurumAitOgrenciler($kurumID) {
        $sql = 'SELECT DISTINCT BSOgrenciIsciID FROM bsogrenciiscitur Where BSKullaniciTip = 0 AND BSKurumID = ' . $kurumID;
        return($this->db->select($sql));
    }

    //yeni tur Kaydet
    public function addNewTur($data) {
        return ($this->db->insert("sbtur", $data));
    }

    //yeni tur tip Kaydet
    public function addNewTurTip($data) {
        return ($this->db->insert("bsturtip", $data));
    }

    //yeni tur öğrenci kaydet
    public function addNewTurOgrenci($data) {
        return ($this->db->insert("bsogrencitur", $data));
    }

    //yeni tur işçi kaydet
    public function addNewTurIsci($data) {
        return ($this->db->insert("sbiscitur", $data));
    }

    //yeni tur işçi öğrenci kaydet
    public function addNewTurIsciOgrenci($data) {
        return ($this->db->multiInsert("bsogrenciiscitur", $data));
    }

    //tur  tip güncelleme
    public function turTipDuzenle($data, $turID) {
        return ($this->db->update("sbtur", $data, "SBTurID=" . $turID));
    }

    //tur kurum öğrenci
    public function turDetayTip($turID) {
        $sql = 'SELECT BSTurTipID, BSTurTip, BSTurGidisDonus, BSTurAracID, BSTurAracPlaka, BSTurAracKapasite, BSTurSoforID, BSTurSoforAd, BSTurSoforLocation, BSTurHostesID, BSTurHostesAd, BSTurHostesLocation, BSTurBslngc, BSTurBts, BSTurBolgeID, BSTurBolgeAd, BSTurKurumID, BSTurKurumAd, BSTurKurumLocation FROM bsturtip Where BSTurGidisDonus IN (0, 1) AND BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //tur gidis detay
    public function turDetayGidisIsciOgrenci($turID) {
        $sql = 'SELECT BSKullaniciTip, BSOgrenciIsciID, BSOgrenciIsciAd, BSOgrenciIsciLocation, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr FROM bsogrenciiscitur Where BSTurID = ' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //tur gidis öğrenci detay
    public function turDetayGidisOgrenci($turID) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr FROM bsogrencitur Where BSTurID = ' . $turID . ' ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //tur gidis detay
    public function turDetayGidisIsci($turID) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation, SBTurPzt, SBTurSli, SBTurCrs, SBTurPrs, SBTurCma, SBTurCmt, SBTurPzr FROM sbiscitur Where SBTurID = ' . $turID . ' ORDER BY SBTurSira ASC';
        return($this->db->select($sql));
    }

    //gidiş tur tip güncelleme
    public function turTipGidisDuzenle($data, $turTipID) {
        return ($this->db->update("bsturtip", $data, "BSTurTipID=" . $turTipID));
    }

    // tur delete
    public function turDelete($turID) {
        return ($this->db->delete("sbtur", "SBTurID=$turID"));
    }

    // tur tip delete
    public function turTipDelete($turID) {
        return ($this->db->delete("bsturtip", "BSTurID=$turID"));
    }

    //öğrencitur delete
    public function detailGidisOgrenciDelete($turID) {
        return ($this->db->delete("bsogrencitur", "BSTurID=$turID"));
    }

    //işçi tur delete
    public function detailGidisIsciDelete($turID) {
        return ($this->db->delete("sbiscitur", "SBTurID=$turID"));
    }

    //işçi tur delete
    public function detailGidisOgrenciIsciDelete($turID) {
        return ($this->db->delete("bsogrenciiscitur", "BSTurID=$turID"));
    }

    //dönüş öğrenci tur düzenleme
    public function turTipDonusOgrenciDuzenle($data, $turID) {
        return ($this->db->update("bsogrencitur", $data, "BSTurID=" . $turID));
    }

    //dönüş işçi tur düzenleme
    public function turTipDonusIsciDuzenle($data, $turID) {
        return ($this->db->update("sbiscitur", $data, "SBTurID=" . $turID));
    }

    //dönüş öğrenci işçi tur düzenleme
    public function turTipDonusOgrenciIsciDuzenle($data, $turID) {
        return ($this->db->update("bsogrenciiscitur", $data, "BSTurID=" . $turID));
    }

    //gidiş öğrenci tur düzenleme
    public function turTipGidisOgrenciDuzenle($data, $turID) {
        return ($this->db->update("bsogrencitur", $data, "BSTurID=" . $turID));
    }

    //gidiş işçi tur düzenleme
    public function turTipGidisIsciDuzenle($data, $turID) {
        return ($this->db->update("sbiscitur", $data, "SBTurID=" . $turID));
    }

    //GİDİŞ öğrenci işçi tur düzenleme
    public function turTipGidisOgrenciIsciDuzenle($data, $turID) {
        return ($this->db->update("bsogrenciiscitur", $data, "BSTurID=" . $turID));
    }

    //dönüş tur tip güncelleme
    public function turTipDonusDuzenle($data, $turTipID) {
        return ($this->db->update("bsturtip", $data, "BSTurTipID=" . $turTipID));
    }

    //lokasyon liste
    public function lokasyonListeleCount() {
        $sql = "SELECT BSAracID FROM bsaraclokasyon";
        return($this->db->select($sql));
    }

    //aktif lokasyonu olan araçlar
    public function rutbeAracLokasyonCount($array = array()) {
        $sql = 'SELECT BSAracID FROM bsaraclokasyon Where BSAracID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //öğrencinin tura göre id listesi
    public function turOgrenciIDListele($turID) {
        $sql = 'SELECT BSOgrenciID FROM bsogrencitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrencinin tur güne göre idler
    public function turOgrenciGunIDListele($turID, $gun, $turGidisDonus) {
        $sql = 'SELECT BSOgrenciID FROM bsseferogrenci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 0 AND BSTurTip = ' . $turGidisDonus;
        return($this->db->select($sql));
    }

    //tura gidişte binenler kimler
    public function turOgrenciBinenIDListele($turID) {
        $sql = 'SELECT BSKisiID FROM bsturgidis WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrenci tur gidişte araca binmiş olanlar
    public function turGidisOgrenciBinenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //öğrenci tur gidişte araca binmemiş olanlar
    public function turGidisOgrenciBinmeyenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //işçinin tura göre id listesi
    public function turIsciIDListele($turID) {
        $sql = 'SELECT SBIsciID FROM sbiscitur WHERE SBTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //işçinin tur güne göre idler
    public function turIsciGunIDListele($turID, $gun, $turGidisDonus) {
        $sql = 'SELECT BSIsciID FROM bsseferisci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 0 AND BSTurTip = ' . $turGidisDonus;
        return($this->db->select($sql));
    }

    //tura gidişte binenler kimler
    public function turIsciBinenIDListele($turID) {
        $sql = 'SELECT BSKisiID FROM bsturgidis WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //işçi tur gidişte araca binmiş olanlar
    public function turGidisIsciBinenListele($turID, $array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID . ' AND SBIsciID IN (' . $array . ') ORDER BY SBTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi tur gidişte araca binmemiş olanlar
    public function turGidisIsciBinmeyenListele($turID, $array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID . ' AND SBIsciID IN (' . $array . ') ORDER BY SBTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi ve öğrenci tura göre id listesi
    public function turIsciOgrenciIDListele($turID) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip FROM bsogrenciiscitur WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrenci ve işçinin tur güne göre idler
    public function turIsciOgrenciGunIDListele($turID, $gun, $turGidisDonus) {
        $sql = 'SELECT BSKisiID, BSKullaniciTip FROM bsseferogrenciisci WHERE BSTurID = ' . $turID . ' AND ' . $gun . ' = 0 AND BSTurTip = ' . $turGidisDonus;
        return($this->db->select($sql));
    }

    //tura gidişte binenler kimler
    public function turIsciOgrenciBinenIDListele($turID) {
        $sql = 'SELECT BSKisiID, BSKisiTip FROM bsturgidis WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //işçi öğrenci tur gidişte araca binmiş olanlar
    public function turGidisIsciOgrenciBinenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi öğrenci tur gidişte araca binmemiş olanlar
    public function turGidisOgrenciIsciBinmeyenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //tura dönüşte binenler kimler
    public function turOgrenciInenIDListele($turID) {
        $sql = 'SELECT BSKisiID FROM bsturdonus WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //öğrenci tur dönüşte araca binmemiş olanlar
    public function turDonusOgrenciInmeyenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //öğrenci tur dönüşte araca binmiş olanlar
    public function turDonusOgrenciInenListele($turID, $array = array()) {
        $sql = 'SELECT BSOgrenciID, BSOgrenciAd, BSOgrenciLocation FROM bsogrencitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciID IN (' . $array . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //tura dönüşte binenler kimler
    public function turIsciDonenIDListele($turID) {
        $sql = 'SELECT BSKisiID FROM bsturdonus WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //işçi tur dönüşte araca binmiş olanlar
    public function turDonusIsciInenListele($turID, $array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID . ' AND SBIsciID IN (' . $array . ') ORDER BY SBTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi tur DÖNÜŞTE araca binmemiş olanlar
    public function turDonusIsciInmeyenListele($turID, $array = array()) {
        $sql = 'SELECT SBIsciID, SBIsciAd, SBIsciLocation FROM sbiscitur WHERE SBTurID = ' . $turID . ' AND SBIsciID IN (' . $array . ') ORDER BY SBTurSira ASC';
        return($this->db->select($sql));
    }

    //tura dönüşte inenler kimler
    public function turIsciOgrenciInenIDListele($turID) {
        $sql = 'SELECT BSKisiID, BSKisiTip FROM bsturdonus WHERE BSTurID = ' . $turID;
        return($this->db->select($sql));
    }

    //işçi öğrenci tur dönüşte araca binmiş olanlar
    public function turDonusIsciOgrenciInenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //işçi öğrenci tur dönüşte araca binmemiş olanlar
    public function turDonusOgrenciIsciInmeyenListele($turID, $array = array(), $array1 = array()) {
        $sql = 'SELECT BSOgrenciIsciID, BSKullaniciTip, BSOgrenciIsciAd, BSOgrenciIsciLocation FROM bsogrenciiscitur WHERE BSTurID = ' . $turID . ' AND BSOgrenciIsciID IN (' . $array . ') AND BSKullaniciTip IN (' . $array1 . ') ORDER BY BSTurSira ASC';
        return($this->db->select($sql));
    }

    //aktif lokasyonu olan araç
    public function aracLokasyon($aracID) {
        $sql = 'SELECT BSAracLokasyon FROM bsaraclokasyon Where BSAracID = ' . $aracID;
        return($this->db->select($sql));
    }

    //duyruu detail bölge admin
    public function duyuruBolgeMultiAdmin($array = array(), $adminID) {
        $sql = 'SELECT DISTINCT BSAdminID FROM bsadminbolge Where BSBolgeID IN (' . $array . ') AND NOT BSAdminID=' . $adminID;
        return($this->db->select($sql));
    }

    //aadmin listele
    public function duyuruAdmin($array = array()) {
        $sql = 'SELECT BSAdminID, BSAdminAd, BSAdminSoyad FROM bsadmin Where BSAdminID IN (' . $array . ') ORDER BY BSAdminAd ASC';
        return($this->db->select($sql));
    }

    //duyruu detail bölge şoför
    public function duyuruBolgeMultiSofor($array = array()) {
        $sql = 'SELECT DISTINCT BSSoforID, BSSoforAd FROM bssoforbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //duyruu detail bölge hostes
    public function duyuruBolgeMultiHostes($array = array()) {
        $sql = 'SELECT DISTINCT BSHostesID, BSHostesAd FROM bshostesbolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //duyruu detail bölge veli
    public function duyuruBolgeMultiVeli($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID, BSVeliAd FROM bsvelibolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //duyruu detail bölge öğrenci
    public function duyuruBolgeMultiOgrenci($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd FROM bsogrencibolge Where BSBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //duyruu detail bölge işçi
    public function duyuruBolgeMultiIsci($array = array()) {
        $sql = 'SELECT DISTINCT SBIsciID, SBIsciAd FROM sbiscibolge Where SBBolgeID IN (' . $array . ')';
        return($this->db->select($sql));
    }

    //duyuru bolge kurum listesi
    public function duyuruKurumMultiSelect($array = array()) {
        $sql = 'SELECT SBKurumID, SBKurumAdi FROM sbkurum Where SBBolgeID IN (' . $array . ') ORDER BY SBKurumAdi ASC';
        return($this->db->select($sql));
    }

    //duyuru kurum Veli
    public function duyuruKurumVeli($array = array()) {
        $sql = 'SELECT DISTINCT BSVeliID, BSVeliAd FROM bsvelikurum Where BSKurumID IN (' . $array . ') ORDER BY BSVeliAd ASC';
        return($this->db->select($sql));
    }

    //duyuru kurum Öğrenci
    public function duyuruKurumOgrenci($array = array()) {
        $sql = 'SELECT DISTINCT BSOgrenciID, BSOgrenciAd FROM bsogrencikurum Where BSKurumID IN (' . $array . ') ORDER BY BSOgrenciAd ASC';
        return($this->db->select($sql));
    }

    //duyuru kurum İşçi
    public function duyuruKurumIsci($array = array()) {
        $sql = 'SELECT DISTINCT SBIsciID, SBIsciAd FROM sbiscikurum Where SBKurumID IN (' . $array . ') ORDER BY SBIsciAd ASC';
        return($this->db->select($sql));
    }

    //duyuru tur listesi
    public function duyuruTurMultiSelect($array = array()) {
        $sql = 'SELECT SBTurID, SBTurAd FROM sbtur Where SBKurumID IN (' . $array . ') ORDER BY SBTurAd ASC';
        return($this->db->select($sql));
    }

    //admin duyuru save
    public function addAdminDuyuru($data) {
        return ($this->db->multiInsert('bsadminduyuru', $data));
    }

    //sofor duyuru save
    public function addSoforDuyuru($data) {
        return ($this->db->multiInsert('bssoforduyuru', $data));
    }

    //hostes duyuru save
    public function addHostesDuyuru($data) {
        return ($this->db->multiInsert('bshostesduyuru', $data));
    }

    //veli duyuru save
    public function addVeliDuyuru($data) {
        return ($this->db->multiInsert('bsveliduyuru', $data));
    }

    //öğrenci duyuru save
    public function addOgrenciDuyuru($data) {
        return ($this->db->multiInsert('bsogrenciduyuru', $data));
    }

    //işçi duyuru save
    public function addIsciDuyuru($data) {
        return ($this->db->multiInsert('sbisciduyuru', $data));
    }

}

?>
