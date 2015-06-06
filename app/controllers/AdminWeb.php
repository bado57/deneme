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
                        $adminKurum[$a]['AdminKurumTip'] = $kurum['SBKurumTip'];
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
                        $adminKurum[$a]['AdminKurumTip'] = $kurum['SBKurumTip'];
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
                $adminCount["HostesCount"] = $Panel_Model->hostesCountListele();
                $adminCount["IsciCount"] = $Panel_Model->isciCountListele();
                $adminCount["VeliCount"] = $Panel_Model->veliCountListele();
                $adminCount["OgrenciCount"] = $Panel_Model->ogrenciCountListele();
                $adminCount["SoforCount"] = $adminCount["SoforCount"][0]['COUNT(*)'];
                $adminCount["HostesCount"] = $adminCount["HostesCount"][0]['COUNT(*)'];
                $adminCount["IsciCount"] = $adminCount["IsciCount"][0]['COUNT(*)'];
                $adminCount["VeliCount"] = $adminCount["VeliCount"][0]['COUNT(*)'];
                $adminCount["OgrenciCount"] = $adminCount["OgrenciCount"][0]['COUNT(*)'];
            } else {
                $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                foreach ($bolgeListeRutbe as $rutbe) {
                    $bolgerutbeId[] = $rutbe['BSBolgeID'];
                }
                $rutbebolgedizi = implode(',', $bolgerutbeId);


                $adminCount["SoforCount"] = $Panel_Model->rutbeSoforCount($rutbebolgedizi);
                $adminCount["HostesCount"] = $Panel_Model->rutbeHostesCount($rutbebolgedizi);
                $adminCount["IsciCount"] = $Panel_Model->rutbeIsciCount($rutbebolgedizi);
                $adminCount["VeliCount"] = $Panel_Model->rutbeVeliCount($rutbebolgedizi);
                $adminCount["OgrenciCount"] = $Panel_Model->rutbeOgrenciCount($rutbebolgedizi);
                $adminCount["SoforCount"] = $adminCount["SoforCount"][0]['COUNT(BSSoforID)'];
                $adminCount["HostesCount"] = $adminCount["HostesCount"][0]['COUNT(BSHostesID)'];
                $adminCount["IsciCount"] = $adminCount["IsciCount"][0]['COUNT(SBIsciID)'];
                $adminCount["VeliCount"] = $adminCount["VeliCount"][0]['COUNT(BSVeliID)'];
                $adminCount["OgrenciCount"] = $adminCount["OgrenciCount"][0]['COUNT(BSOgrenciID)'];
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

    function hostesliste() {
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
            $uniqueKey = $uniqueKey . '_AHostes';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $hostesliste = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $hostesListe = $Panel_Model->hostesListele();
                    //bölge count için
                    if (count($hostesListe) != 0) {
                        $hostesliste[0]['HostesCount'] = count($hostesListe);
                    }

                    $a = 0;
                    foreach ($hostesListe as $hostesListee) {
                        $hostesliste[$a]['HostesID'] = $hostesListee['BSHostesID'];
                        $hostesliste[$a]['HostesAdi'] = $hostesListee['BSHostesAd'];
                        $hostesliste[$a]['HostesSoyad'] = $hostesListee['BSHostesSoyad'];
                        $hostesliste[$a]['HostesTelefon'] = $hostesListee['BSHostesPhone'];
                        $hostesliste[$a]['HostesEmail'] = $hostesListee['BSHostesEmail'];
                        $hostesliste[$a]['HostesAciklama'] = $hostesListee['BSHostesAciklama'];
                        $hostesliste[$a]['HostesDurum'] = $hostesListee['Status'];
                        $a++;
                    }
                } else {
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $hostesBolgeListe = $Panel_Model->hostesBolgeListele($rutbebolgedizi);
                    foreach ($hostesBolgeListe as $hostesBolgeListee) {
                        $hostesrutbeId[] = $hostesBolgeListee['BSHostesID'];
                    }
                    $rutbehostesdizi = implode(',', $hostesrutbeId);

                    $hostesListe = $Panel_Model->rutbeHostesListele($rutbehostesdizi);
                    //bölge count için
                    if (count($hostesListe) != 0) {
                        $hostesliste[0]['HostesCount'] = count($hostesListe);
                    }

                    $a = 0;
                    foreach ($hostesListe as $hostesListee) {
                        $hostesliste[$a]['HostesID'] = $hostesListee['BSHostesID'];
                        $hostesliste[$a]['HostesAdi'] = $hostesListee['BSHostesAd'];
                        $hostesliste[$a]['HostesSoyad'] = $hostesListee['BSHostesSoyad'];
                        $hostesliste[$a]['HostesTelefon'] = $hostesListee['BSHostesPhone'];
                        $hostesliste[$a]['HostesEmail'] = $hostesListee['BSHostesEmail'];
                        $hostesliste[$a]['HostesAciklama'] = $hostesListee['BSHostesAciklama'];
                        $hostesliste[$a]['HostesDurum'] = $hostesListee['Status'];
                        $a++;
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $hostesliste, false, 5);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/hostesliste", $languagedeger, $hostesliste);
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

    function ogrenciliste() {
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
            $uniqueKey = $uniqueKey . '_AOgrenci';

            $resultMemcache = $MemcacheModel->get($uniqueKey);
            if ($resultMemcache) {
                $ogrencilist = $resultMemcache;
            } else {
                //super adminse tüm bölgeleri görür
                if ($adminRutbe != 0) {

                    $ogrenciliste = $Panel_Model->ogrenciListele();
                    //bölge count için
                    if (count($ogrenciliste) != 0) {
                        $ogrencilist[0]['OgrenciCount'] = count($ogrenciliste);
                    }

                    $a = 0;
                    foreach ($ogrenciliste as $ogrencilistee) {
                        $ogrencilist[$a]['OgrenciID'] = $ogrencilistee['BSOgrenciID'];
                        $ogrencilist[$a]['OgrenciAdi'] = $ogrencilistee['BSOgrenciAd'];
                        $ogrencilist[$a]['OgrenciSoyad'] = $ogrencilistee['BSOgrenciSoyad'];
                        $ogrencilist[$a]['OgrenciTelefon'] = $ogrencilistee['BSOgrenciPhone'];
                        $ogrencilist[$a]['OgrenciEmail'] = $ogrencilistee['BSOgrenciEmail'];
                        $ogrencilist[$a]['OgrenciAciklama'] = $ogrencilistee['BSOgrenciAciklama'];
                        $ogrencilist[$a]['OgrenciDurum'] = $ogrencilistee['Status'];
                        $a++;
                    }
                } else {
                    $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                    foreach ($bolgeListeRutbe as $rutbe) {
                        $bolgerutbeId[] = $rutbe['BSBolgeID'];
                    }
                    $rutbebolgedizi = implode(',', $bolgerutbeId);


                    $ogrenciBolgeListe = $Panel_Model->ogrenciBolgeListele($rutbebolgedizi);
                    foreach ($ogrenciBolgeListe as $ogrenciBolgeListee) {
                        $ogrencirutbeId[] = $ogrenciBolgeListee['BSOgrenciID'];
                    }
                    $rutbeogrencidizi = implode(',', $ogrencirutbeId);

                    $ogrenciliste = $Panel_Model->rutbeOgrenciListele($rutbeogrencidizi);
                    //bölge count için
                    if (count($ogrenciliste) != 0) {
                        $ogrencilist[0]['OgrenciCount'] = count($ogrenciliste);
                    }

                    $a = 0;
                    foreach ($ogrenciliste as $ogrencilistee) {
                        $ogrencilist[$a]['OgrenciID'] = $ogrencilistee['BSOgrenciID'];
                        $ogrencilist[$a]['OgrenciAdi'] = $ogrencilistee['BSOgrenciAd'];
                        $ogrencilist[$a]['OgrenciSoyad'] = $ogrencilistee['BSOgrenciSoyad'];
                        $ogrencilist[$a]['OgrenciTelefon'] = $ogrencilistee['BSOgrenciPhone'];
                        $ogrencilist[$a]['OgrenciEmail'] = $ogrencilistee['BSOgrenciEmail'];
                        $ogrencilist[$a]['OgrenciAciklama'] = $ogrencilistee['BSOgrenciAciklama'];
                        $ogrencilist[$a]['OgrenciDurum'] = $ogrencilistee['Status'];
                        $a++;
                    }
                }
                //memcache kayıt
                $result = $MemcacheModel->set($uniqueKey, $ogrencilist, false, 5);
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/ogrenciliste", $languagedeger, $ogrencilist);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function turliste() {
        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        //sessionKontrol
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");


            $language = Session::get("dil");
            //lanuage Kontrol
            $formLanguage = $this->load->multilanguage($language);
            $languagedeger = $formLanguage->multilanguage();


            $adminRutbe = Session::get("userRutbe");
            $adminID = Session::get("userId");
            //super adminse tüm turları görür
            if ($adminRutbe != 0) {

                $turListe = $Panel_Model->turListele();
                //tur count
                if (count($turListe) > 0) {
                    $adminTur[0]['AdminTurCount'] = count($turListe);

                    //tur bilgileri
                    $a = 0;
                    foreach ($turListe as $tur) {
                        $adminTur[$a]['AdminTur'] = $tur['SBTurAd'];
                        $adminTur[$a]['AdminTurID'] = $tur['SBTurID'];
                        $adminTur[$a]['AdminTurAktiflik'] = $tur['SBTurAktiflik'];
                        $adminTur[$a]['AdminTurBolgeAd'] = $tur['SBBolgeAd'];
                        $adminTur[$a]['AdminTurKurumAd'] = $tur['SBKurumAd'];
                        $adminTur[$a]['AdminTurTip'] = $tur['SBTurTip'];
                        $adminTur[$a]['AdminTurAciklama'] = $tur['SBTurAciklama'];
                        $a++;
                    }
                }
            } else {//değilse admin ıd ye göre tur görür
                $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                for ($r = 0; $r < count($bolgeListeRutbe); $r++) {
                    $bolgerutbeId[] = $bolgeListeRutbe[$r]['BSBolgeID'];
                }
                $rutbebolgedizi = implode(',', $bolgerutbeId);


                $turListe = $Panel_Model->rutbeTurBolgeListele($rutbebolgedizi);
                //tur count
                if (count($turListe) > 0) {
                    $adminTur[0]['AdminTurCount'] = count($turListe);

                    //tur bilgileri
                    $a = 0;
                    foreach ($turListe as $tur) {
                        $adminTur[$a]['AdminTur'] = $tur['SBTurAd'];
                        $adminTur[$a]['AdminTurID'] = $tur['SBTurID'];
                        $adminTur[$a]['AdminTurAktiflik'] = $tur['SBTurAktiflik'];
                        $adminTur[$a]['AdminTurBolgeAd'] = $tur['SBBolgeAd'];
                        $adminTur[$a]['AdminTurKurumAd'] = $tur['SBKurumAd'];
                        $adminTur[$a]['AdminTurTip'] = $tur['SBTurTip'];
                        $adminTur[$a]['AdminTurAciklama'] = $tur['SBTurAciklama'];
                        $a++;
                    }
                }
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/turliste", $languagedeger, $adminTur);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function lokasyonliste() {

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
            //super adminse tüm araçları görür
            if ($adminRutbe != 0) {
                //tüm  araçlar
                $aracListe = $Panel_Model->aracIDListele();
                if (count($aracListe) != 0) {
                    foreach ($aracListe as $arac) {
                        $aracId[] = $arac['BSAracID'];
                        $aracTip[] = $arac['BSAracTurTip'];
                        $aracTurID[] = $arac['BSAracTurID'];
                    }
                }

                $aracLokasyonDizi = implode(',', $aracId);
                $aracTipDizi = implode(',', $aracTip);
                $aracTurDizi = implode(',', $aracTurID);

                //tur adlar
                $aracTurAdListe = $Panel_Model->aracTurAdListele($aracTurDizi);
                $a = 0;
                foreach ($aracTurAdListe as $aracTurAdListee) {
                    $adminArac[$a]['aktifTurAd'] = $aracTurAdListee['SBTurAd'];
                    $a++;
                }

                //aktif tur araçları
                $aktifAracListe = $Panel_Model->aracAktifTurListele($aracLokasyonDizi, $aracTipDizi, $aracTurDizi);
                $b = 0;
                foreach ($aktifAracListe as $aktifAracListee) {
                    $aktifaracId[] = $aktifAracListee['BSTurAracID'];
                    $adminArac[$b]['aktifAracID'] = $aktifAracListee['BSTurAracID'];
                    $adminArac[$b]['aktifAracPlaka'] = $aktifAracListee['BSTurAracPlaka'];
                    $adminArac[$b]['aktifTurID'] = $aktifAracListee['BSTurID'];
                    $adminArac[$b]['aktifTurTip'] = $aktifAracListee['BSTurTip'];
                    $adminArac[$b]['aktifAracBolgeID'] = $aktifAracListee['BSTurBolgeID'];
                    $adminArac[$b]['aktifAracBolgeAd'] = $aktifAracListee['BSTurBolgeAd'];
                    $adminArac[$b]['aktifAracKurumID'] = $aktifAracListee['BSTurKurumID'];
                    $adminArac[$b]['aktifAracKurumAd'] = $aktifAracListee['BSTurKurumAd'];
                    $adminArac[$b]['aktifAracKurumLocation'] = $aktifAracListee['BSTurKurumLocation'];
                    $adminArac[$b]['aktifAracSoforID'] = $aktifAracListee['BSTurSoforID'];
                    $adminArac[$b]['aktifAracSoforAd'] = $aktifAracListee['BSTurSoforAd'];
                    $adminArac[$b]['aktifAracSoforLocation'] = $aktifAracListee['BSTurSoforLocation'];
                    $adminArac[$b]['aktifAracKapasite'] = $aktifAracListee['BSTurAracKapasite'];
                    $adminArac[$b]['aktifAracTurKm'] = $aktifAracListee['BSTurKm'];
                    $adminArac[$b]['aktifAracTip'] = $aktifAracListee['BSTurGidisDonus'];
                    $b++;
                }
                if (count($aktifaracId) > 0) {
                    $adminArac[0]['AdminAracCount'] = count($aktifaracId);
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

                $aracListe = $Panel_Model->aracRutbeIDListele($rutbearacdizi);
                if (count($aracListe) != 0) {
                    $adminArac[0]['AdminAracCount'] = count($aracListe);
                    foreach ($aracListe as $arac) {
                        $aracId[] = $arac['BSAracID'];
                        $aracTip[] = $arac['BSAracTurTip'];
                        $aracTurID[] = $arac['BSAracTurID'];
                    }
                }

                $aracLokasyonDizi = implode(',', $aracId);
                $aracTipDizi = implode(',', $aracTip);
                $aracTurDizi = implode(',', $aracTurID);
                //tur adlar
                $aracTurAdListe = $Panel_Model->aracTurAdListele($aracTurDizi);
                $a = 0;
                foreach ($aracTurAdListe as $aracTurAdListee) {
                    $adminArac[$a]['aktifTurAd'] = $aracTurAdListee['SBTurAd'];
                    $a++;
                }
                //aktif tur araçları
                $aktifAracListe = $Panel_Model->aracAktifTurListele($aracLokasyonDizi, $aracTipDizi, $aracTurDizi);
                $b = 0;
                foreach ($aktifAracListe as $aktifAracListee) {
                    $aktifaracId[] = $aktifAracListee['BSTurAracID'];
                    $adminArac[$b]['aktifAracID'] = $aktifAracListee['BSTurAracID'];
                    $adminArac[$b]['aktifAracPlaka'] = $aktifAracListee['BSTurAracPlaka'];
                    $adminArac[$b]['aktifArac'] = $aktifAracListee['BSTurID'];
                    $adminArac[$b]['aktifAracTip'] = $aktifAracListee['BSTurTip'];
                    $adminArac[$b]['aktifAracBolgeID'] = $aktifAracListee['BSTurBolgeID'];
                    $adminArac[$b]['aktifAracBolgeAd'] = $aktifAracListee['BSTurBolgeAd'];
                    $adminArac[$b]['aktifAracKurumID'] = $aktifAracListee['BSTurKurumID'];
                    $adminArac[$b]['aktifAracKurumAd'] = $aktifAracListee['BSTurKurumAd'];
                    $adminArac[$b]['aktifAracKurumLocation'] = $aktifAracListee['BSTurKurumLocation'];
                    $adminArac[$b]['aktifAracSoforID'] = $aktifAracListee['BSTurSoforID'];
                    $adminArac[$b]['aktifAracSoforAd'] = $aktifAracListee['BSTurSoforAd'];
                    $adminArac[$b]['aktifAracSoforLocation'] = $aktifAracListee['BSTurSoforLocation'];
                    $adminArac[$b]['aktifAracKapasite'] = $aktifAracListee['BSTurAracKapasite'];
                    $adminArac[$b]['aktifAracTurKm'] = $aktifAracListee['BSTurKm'];
                    $adminArac[$b]['aktifAracTip'] = $aktifAracListee['BSTurGidisDonus'];
                    $b++;
                }
                if (count($aktifaracId) > 0) {
                    $adminArac[0]['AdminAracCount'] = count($aktifaracId);
                }
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/lokasyonliste", $languagedeger, $adminArac);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function ayarislem() {

        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {

            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $language = Session::get("dil");
            $formlanguage = $this->load->multilanguage($language);
            $languagedeger = $formlanguage->multilanguage();

            $adminID = Session::get("userId");
            $uniqueBidirimKey = Session::get("userFirmaKod");
            $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
            $resultMemcache = $MemcacheModel->get($uniqueBidirimKey);
            if ($resultMemcache != false) {
                $bildirimAyar = $resultMemcache[0];
            } else {
                //model bağlantısı
                $resultBildirim = $Panel_Model->adminBildirimAyar($adminID);
                foreach ($resultBildirim as $resultBildirimm) {
                    $adminBildirim[] = $resultBildirimm['BSAyarTip'];
                }
                $MemcacheModel->set($uniqueBidirimKey, $adminBildirim, false, 3600);
                $bildirimAyar = $resultMemcache[0];
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/bildirimliste", $languagedeger, $bildirimAyar);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function duyuruliste() {

        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {

            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $language = Session::get("dil");
            $formlanguage = $this->load->multilanguage($language);
            $languagedeger = $formlanguage->multilanguage();



            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/duyuruliste", $languagedeger);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function tumbildirimliste() {
        //session güvenlik kontrolü
        $formSession = $this->load->otherClasses('Form');
        //sessionKontrol
        $sessionKey = $formSession->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //memcache model bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $language = Session::get("dil");
            //lanuage Kontrol
            $formLanguage = $this->load->multilanguage($language);
            $languagedeger = $formLanguage->multilanguage();

            $adminID = Session::get("userId");
            $uniqueBidirimKey = Session::get("userFirmaKod");
            $uniqueBidirimKey = $uniqueBidirimKey . '_ABildirimAyar' . $adminID;
            $resultMemcache = $MemcacheModel->get($uniqueBidirimKey);
            if ($resultMemcache != false) {
                $bildirimAyar = $resultMemcache[0];
            } else {
                //model bağlantısı
                $resultBildirim = $Panel_Model->adminBildirimAyar($adminID);
                foreach ($resultBildirim as $resultBildirimm) {
                    $adminBildirim[] = $resultBildirimm['BSAyarTip'];
                }
                $MemcacheModel->set($uniqueBidirimKey, $adminBildirim, false, 3600);
                $bildirimAyar = $resultMemcache[0];
            }

            $tumBildirim = $Panel_Model->tumbildirimListele($bildirimAyar, $adminID);
            if (count($tumBildirim) > 0) {
                $adminTumBildirim[0]['AdminBildirimCount'] = count($tumBildirim);

                //tur bilgileri
                $a = 0;
                foreach ($tumBildirim as $adminTumBildirimm) {
                    $adminTumBildirim[$a]['BildirimID'] = $adminTumBildirimm['BSAdminBildirimID'];
                    $adminTumBildirim[$a]['BildirimText'] = $adminTumBildirimm['BSBildirimText'];
                    $adminTumBildirim[$a]['BildirimIcon'] = $adminTumBildirimm['BSBildirimIcon'];
                    $adminTumBildirim[$a]['BildirimUrl'] = $adminTumBildirimm['BSBildirimUrl'];
                    $adminTumBildirim[$a]['BildirimRenk'] = $adminTumBildirimm['BSBildirimRenk'];
                    $adminTumBildirim[$a]['BildirimGonderenID'] = $adminTumBildirimm['BSGonderenID'];
                    $adminTumBildirim[$a]['BildirimGonderenAd'] = $adminTumBildirimm['BSGonderenAdSoyad'];
                    $tarih = explode(" ", $adminTumBildirimm['BSBildirimTarih']);
                    $digerTarih = explode("-", $tarih[0]);
                    $yeniTarih = $tarih[1] . '--' . $digerTarih[2] . '/' . $digerTarih[1] . '/' . $digerTarih[0];
                    $adminTumBildirim[$a]['BildirimTarih'] = $yeniTarih;
                    $a++;
                }
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/tumbildirimliste", $languagedeger, $adminTumBildirim);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

    function profil() {

        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {

            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            $adminID = Session::get("userId");

            $language = Session::get("dil");
            $formlanguage = $this->load->multilanguage($language);
            $languagedeger = $formlanguage->multilanguage();

            $adminProfil = $Panel_Model->adminProfil($adminID);

            foreach ($adminProfil as $adminProfill) {
                $adminlist['ID'] = $adminProfill['BSAdminID'];
                $adminlist['Ad'] = $adminProfill['BSAdminAd'];
                $adminlist['Soyad'] = $adminProfill['BSAdminSoyad'];
                $adminlist['Kadi'] = $adminProfill['BSAdminKadi'];
                $adminlist['Phone'] = $adminProfill['BSAdminPhone'];
                $adminlist['Email'] = $adminProfill['BSAdminEmail'];
                $adminlist['Location'] = $adminProfill['BSAdminLocation'];
                $adminlist['Ulke'] = $adminProfill['BSAdminUlke'];
                $adminlist['Il'] = $adminProfill['BSAdminIl'];
                $adminlist['Ilce'] = $adminProfill['BSAdminIlce'];
                $adminlist['Semt'] = $adminProfill['BSAdminSemt'];
                $adminlist['Mahalle'] = $adminProfill['BSAdminMahalle'];
                $adminlist['Sokak'] = $adminProfill['BSAdminSokak'];
                $adminlist['PostaKodu'] = $adminProfill['BSAdminPostaKodu'];
                $adminlist['CaddeNo'] = $adminProfill['BSAdminCaddeNo'];
                $adminlist['Adres'] = $adminProfill['BSAdminAdres'];
                $adminlist['Durum'] = $adminProfill['Status'];
                $adminlist['Aciklama'] = $adminProfill['BSAdminAciklama'];
            }

            $this->load->view("Template_AdminBackEnd/header", $languagedeger);
            $this->load->view("Template_AdminBackEnd/left", $languagedeger);
            $this->load->view("Template_AdminBackEnd/profil", $languagedeger, $adminlist);
            $this->load->view("Template_AdminBackEnd/footer", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

}

?>