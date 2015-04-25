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

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
            $this->firmislem();
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function firmislem() {

        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {

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

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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
                    if (count($aracListe) != 0) {
                        $adminArac[0]['AdminAracCount'] = count($aracListe);
                    }

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

                    //bölge araç ıdler
                    $aracIDListe = $Panel_Model->rutbearacIDListele($rutbebolgedizi);

                    foreach ($aracIDListe as $ID) {
                        $aracID[] = $ID['SBAracID'];
                    }
                    $rutbearacdizi = implode(',', $aracID);

                    $aracListe = $Panel_Model->aracRutbeListele($rutbearacdizi);

                    $b = 0;
                    foreach ($aracListe as $arac) {
                        $adminArac[$b]['AdminAracID'] = $arac['SBAracID'];
                        $adminArac[$b]['AdminAracPlaka'] = $arac['SBAracPlaka'];
                        $adminArac[$b]['AdminAracMarka'] = $arac['SBAracMarka'];
                        $adminArac[$b]['AdminAracYil'] = $arac['SBAracModelYili'];
                        $adminArac[$b]['AdminAracKapasite'] = $arac['SBAracKapasite'];
                        $adminArac[$b]['AdminAracKm'] = $arac['SBAracKm'];
                        $adminArac[$b]['AdminAracDurum'] = $arac['SBAracDurum'];
                        $rutbeAracId[] = $arac['SBAracID'];
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

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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

    function kullaniciListe() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {

            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $formDbConfig->configDb();

            $language = Session::get("dil");
            $formlanguage = $this->load->multilanguage($language);
            $languagedeger = $formlanguage->multilanguage();


            $adminRutbe = Session::get("userRutbe");
            $adminID = Session::get("userId");

            //super adminse kendi hariç diğer adminleri görür
            if ($adminRutbe != 0) {
                $adminCount = $Panel_Model->adminCountListele($adminID);
                $adminCount["SoforCount"] = $Panel_Model->soforCountListele();
                $adminCount["IsciCount"] = $Panel_Model->isciCountListele();
                $adminCount["VeliCount"] = $Panel_Model->veliCountListele();
                $adminCount["SoforCount"] = $adminCount["SoforCount"][0]['COUNT(*)'];
                $adminCount["IsciCount"] = $adminCount["IsciCount"][0]['COUNT(*)'];
                $adminCount["VeliCount"] = $adminCount["VeliCount"][0]['COUNT(*)'];
            } else {
                $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                foreach ($bolgeListeRutbe as $rutbe) {
                    $bolgerutbeId[] = $rutbe['BSBolgeID'];
                }
                $rutbebolgedizi = implode(',', $bolgerutbeId);


                $adminCount["SoforCount"] = $Panel_Model->rutbeSoforCount($rutbebolgedizi);
                $adminCount["IsciCount"] = $Panel_Model->rutbeIsciCount($rutbebolgedizi);
                $adminCount["VeliCount"] = $Panel_Model->rutbeVeliCount($rutbebolgedizi);
                $adminCount["SoforCount"] = $adminCount["SoforCount"][0]['COUNT(BSSoforID)'];
                $adminCount["IsciCount"] = $adminCount["IsciCount"][0]['COUNT(SBIsciID)'];
                $adminCount["VeliCount"] = $adminCount["VeliCount"][0]['COUNT(BSVeliID)'];
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/kullaniciliste", $languagedeger, $adminCount);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function adminliste() {
        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        //sessionKontrol
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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
            $uniqueKey = $uniqueKey . '_AAdmin';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $adminliste = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $adminListe = $Panel_Model->adminListele($adminID);
                    //bölge count için
                    if (count($adminListe) != 0) {
                        $adminliste[0]['AdminCount'] = count($adminListe);
                    }

                    $a = 0;
                    foreach ($adminListe as $adminListee) {
                        $adminliste[$a]['AdminID'] = $adminListee['BSAdminID'];
                        $adminliste[$a]['AdminAdi'] = $adminListee['BSAdminAd'];
                        $adminliste[$a]['AdminSoyad'] = $adminListee['BSAdminSoyad'];
                        $adminliste[$a]['AdminTelefon'] = $adminListee['BSAdminPhone'];
                        $adminliste[$a]['AdminEmail'] = $adminListee['BSAdminEmail'];
                        $adminliste[$a]['AdminAciklama'] = $adminListee['BSAdminAciklama'];
                        $adminliste[$a]['AdminDurum'] = $adminListee['Status'];
                        $a++;
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $adminliste, false, 5);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/adminliste", $languagedeger, $adminliste);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function soforliste() {
        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        //sessionKontrol
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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
            $uniqueKey = $uniqueKey . '_ASofor';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $soforliste = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $soforListe = $Panel_Model->soforListele();
                    //bölge count için
                    if (count($soforListe) != 0) {
                        $soforliste[0]['SoforCount'] = count($soforListe);
                    }

                    $a = 0;
                    foreach ($soforListe as $soforListee) {
                        $soforliste[$a]['SoforID'] = $soforListee['BSSoforID'];
                        $soforliste[$a]['SoforAdi'] = $soforListee['BSSoforAd'];
                        $soforliste[$a]['SoforSoyad'] = $soforListee['BSSoforSoyad'];
                        $soforliste[$a]['SoforTelefon'] = $soforListee['BSSoforPhone'];
                        $soforliste[$a]['SoforEmail'] = $soforListee['BSSoforEmail'];
                        $soforliste[$a]['SoforAciklama'] = $soforListee['BSSoforAciklama'];
                        $soforliste[$a]['SoforDurum'] = $soforListee['Status'];
                        $a++;
                    }
                } else {
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $soforBolgeListe = $Panel_Model->soforBolgeListele($rutbebolgedizi);
                    foreach ($soforBolgeListe as $soforBolgeListee) {
                        $soforrutbeId[] = $soforBolgeListee['BSSoforID'];
                    }
                    $rutbesofordizi = implode(',', $soforrutbeId);

                    $soforListe = $Panel_Model->rutbeSoforListele($rutbesofordizi);
                    //bölge count için
                    if (count($soforListe) != 0) {
                        $soforliste[0]['SoforCount'] = count($soforListe);
                    }

                    $a = 0;
                    foreach ($soforListe as $soforListee) {
                        $soforliste[$a]['SoforID'] = $soforListee['BSSoforID'];
                        $soforliste[$a]['SoforAdi'] = $soforListee['BSSoforAd'];
                        $soforliste[$a]['SoforSoyad'] = $soforListee['BSSoforSoyad'];
                        $soforliste[$a]['SoforTelefon'] = $soforListee['BSSoforPhone'];
                        $soforliste[$a]['SoforEmail'] = $soforListee['BSSoforEmail'];
                        $soforliste[$a]['SoforAciklama'] = $soforListee['BSSoforAciklama'];
                        $soforliste[$a]['SoforDurum'] = $soforListee['Status'];
                        $a++;
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $soforliste, false, 5);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/soforliste", $languagedeger, $soforliste);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function isciliste() {
        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        //sessionKontrol
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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
            $uniqueKey = $uniqueKey . '_AIsci';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $iscilist = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $isciliste = $Panel_Model->isciListele();
                    //bölge count için
                    if (count($isciliste) != 0) {
                        $iscilist[0]['IsciCount'] = count($isciliste);
                    }

                    $a = 0;
                    foreach ($isciliste as $iscilistee) {
                        $iscilist[$a]['IsciID'] = $iscilistee['SBIsciID'];
                        $iscilist[$a]['IsciAdi'] = $iscilistee['SBIsciAd'];
                        $iscilist[$a]['IsciSoyad'] = $iscilistee['SBIsciSoyad'];
                        $iscilist[$a]['IsciTelefon'] = $iscilistee['SBIsciPhone'];
                        $iscilist[$a]['IsciEmail'] = $iscilistee['SBIsciEmail'];
                        $iscilist[$a]['IsciAciklama'] = $iscilistee['SBIsciAciklama'];
                        $iscilist[$a]['IsciDurum'] = $iscilistee['Status'];
                        $a++;
                    }
                } else {
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $isciBolgeListe = $Panel_Model->isciBolgeListele($rutbebolgedizi);
                    foreach ($isciBolgeListe as $isciBolgeListe) {
                        $iscirutbeId[] = $isciBolgeListe['SBIsciID'];
                    }
                    $rutbeiscidizi = implode(',', $iscirutbeId);

                    $isciliste = $Panel_Model->rutbeIsciListele($rutbeiscidizi);
                    //bölge count için
                    if (count($isciliste) != 0) {
                        $iscilist[0]['IsciCount'] = count($isciliste);
                    }

                    $a = 0;
                    foreach ($isciliste as $iscilistee) {
                        $iscilist[$a]['IsciID'] = $iscilistee['SBIsciID'];
                        $iscilist[$a]['IsciAdi'] = $iscilistee['SBIsciAd'];
                        $iscilist[$a]['IsciSoyad'] = $iscilistee['SBIsciSoyad'];
                        $iscilist[$a]['IsciTelefon'] = $iscilistee['SBIsciPhone'];
                        $iscilist[$a]['IsciEmail'] = $iscilistee['SBIsciEmail'];
                        $iscilist[$a]['IsciAciklama'] = $iscilistee['SBIsciAciklama'];
                        $iscilist[$a]['IsciDurum'] = $iscilistee['Status'];
                        $a++;
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $iscilist, false, 5);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/isciliste", $languagedeger, $iscilist);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function veliliste() {
        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        //sessionKontrol
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
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
            $uniqueKey = $uniqueKey . '_AVeli';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $velilist = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $veliliste = $Panel_Model->veliListele();
                    //bölge count için
                    if (count($veliliste) != 0) {
                        $velilist[0]['VeliCount'] = count($veliliste);
                    }

                    $a = 0;
                    foreach ($veliliste as $velilistee) {
                        $velilist[$a]['VeliID'] = $velilistee['SBVeliID'];
                        $velilist[$a]['VeliAdi'] = $velilistee['SBVeliAd'];
                        $velilist[$a]['VeliSoyad'] = $velilistee['SBVeliSoyad'];
                        $velilist[$a]['VeliTelefon'] = $velilistee['SBVeliPhone'];
                        $velilist[$a]['VeliEmail'] = $velilistee['SBVeliEmail'];
                        $velilist[$a]['VeliAciklama'] = $velilistee['SBVeliAciklama'];
                        $velilist[$a]['VeliDurum'] = $velilistee['Status'];
                        $a++;
                    }
                } else {
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $veliBolgeListe = $Panel_Model->veliBolgeListele($rutbebolgedizi);
                    foreach ($veliBolgeListe as $veliBolgeListe) {
                        $velirutbeId[] = $veliBolgeListe['BSVeliID'];
                    }
                    $rutbevelidizi = implode(',', $velirutbeId);

                    $veliliste = $Panel_Model->rutbeVeliListele($rutbevelidizi);
                    //bölge count için
                    if (count($veliliste) != 0) {
                        $velilist[0]['VeliCount'] = count($veliliste);
                    }

                    $a = 0;
                    foreach ($veliliste as $velilistee) {
                        $velilist[$a]['VeliID'] = $velilistee['SBVeliID'];
                        $velilist[$a]['VeliAdi'] = $velilistee['SBVeliAd'];
                        $velilist[$a]['VeliSoyad'] = $velilistee['SBVeliSoyad'];
                        $velilist[$a]['VeliTelefon'] = $velilistee['SBVeliPhone'];
                        $velilist[$a]['VeliEmail'] = $velilistee['SBVeliEmail'];
                        $velilist[$a]['VeliAciklama'] = $velilistee['SBVeliAciklama'];
                        $velilist[$a]['VeliDurum'] = $velilistee['Status'];
                        $a++;
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $velilist, false, 5);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/veliliste", $languagedeger, $velilist);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}

?>