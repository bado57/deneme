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
            $uniqueKey = Session::get("userFirmaKod");
            $uniqueKey = $uniqueKey . '_APanel' . $adminID;

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $adminBolge = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $bolgeListe = $Panel_Model->bolgeListele();
                    $kurumListe = $Panel_Model->kurumListeleCount();
                    $aracListe = $Panel_Model->aracListeleCount();

                    $adminBolge['AdminBolge'] = count($bolgeListe);
                    $adminBolge['AdminKurum'] = count($kurumListe);
                    $adminBolge['AdminArac'] = count($aracListe);
                } else {//değilse admin ıd ye göre bölge görür
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }

                    $rutbebolgedizi = implode(',', $bolgerutbeId);

                    //bölge araç idler
                    $aracIDListe = $Panel_Model->rutbearacIDListele($rutbebolgedizi);


                    $bolgeListe = $Panel_Model->rutbeBolgeListele($rutbebolgedizi);
                    $kurumListe = $Panel_Model->rutbeKurumCount($rutbebolgedizi);

                    $adminBolge['AdminBolge'] = count($bolgeListe);
                    $adminBolge['AdminKurum'] = count($kurumListe);
                    $adminBolge['AdminArac'] = count($aracIDListe);
                }

                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $adminBolge, false, 60);
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

