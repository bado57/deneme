<?php

class Panel extends Controller {

    public function __construct() {

        parent::__construct();
        //oturum kontrolü
        Session::checkSession();
    }

    public function index() {
        $this->login();
    }

    //daha önce login oldu ise
    function login() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {
            $this->home();
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    public function home() {

        $loginTip = Session::get("userTip");
        if (!Session::get("dil")) {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            Session::set("dil", $lang);
            $form = $this->load->multilanguage($lang);
            $deger = $form->multilanguage();
        } else {
            $form = $this->load->multilanguage(Session::get("dil"));
            $deger = $form->multilanguage();
        }

        if ($loginTip == 1) {
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("AdminMemcache_Model");

            $adminID = Session::get("userId");
            $uniqueBidirimKey = Session::get("userFirmaKod");
            $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
            $resultMemcache = $MemcacheModel->get($uniqueBidirimKey);
            if ($resultMemcache != false) {
                $bildirimAyar = $resultMemcache;
            } else {
                //model bağlantısı
                $resultBildirim = $Panel_Model->adminBildirimAyar($adminID);
                foreach ($resultBildirim as $resultBildirimm) {
                    $adminBildirim[] = $resultBildirimm['BSAyarTip'];
                }
                $MemcacheModel->set($uniqueBidirimKey, $adminBildirim, false, 3600);
                $bildirimAyar = $resultMemcache;
            }
            $adminRutbe = Session::get("userRutbe");
            //super adminse tüm bölgeleri görür
            if ($adminRutbe != 0) {
                $bolgeListe = $Panel_Model->bolgeListeCount();
                $kurumListe = $Panel_Model->kurumListeleCount();
                $aracListe = $Panel_Model->aracListeleCount();
                $turListe = $Panel_Model->turListeleCount();
                $lokasyonListe = $Panel_Model->lokasyonListeleCount();
                $adminCount["AdminDuyuru"] = $Panel_Model->duyuruCountListele($adminID);
                $adminCount["AdminCount"] = $Panel_Model->adminCountListele($adminID);
                $adminCount["SoforCount"] = $Panel_Model->soforCountListele();
                $adminCount["HostesCount"] = $Panel_Model->hostesCountListele();
                $adminCount["IsciCount"] = $Panel_Model->isciCountListele();
                $adminCount["VeliCount"] = $Panel_Model->veliCountListele();
                $adminCount["OgrenciCount"] = $Panel_Model->ogrenciCountListele();
                $adminBolge['AdminKullanici'] = $adminCount["AdminCount"][0]['COUNT(*)'] + $adminCount["SoforCount"][0]['COUNT(*)'] + $adminCount["HostesCount"][0]['COUNT(*)'] + $adminCount["IsciCount"][0]['COUNT(*)'] + $adminCount["VeliCount"][0]['COUNT(*)'] + $adminCount["OgrenciCount"][0]['COUNT(*)'];
                $sumOgr = $Panel_Model->ogrenciOdemeTotal();
                $sumIsci = $Panel_Model->isciOdemeTotal();
                $adminBolge['AdminParaTotal'] = $sumOgr[0]['COUNT(*)'] + $sumIsci[0]['COUNT(*)'];
                $adminBolge['AdminDuyuru'] = $adminCount["AdminDuyuru"][0]['COUNT(*)'];
                $adminBolge['AdminBolge'] = $bolgeListe[0]['COUNT(*)'];
                $adminBolge['AdminKurum'] = $kurumListe[0]['COUNT(*)'];
                $adminBolge['AdminArac'] = $aracListe[0]['COUNT(*)'];
                $adminBolge['AdminTur'] = $turListe[0]['COUNT(*)'];
                $adminBolge['AdminLokasyon'] = $lokasyonListe[0]['COUNT(*)'];
            } else {//değilse admin ıd ye göre bölge görür
                $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                foreach ($bolgeListeRutbe as $rutbe) {
                    $bolgerutbeId[] = $rutbe['BSBolgeID'];
                }

                $rutbebolgedizi = implode(',', $bolgerutbeId);

                //bölge araç idler
                $aracIDListe = $Panel_Model->rutbearacIDListele($rutbebolgedizi);
                //aktif lokasyonlar için
                foreach ($aracIDListe as $aracIDListee) {
                    $aracAktifId[] = $aracIDListee['SBAracID'];
                }
                $aracaktifdizi = implode(',', $aracAktifId);
                $lokasyonListe = $Panel_Model->rutbeAracLokasyonCount($aracaktifdizi);

                $bolgeListe = $Panel_Model->rutbeBolgeCount($rutbebolgedizi);
                $kurumListe = $Panel_Model->rutbeKurumCount($rutbebolgedizi);
                $turListe = $Panel_Model->rutbeTurCount($rutbebolgedizi);
                $adminCount["AdminDuyuru"] = $Panel_Model->duyuruCountListele($adminID);
                $adminCount["SoforCount"] = $Panel_Model->rutbeSoforCount($rutbebolgedizi);
                $adminCount["HostesCount"] = $Panel_Model->rutbeHostesCount($rutbebolgedizi);
                $adminCount["IsciCount"] = $Panel_Model->rutbeIsciCount($rutbebolgedizi);
                $adminCount["VeliCount"] = $Panel_Model->rutbeVeliCount($rutbebolgedizi);
                $adminCount["OgrenciCount"] = $Panel_Model->rutbeOgrenciCount($rutbebolgedizi);
                $adminBolge['AdminKullanici'] = $adminCount["SoforCount"][0]['COUNT(BSSoforID)'] + $adminCount["HostesCount"][0]['COUNT(BSHostesID)'] + $adminCount["IsciCount"][0]['COUNT(SBIsciID)'] + $adminCount["VeliCount"][0]['COUNT(BSVeliID)'] + $adminCount["OgrenciCount"][0]['COUNT(BSOgrenciID)'];
                $sumOgr = $Panel_Model->rutbeOgrenciOdemeTot($adminID);
                $sumIsci = $Panel_Model->rutbeIsciOdemeTot($adminID);
                $adminBolge['AdminParaTotal'] = $sumOgr[0]['COUNT(*)'] + $sumIsci[0]['COUNT(*)'];
                $adminBolge['AdminDuyuru'] = $adminCount["AdminDuyuru"][0]['COUNT(*)'];
                $adminBolge['AdminBolge'] = $bolgeListe[0]['COUNT(*)'];
                $adminBolge['AdminKurum'] = $kurumListe[0]['COUNT(*)'];
                $adminBolge['AdminArac'] = count($aracIDListe);
                $adminBolge['AdminTur'] = $turListe[0]['COUNT(*)'];
                $adminBolge['AdminLokasyon'] = $lokasyonListe[0]['COUNT(*)'];
            }

            $this->load->view("Template_AdminBackEnd/header", $deger);
            $this->load->view("Template_AdminBackEnd/left", $deger);
            $this->load->view("Template_AdminBackEnd/home", $deger, $adminBolge);
            $this->load->view("Template_AdminBackEnd/footer", $deger);
        } else {
            $form->yonlendir(SITE_URL_LOGOUT);
        }
    }

}
?>

