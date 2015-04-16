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
            header("Location:" . SITE_URL_LOGOUT);
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
                    error_log($key . "--->" . $new_array['Firmasshkey'][$a]);
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
            $uniqueKey = $uniqueKey . '_AArac';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $adminArac = $resultMemcache;
            } else {
                //super adminse tüm kurumları görür
                if ($adminRutbe != 0) {

                    //aktif olan tur araçları
                    $aracListe = $Panel_Model->aracListele();
                    $b = 0;
                    foreach ($aracListe as $arac) {
                        $adminArac[$b]['AdminAracID'] = $arac['SBAracID'];
                        $adminArac[$b]['AdminAracPlaka'] = $arac['SBAracPlaka'];
                        $adminArac[$b]['AdminAracMarka'] = $arac['SBAracMarka'];
                        $adminArac[$b]['AdminAracYil'] = $arac['SBAracModelYili'];
                        $adminArac[$b]['AdminAracKapasite'] = $arac['SBAracKapasite'];
                        $adminArac[$b]['AdminAracKm'] = $arac['SBAracKm'];
                        $adminArac[$b]['AdminAracDurum'] = $arac['SBAracDurum'];
                        $b++;
                    }
                } else {//değilse admin ıd ye göre kurum görür
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);
                    //bölge idler
                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);
                    //böle araç ıdler
                    $aracIDListe = $Panel_Model->rutbearacIDListele($rutbebolgedizi);

                    foreach ($aracIDListe as $ID) {
                        $aracID[] = $ID['SBAracID'];
                    }
                    $rutbearacdizi = implode(',', $aracID);

                    $aracListe = $Panel_Model->aracRutbeListele($rutbearacdizi);
                    $aracListeCount = count($aracListe);

                    $b = 0;
                    foreach ($aracListe as $arac) {
                        $adminArac[$b]['AdminAracID'] = $arac['SBAracID'];
                        $adminArac[$b]['AdminAracPlaka'] = $arac['SBAracPlaka'];
                        $adminArac[$b]['AdminAracMarka'] = $arac['SBAracMarka'];
                        $adminArac[$b]['AdminAracYil'] = $arac['SBAracModelYili'];
                        $adminArac[$b]['AdminAracKapasite'] = $arac['SBAracKapasite'];
                        $adminArac[$b]['AdminAracKm'] = $arac['SBAracKm'];
                        $adminArac[$b]['AdminAracDurum'] = $arac['SBAracDurum'];
                        $b++;
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $adminArac, false, 10);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/aracliste", $languagedeger, $adminArac);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
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
                $adminBolge = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $bolgeListe = $Panel_Model->bolgeListele();
                    //bölge count için
                    if (count($bolgeListe) != 0) {
                        $adminBolge[0]['AdminBolgeCount'] = count($bolgeListe);
                    }

                    $b = 0;
                    foreach ($bolgeListe as $bolge) {
                        $adminBolge[$b]['AdminBolge'] = $bolge['SBBolgeAdi'];
                        $adminBolge[$b]['AdminBolgeID'] = $bolge['SBBolgeID'];
                        $adminBolge[$b]['AdminBolgeAciklama'] = $bolge['SBBolgeAciklama'];
                        $bolgeId[] = $bolge['SBBolgeID'];
                        $b++;
                    }
                } else {//değilse admin ıd ye göre bölge görür
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $bolgeListe = $Panel_Model->rutbeBolgeListele($rutbebolgedizi);
                    //bölge count için
                    if (count($bolgeListe) != 0) {
                        $adminBolge[0]['AdminBolgeCount'] = count($bolgeListe);
                    }

                    $b = 0;
                    foreach ($bolgeListe as $bolge) {
                        $adminBolge[$b]['AdminBolge'] = $bolge['SBBolgeAdi'];
                        $adminBolge[$b]['AdminBolgeID'] = $bolge['SBBolgeID'];
                        $adminBolge[$b]['AdminBolgeAciklama'] = $bolge['SBBolgeAciklama'];
                        $bolgeId[] = $bolge['SBBolgeID'];
                        $b++;
                    }
                }

                $bolgekurumSayi[] = $Panel_Model->bolgeKurum_Count($bolgeId);
                $bolgeListeCount = count($bolgeListe);
                for ($a = 0; $a < $bolgeListeCount; $a++) {
                    $sonuc = $formSession->array_deger_filtreleme($bolgekurumSayi[0], 'SBBolgeID', $bolgeListe[$a]['SBBolgeID']);
                    $adminBolge[$a]['AdminKurum'] = count($sonuc);
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $adminBolge, false, 60);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/bolgeliste", $languagedeger, $adminBolge);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function kurumliste() {
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
            $uniqueKey = $uniqueKey . '_AKurum';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $adminKurum = $resultMemcache;
            } else {
                //super adminse tüm kurumları görür
                if ($adminRutbe != 0) {

                    $kurumListe = $Panel_Model->kurumListele();
                    //kurum count
                    $adminKurum[0]['AdminKurumCount'] = count($kurumListe);
                    //kurum bilgileri
                    $a = 0;
                    foreach ($kurumListe as $kurum) {
                        $adminKurum[$a]['AdminKurum'] = $kurum['SBKurumAdi'];
                        $adminKurum[$a]['AdminKurumID'] = $kurum['SBKurumID'];
                        $adminKurum[$a]['AdminKurumAciklama'] = $kurum['SBKurumAciklama'];
                        $adminKurum[$a]['AdminKurumBolge'] = $kurum['SBBolgeAdi'];
                        $adminKurum[$a]['AdminKurumBolgeID'] = $kurum['SBBolgeID'];
                        $kurumID[] = $kurum['SBKurumID'];
                        $a++;
                    }

                    //kurum tur işlemleri
                    $kurumTurSayi[] = $Panel_Model->kurumTur_Count($kurumID);
                    $kurumTurCount = count($kurumListe);
                    for ($b = 0; $b < $kurumTurCount; $b++) {
                        $sonuc = $formSession->array_deger_filtreleme($kurumTurSayi[0], 'SBKurumID', $kurumListe[$b]['SBKurumID']);
                        $adminKurum[$b]['AdminKurumTur'] = count($sonuc);
                    }
                } else {//değilse admin ıd ye göre kurum görür
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    for ($r = 0; $r < count($bolgeListeRutbe); $r++) {
                        $bolgerutbeId[] = $bolgeListeRutbe[$r]['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $bolgeKurumListe = $Panel_Model->rutbeKurumBolgeListele($rutbebolgedizi);
                    //bölge count için
                    $adminKurum[0]['AdminKurumCount'] = count($bolgeKurumListe);

                    $a = 0;
                    foreach ($bolgeKurumListe as $kurum) {
                        $adminKurum[$a]['AdminKurum'] = $kurum[$a]['SBKurumAdi'];
                        $adminKurum[$a]['AdminKurumID'] = $kurum[$a]['SBKurumID'];
                        $adminKurum[$a]['AdminKurumAciklama'] = $kurum[$a]['SBKurumAciklama'];
                        $adminKurum[$a]['AdminKurumBolge'] = $kurum[$a]['SBBolgeAdi'];
                        $adminKurum[$a]['AdminKurumBolgeID'] = $kurum[$a]['SBBolgeID'];
                        $kurumID[] = $kurum[$a]['SBKurumID'];
                        $a++;
                    }

                    //kurum tur işlemleri
                    $kurumTurSayi[] = $Panel_Model->kurumTur_Count($kurumID);
                    $kurumTurCount = $adminKurum[0]['AdminKurumCount'];
                    for ($b = 0; $b < $kurumTurCount; $b++) {
                        $sonuc = $formSession->array_deger_filtreleme($kurumTurSayi[0], 'SBKurumID', $bolgeKurumListe[$b]['SBKurumID']);
                        $adminKurum[$b]['AdminKurumTur'] = count($sonuc);
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $adminKurum, false, 60);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/kurumliste", $languagedeger, $adminKurum);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}

?>