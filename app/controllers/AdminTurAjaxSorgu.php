<?php

class AdminTurAjaxSorgu extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->adminAjaxSorgu();
    }

    public function adminAjaxSorgu() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest" && Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey && Session::get("selectFirmaDurum") != 0) {
            $sonuc = array();
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

                case "turBolgeEkleSelect":
                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            $bolgeListe = $Panel_Model->turBolgeListele();

                            $turbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$turbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$turbolge] = $bolgelist['SBBolgeID'];
                                $turbolge++;
                            }
                        } else {//değilse admin ıd ye göre bölge görür
                            $bolgeListeRutbe = $Panel_Model->adminTurBolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);


                            $bolgeListe = $Panel_Model->turRutbeBolgeListele($rutbebolgedizi);

                            $kurumbolge = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$kurumbolge] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$kurumbolge] = $bolgelist['SBBolgeID'];
                                $kurumbolge++;
                            }
                        }

                        $sonuc["adminTurBolge"] = $adminBolge['AdminBolge'];
                        $sonuc["adminTurBolgee"] = $adminBolge['AdminBolgeID'];
                    }
                    break;

                case "turKurumSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("turBolgeID", true);
                        $turBolgeID = $form->values['turBolgeID'];

                        $kurumListe = $Panel_Model->turKurumSelect($turBolgeID);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $turKurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $turKurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $turKurumSelect['KurumSelectTip'][$a] = $kurumListee['SBKurumTip'];
                            $turKurumSelect['KurumSelectLokasyon'][$a] = $kurumListee['SBKurumLokasyon'];
                            $a++;
                        }
                        $sonuc["kurumSelect"] = $turKurumSelect;
                    }
                    break;

                case "turAracSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("turBolgeID", true);
                        $form->post("turKurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $turBolgeID = $form->values['turBolgeID'];
                        $turKurumID = $form->values['turKurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turGunler = $_REQUEST['turGunID'];
                        $gunSaatSql = $form->sqlGunSaat($turBolgeID, $turSaat1ID, $turSaat2ID, $turGunler);
                        $turAracListe = $Panel_Model->turAracSelect($gunSaatSql);

                        $a = 0;
                        foreach ($turAracListe as $turAracListee) {
                            $turAktifAracId[] = $turAracListee['BSTurAracID'];
                            $a++;
                        }

                        $turBolgeAracListe = $Panel_Model->turBolgeAracListele($turBolgeID);

                        if (count($turBolgeAracListe) > 0) {
                            //bölgede araç varsa
                            $b = 0;
                            foreach ($turBolgeAracListe as $turBolgeAracListee) {
                                $turBolgeArac[] = $turBolgeAracListee['SBAracID'];
                                $b++;
                            }

                            if (count($turAracListe) > 0) {//aktif araç varsa
                                $bolgePasifArac = array_diff($turBolgeArac, $turAktifAracId);
                                $pasifArac = implode(',', $bolgePasifArac);
                                //bölgedeki pasif araçlar
                                $turPasifAracListe = $Panel_Model->turBolgePasifAracListele($pasifArac);
                                $c = 0;
                                foreach ($turPasifAracListe as $turPasifAracListee) {
                                    $turArac[$c]['turAracID'] = $turPasifAracListee['SBAracID'];
                                    $turArac[$c]['turAracPlaka'] = $turPasifAracListee['SBAracPlaka'];
                                    $turArac[$c]['turAracKapasite'] = $turPasifAracListee['SBAracKapasite'];
                                    $c++;
                                }
                            } else {//aktif araç yoksa
                                $pasifArac = implode(',', $turBolgeArac);
                                $turPasifAracListe = $Panel_Model->turBolgePasifAracListele($pasifArac);
                                $c = 0;
                                foreach ($turPasifAracListe as $turPasifAracListee) {
                                    $turArac[$c]['turAracID'] = $turPasifAracListee['SBAracID'];
                                    $turArac[$c]['turAracPlaka'] = $turPasifAracListee['SBAracPlaka'];
                                    $turArac[$c]['turAracKapasite'] = $turPasifAracListee['SBAracKapasite'];
                                    $c++;
                                }
                            }
                        }
                        $sonuc["pasifArac"] = $turArac;
                    }
                    break;

                case "turSoforSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("turBolgeID", true);
                        $form->post("turKurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $form->post("aracID", true);
                        $turBolgeID = $form->values['turBolgeID'];
                        $turKurumID = $form->values['turKurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turAracID = $form->values['aracID'];
                        $turGunler = $_REQUEST['turGunID'];

                        $gunSaatSoforSql = $form->sqlGunSaatSofor($turBolgeID, $turAracID, $turSaat1ID, $turSaat2ID, $turGunler);

                        $turSoforListe = $Panel_Model->turSoforSelect($gunSaatSoforSql);

                        $a = 0;
                        foreach ($turSoforListe as $turSoforListee) {
                            $turAktifSoforId[] = $turSoforListee['BSTurSoforID'];
                            $a++;
                        }

                        $turAracSoforListe = $Panel_Model->turAracSoforListele($turAracID);

                        if (count($turAracSoforListe) > 0) {
                            //araça ait şoför varsa
                            $b = 0;
                            foreach ($turAracSoforListe as $turAracSoforListee) {
                                $turAracSofor[] = $turAracSoforListee['BSSoforID'];
                                $b++;
                            }

                            if (count($turSoforListe) > 0) {//aktif şoför varsa
                                $bolgePasifSofor = array_diff($turAracSofor, $turAktifSoforId);
                                if (count($bolgePasifSofor) > 0) {//aracın birden fazla şoförü varsa
                                    $pasifSofor = implode(',', $bolgePasifSofor);
                                    //bölgedeki pasif şoförler
                                    $turPasifSoforListe = $Panel_Model->turAracPasifSoforListele($pasifSofor);
                                    $c = 0;
                                    foreach ($turPasifSoforListe as $turPasifSoforListee) {
                                        $turSofor[$c]['turSoforID'] = $turPasifSoforListee['BSSoforID'];
                                        $turSofor[$c]['turSoforAd'] = $turPasifSoforListee['BSSoforAd'];
                                        $turSofor[$c]['turSoforSoyad'] = $turPasifSoforListee['BSSoforSoyad'];
                                        $turSofor[$c]['turSoforLocation'] = $turPasifSoforListee['BSSoforLocation'];
                                        $c++;
                                    }
                                }
                            } else {//aktif şoför yoksa
                                $pasifSofor = implode(',', $turAracSofor);
                                $turPasifSoforListe = $Panel_Model->turAracPasifSoforListele($pasifSofor);
                                $c = 0;
                                foreach ($turPasifSoforListe as $turPasifSoforListee) {
                                    $turSofor[$c]['turSoforID'] = $turPasifSoforListee['BSSoforID'];
                                    $turSofor[$c]['turSoforAd'] = $turPasifSoforListee['BSSoforAd'];
                                    $turSofor[$c]['turSoforSoyad'] = $turPasifSoforListee['BSSoforSoyad'];
                                    $turSofor[$c]['turSoforLocation'] = $turPasifSoforListee['BSSoforLocation'];
                                    $c++;
                                }
                            }
                        }
                        $sonuc["pasifSofor"] = $turSofor;
                    }
                    break;

                case "turKurumSelectKisi":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("turKurumID", true);
                        $form->post("turKurumTip", true);
                        $turKurumID = $form->values['turKurumID'];
                        $turKurumTip = $form->values['turKurumTip'];

                        if ($turKurumTip == 0) {//Öğrenci
                            $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                            $a = 0;
                            foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                $a++;
                            }
                            //herhangi bir tura kayıtlı öğrenciler
                            $kurumTurAitOgrenci = $Panel_Model->turKurumAitOgrenci($turKurumID);
                            $f = 0;
                            foreach ($kurumTurAitOgrenci as $kurumTurAitOgrencii) {
                                $turKurumAitOgrenci[] = $kurumTurAitOgrencii['BSOgrenciID'];
                                $f++;
                            }
                            $turKurumNotTurOgrenci = array_diff($turKurumOgrenci, $turKurumAitOgrenci);

                            $kurumOgrenci = implode(',', $turKurumNotTurOgrenci);
                            $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                            $b = 0;
                            foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                $turOKisi[$b]['turOKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                $turOKisi[$b]['turOKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                $turOKisi[$b]['turOKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                $turOKisi[$b]['turOKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                $b++;
                            }
                        } else if ($turKurumTip == 1) {//işçi
                            $kurumIsciListe = $Panel_Model->turKurumIsci($turKurumID);
                            $a = 0;
                            foreach ($kurumIsciListe as $kurumIsciListee) {
                                $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                                $a++;
                            }
                            //herhangi bir tura kayıtlı işçiler
                            $kurumTurAitIsci = $Panel_Model->turKurumAitIsci($turKurumID);
                            $f = 0;
                            foreach ($kurumTurAitIsci as $kurumTurAitIscii) {
                                $turKurumAitIsci[] = $kurumTurAitIscii['SBIsciID'];
                                $f++;
                            }
                            $turKurumNotTurIsci = array_diff($turKurumIsci, $turKurumAitIsci);
                            $kurumIsci = implode(',', $turKurumNotTurIsci);
                            $kurumIsciListesi = $Panel_Model->turKurumIscii($kurumIsci);
                            $b = 0;
                            foreach ($kurumIsciListesi as $kurumIsciListesii) {
                                $turPKisi[$b]['turPKisiID'] = $kurumIsciListesii['SBIsciID'];
                                $turPKisi[$b]['turPKisiAd'] = $kurumIsciListesii['SBIsciAd'];
                                $turPKisi[$b]['turPKisiSoyad'] = $kurumIsciListesii['SBIsciSoyad'];
                                $turPKisi[$b]['turPKisiLocation'] = $kurumIsciListesii['SBIsciLocation'];
                                $b++;
                            }
                        } else {//hem öğrenci hem de personel
                            $kurumIsciListe = $Panel_Model->turKurumIsci($turKurumID);
                            if (count($kurumIsciListe) > 0) {//hem öğrenci hem de personel
                                $a = 0;
                                foreach ($kurumIsciListe as $kurumIsciListee) {
                                    $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                                    $a++;
                                }
                                //herhangi bir tura kayıtlı işçiler
                                $kurumTurAitPersonel = $Panel_Model->turKurumAitPersonel($turKurumID);
                                $f = 0;
                                foreach ($kurumTurAitPersonel as $kurumTurAitPersonell) {
                                    $turKurumAitPersonel[] = $kurumTurAitPersonell['BSOgrenciIsciID'];
                                    $f++;
                                }
                                $turKurumNotTurPersonel = array_diff($turKurumIsci, $turKurumAitPersonel);

                                $kurumIsci = implode(',', $turKurumNotTurPersonel);
                                $kurumIsciListesi = $Panel_Model->turKurumIscii($kurumIsci);
                                $b = 0;
                                foreach ($kurumIsciListesi as $kurumIsciListesii) {
                                    $turPKisi[$b]['turPKisiID'] = $kurumIsciListesii['SBIsciID'];
                                    $turPKisi[$b]['turPKisiAd'] = $kurumIsciListesii['SBIsciAd'];
                                    $turPKisi[$b]['turPKisiSoyad'] = $kurumIsciListesii['SBIsciSoyad'];
                                    $turPKisi[$b]['turPKisiLocation'] = $kurumIsciListesii['SBIsciLocation'];
                                    $b++;
                                }

                                $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                                $c = 0;
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                    $c++;
                                }

                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                $g = 0;
                                foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                    $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
                                    $g++;
                                }
                                $turKurumNotTurOgrenciler = array_diff($turKurumOgrenci, $turKurumAitOgrenciler);

                                $kurumOgrenci = implode(',', $turKurumNotTurOgrenciler);
                                $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                                $d = 0;
                                foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                    $turOKisi[$d]['turOKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                    $turOKisi[$d]['turOKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                    $turOKisi[$d]['turOKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                    $turOKisi[$d]['turOKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                    $d++;
                                }
                            } else {//sadece öğrenci
                                $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                                $c = 0;
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                    $c++;
                                }
                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                $g = 0;
                                foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                    $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
                                    $g++;
                                }
                                $turKurumNotTurOgrenciler = array_diff($turKurumOgrenci, $turKurumAitOgrenciler);

                                $kurumOgrenci = implode(',', $turKurumNotTurOgrenciler);
                                $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                                $d = 0;
                                foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                    $turOKisi[$d]['turOKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                    $turOKisi[$d]['turOKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                    $turOKisi[$d]['turOKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                    $turOKisi[$d]['turOKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                    $d++;
                                }
                            }
                        }

                        $sonuc["kurumOKisi"] = $turOKisi;
                        $sonuc["kurumPKisi"] = $turPKisi;
                    }
                    break;

                case "turKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $form->post("turSaat1", true);
                        $form->post("turSaat2", true);
                        $form->post("aracID", true);
                        $form->post("aracPlaka", true);
                        $form->post("soforID", true);
                        $form->post("soforAd", true);
                        $form->post("turTip", true);
                        $form->post("turID", true);
                        $form->post("turGidis", true);
                        $form->post("turDonus", true);
                        $form->post("kurumTip", true);
                        $form->post("bolgeID", true);
                        $form->post("bolgead", true);
                        $form->post("turAdi", true);
                        $form->post("turAciklama", true);
                        $form->post("kurumad", true);
                        $form->post("kurumId", true);
                        $form->post("kurumLocation", true);
                        $bolgeID = $form->values['bolgeID'];
                        $bolgeAd = $form->values['bolgead'];
                        $kurumID = $form->values['kurumId'];
                        $kurumAd = $form->values['kurumad'];
                        $kurumLocation = $form->values['kurumLocation'];
                        $turGidis = $form->values['turGidis'];
                        $turDonus = $form->values['turDonus'];
                        $turAdi = $form->values['turAdi'];
                        $turAciklama = $form->values['turAciklama'];
                        $turSaat1 = $form->values['turSaat1'];
                        $turSaat2 = $form->values['turSaat2'];
                        $turAracID = $form->values['aracID'];
                        $turAracPlaka = $form->values['aracPlaka'];
                        $turSoforID = $form->values['soforID'];
                        $turSoforAd = $form->values['soforAd'];
                        $kurumTip = $form->values['kurumTip'];
                        $turTip = $form->values['turTip'];
                        $turID = $form->values['turID'];
                        $turGunler = $_REQUEST['turGun'];
                        $turOgrenciID = $_REQUEST['turOgrenciID'];
                        $turOgrenciAd = $_REQUEST['turOgrenciAd'];
                        $turOgrenciLocation = $_REQUEST['turOgrenciLocation'];
                        $turIsciID = $_REQUEST['turKisiIsciID'];
                        $turIsciAd = $_REQUEST['turKisiIsciAd'];
                        $turIsciLocation = $_REQUEST['turKisiIsciLocation'];
                        $turGunReturn = $form->sqlGunInsert($turGunler);
                        if ($turID) {//girilen tur daha önce eklendi ise
                            if ($turGidis != '') {//gidiş kayıt olmuş dönüşü kaydedeceğiz
                                //tur tablosundaki dönüşü 0 dan 1 yapacağız
                                $turDonusUpdate = array(
                                    'SBTurDonus' => 1
                                );
                                $resultTurUpdate = $Panel_Model->turTipDuzenle($turDonusUpdate, $turID);

                                if ($form->submit()) {
                                    $data = array(
                                        'BSTurID' => $turID,
                                        'BSTurTip' => $kurumTip,
                                        'BSTurBolgeID' => $bolgeID,
                                        'BSTurBolgeAd' => $bolgeAd,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 1,
                                    );
                                    $turDatam = array_merge($data, $turGunReturn);
                                }
                                $turDonusID = $Panel_Model->addNewTurTip($turDatam);

                                if ($kurumTip == 0) {//öğrenci
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurAciklama' => $turAciklama,
                                            'BSOgrenciID' => $turOgrenciID[$o],
                                            'BSOgrenciAd' => $turOgrenciAd[$o],
                                            'BSOgrenciLocation' => $turOgrenciLocation[$o],
                                            'BSKurumID' => $kurumID,
                                            'BSKurumAd' => $kurumAd,
                                            'BSKurumLocation' => $kurumLocation,
                                            'BSBolgeID' => $bolgeID,
                                            'BSBolgeAd' => $bolgeAd,
                                            'BSTurGidis' => 0,
                                            'BSTurDonus' => 1,
                                            'BSTurTip' => $turDonusID,
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci[$o]);
                                } else if ($kurumTip == 1) {//işçi
                                    for ($i = 0; $i < count($turIsciID); $i++) {
                                        $dataIsci[$i] = array(
                                            'SBTurID' => $turID,
                                            'SBTurAd' => $turAdi,
                                            'SBTurAciklama' => $turAciklama,
                                            'SBIsciID' => $turIsciID[$i],
                                            'SBIsciAd' => $turIsciAd[$i],
                                            'SBIsciLocation' => $turIsciLocation[$i],
                                            'SBKurumID' => $kurumID,
                                            'SBKurumAd' => $kurumAd,
                                            'SBKurumLocation' => $kurumLocation,
                                            'SBBolgeID' => $bolgeID,
                                            'SBBolgeAd' => $bolgeAd,
                                            'SBTurGidis' => 0,
                                            'SBTurDonus' => 1,
                                            'SBTurTip' => $turDonusID,
                                        );
                                        $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurID' => $turID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 0,
                                                'BSOgrenciIsciID' => $turOgrenciID[$o],
                                                'BSOgrenciIsciAd' => $turOgrenciAd[$o],
                                                'BSOgrenciIsciLocation' => $turOgrenciLocation[$o],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 0,
                                                'BSTurDonus' => 1,
                                                'BSTurTip' => $turDonusID,
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataOgrenci);
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'BSTurID' => $turID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 1,
                                                'BSOgrenciIsciID' => $turIsciID[$i],
                                                'BSOgrenciIsciAd' => $turIsciAd[$i],
                                                'BSOgrenciIsciLocation' => $turIsciLocation[$i],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 0,
                                                'BSTurDonus' => 1,
                                                'BSTurTip' => $turDonusID,
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataIsci);
                                    }
                                }

                                $sonuc["turDonus"] = 1;
                            } else {//dönüş kayıt olmuş gidişi kaydedeceğiz
                                //tur tablosundaki dönüşü 0 dan 1 yapacağız
                                $turGidisUpdate = array(
                                    'SBTurGidis' => 1
                                );
                                $resultTurUpdate = $Panel_Model->turTipDuzenle($turGidisUpdate, $turID);

                                if ($form->submit()) {
                                    $data = array(
                                        'BSTurID' => $turID,
                                        'BSTurTip' => $kurumTip,
                                        'BSTurBolgeID' => $bolgeID,
                                        'BSTurBolgeAd' => $bolgeAd,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 0,
                                    );
                                    $turDatam = array_merge($data, $turGunReturn);
                                }
                                $turGidisID = $Panel_Model->addNewTurTip($turDatam);

                                if ($kurumTip == 0) {//öğrenci
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurAciklama' => $turAciklama,
                                            'BSOgrenciID' => $turOgrenciID[$o],
                                            'BSOgrenciAd' => $turOgrenciAd[$o],
                                            'BSOgrenciLocation' => $turOgrenciLocation[$o],
                                            'BSKurumID' => $kurumID,
                                            'BSKurumAd' => $kurumAd,
                                            'BSKurumLocation' => $kurumLocation,
                                            'BSBolgeID' => $bolgeID,
                                            'BSBolgeAd' => $bolgeAd,
                                            'BSTurGidis' => 1,
                                            'BSTurDonus' => 0,
                                            'BSTurTip' => $turGidisID,
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci);
                                } else if ($kurumTip == 1) {//işçi
                                    for ($i = 0; $i < count($turIsciID); $i++) {
                                        $dataIsci[$i] = array(
                                            'SBTurID' => $turID,
                                            'SBTurAd' => $turAdi,
                                            'SBTurAciklama' => $turAciklama,
                                            'SBIsciID' => $turIsciID[$i],
                                            'SBIsciAd' => $turIsciAd[$i],
                                            'SBIsciLocation' => $turIsciLocation[$i],
                                            'SBKurumID' => $kurumID,
                                            'SBKurumAd' => $kurumAd,
                                            'SBKurumLocation' => $kurumLocation,
                                            'SBBolgeID' => $bolgeID,
                                            'SBBolgeAd' => $bolgeAd,
                                            'SBTurGidis' => 1,
                                            'SBTurDonus' => 0,
                                            'SBTurTip' => $turGidisID,
                                        );
                                        $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurID' => $turID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 0,
                                                'BSOgrenciIsciID' => $turOgrenciID[$o],
                                                'BSOgrenciIsciAd' => $turOgrenciAd[$o],
                                                'BSOgrenciIsciLocation' => $turOgrenciLocation[$o],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 1,
                                                'BSTurDonus' => 0,
                                                'BSTurTip' => $turGidisID,
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataOgrenci);
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'BSTurID' => $turID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 1,
                                                'BSOgrenciIsciID' => $turIsciID[$i],
                                                'BSOgrenciIsciAd' => $turIsciAd[$i],
                                                'BSOgrenciIsciLocation' => $turIsciLocation[$i],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 1,
                                                'BSTurDonus' => 0,
                                                'BSTurTip' => $turGidisID,
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataIsci);
                                    }
                                }
                                $sonuc["turGidis"] = 1;
                            }
                        } else {//tur eklenmedi ise
                            if ($turTip == 0) {//Gidiş
                                if ($form->submit()) {
                                    $data = array(
                                        'SBTurAd' => $turAdi,
                                        'SBTurAciklama' => $turAciklama,
                                        'SBTurAktiflik' => 0,
                                        'SBKurumID' => $kurumID,
                                        'SBKurumAd' => $kurumAd,
                                        'SBKurumTip' => $kurumTip,
                                        'SBKurumLocation' => $kurumLocation,
                                        'SBBolgeID' => $bolgeID,
                                        'SBBolgeAd' => $bolgeAd,
                                        'SBTurGidis' => 1,
                                        'SBTurDonus' => 0,
                                        'SBTurTip' => $kurumTip,
                                    );
                                    $turData = array_merge($data, $turGunReturn);
                                }
                                $resultTurID = $Panel_Model->addNewTur($turData);

                                if ($form->submit()) {
                                    $dataGidis = array(
                                        'BSTurID' => $resultTurID,
                                        'BSTurTip' => $kurumTip,
                                        'BSTurBolgeID' => $bolgeID,
                                        'BSTurBolgeAd' => $bolgeAd,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 0,
                                    );
                                    $turDatam = array_merge($dataGidis, $turGunReturn);
                                }
                                $turGidisID = $Panel_Model->addNewTurTip($turDatam);
                                if ($kurumTip == 0) {//öğrenci
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurID' => $resultTurID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurAciklama' => $turAciklama,
                                            'BSOgrenciID' => $turOgrenciID[$o],
                                            'BSOgrenciAd' => $turOgrenciAd[$o],
                                            'BSOgrenciLocation' => $turOgrenciLocation[$o],
                                            'BSKurumID' => $kurumID,
                                            'BSKurumAd' => $kurumAd,
                                            'BSKurumLocation' => $kurumLocation,
                                            'BSBolgeID' => $bolgeID,
                                            'BSBolgeAd' => $bolgeAd,
                                            'BSTurGidis' => 1,
                                            'BSTurDonus' => 0,
                                            'BSTurTip' => $turGidisID,
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci);
                                } else if ($kurumTip == 1) {//işçi
                                    for ($i = 0; $i < count($turIsciID); $i++) {
                                        $dataIsci[$i] = array(
                                            'SBTurID' => $resultTurID,
                                            'SBTurAd' => $turAdi,
                                            'SBTurAciklama' => $turAciklama,
                                            'SBIsciID' => $turIsciID[$i],
                                            'SBIsciAd' => $turIsciAd[$i],
                                            'SBIsciLocation' => $turIsciLocation[$i],
                                            'SBKurumID' => $kurumID,
                                            'SBKurumAd' => $kurumAd,
                                            'SBKurumLocation' => $kurumLocation,
                                            'SBBolgeID' => $bolgeID,
                                            'SBBolgeAd' => $bolgeAd,
                                            'SBTurGidis' => 1,
                                            'SBTurDonus' => 0,
                                            'SBTurTip' => $turGidisID,
                                        );
                                        $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurID' => $resultTurID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 0,
                                                'BSOgrenciIsciID' => $turOgrenciID[$o],
                                                'BSOgrenciIsciAd' => $turOgrenciAd[$o],
                                                'BSOgrenciIsciLocation' => $turOgrenciLocation[$o],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 1,
                                                'BSTurDonus' => 0,
                                                'BSTurTip' => $turGidisID,
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataOgrenci);
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'BSTurID' => $resultTurID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 1,
                                                'BSOgrenciIsciID' => $turIsciID[$i],
                                                'BSOgrenciIsciAd' => $turIsciAd[$i],
                                                'BSOgrenciIsciLocation' => $turIsciLocation[$i],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 1,
                                                'BSTurDonus' => 0,
                                                'BSTurTip' => $turGidisID,
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataIsci);
                                    }
                                }

                                $sonuc["turGidis"] = 1;
                            } else {//Dönüş
                                if ($form->submit()) {
                                    $dataIlkDonus = array(
                                        'SBTurAd' => $turAdi,
                                        'SBTurAciklama' => $turAciklama,
                                        'SBTurAktiflik' => 0,
                                        'SBKurumID' => $kurumID,
                                        'SBKurumAd' => $kurumAd,
                                        'SBKurumTip' => $kurumTip,
                                        'SBKurumLocation' => $kurumLocation,
                                        'SBBolgeID' => $bolgeID,
                                        'SBBolgeAd' => $bolgeAd,
                                        'SBTurGidis' => 0,
                                        'SBTurDonus' => 1,
                                        'SBTurTip' => $kurumTip
                                    );
                                    $turIlkDonusData = array_merge($dataIlkDonus, $turGunReturn);
                                }
                                $resultTurID = $Panel_Model->addNewTur($turIlkDonusData);

                                if ($form->submit()) {
                                    $dataDonus = array(
                                        'BSTurID' => $resultTurID,
                                        'BSTurTip' => $kurumTip,
                                        'BSTurBolgeID' => $bolgeID,
                                        'BSTurBolgeAd' => $bolgeAd,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 1,
                                    );
                                    $turDatam = array_merge($dataDonus, $turGunReturn);
                                }

                                $turDonusID = $Panel_Model->addNewTurTip($turDatam);

                                if ($kurumTip == 0) {//öğrenci
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurID' => $resultTurID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurAciklama' => $turAciklama,
                                            'BSOgrenciID' => $turOgrenciID[$o],
                                            'BSOgrenciAd' => $turOgrenciAd[$o],
                                            'BSOgrenciLocation' => $turOgrenciLocation[$o],
                                            'BSKurumID' => $kurumID,
                                            'BSKurumAd' => $kurumAd,
                                            'BSKurumLocation' => $kurumLocation,
                                            'BSBolgeID' => $bolgeID,
                                            'BSBolgeAd' => $bolgeAd,
                                            'BSTurGidis' => 0,
                                            'BSTurDonus' => 1,
                                            'BSTurTip' => $turDonusID,
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci);
                                } else if ($kurumTip == 1) {//işçi
                                    for ($o = 0; $o < count($turIsciID); $o++) {
                                        $dataIsci[$o] = array(
                                            'SBTurID' => $resultTurID,
                                            'SBTurAd' => $turAdi,
                                            'SBTurAciklama' => $turAciklama,
                                            'SBIsciID' => $turIsciID[$o],
                                            'SBIsciAd' => $turIsciAd[$o],
                                            'SBIsciLocation' => $turIsciLocation[$o],
                                            'SBKurumID' => $kurumID,
                                            'SBKurumAd' => $kurumAd,
                                            'SBKurumLocation' => $kurumLocation,
                                            'SBBolgeID' => $bolgeID,
                                            'SBBolgeAd' => $bolgeAd,
                                            'SBTurGidis' => 0,
                                            'SBTurDonus' => 1,
                                            'SBTurTip' => $turDonusID,
                                        );
                                        $turDataIsci[$o] = array_merge($dataIsci[$o], $turGunReturn);
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurID' => $resultTurID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 0,
                                                'BSOgrenciIsciID' => $turOgrenciID[$o],
                                                'BSOgrenciIsciAd' => $turOgrenciAd[$o],
                                                'BSOgrenciIsciLocation' => $turOgrenciLocation[$o],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 0,
                                                'BSTurDonus' => 1,
                                                'BSTurTip' => $turDonusID,
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataOgrenci);
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'BSTurID' => $resultTurID,
                                                'BSTurAd' => $turAdi,
                                                'BSTurAciklama' => $turAciklama,
                                                'BSKullaniciTip' => 1,
                                                'BSOgrenciIsciID' => $turIsciID[$i],
                                                'BSOgrenciIsciAd' => $turIsciAd[$i],
                                                'BSOgrenciIsciLocation' => $turIsciLocation[$i],
                                                'BSKurumID' => $kurumID,
                                                'BSKurumAd' => $kurumAd,
                                                'BSKurumLocation' => $kurumLocation,
                                                'BSBolgeID' => $bolgeID,
                                                'BSBolgeAd' => $bolgeAd,
                                                'BSTurGidis' => 0,
                                                'BSTurDonus' => 1,
                                                'BSTurTip' => $turDonusID,
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataIsci);
                                    }
                                }

                                $sonuc["turDonus"] = 1;
                            }
                        }
                        if ($resultTurID) {
                            $sonuc["turID"] = $resultTurID;
                        } else {
                            $sonuc["turID"] = $turID;
                        }
                    }
                    break;

                default :
                    header("Location:" . SITE_URL_LOGOUT);
                    break;
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}
?>

