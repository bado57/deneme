<?php

class AdminWeb extends Controller {

    public function __construct() {
        parent::__construct();
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
            $this->firmislem();
        } else {
            header("Location:" . SITE_URL_HOME);
        }
    }

    //daha önce login oldu ise
    function firmislem() {

        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {

            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $formDbConfig->configDb();

            $language = Session::get("dil");
            $formlanguage = $this->load->multilanguage($language);
            $languagedeger = $formlanguage->multilanguage();



            $uniqueKey = Session::get("userFirmaKod");
            $uniqueKey = $uniqueKey . '_AFirma';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $sonuc["FirmaOzellikler"] = $resultMemcache;
            } else {
                $data["FirmaOzellikler"] = $Panel_Model->firmaOzellikler();
                $returnModelData = $data['FirmaOzellikler'][0];

                $a = 0;
                foreach ($returnModelData as $key => $value) {
                    $new_array['Firmasshkey'][$a] = md5(sha1(md5($key)));
                    $a++;
                }
                $returnFormdata['FirmaOzellikler'] = $form->newKeys($data['FirmaOzellikler'][0], $new_array['Firmasshkey']);

                $result = $MemcacheModel->set($uniqueKey, $returnFormdata['FirmaOzellikler'], false, 10);

                $sonuc["FirmaOzellikler"] = $returnFormdata['FirmaOzellikler'];
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/firmaislem", $languagedeger, $sonuc["FirmaOzellikler"]);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function aracliste() {

        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {
            $language = Session::get("dil");
            $form = $this->load->multilanguage($language);
            $Panel_Model = $this->load->model("panel_model");
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $deger = $form->multilanguage();



            $this->load->view("Template_AdminBackEnd/header", $deger);
            $this->load->view("Template_AdminBackEnd/left", $deger);
            $this->load->view("Template_AdminBackEnd/aracliste", $deger);
            $this->load->view("Template_AdminBackEnd/footer", $deger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function bolgeliste() {
        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        //sessionKontrol
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");


            $language = Session::get("dil");
            //lanuage Kontrol
            $formLanguage = $this->load->multilanguage($language);
            $languagedeger = $formLanguage->multilanguage();


            $adminRutbe = Session::get("userRutbe");
            $adminID = Session::get("userId");
            $uniqueKey = Session::get("username");
            $uniqueKey = $uniqueKey . '_ABolge';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                error_log("son" . $uniqueKey);
                $adminBolge = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $bolgeListe = $Panel_Model->bolgeListele();
                    //bölge count için
                    $adminBolge[0]['AdminBolgeCount'] = count($bolgeListe);

                    for ($a = 0; $a < count($bolgeListe); $a++) {
                        $adminBolge[$a]['AdminBolge'] = $bolgeListe[$a]['SBBolgeAdi'];
                        $adminBolge[$a]['AdminBolgeID'] = $bolgeListe[$a]['SBBolgeID'];
                        $adminBolge[$a]['AdminBolgeAciklama'] = $bolgeListe[$a]['SBBolgeAciklama'];
                        $bolgeId[] = $bolgeListe[$a]['SBBolgeID'];
                    }
                } else {//değilse admin ıd ye göre bölge görür
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);
                    //echo count($bolgeListeRutbe);

                    for ($r = 0; $r < count($bolgeListeRutbe); $r++) {
                        $bolgerutbeId[] = $bolgeListeRutbe[$r]['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $bolgeListe = $Panel_Model->rutbeBolgeListele($rutbebolgedizi);
                    //bölge count için
                    $adminBolge[0]['AdminBolgeCount'] = count($bolgeListe);

                    for ($a = 0; $a < count($bolgeListe); $a++) {
                        $adminBolge[$a]['AdminBolge'] = $bolgeListe[$a]['SBBolgeAdi'];
                        $adminBolge[$a]['AdminBolgeID'] = $bolgeListe[$a]['SBBolgeID'];
                        $bolgeId[] = $bolgeListe[$a]['SBBolgeID'];
                    }
                }

                $bolgekurumSayi[] = $Panel_Model->bolgeKurum_Count($bolgeId);

                for ($b = 0; $b < count($bolgeListe); $b++) {
                    $sonuc = $formSession->array_deger_filtreleme($bolgekurumSayi[0], 'SBBolgeID', $bolgeListe[$b]['SBBolgeID']);
                    $adminBolge[$b]['AdminKurum'] = count($sonuc);
                }
                error_log("Web" . $uniqueKey);
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $adminBolge, false, 60);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/bolgeliste", $languagedeger, $adminBolge);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

}

?>