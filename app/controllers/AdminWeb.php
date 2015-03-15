<?php

class AdminWeb extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->firmislem();
    }

    //daha önce login oldu ise
    function firmislem() {

        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("login") == true && Session::get("sessionkey") == $sessionKey) {
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $language = Session::get("dil");
            $formlanguage = $this->load->multilanguage($language);
            $languagedeger = $formlanguage->multilanguage();



            $firmaKod = Session::get("BSfirmaKodu");
            $firmaKod = $firmaKod . '_AFirma';

            $resultMemcache = $MemcacheModel->get($firmaKod);
            if ($resultMemcache) {
                error_log("burada simdi");
                $sonuc["FirmaOzellikler"] = $resultMemcache;
            } else {
                $AdminId = Session::get("userId");

                $data["AdminFirmaID"] = $Panel_Model->adminFirmaID($AdminId);

                $data["FirmaOzellikler"] = $Panel_Model->firmaOzellikler($data["AdminFirmaID"][0]["BSFirmaID"]);

                $returnModelData = $data['FirmaOzellikler'][0];

                $a = 0;
                foreach ($returnModelData as $key => $value) {
                    $new_array['Firmasshkey'][$a] = md5(sha1(md5($key)));
                    $a++;
                }
                $returnFormdata['FirmaOzellikler'] = $form->newKeys($data['FirmaOzellikler'][0], $new_array['Firmasshkey']);

                $result = $MemcacheModel->set($firmaKod, $returnFormdata['FirmaOzellikler'], false, 10);

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

        if (Session::get("login") == true && Session::get("sessionkey") == $sessionKey) {
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

        if (Session::get("login") == true && Session::get("sessionkey") == $sessionKey) {
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");


            $language = Session::get("dil");
            //lanuage Kontrol
            $formLanguage = $this->load->multilanguage($language);
            $languagedeger = $formLanguage->multilanguage();


            $firmaID = Session::get("BSfirmaID");
            $adminRutbe = Session::get("userRutbe");
            $adminID = Session::get("userId");
            $firmaKod = Session::get("BSfirmaKodu");
            $firmaKod = $firmaKod . '_ABolge' . $adminID;



            $resultMemcache = $MemcacheModel->get($firmaKod);
            if ($resultMemcache) {
                $adminBolge = $resultMemcache;
            } else {
                //super adminse tüm böleleri görür
                if ($adminRutbe != 0) {

                    $bolgeListe = $Panel_Model->bolgeListele($firmaID);

                    for ($a = 0; $a < count($bolgeListe); $a++) {
                        $adminBolge[$a]['AdminBolge'] = $bolgeListe[$a]['SBBolgeAdi'];
                        $adminBolge[$a]['AdminBolgeID'] = $bolgeListe[$a]['SBBolgeID'];
                        $bolgeId[] = $bolgeListe[$a]['SBBolgeID'];
                    }
                } else {//değilse admin ıd ye göre bölge görür
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);
                    //echo count($bolgeListeRutbe);

                    for ($r = 0; $r < count($bolgeListeRutbe); $r++) {
                        $bolgerutbeId[] = $bolgeListeRutbe[$r]['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $bolgeListe = $Panel_Model->rutbeBolgeListele($rutbebolgedizi, $firmaID);

                    for ($a = 0; $a < count($bolgeListe); $a++) {
                        $adminBolge[$a]['AdminBolge'] = $bolgeListe[$a]['SBBolgeAdi'];
                        $adminBolge[$a]['AdminBolgeID'] = $bolgeListe[$a]['SBBolgeID'];
                        $bolgeId[] = $bolgeListe[$a]['SBBolgeID'];
                    }
                }

                $bolgekurumSayi[] = $Panel_Model->bolgeKurum_Count($bolgeId, $firmaID);

                for ($b = 0; $b < count($bolgeListe); $b++) {
                    $sonuc = $formSession->array_deger_filtreleme($bolgekurumSayi[0], 'SBBolgeID', $bolgeListe[$b]['SBBolgeID']);
                    $adminBolge[$b]['AdminKurum'] = count($sonuc);
                }

                $bolgearacSayi[] = $Panel_Model->bolgeArac_Count($bolgeId, $firmaID);

                for ($c = 0; $c < count($bolgeListe); $c++) {
                    $sonuc = $formSession->array_deger_filtreleme($bolgearacSayi[0], 'SBBolgeID', $bolgeListe[$c]['SBBolgeID']);
                    $adminBolge[$c]['AdminArac'] = count($sonuc);
                }

                $bolgeogrenciSayi[] = $Panel_Model->bolgeOgrenci_Count($bolgeId, $firmaID);

                for ($d = 0; $d < count($bolgeListe); $d++) {
                    $sonuc = $formSession->array_deger_filtreleme($bolgeogrenciSayi[0], 'BSBolgeID', $bolgeListe[$d]['SBBolgeID']);
                    $adminBolge[$d]['AdminOgrenci'] = count($sonuc);
                }

                $bolgeisciSayi[] = $Panel_Model->bolgeIsci_Count($bolgeId, $firmaID);

                for ($e = 0; $e < count($bolgeListe); $e++) {
                    $sonuc = $formSession->array_deger_filtreleme($bolgeisciSayi[0], 'SBBolgeID', $bolgeListe[$e]['SBBolgeID']);
                    $adminBolge[$e]['AdminIsci'] = count($sonuc);
                }

                //memcache kayıt
                $result = $MemcacheModel->set($firmaKod, $adminBolge, false, 120);
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