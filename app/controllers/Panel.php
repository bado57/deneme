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
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $form = $this->load->multilanguage($lang);
            $deger = $form->multilanguage();
        } else {
            $form = $this->load->multilanguage(Session::get("dil"));
            $deger = $form->multilanguage();
        }

        if ($loginTip == 1) {
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");

            $adminRutbe = Session::get("userRutbe");
            $adminID = Session::get("userId");
            //super adminse tüm bölgeleri görür
            if ($adminRutbe != 0) {

                $bolgeListe = $Panel_Model->bolgeListele();
                $kurumListe = $Panel_Model->kurumListeleCount();
                $aracListe = $Panel_Model->aracListeleCount();
                $turListe = $Panel_Model->turListeleCount();
                $lokasyonListe = $Panel_Model->lokasyonListeleCount();
                $adminCount["AdminCount"] = $Panel_Model->adminCountListele($adminID);
                $adminCount["SoforCount"] = $Panel_Model->soforCountListele();
                $adminCount["IsciCount"] = $Panel_Model->isciCountListele();
                $adminCount["VeliCount"] = $Panel_Model->veliCountListele();
                $adminCount["OgrenciCount"] = $Panel_Model->ogrenciCountListele();
                $adminBolge['AdminKullanici'] = $adminCount["AdminCount"][0]['COUNT(*)'] + $adminCount["SoforCount"][0]['COUNT(*)'] + $adminCount["IsciCount"][0]['COUNT(*)'] + $adminCount["VeliCount"][0]['COUNT(*)'] + $adminCount["OgrenciCount"][0]['COUNT(*)'];

                $adminBolge['AdminBolge'] = count($bolgeListe);
                $adminBolge['AdminKurum'] = count($kurumListe);
                $adminBolge['AdminArac'] = count($aracListe);
                $adminBolge['AdminTur'] = count($turListe);
                $adminBolge['AdminLokasyon'] = count($lokasyonListe);
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

                $bolgeListe = $Panel_Model->rutbeBolgeListele($rutbebolgedizi);
                $kurumListe = $Panel_Model->rutbeKurumCount($rutbebolgedizi);
                $turListe = $Panel_Model->rutbeTurCount($rutbebolgedizi);
                $adminCount["SoforCount"] = $Panel_Model->rutbeSoforCount($rutbebolgedizi);
                $adminCount["IsciCount"] = $Panel_Model->rutbeIsciCount($rutbebolgedizi);
                $adminCount["VeliCount"] = $Panel_Model->rutbeVeliCount($rutbebolgedizi);
                $adminCount["OgrenciCount"] = $Panel_Model->rutbeOgrenciCount($rutbebolgedizi);
                $adminBolge['AdminKullanici'] = $adminCount["SoforCount"][0]['COUNT(BSSoforID)'] + $adminCount["IsciCount"][0]['COUNT(SBIsciID)'] + $adminCount["VeliCount"][0]['COUNT(BSVeliID)'] + $adminCount["OgrenciCount"][0]['COUNT(BSOgrenciID)'];

                $adminBolge['AdminBolge'] = count($bolgeListe);
                $adminBolge['AdminKurum'] = count($kurumListe);
                $adminBolge['AdminArac'] = count($aracIDListe);
                $adminBolge['AdminTur'] = count($turListe);
                $adminBolge['AdminLokasyon'] = count($lokasyonListe);
            }

            $this->load->view("Template_AdminBackEnd/header", $deger);
            $this->load->view("Template_AdminBackEnd/left", $deger);
            $this->load->view("Template_AdminBackEnd/home", $deger, $adminBolge);
            $this->load->view("Template_AdminBackEnd/footer", $deger);
        } else {
            //$this->load->view("Entry/loginForm");
        }
    }

}
?>

