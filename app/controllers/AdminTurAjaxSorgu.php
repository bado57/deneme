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
            //dil yapılandırılması

            $formm = $this->load->ajaxlanguage(Session::get("dil"));
            $deger = $formm->ajaxlanguage();
            $degerbildirim = $formm->bildirimlanguage();
            $sonuc = array();
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("AdminMemcache_Model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            $adSoyad = Session::get("kullaniciad") . ' ' . Session::get("kullanicisoyad");

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
                        $turAktifAracId = [];
                        foreach ($turAracListe as $turAracListee) {
                            $turAktifAracId[] = $turAracListee['BSTurAracID'];
                        }

                        $turBolgeAracListe = $Panel_Model->turBolgeAracListele($turBolgeID);

                        if (count($turBolgeAracListe) > 0) {
                            //bölgede araç varsa
                            $turBolgeArac = [];
                            foreach ($turBolgeAracListe as $turBolgeAracListee) {
                                $turBolgeArac[] = $turBolgeAracListee['SBAracID'];
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

                        $turAktifSoforId = [];
                        foreach ($turSoforListe as $turSoforListee) {
                            $turAktifSoforId[] = $turSoforListee['BSTurSoforID'];
                        }

                        $turAracSoforListe = $Panel_Model->turAracSoforListele($turAracID);

                        if (count($turAracSoforListe) > 0) {
                            //araça ait şoför varsa
                            $turAracSofor = [];
                            foreach ($turAracSoforListe as $turAracSoforListee) {
                                $turAracSofor[] = $turAracSoforListee['BSSoforID'];
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
                case "turHostesSelect":
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

                        $gunSaatHostesSql = $form->sqlGunSaatHostes($turBolgeID, $turAracID, $turSaat1ID, $turSaat2ID, $turGunler);

                        $turHostesListe = $Panel_Model->turHostesSelect($gunSaatHostesSql);

                        $turAktifHostesId = [];
                        foreach ($turHostesListe as $turHostesListee) {
                            $turAktifHostesId[] = $turHostesListee['BSTurHostesID'];
                        }

                        $turAracHostesListe = $Panel_Model->turAracHostesListele($turAracID);

                        if (count($turAracHostesListe) > 0) {
                            //araça ait hostes varsa
                            $turAracHostes = [];
                            foreach ($turAracHostesListe as $turAracHostesListee) {
                                $turAracHostes[] = $turAracHostesListee['BSHostesID'];
                            }

                            if (count($turHostesListe) > 0) {//aktif hostes varsa
                                $bolgePasifHostes = array_diff($turAracHostes, $turAktifHostesId);
                                if (count($bolgePasifHostes) > 0) {//aracın birden fazla hostesi varsa
                                    $pasifHostes = implode(',', $bolgePasifHostes);
                                    //bölgedeki pasif hostesler
                                    $turPasifHostesListe = $Panel_Model->turAracPasifHostesListele($pasifHostes);
                                    $c = 0;
                                    foreach ($turPasifHostesListe as $turPasifHostesListee) {
                                        $turHostes[$c]['turHostesID'] = $turPasifHostesListee['BSHostesID'];
                                        $turHostes[$c]['turHostesAd'] = $turPasifHostesListee['BSHostesAd'];
                                        $turHostes[$c]['turHostesSoyad'] = $turPasifHostesListee['BSHostesSoyad'];
                                        $turHostes[$c]['turHostesLocation'] = $turPasifHostesListee['BSHostesLocation'];
                                        $c++;
                                    }
                                }
                            } else {//aktif hostes yoksa
                                $pasifHostes = implode(',', $turAracHostes);
                                $turPasifHostesListe = $Panel_Model->turAracPasifHostesListele($pasifHostes);
                                $c = 0;
                                foreach ($turPasifHostesListe as $turPasifHostesListee) {
                                    $turHostes[$c]['turHostesID'] = $turPasifHostesListee['BSHostesID'];
                                    $turHostes[$c]['turHostesAd'] = $turPasifHostesListee['BSHostesAd'];
                                    $turHostes[$c]['turHostesSoyad'] = $turPasifHostesListee['BSHostesSoyad'];
                                    $turHostes[$c]['turHostesLocation'] = $turPasifHostesListee['BSHostesLocation'];
                                    $c++;
                                }
                            }
                        }
                        $sonuc["pasifHostes"] = $turHostes;
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
                            $turKurumOgrenci = [];
                            foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                            }
                            //herhangi bir tura kayıtlı öğrenciler
                            $kurumTurAitOgrenci = $Panel_Model->turKurumAitOgrenci($turKurumID);
                            $turKurumAitOgrenci = [];
                            foreach ($kurumTurAitOgrenci as $kurumTurAitOgrencii) {
                                $turKurumAitOgrenci[] = $kurumTurAitOgrencii['BSOgrenciID'];
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
                            $turKurumIsci = [];
                            foreach ($kurumIsciListe as $kurumIsciListee) {
                                $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                            }
                            //herhangi bir tura kayıtlı işçiler
                            $kurumTurAitIsci = $Panel_Model->turKurumAitIsci($turKurumID);
                            $turKurumAitIsci = [];
                            foreach ($kurumTurAitIsci as $kurumTurAitIscii) {
                                $turKurumAitIsci[] = $kurumTurAitIscii['SBIsciID'];
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
                                $turKurumIsci = [];
                                foreach ($kurumIsciListe as $kurumIsciListee) {
                                    $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                                }
                                //herhangi bir tura kayıtlı işçiler
                                $kurumTurAitPersonel = $Panel_Model->turKurumAitPersonel($turKurumID);
                                if (count($kurumTurAitPersonel) > 0) {
                                    $turKurumAitPersonel = [];
                                    foreach ($kurumTurAitPersonel as $kurumTurAitPersonell) {
                                        $turKurumAitPersonel[] = $kurumTurAitPersonell['BSOgrenciIsciID'];
                                    }
                                    $turKurumNotTurPersonel = array_diff($turKurumIsci, $turKurumAitPersonel);
                                    $kurumIsci = implode(',', $turKurumNotTurPersonel);
                                } else {
                                    $kurumIsci = implode(',', $turKurumIsci);
                                }

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
                                $turKurumOgrenci = [];
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                }

                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                if (count($kurumTurAitOgrenciler) > 0) {
                                    $turKurumAitOgrenciler = [];
                                    foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                        $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
                                    }
                                    $turKurumNotTurOgrenciler = array_diff($turKurumOgrenci, $turKurumAitOgrenciler);

                                    $kurumOgrenci = implode(',', $turKurumNotTurOgrenciler);
                                } else {
                                    $kurumOgrenci = implode(',', $turKurumOgrenci);
                                }

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
                                $turKurumOgrenci = [];
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                }
                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                $turKurumAitOgrenciler = [];
                                foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                    $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
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
                        $adminRutbe = Session::get("userRutbe");
                        $form->post("turSaat1", true);
                        $form->post("turSaat2", true);
                        $form->post("aracID", true);
                        $form->post("aracPlaka", true);
                        $form->post("aracKapasite", true);
                        $form->post("soforID", true);
                        $form->post("soforAd", true);
                        $form->post("soforLocation", true);
                        $form->post("hostesID", true);
                        $form->post("hostesAd", true);
                        $form->post("hostesLocation", true);
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
                        $form->post("turKm", true);
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
                        $turAracKapasite = $form->values['aracKapasite'];
                        $turSoforID = $form->values['soforID'];
                        $turSoforAd = $form->values['soforAd'];
                        $turSoforLocation = $form->values['soforLocation'];
                        $turHostesID = $form->values['hostesID'];
                        $turHostesAd = $form->values['hostesAd'];
                        $turHostesLocation = $form->values['hostesLocation'];
                        $kurumTip = $form->values['kurumTip'];
                        $turTip = $form->values['turTip'];
                        $turID = $form->values['turID'];
                        $turKm = $form->values['turKm'];
                        $turGunler = $_REQUEST['turGun'];
                        $turOgrenciID = $_REQUEST['turOgrenciID'];
                        $turOgrenciAd = $_REQUEST['turOgrenciAd'];
                        $turOgrenciLocation = $_REQUEST['turOgrenciLocation'];
                        $turOgrenciSira = $_REQUEST['turOgrenciSira'];
                        $turIsciID = $_REQUEST['turKisiIsciID'];
                        $turIsciAd = $_REQUEST['turKisiIsciAd'];
                        $turIsciLocation = $_REQUEST['turKisiIsciLocation'];
                        $turIsciSira = $_REQUEST['turKisiIsciSira'];
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
                                        'BSTurKurumID' => $kurumID,
                                        'BSTurKurumAd' => $kurumAd,
                                        'BSTurKurumLocation' => $kurumLocation,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurAracKapasite' => $turAracKapasite,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurSoforLocation' => $turSoforLocation,
                                        'BSTurHostesID' => $turHostesID,
                                        'BSTurHostesAd' => $turHostesAd,
                                        'BSTurHostesLocation' => $turHostesLocation,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 1,
                                        'BSTurKm' => $turKm,
                                    );
                                    $turDatam = array_merge($data, $turGunReturn);
                                }
                                $turDonusID = $Panel_Model->addNewTurTip($turDatam);

                                if ($kurumTip == 0) {//öğrenci
                                    $turDonusOgrenciUpdate = array(
                                        'BSTurDonus' => $turDonusID,
                                    );
                                    $resultDonusUpdate = $Panel_Model->turTipDonusOgrenciDuzenle($turDonusOgrenciUpdate, $turID);
                                } else if ($kurumTip == 1) {//işçi
                                    $turDonusIsciUpdate = array(
                                        'SBTurDonus' => $turDonusID,
                                    );
                                    $resultDonusUpdate = $Panel_Model->turTipDonusIsciDuzenle($turDonusIsciUpdate, $turID);
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        $turDonusOgrenciIsciUpdate = array(
                                            'BSTurDonus' => $turDonusID,
                                        );
                                        $resultDonusUpdate = $Panel_Model->turTipDonusOgrenciIsciDuzenle($turDonusOgrenciIsciUpdate, $turID);
                                    }
                                }
                                $sonuc["turDonus"] = 1;
                                $sonuc["turDonusReply"] = $deger["DonusTur"];
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
                                        'BSTurKurumID' => $kurumID,
                                        'BSTurKurumAd' => $kurumAd,
                                        'BSTurKurumLocation' => $kurumLocation,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurAracKapasite' => $turAracKapasite,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurSoforLocation' => $turSoforLocation,
                                        'BSTurHostesID' => $turHostesID,
                                        'BSTurHostesAd' => $turHostesAd,
                                        'BSTurHostesLocation' => $turHostesLocation,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 0,
                                        'BSTurKm' => $turKm,
                                    );
                                    $turDatam = array_merge($data, $turGunReturn);
                                }
                                $turGidisID = $Panel_Model->addNewTurTip($turDatam);

                                if ($kurumTip == 0) {//öğrenci
                                    $turGidisOgrenciUpdate = array(
                                        'BSTurGidis' => $turGidisID,
                                    );
                                    $resultGidisUpdate = $Panel_Model->turTipGidisOgrenciDuzenle($turGidisOgrenciUpdate, $turID);
                                } else if ($kurumTip == 1) {//işçi
                                    $turGidisIsciUpdate = array(
                                        'SBTurGidis' => $turGidisID,
                                    );
                                    $resultGidisUpdate = $Panel_Model->turTipGidisIsciDuzenle($turGidisIsciUpdate, $turID);
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    $turGidisOgrenciIsciUpdate = array(
                                        'BSTurGidis' => $turGidisID,
                                    );
                                    $resultGidisUpdate = $Panel_Model->turTipGidisOgrenciIsciDuzenle($turGidisOgrenciIsciUpdate, $turID);
                                }
                                $sonuc["turGidis"] = 1;
                                $sonuc["turGidisReply"] = $deger["GidisTur"];
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
                                        'SBTurKm' => $turKm,
                                        'SBTurBasSaat' => 0,
                                        'SBTurBitSaat' => 0,
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
                                        'BSTurKurumID' => $kurumID,
                                        'BSTurKurumAd' => $kurumAd,
                                        'BSTurKurumLocation' => $kurumLocation,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurAracKapasite' => $turAracKapasite,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurSoforLocation' => $turSoforLocation,
                                        'BSTurHostesID' => $turHostesID,
                                        'BSTurHostesAd' => $turHostesAd,
                                        'BSTurHostesLocation' => $turHostesLocation,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 0,
                                        'BSTurKm' => $turKm,
                                    );
                                    $turDatam = array_merge($dataGidis, $turGunReturn);
                                }
                                $turGidisID = $Panel_Model->addNewTurTip($turDatam);

                                //şoföre bildirim gönderme
                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisAtama"];
                                $resultSoforCihaz = $Panel_Model->soforCihaz($turSoforID);
                                if (count($resultSoforCihaz) > 0) {
                                    foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                        $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                    }
                                    $soforCihazlar = implode(',', $soforCihaz);
                                    $form->shuttleNotification($soforCihazlar, $alert, $degerbildirim["TurAta"]);
                                }
                                //hostes varsa
                                if ($turHostesID) {
                                    //hostese bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisAtama"];
                                    $resultHostesCihaz = $Panel_Model->hostesCihaz($turHostesID);
                                    if (count($resultHostesCihaz) > 0) {
                                        foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                            $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                        }
                                        $hostesCihazlar = implode(',', $hostesCihaz);
                                        $form->shuttleNotification($hostesCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }
                                }
                                if ($kurumTip == 0) {//öğrenci
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurSira' => $turOgrenciSira[$o],
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
                                            'BSTurGidis' => $turGidisID,
                                            'BSTurDonus' => 0
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);

                                        $turOgrenciBildirim[] = $turOgrenciID[$o];
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci);

                                    //öğrenciye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                    $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                    $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                    if (count($resultOgrenciCihaz) > 0) {
                                        foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                            $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                        $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }

                                    //veliye bildirim gönderme
                                    $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                    if (count($resultVeliOgrenci) > 0) {
                                        foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                            $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                        }
                                        $ogrenciVelim = implode(',', $ogrenciVeliler);
                                        $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                        foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                            $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                        }
                                        $veliCihazlar = implode(',', $veliCihaz);
                                        $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }
                                } else if ($kurumTip == 1) {//işçi
                                    for ($i = 0; $i < count($turIsciID); $i++) {
                                        $dataIsci[$i] = array(
                                            'SBTurSira' => $turIsciSira[$i],
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
                                            'SBTurGidis' => $turGidisID,
                                            'SBTurDonus' => 0
                                        );
                                        $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);

                                        $turIsciBildirim[] = $turIsciID[$i];
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);

                                    //işçiye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                    $isciBildirimID = implode(",", $turIsciBildirim);
                                    $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurGidis' => $turGidisID,
                                                'BSTurDonus' => 0
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataOgrenci);

                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurAta"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurAta"]);
                                        }
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'BSTurSira' => $turIsciSira[$i],
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
                                                'BSTurGidis' => $turGidisID,
                                                'BSTurDonus' => 0
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);

                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataIsci);

                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurAta"]);
                                        }
                                    }
                                }

                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurEkleme"];
                                $kurumRenk = 'success';
                                $kurumUrl = 'turliste';
                                $kurumIcon = 'fa fa-refresh';
                                //bildirim ayarları
                                if ($adminRutbe != 1) {//normal admin
                                    $adminIDLer = array(1, $adminID);
                                    $adminImplodeID = implode(',', $adminIDLer);
                                    $resultAdminBolgeler = $Panel_Model->digerOrtakTekBolge($bolgeID, $adminImplodeID);
                                    $adminBolgeCount = count($resultAdminBolgeler);
                                    if ($adminBolgeCount > 0) {//diğer adminler
                                        $multiData[0] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 72);
                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                            $multiData[$b + 1] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 72);
                                        }
                                        $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                        if ($resultBildirim) {
                                            $adminNotfIDLer = array(1, $adminImplodeID);
                                            $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                            $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurEkle"]);
                                            }
                                        }
                                    } else {
                                        $dataBildirim = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 72);
                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                        if ($resultBildirim) {
                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurEkle"]);
                                            }
                                        }
                                    }
                                } else {//üst admin
                                    $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($bolgeID);
                                    $adminIDCount = count($resultBolgeAdminID);
                                    if ($adminIDCount > 0) {
                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 72);
                                        }
                                        $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                        if ($resultBildirim) {
                                            $adminImplodeID = implode(',', $resultBolgeAdminID);
                                            $adminNotfIDLer = array($adminImplodeID);
                                            $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                            $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurEkle"]);
                                            }
                                        }
                                    }
                                }
                                //log ayarları
                                $dataLog = $form->adminBildirimLogDuzen($adminID, $adSoyad, $alert);
                                $resultLog = $Panel_Model->addNewAdminBildirimLog($dataLog);
                                if ($resultLog) {
                                    $sonuc["turGidis"] = 1;
                                    $sonuc["turGidisReply"] = $deger["GidisTur"];
                                } else {
                                    $sonuc["hata"] = $deger["Hata"];
                                }
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
                                        'SBTurTip' => $kurumTip,
                                        'SBTurKm' => $turKm,
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
                                        'BSTurKurumID' => $kurumID,
                                        'BSTurKurumAd' => $kurumAd,
                                        'BSTurKurumLocation' => $kurumLocation,
                                        'BSTurAracID' => $turAracID,
                                        'BSTurAracPlaka' => $turAracPlaka,
                                        'BSTurAracKapasite' => $turAracKapasite,
                                        'BSTurSoforID' => $turSoforID,
                                        'BSTurSoforAd' => $turSoforAd,
                                        'BSTurSoforLocation' => $turSoforLocation,
                                        'BSTurHostesID' => $turHostesID,
                                        'BSTurHostesAd' => $turHostesAd,
                                        'BSTurHostesLocation' => $turHostesLocation,
                                        'BSTurBslngc' => $turSaat1,
                                        'BSTurBts' => $turSaat2,
                                        'BSTurGidisDonus' => 1,
                                        'BSTurKm' => $turKm,
                                    );
                                    $turDatam = array_merge($dataDonus, $turGunReturn);
                                }

                                $turDonusID = $Panel_Model->addNewTurTip($turDatam);

                                //şoföre bildirim gönderme
                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusAtama"];
                                $resultSoforCihaz = $Panel_Model->soforCihaz($turSoforID);
                                if (count($resultSoforCihaz) > 0) {
                                    foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                        $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                    }
                                    $soforCihazlar = implode(',', $soforCihaz);
                                    $form->shuttleNotification($soforCihazlar, $alert, $degerbildirim["TurAta"]);
                                }
                                //hostes varsa
                                if ($turHostesID) {
                                    //hostese bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusAtama"];
                                    $resultHostesCihaz = $Panel_Model->hostesCihaz($turHostesID);
                                    if (count($resultHostesCihaz) > 0) {
                                        foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                            $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                        }
                                        $hostesCihazlar = implode(',', $hostesCihaz);
                                        $form->shuttleNotification($hostesCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }
                                }

                                if ($kurumTip == 0) {//öğrenci
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurSira' => $turOgrenciSira[$o],
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
                                            'BSTurDonus' => $turDonusID
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);

                                        $turOgrenciBildirim[] = $turOgrenciID[$o];
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci);

                                    //öğrenciye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                    $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                    $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                    if (count($resultOgrenciCihaz) > 0) {
                                        foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                            $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                        $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }

                                    //veliye bildirim gönderme
                                    $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                    if (count($resultVeliOgrenci) > 0) {
                                        foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                            $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                        }
                                        $ogrenciVelim = implode(',', $ogrenciVeliler);
                                        $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                        foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                            $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                        }
                                        $veliCihazlar = implode(',', $veliCihaz);
                                        $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }
                                } else if ($kurumTip == 1) {//işçi
                                    for ($o = 0; $o < count($turIsciID); $o++) {
                                        $dataIsci[$o] = array(
                                            'SBTurSira' => $turIsciSira[$o],
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
                                            'SBTurDonus' => $turDonusID
                                        );
                                        $turDataIsci[$o] = array_merge($dataIsci[$o], $turGunReturn);
                                        $turIsciBildirim[] = $turIsciID[$i];
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);

                                    //işçiye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                    $isciBildirimID = implode(",", $turIsciBildirim);
                                    $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurAta"]);
                                    }
                                } else {//öğrenci ve işçi
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurDonus' => $turDonusID
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);

                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataOgrenci);
                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurAta"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurAta"]);
                                        }
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'BSTurSira' => $turIsciSira[$i],
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
                                                'BSTurDonus' => $turDonusID
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);

                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turDataIsci);

                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurAtama"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurAta"]);
                                        }
                                    }
                                }

                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurEkleme"];
                                $kurumRenk = 'success';
                                $kurumUrl = 'turliste';
                                $kurumIcon = 'fa fa-refresh';
                                //bildirim ayarları
                                if ($adminRutbe != 1) {//normal admin
                                    $adminIDLer = array(1, $adminID);
                                    $adminImplodeID = implode(',', $adminIDLer);
                                    $resultAdminBolgeler = $Panel_Model->digerOrtakTekBolge($bolgeID, $adminImplodeID);
                                    $adminBolgeCount = count($resultAdminBolgeler);
                                    if ($adminBolgeCount > 0) {//diğer adminler
                                        $multiData[0] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 72);
                                        for ($b = 0; $b < $adminBolgeCount; $b++) {
                                            $multiData[$b + 1] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 72);
                                        }
                                        $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                        if ($resultBildirim) {
                                            $adminNotfIDLer = array(1, $adminImplodeID);
                                            $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                            $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurEkle"]);
                                            }
                                        }
                                    } else {
                                        $dataBildirim = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 72);
                                        $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                        if ($resultBildirim) {
                                            $resultAdminCihaz = $Panel_Model->adminCihaz();
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurEkle"]);
                                            }
                                        }
                                    }
                                } else {//üst admin
                                    $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($bolgeID);
                                    $adminIDCount = count($resultBolgeAdminID);
                                    if ($adminIDCount > 0) {
                                        for ($b = 0; $b < $adminIDCount; $b++) {
                                            $multiData[$b] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 72);
                                        }
                                        $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                        if ($resultBildirim) {
                                            $adminImplodeID = implode(',', $resultBolgeAdminID);
                                            $adminNotfIDLer = array($adminImplodeID);
                                            $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                            $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                            if (count($resultAdminCihaz) > 0) {
                                                foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                    $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                                }
                                                $adminCihaz = implode(',', $adminCihaz);
                                                $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurEkle"]);
                                            }
                                        }
                                    }
                                }
                                //log ayarları
                                $dataLog = $form->adminBildirimLogDuzen($adminID, $adSoyad, $alert);
                                $resultLog = $Panel_Model->addNewAdminBildirimLog($dataLog);
                                if ($resultLog) {
                                    $sonuc["turDonus"] = 1;
                                    $sonuc["turDonusReply"] = $deger["DonusTur"];
                                } else {
                                    $sonuc["hata"] = $deger["Hata"];
                                }
                            }
                        }
                        if ($resultTurID) {
                            $sonuc["turID"] = $resultTurID;
                        } else {
                            $sonuc["turID"] = $turID;
                        }
                    }
                    break;
                case "adminTurDetaySecim":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("adminturRowid", true);
                        $turID = $form->values['adminturRowid'];
                        $turDetayTip = $Panel_Model->turDetayTip($turID);
                        $a = 0;
                        foreach ($turDetayTip as $turDetayTipp) {
                            $turTipDetay['TurDetayTipID'][$a] = $turDetayTipp['BSTurTipID'];
                            $turTipDetay['TurDetayTip'][$a] = $turDetayTipp['BSTurTip'];
                            $turTipDetay['TurDetayTur'][$a] = $turDetayTipp['BSTurGidisDonus'];
                            $turTipDetay['TurDetayAracID'][$a] = $turDetayTipp['BSTurAracID'];
                            $turTipDetay['TurDetayAracPlaka'][$a] = $turDetayTipp['BSTurAracPlaka'];
                            $turTipDetay['TurDetayAracKapasite'][$a] = $turDetayTipp['BSTurAracKapasite'];
                            $turTipDetay['TurDetaySoforID'][$a] = $turDetayTipp['BSTurSoforID'];
                            $turTipDetay['TurDetaySoforAd'][$a] = $turDetayTipp['BSTurSoforAd'];
                            $turTipDetay['TurDetaySoforLocation'][$a] = $turDetayTipp['BSTurSoforLocation'];
                            $turTipDetay['TurDetayHostesID'][$a] = $turDetayTipp['BSTurHostesID'];
                            $turTipDetay['TurDetayHostesAd'][$a] = $turDetayTipp['BSTurHostesAd'];
                            $turTipDetay['TurDetayHostesLocation'][$a] = $turDetayTipp['BSTurHostesLocation'];
                            $turTipDetay['TurDetayBsSaat'][$a] = $turDetayTipp['BSTurBslngc'];
                            $turTipDetay['TurDetayBtsSaat'][$a] = $turDetayTipp['BSTurBts'];
                            $turTipDetay['TurDetayBolgeID'][$a] = $turDetayTipp['BSTurBolgeID'];
                            $turTipDetay['TurDetayBolgeAd'][$a] = $turDetayTipp['BSTurBolgeAd'];
                            $turTipDetay['TurDetayKurumID'][$a] = $turDetayTipp['BSTurKurumID'];
                            $turTipDetay['TurDetayKurumAd'][$a] = $turDetayTipp['BSTurKurumAd'];
                            $turTipDetay['TurDetayKurumLocation'][$a] = $turDetayTipp['BSTurKurumLocation'];
                            $a++;
                        }
                        $sonuc["turTipDetay"] = $turTipDetay;
                    }
                    break;
                case "adminTurDetayGidis":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("gidisTipID", true);
                        $form->post("turTip", true);
                        $form->post("kurumID", true);
                        $form->post("turID", true);
                        $gidisTipID = $form->values['gidisTipID'];
                        $gidisTip = $form->values['turTip'];
                        $turKurumID = $form->values['kurumID'];
                        $turID = $form->values['turID'];

                        if ($gidisTip == 0) { //öğrenci
                            $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                            $turKurumOgrenci = [];
                            foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                            }
                            //herhangi bir tura kayıtlı öğrenciler
                            $kurumTurAitOgrenci = $Panel_Model->turKurumAitOgrenci($turKurumID);
                            $turKurumAitOgrenci = [];
                            foreach ($kurumTurAitOgrenci as $kurumTurAitOgrencii) {
                                $turKurumAitOgrenci[] = $kurumTurAitOgrencii['BSOgrenciID'];
                            }
                            $turKurumNotTurOgrenci = array_diff($turKurumOgrenci, $turKurumAitOgrenci);

                            $kurumOgrenci = implode(',', $turKurumNotTurOgrenci);
                            $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                            $b = 0;
                            foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                $turDigerKisi[$b]['digerKisiTip'] = 0;
                                $turDigerKisi[$b]['digerKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                $turDigerKisi[$b]['digerKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                $turDigerKisi[$b]['digerKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                $turDigerKisi[$b]['digerKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                $b++;
                            }

                            $turDetayGidisKisi = $Panel_Model->turDetayGidisOgrenci($turID);
                            $a = 0;
                            foreach ($turDetayGidisKisi as $turDetayGidisKisii) {
                                $turDetayGidis['KisiTip'][$a] = 0;
                                $turDetayGidis['KisiID'][$a] = $turDetayGidisKisii['BSOgrenciID'];
                                $turDetayGidis['KisiAd'][$a] = $turDetayGidisKisii['BSOgrenciAd'];
                                $turDetayGidis['KisiLocation'][$a] = $turDetayGidisKisii['BSOgrenciLocation'];
                                $turDetayGidis['Pzt'][$a] = $turDetayGidisKisii['SBTurPzt'];
                                $turDetayGidis['Sli'][$a] = $turDetayGidisKisii['SBTurSli'];
                                $turDetayGidis['Crs'][$a] = $turDetayGidisKisii['SBTurCrs'];
                                $turDetayGidis['Prs'][$a] = $turDetayGidisKisii['SBTurPrs'];
                                $turDetayGidis['Cma'][$a] = $turDetayGidisKisii['SBTurCma'];
                                $turDetayGidis['Cmt'][$a] = $turDetayGidisKisii['SBTurCmt'];
                                $turDetayGidis['Pzr'][$a] = $turDetayGidisKisii['SBTurPzr'];
                                $a++;
                            }
                        } else if ($gidisTip == 1) {//işçi
                            $kurumIsciListe = $Panel_Model->turKurumIsci($turKurumID);
                            $turKurumIsci = [];
                            foreach ($kurumIsciListe as $kurumIsciListee) {
                                $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                            }
                            //herhangi bir tura kayıtlı işçiler
                            $kurumTurAitIsci = $Panel_Model->turKurumAitIsci($turKurumID);
                            $turKurumAitIsci = [];
                            foreach ($kurumTurAitIsci as $kurumTurAitIscii) {
                                $turKurumAitIsci[] = $kurumTurAitIscii['SBIsciID'];
                            }
                            $turKurumNotTurIsci = array_diff($turKurumIsci, $turKurumAitIsci);
                            $kurumIsci = implode(',', $turKurumNotTurIsci);
                            $kurumIsciListesi = $Panel_Model->turKurumIscii($kurumIsci);
                            $b = 0;
                            foreach ($kurumIsciListesi as $kurumIsciListesii) {
                                $turDigerKisi[$b]['digerKisiTip'] = 1;
                                $turDigerKisi[$b]['digerKisiID'] = $kurumIsciListesii['SBIsciID'];
                                $turDigerKisi[$b]['digerKisiAd'] = $kurumIsciListesii['SBIsciAd'];
                                $turDigerKisi[$b]['digerKisiSoyad'] = $kurumIsciListesii['SBIsciSoyad'];
                                $turDigerKisi[$b]['digerKisiLocation'] = $kurumIsciListesii['SBIsciLocation'];
                                $b++;
                            }


                            $turDetayGidisKisi = $Panel_Model->turDetayGidisIsci($turID);
                            $a = 0;
                            foreach ($turDetayGidisKisi as $turDetayGidisKisii) {
                                $turDetayGidis['KisiTip'][$a] = 1;
                                $turDetayGidis['KisiID'][$a] = $turDetayGidisKisii['SBIsciID'];
                                $turDetayGidis['KisiAd'][$a] = $turDetayGidisKisii['SBIsciAd'];
                                $turDetayGidis['KisiLocation'][$a] = $turDetayGidisKisii['SBIsciLocation'];
                                $turDetayGidis['Pzt'][$a] = $turDetayGidisKisii['SBTurPzt'];
                                $turDetayGidis['Sli'][$a] = $turDetayGidisKisii['SBTurSli'];
                                $turDetayGidis['Crs'][$a] = $turDetayGidisKisii['SBTurCrs'];
                                $turDetayGidis['Prs'][$a] = $turDetayGidisKisii['SBTurPrs'];
                                $turDetayGidis['Cma'][$a] = $turDetayGidisKisii['SBTurCma'];
                                $turDetayGidis['Cmt'][$a] = $turDetayGidisKisii['SBTurCmt'];
                                $turDetayGidis['Pzr'][$a] = $turDetayGidisKisii['SBTurPzr'];
                                $a++;
                            }
                        } else {//öğrenci ve işçi
                            $kurumIsciListe = $Panel_Model->turKurumIsci($turKurumID);
                            if (count($kurumIsciListe) > 0) {//hem öğrenci hem de personel
                                $turKurumIsci = [];
                                foreach ($kurumIsciListe as $kurumIsciListee) {
                                    $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                                }
                                //herhangi bir tura kayıtlı işçiler
                                $kurumTurAitPersonel = $Panel_Model->turKurumAitPersonel($turKurumID);
                                if (count($kurumTurAitPersonel) > 0) {
                                    $turKurumAitPersonel = [];
                                    foreach ($kurumTurAitPersonel as $kurumTurAitPersonell) {
                                        $turKurumAitPersonel[] = $kurumTurAitPersonell['BSOgrenciIsciID'];
                                    }
                                    $turKurumNotTurPersonel = array_diff($turKurumIsci, $turKurumAitPersonel);
                                    $kurumIsci = implode(',', $turKurumNotTurPersonel);
                                } else {
                                    $kurumIsci = implode(',', $turKurumIsci);
                                }

                                $kurumIsciListesi = $Panel_Model->turKurumIscii($kurumIsci);
                                $b = 0;
                                foreach ($kurumIsciListesi as $kurumIsciListesii) {
                                    $turDigerKisi[$b]['digerKisiTip'] = 1;
                                    $turDigerKisi[$b]['digerKisiID'] = $kurumIsciListesii['SBIsciID'];
                                    $turDigerKisi[$b]['digerKisiAd'] = $kurumIsciListesii['SBIsciAd'];
                                    $turDigerKisi[$b]['digerKisiSoyad'] = $kurumIsciListesii['SBIsciSoyad'];
                                    $turDigerKisi[$b]['digerKisiLocation'] = $kurumIsciListesii['SBIsciLocation'];
                                    $b++;
                                }

                                $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                                $turKurumOgrenci = [];
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                }

                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                if (count($kurumTurAitOgrenciler) > 0) {
                                    $turKurumAitOgrenciler = [];
                                    foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                        $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
                                    }
                                    $turKurumNotTurOgrenciler = array_diff($turKurumOgrenci, $turKurumAitOgrenciler);

                                    $kurumOgrenci = implode(',', $turKurumNotTurOgrenciler);
                                } else {
                                    $kurumOgrenci = implode(',', $turKurumOgrenci);
                                }

                                $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                                $d = $b;
                                foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                    $turDigerKisi[$d]['digerKisiTip'] = 0;
                                    $turDigerKisi[$d]['digerKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                    $turDigerKisi[$d]['digerKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                    $turDigerKisi[$d]['digerKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                    $turDigerKisi[$d]['digerKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                    $d++;
                                }
                            } else {//sadece öğrenci
                                $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                                $turKurumOgrenci = [];
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                }
                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                $turKurumAitOgrenciler = [];
                                foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                    $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
                                }
                                $turKurumNotTurOgrenciler = array_diff($turKurumOgrenci, $turKurumAitOgrenciler);

                                $kurumOgrenci = implode(',', $turKurumNotTurOgrenciler);
                                $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                                $d = 0;
                                foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                    $turDigerKisi[$d]['digerKisiTip'] = 0;
                                    $turDigerKisi[$d]['digerKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                    $turDigerKisi[$d]['digerKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                    $turDigerKisi[$d]['digerKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                    $turDigerKisi[$d]['digerKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                    $d++;
                                }
                            }

                            $turDetayGidisKisi = $Panel_Model->turDetayGidisIsciOgrenci($turID);
                            $a = 0;
                            foreach ($turDetayGidisKisi as $turDetayGidisKisii) {
                                $turDetayGidis['KisiTip'][$a] = $turDetayGidisKisii['BSKullaniciTip'];
                                $turDetayGidis['KisiID'][$a] = $turDetayGidisKisii['BSOgrenciIsciID'];
                                $turDetayGidis['KisiAd'][$a] = $turDetayGidisKisii['BSOgrenciIsciAd'];
                                $turDetayGidis['KisiLocation'][$a] = $turDetayGidisKisii['BSOgrenciIsciLocation'];
                                $turDetayGidis['Pzt'] = $turDetayGidisKisii['SBTurPzt'];
                                $turDetayGidis['Sli'] = $turDetayGidisKisii['SBTurSli'];
                                $turDetayGidis['Crs'] = $turDetayGidisKisii['SBTurCrs'];
                                $turDetayGidis['Prs'] = $turDetayGidisKisii['SBTurPrs'];
                                $turDetayGidis['Cma'] = $turDetayGidisKisii['SBTurCma'];
                                $turDetayGidis['Cmt'] = $turDetayGidisKisii['SBTurCmt'];
                                $turDetayGidis['Pzr'] = $turDetayGidisKisii['SBTurPzr'];
                                $a++;
                            }
                        }
                        $sonuc["gidis"] = $turDetayGidis;
                        $sonuc["gidisDiger"] = $turDigerKisi;
                    }
                    break;
                case "turGidisAracSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("bolgeID", true);
                        $form->post("kurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $turBolgeID = $form->values['bolgeID'];
                        $turKurumID = $form->values['kurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turGunler = $_REQUEST['turGunID'];
                        $gunSaatSql = $form->sqlGunSaat($turBolgeID, $turSaat1ID, $turSaat2ID, $turGunler);
                        $turAracListe = $Panel_Model->turAracSelect($gunSaatSql);

                        $turAktifAracId = [];
                        foreach ($turAracListe as $turAracListee) {
                            $turAktifAracId[] = $turAracListee['BSTurAracID'];
                        }

                        $turBolgeAracListe = $Panel_Model->turBolgeAracListele($turBolgeID);

                        if (count($turBolgeAracListe) > 0) {
                            //bölgede araç varsa
                            $turBolgeArac = [];
                            foreach ($turBolgeAracListe as $turBolgeAracListee) {
                                $turBolgeArac[] = $turBolgeAracListee['SBAracID'];
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
                case "turGidisSoforSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("bolgeID", true);
                        $form->post("kurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $form->post("aracID", true);
                        $turBolgeID = $form->values['bolgeID'];
                        $turKurumID = $form->values['kurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turAracID = $form->values['aracID'];
                        $turGunler = $_REQUEST['turGunID'];

                        $gunSaatSoforSql = $form->sqlGunSaatSofor($turBolgeID, $turAracID, $turSaat1ID, $turSaat2ID, $turGunler);

                        $turSoforListe = $Panel_Model->turSoforSelect($gunSaatSoforSql);

                        $turAktifSoforId = [];
                        foreach ($turSoforListe as $turSoforListee) {
                            $turAktifSoforId[] = $turSoforListee['BSTurSoforID'];
                        }

                        $turAracSoforListe = $Panel_Model->turAracSoforListele($turAracID);

                        if (count($turAracSoforListe) > 0) {
                            //araça ait şoför varsa
                            $turAracSofor = [];
                            foreach ($turAracSoforListe as $turAracSoforListee) {
                                $turAracSofor[] = $turAracSoforListee['BSSoforID'];
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
                case "turGidisHostesSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("bolgeID", true);
                        $form->post("kurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $form->post("aracID", true);
                        $turBolgeID = $form->values['bolgeID'];
                        $turKurumID = $form->values['kurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turAracID = $form->values['aracID'];
                        $turGunler = $_REQUEST['turGunID'];

                        $gunSaatHostesSql = $form->sqlGunSaatHostes($turBolgeID, $turAracID, $turSaat1ID, $turSaat2ID, $turGunler);

                        $turHostesListe = $Panel_Model->turHostesSelect($gunSaatHostesSql);

                        $turAktifHostesId = [];
                        foreach ($turHostesListe as $turHostesListee) {
                            $turAktifHostesId[] = $turHostesListee['BSTurHostesID'];
                        }

                        $turAracHostesListe = $Panel_Model->turAracHostesListele($turAracID);

                        if (count($turAracHostesListe) > 0) {
                            //araça ait hostes varsa
                            $turAracHostes = [];
                            foreach ($turAracHostesListe as $turAracHostesListee) {
                                $turAracHostes[] = $turAracHostesListee['BSHostesID'];
                            }

                            if (count($turHostesListe) > 0) {//aktif hostes varsa
                                $bolgePasifHostes = array_diff($turAracHostes, $turAktifHostesId);
                                if (count($bolgePasifHostes) > 0) {//aracın birden fazla hostesi varsa
                                    $pasifHostes = implode(',', $bolgePasifHostes);
                                    //bölgedeki pasif hostesler
                                    $turPasifSoforListe = $Panel_Model->turAracPasifHostesListele($pasifHostes);
                                    $c = 0;
                                    foreach ($turPasifSoforListe as $turPasifHostesListee) {
                                        $turHostes[$c]['turHostesID'] = $turPasifHostesListee['BSHostesID'];
                                        $turHostes[$c]['turHostesAd'] = $turPasifHostesListee['BSHostesAd'];
                                        $turHostes[$c]['turHostesSoyad'] = $turPasifHostesListee['BSHostesSoyad'];
                                        $turHostes[$c]['turHostesLocation'] = $turPasifHostesListee['BSHostesLocation'];
                                        $c++;
                                    }
                                }
                            } else {//aktif hostes yoksa
                                $pasifHostes = implode(',', $turAracHostes);
                                $turPasifHostesListe = $Panel_Model->turAracPasifHostesListele($pasifHostes);
                                $c = 0;
                                foreach ($turPasifHostesListe as $turPasifHostesListee) {
                                    $turHostes[$c]['turHostesID'] = $turPasifHostesListee['BSHostesID'];
                                    $turHostes[$c]['turHostesAd'] = $turPasifHostesListee['BSHostesAd'];
                                    $turHostes[$c]['turHostesSoyad'] = $turPasifHostesListee['BSHostesSoyad'];
                                    $turHostes[$c]['turHostesLocation'] = $turPasifHostesListee['BSHostesLocation'];
                                    $c++;
                                }
                            }
                        }
                        $sonuc["pasifHostes"] = $turHostes;
                    }
                    break;
                case "turGidisDKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");

                        $form->post("turSaat1", true);
                        $form->post("turSaat2", true);
                        $form->post("aracID", true);
                        $form->post("aracPlaka", true);
                        $form->post("aracKapasite", true);
                        $form->post("soforID", true);
                        $form->post("soforAd", true);
                        $form->post("soforLocation", true);
                        $form->post("hostesID", true);
                        $form->post("hostesAd", true);
                        $form->post("hostesLocation", true);
                        $form->post("turID", true);
                        $form->post("turGidisID", true);
                        $form->post("turDonusID", true);
                        $form->post("kurumTip", true);
                        $form->post("bolgeID", true);
                        $form->post("bolgead", true);
                        $form->post("turAdi", true);
                        $form->post("turAciklama", true);
                        $form->post("kurumad", true);
                        $form->post("kurumId", true);
                        $form->post("kurumLocation", true);
                        $form->post("turKm", true);
                        $bolgeID = $form->values['bolgeID'];
                        $bolgeAd = $form->values['bolgead'];
                        $kurumID = $form->values['kurumId'];
                        $kurumAd = $form->values['kurumad'];
                        $kurumLocation = $form->values['kurumLocation'];
                        $turTipGidisID = $form->values['turGidisID'];
                        $turTipDonusID = $form->values['turDonusID'];
                        $turAdi = $form->values['turAdi'];
                        $turAciklama = $form->values['turAciklama'];
                        $turSaat1 = $form->values['turSaat1'];
                        $turSaat2 = $form->values['turSaat2'];
                        $turAracID = $form->values['aracID'];
                        $turAracPlaka = $form->values['aracPlaka'];
                        $turAracKapasite = $form->values['aracKapasite'];
                        $turSoforID = $form->values['soforID'];
                        $turSoforAd = $form->values['soforAd'];
                        $turSoforLocation = $form->values['soforLocation'];
                        $turHostesID = $form->values['hostesID'];
                        $turHostesAd = $form->values['hostesAd'];
                        $turHostesLocation = $form->values['hostesLocation'];
                        $kurumTip = $form->values['kurumTip'];
                        $turID = $form->values['turID'];
                        $turKm = $form->values['turKm'];
                        $turGunler = $_REQUEST['turGun'];
                        $turOgrenciID = $_REQUEST['turOgrenciID'];
                        $turOgrenciAd = $_REQUEST['turOgrenciAd'];
                        $turOgrenciLocation = $_REQUEST['turOgrenciLocation'];
                        $turOgrenciSira = $_REQUEST['turOgrenciSira'];
                        $turIsciID = $_REQUEST['turKisiIsciID'];
                        $turIsciAd = $_REQUEST['turKisiIsciAd'];
                        $turIsciLocation = $_REQUEST['turKisiIsciLocation'];
                        $turIsciSira = $_REQUEST['turKisiIsciSira'];
                        $turGunReturn = $form->sqlGunInsert($turGunler);
                        $turGunReturnUpdate = $form->sqlGunUpdate($turGunler);

                        //gidiş Tur düzenleme
                        if ($form->submit()) {
                            $updateGidisTur = array(
                                'SBTurAd' => $turAdi,
                                'SBTurAciklama' => $turAciklama,
                                'SBTurGidis' => 1,
                                'SBTurKm' => $turKm,
                            );
                            $turGidisUpdate = array_merge($updateGidisTur, $turGunReturnUpdate);
                        }
                        $resultTurUpdate = $Panel_Model->turTipDuzenle($turGidisUpdate, $turID);

                        //Tur Gidiş varsa Düzenleme
                        if ($turTipGidisID) {//daha önce kaydedilmişse güncelleme yapılacak
                            //Gidiş tur tip düzenleme
                            if ($form->submit()) {
                                $gidisTurTipdata = array(
                                    'BSTurAracID' => $turAracID,
                                    'BSTurAracPlaka' => $turAracPlaka,
                                    'BSTurAracKapasite' => $turAracKapasite,
                                    'BSTurSoforID' => $turSoforID,
                                    'BSTurSoforAd' => $turSoforAd,
                                    'BSTurSoforLocation' => $turSoforLocation,
                                    'BSTurHostesID' => $turHostesID,
                                    'BSTurHostesAd' => $turHostesAd,
                                    'BSTurHostesLocation' => $turHostesLocation,
                                    'BSTurBslngc' => $turSaat1,
                                    'BSTurBts' => $turSaat2,
                                    'BSTurKm' => $turKm,
                                );
                                $turTipGidisDatam = array_merge($gidisTurTipdata, $turGunReturnUpdate);
                            }
                            $resultTurTip = $Panel_Model->turTipGidisDuzenle($turTipGidisDatam, $turTipGidisID);

                            //şoföre bildirim gönderme
                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                            $resultSoforCihaz = $Panel_Model->soforCihaz($turSoforID);
                            if (count($resultSoforCihaz) > 0) {
                                foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                    $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                }
                                $soforCihazlar = implode(',', $soforCihaz);
                                $form->shuttleNotification($soforCihazlar, $alert, $degerbildirim["TurDuzen"]);
                            }
                            //hostes varsa
                            if ($turHostesID) {
                                //hostese bildirim gönderme
                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                $resultHostesCihaz = $Panel_Model->hostesCihaz($turHostesID);
                                if (count($resultHostesCihaz) > 0) {
                                    foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                        $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                    }
                                    $hostesCihazlar = implode(',', $hostesCihaz);
                                    $form->shuttleNotification($hostesCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                }
                            }
                            //dönüşü varmı kontrolü
                            if ($turTipDonusID) {//varsa
                                if ($kurumTip == 0) {//öğrenci
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurGidis' => $turTipGidisID,
                                                'BSTurDonus' => $turTipDonusID
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);

                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurOgrenci($turDataOgrenci[$o]);

                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else if ($kurumTip == 1) {//işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisIsciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'SBTurSira' => $turIsciSira[$i],
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
                                                'SBTurGidis' => $turTipGidisID,
                                                'SBTurDonus' => $turTipDonusID
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsci($turDataIsci);

                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else {//öğrenci ve işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciIsciDelete($turID);
                                    if ($deleteresultt) {
                                        //öğrenci için
                                        if (count($turOgrenciID) > 0) {
                                            for ($o = 0; $o < count($turOgrenciID); $o++) {
                                                $updateGidisOgrenci[$o] = array(
                                                    'BSTurSira' => $turOgrenciSira[$o],
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
                                                    'BSTurGidis' => $turTipGidisID,
                                                    'BSTurDonus' => $turTipDonusID
                                                );
                                                $turUpdateDataOgrenci[$o] = array_merge($updateGidisOgrenci[$o], $turGunReturn);
                                                $turOgrenciBildirim[] = $turOgrenciID[$o];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataOgrenci);
                                            //öğrenciye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                            $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                            $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                            if (count($resultOgrenciCihaz) > 0) {
                                                foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                    $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                                }
                                                $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                                $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }

                                            //veliye bildirim gönderme
                                            $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                            if (count($resultVeliOgrenci) > 0) {
                                                foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                    $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                                }
                                                $ogrenciVelim = implode(',', $ogrenciVeliler);
                                                $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                                foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                    $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                                }
                                                $veliCihazlar = implode(',', $veliCihaz);
                                                $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                        //işçi için
                                        if (count($turIsciID) > 0) {
                                            for ($i = 0; $i < count($turIsciID); $i++) {
                                                $dataUpdateIsci[$i] = array(
                                                    'BSTurSira' => $turIsciSira[$i],
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
                                                    'BSTurGidis' => $turTipGidisID,
                                                    'BSTurDonus' => $turTipDonusID
                                                );
                                                $turUpdateDataIsci[$i] = array_merge($dataUpdateIsci[$i], $turGunReturn);

                                                $turIsciBildirim[] = $turIsciID[$i];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataIsci);

                                            //işçiye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                            $isciBildirimID = implode(",", $turIsciBildirim);
                                            $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                            if (count($resultIsciCihaz) > 0) {
                                                foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                    $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                                }
                                                $isciCihazlar = implode(',', $isciCihaz);
                                                $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                    }
                                }
                            } else {//yoksa
                                if ($kurumTip == 0) {//öğrenci
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurGidis' => $turTipGidisID,
                                                'BSTurDonus' => 0
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);

                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurOgrenci($turDataOgrenci[$o]);

                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else if ($kurumTip == 1) {//işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisIsciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'SBTurSira' => $turIsciSira[$i],
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
                                                'SBTurGidis' => $turTipGidisID,
                                                'SBTurDonus' => 0
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);

                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsci($turDataIsci);

                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else {//öğrenci ve işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciIsciDelete($turID);
                                    if ($deleteresultt) {
                                        //öğrenci için
                                        if (count($turOgrenciID) > 0) {
                                            for ($o = 0; $o < count($turOgrenciID); $o++) {
                                                $updateGidisOgrenci[$o] = array(
                                                    'BSTurSira' => $turOgrenciSira[$o],
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
                                                    'BSTurGidis' => $turTipGidisID,
                                                    'BSTurDonus' => 0
                                                );
                                                $turUpdateDataOgrenci[$o] = array_merge($updateGidisOgrenci[$o], $turGunReturn);

                                                $turOgrenciBildirim[] = $turOgrenciID[$o];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataOgrenci);

                                            //öğrenciye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                            $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                            $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                            if (count($resultOgrenciCihaz) > 0) {
                                                foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                    $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                                }
                                                $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                                $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }

                                            //veliye bildirim gönderme
                                            $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                            if (count($resultVeliOgrenci) > 0) {
                                                foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                    $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                                }
                                                $ogrenciVelim = implode(',', $ogrenciVeliler);
                                                $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                                foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                    $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                                }
                                                $veliCihazlar = implode(',', $veliCihaz);
                                                $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                        //işçi için
                                        if (count($turIsciID) > 0) {
                                            for ($i = 0; $i < count($turIsciID); $i++) {
                                                $dataUpdateIsci[$i] = array(
                                                    'BSTurSira' => $turIsciSira[$i],
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
                                                    'BSTurGidis' => $turTipGidisID,
                                                    'BSTurDonus' => 0
                                                );
                                                $turUpdateDataIsci[$i] = array_merge($dataUpdateIsci[$i], $turGunReturn);

                                                $turIsciBildirim[] = $turIsciID[$i];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataIsci);

                                            //işçiye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                            $isciBildirimID = implode(",", $turIsciBildirim);
                                            $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                            if (count($resultIsciCihaz) > 0) {
                                                foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                    $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                                }
                                                $isciCihazlar = implode(',', $isciCihaz);
                                                $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                    }
                                }
                            }
                        } else {//daha önce kaydedilmemişse insert yapacak
                            if ($form->submit()) {
                                $dataInsertGidis = array(
                                    'BSTurID' => $turID,
                                    'BSTurTip' => $kurumTip,
                                    'BSTurBolgeID' => $bolgeID,
                                    'BSTurBolgeAd' => $bolgeAd,
                                    'BSTurKurumID' => $kurumID,
                                    'BSTurKurumAd' => $kurumAd,
                                    'BSTurKurumLocation' => $kurumLocation,
                                    'BSTurAracID' => $turAracID,
                                    'BSTurAracPlaka' => $turAracPlaka,
                                    'BSTurAracKapasite' => $turAracKapasite,
                                    'BSTurSoforID' => $turSoforID,
                                    'BSTurSoforAd' => $turSoforAd,
                                    'BSTurSoforLocation' => $turSoforLocation,
                                    'BSTurHostesID' => $turHostesID,
                                    'BSTurHostesAd' => $turHostesAd,
                                    'BSTurHostesLocation' => $turHostesLocation,
                                    'BSTurBslngc' => $turSaat1,
                                    'BSTurBts' => $turSaat2,
                                    'BSTurGidisDonus' => 0,
                                    'BSTurKm' => $turKm,
                                );
                                $turUpdateDatam = array_merge($dataInsertGidis, $turGunReturn);
                            }
                            $resultTurTip = $Panel_Model->addNewTurTip($turUpdateDatam);

                            //şoföre bildirim gönderme
                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisAtama"];
                            $resultSoforCihaz = $Panel_Model->soforCihaz($turSoforID);
                            if (count($resultSoforCihaz) > 0) {
                                foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                    $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                }
                                $soforCihazlar = implode(',', $soforCihaz);
                                $form->shuttleNotification($soforCihazlar, $alert, $degerbildirim["TurAta"]);
                            }
                            //hostes varsa
                            if ($turHostesID) {
                                //hostese bildirim gönderme
                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisAtama"];
                                $resultHostesCihaz = $Panel_Model->hostesCihaz($turHostesID);
                                if (count($resultHostesCihaz) > 0) {
                                    foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                        $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                    }
                                    $hostesCihazlar = implode(',', $hostesCihaz);
                                    $form->shuttleNotification($hostesCihazlar, $alert, $degerbildirim["TurAta"]);
                                }
                            }
                            //eğer bu ilk defa ekleniyorsa dönüşe ait bilgiler mevcuttur
                            if ($kurumTip == 0) {//öğrenci
                                //önce silip sonra kaydedeceğiz
                                $deleteresultt = $Panel_Model->detailGidisOgrenciDelete($turID);
                                if ($deleteresultt) {
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurSira' => $turOgrenciSira[$o],
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
                                            'BSTurGidis' => $turGidisID,
                                            'BSTurDonus' => $turTipDonusID
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                        $turOgrenciBildirim[] = $turOgrenciID[$o];
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci[$o]);

                                    //öğrenciye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                    $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                    $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                    if (count($resultOgrenciCihaz) > 0) {
                                        foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                            $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                        $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                    }

                                    //veliye bildirim gönderme
                                    $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                    if (count($resultVeliOgrenci) > 0) {
                                        foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                            $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                        }
                                        $ogrenciVelim = implode(',', $ogrenciVeliler);
                                        $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                        foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                            $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                        }
                                        $veliCihazlar = implode(',', $veliCihaz);
                                        $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            } else if ($kurumTip == 1) {//işçi
                                //önce silip sonra kaydedeceğiz
                                $deleteresultt = $Panel_Model->detailGidisIsciDelete($turID);
                                if ($deleteresultt) {
                                    for ($i = 0; $i < count($turIsciID); $i++) {
                                        $dataIsci[$i] = array(
                                            'SBTurSira' => $turIsciSira[$i],
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
                                            'SBTurGidis' => $turGidisID,
                                            'SBTurDonus' => $turTipDonusID
                                        );
                                        $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);

                                        $turIsciBildirim[] = $turIsciID[$i];
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);

                                    //işçiye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                    $isciBildirimID = implode(",", $turIsciBildirim);
                                    $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            } else {//öğrenci ve işçi
                                //önce silip sonra kaydedeceğiz
                                $deleteresultt = $Panel_Model->detailGidisOgrenciIsciDelete($turID);
                                if ($deleteresultt) {
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $updateGidisOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurGidis' => $turGidisID,
                                                'BSTurDonus' => $turTipDonusID
                                            );
                                            $turUpdateDataOgrenci[$o] = array_merge($updateGidisOgrenci[$o], $turGunReturn);

                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turUpdateDataOgrenci);

                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataUpdateIsci[$i] = array(
                                                'BSTurSira' => $turIsciSira[$i],
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
                                                'BSTurGidis' => $turGidisID,
                                                'BSTurDonus' => $turTipDonusID
                                            );
                                            $turUpdateDataIsci[$i] = array_merge($dataUpdateIsci[$i], $turGunReturn);

                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turUpdateDataIsci);

                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                }
                            }
                        }
                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurGidisDuzenleme"];
                        $kurumRenk = 'warning';
                        $kurumUrl = 'turliste';
                        $kurumIcon = 'fa fa-refresh';
                        //bildirim ayarları
                        if ($adminRutbe != 1) {//normal admin
                            $adminIDLer = array(1, $adminID);
                            $adminImplodeID = implode(',', $adminIDLer);
                            $resultAdminBolgeler = $Panel_Model->digerOrtakTekBolge($bolgeID, $adminImplodeID);
                            $adminBolgeCount = count($resultAdminBolgeler);
                            if ($adminBolgeCount > 0) {//diğer adminler
                                $multiData[0] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 52);
                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                    $multiData[$b + 1] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 52);
                                }
                                $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                if ($resultBildirim) {
                                    $adminNotfIDLer = array(1, $adminImplodeID);
                                    $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                    $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                    if (count($resultAdminCihaz) > 0) {
                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                        }
                                        $adminCihaz = implode(',', $adminCihaz);
                                        $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            } else {
                                $dataBildirim = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 52);
                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                if ($resultBildirim) {
                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                    if (count($resultAdminCihaz) > 0) {
                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                        }
                                        $adminCihaz = implode(',', $adminCihaz);
                                        $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            }
                        } else {//üst admin
                            $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($bolgeID);
                            $adminIDCount = count($resultBolgeAdminID);
                            if ($adminIDCount > 0) {
                                for ($b = 0; $b < $adminIDCount; $b++) {
                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 52);
                                }
                                $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                if ($resultBildirim) {
                                    $adminImplodeID = implode(',', $resultBolgeAdminID);
                                    $adminNotfIDLer = array($adminImplodeID);
                                    $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                    $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                    if (count($resultAdminCihaz) > 0) {
                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                        }
                                        $adminCihaz = implode(',', $adminCihaz);
                                        $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            }
                        }
                        //log ayarları
                        $dataLog = $form->adminBildirimLogDuzen($adminID, $adSoyad, $alert);
                        $resultLog = $Panel_Model->addNewAdminBildirimLog($dataLog);
                        if ($resultLog) {
                            $sonuc["turGidisID"] = $resultTurTip;
                            $sonuc["update"] = $deger["GidisTurDuzenle"];
                        } else {
                            $sonuc["hata"] = $deger["Hata"];
                        }
                    }
                    break;
                case "turDetailDelete":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        $form->post('turID', true);
                        $form->post('kurumTip', true);
                        $form->post('bolgeID', true);
                        $form->post('hostesID', true);
                        $form->post('soforID', true);
                        $form->post('turAd', true);
                        $turID = $form->values['turID'];
                        $turAdi = $form->values['turAd'];
                        $kurumTip = $form->values['kurumTip'];
                        $bolgeID = $form->values['bolgeID'];
                        $turHostesID = $form->values['hostesID'];
                        $turSoforID = $form->values['soforID'];
                        $turOgrenciID = $_REQUEST['turOgrenciID'];
                        $turIsciID = $_REQUEST['turKisiIsciID'];

                        $deleteresult = $Panel_Model->turDelete($turID);
                        if ($deleteresult) {
                            $deleteresultt = $Panel_Model->turTipDelete($turID);
                            if ($deleteresultt) {
                                if ($kurumTip == 0) {//öğrenci
                                    $ogrencidelete = $Panel_Model->detailGidisOgrenciDelete($turID);

                                    //öğrenciye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurSilme"];
                                    $ogrenciBildirimID = implode(",", $turOgrenciID);
                                    $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                    if (count($resultOgrenciCihaz) > 0) {
                                        foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                            $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                        $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurSil"]);
                                    }

                                    //veliye bildirim gönderme
                                    $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                    if (count($resultVeliOgrenci) > 0) {
                                        foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                            $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                        }
                                        $ogrenciVelim = implode(',', $ogrenciVeliler);
                                        $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                        foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                            $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                        }
                                        $veliCihazlar = implode(',', $veliCihaz);
                                        $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurSil"]);
                                    }
                                } else if ($kurumTip == 1) {//işçi
                                    $iscidelete = $Panel_Model->detailGidisIsciDelete($turID);
                                    //işçiye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurSilme"];
                                    $isciBildirimID = implode(",", $turIsciID);
                                    $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurSil"]);
                                    }
                                } else {//öğrenci ve işçi
                                    $isciogrencidelete = $Panel_Model->detailGidisOgrenciIsciDelete($turID);

                                    if (count($turOgrenciID) > 0) {
                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurSilme"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciID);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurSil"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurSil"]);
                                        }
                                    }

                                    if (count($turIsciID) > 0) {
                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurSilme"];
                                        $isciBildirimID = implode(",", $turIsciID);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurSil"]);
                                        }
                                    }
                                }
                            }

                            //şoföre bildirim gönderme
                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurSilme"];
                            $resultSoforCihaz = $Panel_Model->soforCihaz($turSoforID);
                            if (count($resultSoforCihaz) > 0) {
                                foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                    $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                }
                                $soforCihazlar = implode(',', $soforCihaz);
                                $form->shuttleNotification($soforCihazlar, $alert, $degerbildirim["TurSil"]);
                            }
                            //hostes varsa
                            if ($turHostesID) {
                                //hostese bildirim gönderme
                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurSilme"];
                                $resultHostesCihaz = $Panel_Model->hostesCihaz($turHostesID);
                                if (count($resultHostesCihaz) > 0) {
                                    foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                        $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                    }
                                    $hostesCihazlar = implode(',', $hostesCihaz);
                                    $form->shuttleNotification($hostesCihazlar, $alert, $degerbildirim["TurSil"]);
                                }
                            }

                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurSilme"];
                            $kurumRenk = 'danger';
                            $kurumUrl = 'turliste';
                            $kurumIcon = 'fa fa-refresh';
                            //bildirim ayarları
                            if ($adminRutbe != 1) {//normal admin
                                $adminIDLer = array(1, $adminID);
                                $adminImplodeID = implode(',', $adminIDLer);
                                $resultAdminBolgeler = $Panel_Model->digerOrtakTekBolge($bolgeID, $adminImplodeID);
                                $adminBolgeCount = count($resultAdminBolgeler);
                                if ($adminBolgeCount > 0) {//diğer adminler
                                    $multiData[0] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 32);
                                    for ($b = 0; $b < $adminBolgeCount; $b++) {
                                        $multiData[$b + 1] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 32);
                                    } $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                    if ($resultBildirim) {
                                        $adminNotfIDLer = array(1, $adminImplodeID);
                                        $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                        $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurSil"]);
                                        }
                                    }
                                } else {
                                    $dataBildirim = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 32);
                                    $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                    if ($resultBildirim) {
                                        $resultAdminCihaz = $Panel_Model->adminCihaz();
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurSil"]);
                                        }
                                    }
                                }
                            } else {//üst admin
                                $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($bolgeID);
                                $adminIDCount = count($resultBolgeAdminID);
                                if ($adminIDCount > 0) {
                                    for ($b = 0; $b < $adminIDCount; $b++) {
                                        $multiData[$b] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 32);
                                    }
                                    $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                    if ($resultBildirim) {
                                        $adminImplodeID = implode(',', $resultBolgeAdminID);
                                        $adminNotfIDLer = array($adminImplodeID);
                                        $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                        $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                        if (count($resultAdminCihaz) > 0) {
                                            foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                                $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                            }
                                            $adminCihaz = implode(',', $adminCihaz);
                                            $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurSil"]);
                                        }
                                    }
                                }
                            }

                            //log ayarları
                            $dataLog = $form->adminBildirimLogDuzen($adminID, $adSoyad, $alert);
                            $resultLog = $Panel_Model->addNewAdminBildirimLog($dataLog);
                            if ($resultLog) {
                                $sonuc["delete"] = $deger["TurSilme"];
                            } else {
                                $sonuc["hata"] = $deger["Hata"];
                            }
                        } else {
                            $sonuc["hata"] = $deger["Hata"];
                        }
                    }
                    break;
                case "adminTurDetayDonus":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("donusTipID", true);
                        $form->post("turTip", true);
                        $form->post("kurumID", true);
                        $form->post("turID", true);
                        $donusTipID = $form->values['donusTipID'];
                        $gidisTip = $form->values['turTip'];
                        $turKurumID = $form->values['kurumID'];
                        $turID = $form->values['turID'];

                        if ($gidisTip == 0) { //öğrenci
                            $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                            $turKurumOgrenci = [];
                            foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                            }
                            //herhangi bir tura kayıtlı öğrenciler
                            $kurumTurAitOgrenci = $Panel_Model->turKurumAitOgrenci($turKurumID);
                            $turKurumAitOgrenci = [];
                            foreach ($kurumTurAitOgrenci as $kurumTurAitOgrencii) {
                                $turKurumAitOgrenci[] = $kurumTurAitOgrencii['BSOgrenciID'];
                            }
                            $turKurumNotTurOgrenci = array_diff($turKurumOgrenci, $turKurumAitOgrenci);

                            $kurumOgrenci = implode(',', $turKurumNotTurOgrenci);
                            $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                            $b = 0;
                            foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                $turDigerKisi[$b]['digerKisiTip'] = 0;
                                $turDigerKisi[$b]['digerKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                $turDigerKisi[$b]['digerKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                $turDigerKisi[$b]['digerKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                $turDigerKisi[$b]['digerKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                $b++;
                            }

                            $turDetayGidisKisi = $Panel_Model->turDetayGidisOgrenci($turID);
                            $a = 0;
                            foreach ($turDetayGidisKisi as $turDetayGidisKisii) {
                                $turDetayDonus['KisiTip'][$a] = 0;
                                $turDetayDonus['KisiID'][$a] = $turDetayGidisKisii['BSOgrenciID'];
                                $turDetayDonus['KisiAd'][$a] = $turDetayGidisKisii['BSOgrenciAd'];
                                $turDetayDonus['KisiLocation'][$a] = $turDetayGidisKisii['BSOgrenciLocation'];
                                $turDetayDonus['Pzt'][$a] = $turDetayGidisKisii['SBTurPzt'];
                                $turDetayDonus['Sli'][$a] = $turDetayGidisKisii['SBTurSli'];
                                $turDetayDonus['Crs'][$a] = $turDetayGidisKisii['SBTurCrs'];
                                $turDetayDonus['Prs'][$a] = $turDetayGidisKisii['SBTurPrs'];
                                $turDetayDonus['Cma'][$a] = $turDetayGidisKisii['SBTurCma'];
                                $turDetayDonus['Cmt'][$a] = $turDetayGidisKisii['SBTurCmt'];
                                $turDetayDonus['Pzr'][$a] = $turDetayGidisKisii['SBTurPzr'];
                                $a++;
                            }
                        } else if ($gidisTip == 1) {//işçi
                            $kurumIsciListe = $Panel_Model->turKurumIsci($turKurumID);
                            $turKurumIsci = [];
                            foreach ($kurumIsciListe as $kurumIsciListee) {
                                $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                            }
                            //herhangi bir tura kayıtlı işçiler
                            $kurumTurAitIsci = $Panel_Model->turKurumAitIsci($turKurumID);
                            $turKurumAitIsci = [];
                            foreach ($kurumTurAitIsci as $kurumTurAitIscii) {
                                $turKurumAitIsci[] = $kurumTurAitIscii['SBIsciID'];
                            }
                            $turKurumNotTurIsci = array_diff($turKurumIsci, $turKurumAitIsci);
                            $kurumIsci = implode(',', $turKurumNotTurIsci);
                            $kurumIsciListesi = $Panel_Model->turKurumIscii($kurumIsci);
                            $b = 0;
                            foreach ($kurumIsciListesi as $kurumIsciListesii) {
                                $turDigerKisi[$b]['digerKisiTip'] = 1;
                                $turDigerKisi[$b]['digerKisiID'] = $kurumIsciListesii['SBIsciID'];
                                $turDigerKisi[$b]['digerKisiAd'] = $kurumIsciListesii['SBIsciAd'];
                                $turDigerKisi[$b]['digerKisiSoyad'] = $kurumIsciListesii['SBIsciSoyad'];
                                $turDigerKisi[$b]['digerKisiLocation'] = $kurumIsciListesii['SBIsciLocation'];
                                $b++;
                            }


                            $turDetayGidisKisi = $Panel_Model->turDetayGidisIsci($turID);
                            $a = 0;
                            foreach ($turDetayGidisKisi as $turDetayGidisKisii) {
                                $turDetayDonus['KisiTip'][$a] = 1;
                                $turDetayDonus['KisiID'][$a] = $turDetayGidisKisii['SBIsciID'];
                                $turDetayDonus['KisiAd'][$a] = $turDetayGidisKisii['SBIsciAd'];
                                $turDetayDonus['KisiLocation'][$a] = $turDetayGidisKisii['SBIsciLocation'];
                                $turDetayDonus['Pzt'][$a] = $turDetayGidisKisii['SBTurPzt'];
                                $turDetayDonus['Sli'][$a] = $turDetayGidisKisii['SBTurSli'];
                                $turDetayDonus['Crs'][$a] = $turDetayGidisKisii['SBTurCrs'];
                                $turDetayDonus['Prs'][$a] = $turDetayGidisKisii['SBTurPrs'];
                                $turDetayDonus['Cma'][$a] = $turDetayGidisKisii['SBTurCma'];
                                $turDetayDonus['Cmt'][$a] = $turDetayGidisKisii['SBTurCmt'];
                                $turDetayDonus['Pzr'][$a] = $turDetayGidisKisii['SBTurPzr'];
                                $a++;
                            }
                        } else {//öğrenci ve işçi
                            $kurumIsciListe = $Panel_Model->turKurumIsci($turKurumID);
                            if (count($kurumIsciListe) > 0) {//hem öğrenci hem de personel
                                $turKurumIsci = [];
                                foreach ($kurumIsciListe as $kurumIsciListee) {
                                    $turKurumIsci[] = $kurumIsciListee['SBIsciID'];
                                }
                                //herhangi bir tura kayıtlı işçiler
                                $kurumTurAitPersonel = $Panel_Model->turKurumAitPersonel($turKurumID);
                                if (count($kurumTurAitPersonel) > 0) {
                                    $turKurumAitPersonel = [];
                                    foreach ($kurumTurAitPersonel as $kurumTurAitPersonell) {
                                        $turKurumAitPersonel[] = $kurumTurAitPersonell['BSOgrenciIsciID'];
                                    }
                                    $turKurumNotTurPersonel = array_diff($turKurumIsci, $turKurumAitPersonel);
                                    $kurumIsci = implode(',', $turKurumNotTurPersonel);
                                } else {
                                    $kurumIsci = implode(',', $turKurumIsci);
                                }

                                $kurumIsciListesi = $Panel_Model->turKurumIscii($kurumIsci);
                                $b = 0;
                                foreach ($kurumIsciListesi as $kurumIsciListesii) {
                                    $turDigerKisi[$b]['digerKisiTip'] = 1;
                                    $turDigerKisi[$b]['digerKisiID'] = $kurumIsciListesii['SBIsciID'];
                                    $turDigerKisi[$b]['digerKisiAd'] = $kurumIsciListesii['SBIsciAd'];
                                    $turDigerKisi[$b]['digerKisiSoyad'] = $kurumIsciListesii['SBIsciSoyad'];
                                    $turDigerKisi[$b]['digerKisiLocation'] = $kurumIsciListesii['SBIsciLocation'];
                                    $b++;
                                }

                                $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                                $turKurumOgrenci = [];
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                }

                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                if (count($kurumTurAitOgrenciler) > 0) {
                                    $turKurumAitOgrenciler = [];
                                    foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                        $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
                                    }
                                    $turKurumNotTurOgrenciler = array_diff($turKurumOgrenci, $turKurumAitOgrenciler);

                                    $kurumOgrenci = implode(',', $turKurumNotTurOgrenciler);
                                } else {
                                    $kurumOgrenci = implode(',', $turKurumOgrenci);
                                }

                                $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                                $d = $b;
                                foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                    $turDigerKisi[$d]['digerKisiTip'] = 0;
                                    $turDigerKisi[$d]['digerKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                    $turDigerKisi[$d]['digerKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                    $turDigerKisi[$d]['digerKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                    $turDigerKisi[$d]['digerKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                    $d++;
                                }
                            } else {//sadece öğrenci
                                $kurumOgrenciListe = $Panel_Model->turKurumOgrenci($turKurumID);
                                $turKurumOgrenci = [];
                                foreach ($kurumOgrenciListe as $kurumOgrenciListee) {
                                    $turKurumOgrenci[] = $kurumOgrenciListee['BSOgrenciID'];
                                }
                                //herhangi bir tura kayıtlı öğrenciler
                                $kurumTurAitOgrenciler = $Panel_Model->turKurumAitOgrenciler($turKurumID);
                                $turKurumAitOgrenciler = [];
                                foreach ($kurumTurAitOgrenciler as $kurumTurAitOgrencilerr) {
                                    $turKurumAitOgrenciler[] = $kurumTurAitOgrencilerr['BSOgrenciIsciID'];
                                }
                                $turKurumNotTurOgrenciler = array_diff($turKurumOgrenci, $turKurumAitOgrenciler);

                                $kurumOgrenci = implode(',', $turKurumNotTurOgrenciler);
                                $kurumOgrenciListesi = $Panel_Model->turKurumOgrencii($kurumOgrenci);
                                $d = 0;
                                foreach ($kurumOgrenciListesi as $kurumOgrenciListesii) {
                                    $turDigerKisi[$d]['digerKisiTip'] = 0;
                                    $turDigerKisi[$d]['digerKisiID'] = $kurumOgrenciListesii['BSOgrenciID'];
                                    $turDigerKisi[$d]['digerKisiAd'] = $kurumOgrenciListesii['BSOgrenciAd'];
                                    $turDigerKisi[$d]['digerKisiSoyad'] = $kurumOgrenciListesii['BSOgrenciSoyad'];
                                    $turDigerKisi[$d]['digerKisiLocation'] = $kurumOgrenciListesii['BSOgrenciLocation'];
                                    $d++;
                                }
                            }

                            $turDetayGidisKisi = $Panel_Model->turDetayGidisIsciOgrenci($turID);
                            $a = 0;
                            foreach ($turDetayGidisKisi as $turDetayGidisKisii) {
                                $turDetayDonus['KisiTip'][$a] = $turDetayGidisKisii['BSKullaniciTip'];
                                $turDetayDonus['KisiID'][$a] = $turDetayGidisKisii['BSOgrenciIsciID'];
                                $turDetayDonus['KisiAd'][$a] = $turDetayGidisKisii['BSOgrenciIsciAd'];
                                $turDetayDonus['KisiLocation'][$a] = $turDetayGidisKisii['BSOgrenciIsciLocation'];
                                $turDetayDonus['Pzt'] = $turDetayGidisKisii['SBTurPzt'];
                                $turDetayDonus['Sli'] = $turDetayGidisKisii['SBTurSli'];
                                $turDetayDonus['Crs'] = $turDetayGidisKisii['SBTurCrs'];
                                $turDetayDonus['Prs'] = $turDetayGidisKisii['SBTurPrs'];
                                $turDetayDonus['Cma'] = $turDetayGidisKisii['SBTurCma'];
                                $turDetayDonus['Cmt'] = $turDetayGidisKisii['SBTurCmt'];
                                $turDetayDonus['Pzr'] = $turDetayGidisKisii['SBTurPzr'];
                                $a++;
                            }
                        }
                        $sonuc["donus"] = $turDetayDonus;
                        $sonuc["donusDiger"] = $turDigerKisi;
                    }
                    break;
                case "turDonusAracSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("bolgeID", true);
                        $form->post("kurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $turBolgeID = $form->values['bolgeID'];
                        $turKurumID = $form->values['kurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turGunler = $_REQUEST['turGunID'];
                        $gunSaatSql = $form->sqlGunSaat($turBolgeID, $turSaat1ID, $turSaat2ID, $turGunler);
                        $turAracListe = $Panel_Model->turAracSelect($gunSaatSql);

                        $turAktifAracId = [];
                        foreach ($turAracListe as $turAracListee) {
                            $turAktifAracId[] = $turAracListee['BSTurAracID'];
                        }

                        $turBolgeAracListe = $Panel_Model->turBolgeAracListele($turBolgeID);

                        if (count($turBolgeAracListe) > 0) {
                            //bölgede araç varsa
                            $turBolgeArac = [];
                            foreach ($turBolgeAracListe as $turBolgeAracListee) {
                                $turBolgeArac[] = $turBolgeAracListee['SBAracID'];
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
                case "turDonusSoforSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("bolgeID", true);
                        $form->post("kurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $form->post("aracID", true);
                        $turBolgeID = $form->values['bolgeID'];
                        $turKurumID = $form->values['kurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turAracID = $form->values['aracID'];
                        $turGunler = $_REQUEST['turGunID'];

                        $gunSaatSoforSql = $form->sqlGunSaatSofor($turBolgeID, $turAracID, $turSaat1ID, $turSaat2ID, $turGunler);

                        $turSoforListe = $Panel_Model->turSoforSelect($gunSaatSoforSql);

                        $turAktifSoforId = [];
                        foreach ($turSoforListe as $turSoforListee) {
                            $turAktifSoforId[] = $turSoforListee['BSTurSoforID'];
                        }

                        $turAracSoforListe = $Panel_Model->turAracSoforListele($turAracID);

                        if (count($turAracSoforListe) > 0) {
                            //araça ait şoför varsa
                            $turAracSofor = [];
                            foreach ($turAracSoforListe as $turAracSoforListee) {
                                $turAracSofor[] = $turAracSoforListee['BSSoforID'];
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
                case "turDonusHostesSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("bolgeID", true);
                        $form->post("kurumID", true);
                        $form->post("turSaat1ID", true);
                        $form->post("turSaat2ID", true);
                        $form->post("aracID", true);
                        $turBolgeID = $form->values['bolgeID'];
                        $turKurumID = $form->values['kurumID'];
                        $turSaat1ID = $form->values['turSaat1ID'];
                        $turSaat2ID = $form->values['turSaat2ID'];
                        $turAracID = $form->values['aracID'];
                        $turGunler = $_REQUEST['turGunID'];

                        $gunSaatHostesSql = $form->sqlGunSaatHostes($turBolgeID, $turAracID, $turSaat1ID, $turSaat2ID, $turGunler);

                        $turHostesListe = $Panel_Model->turHostesSelect($gunSaatHostesSql);

                        $turAktifHostesId = [];
                        foreach ($turHostesListe as $turHostesListee) {
                            $turAktifHostesId[] = $turHostesListee['BSTurHostesID'];
                        }

                        $turAracHostesListe = $Panel_Model->turAracHostesListele($turAracID);

                        if (count($turAracHostesListe) > 0) {
                            //araça ait hostes varsa
                            $turAracHostes = [];
                            foreach ($turAracHostesListe as $turAracHostesListee) {
                                $turAracHostes[] = $turAracHostesListee['BSHostesID'];
                            }

                            if (count($turHostesListe) > 0) {//aktif hostes varsa
                                $bolgePasifHostes = array_diff($turAracHostes, $turAktifHostesId);
                                if (count($bolgePasifHostes) > 0) {//aracın birden fazla hostesi varsa
                                    $pasifHostes = implode(',', $bolgePasifHostes);
                                    //bölgedeki pasif hostesler
                                    $turPasifHostesListe = $Panel_Model->turAracPasifHostesListele($pasifHostes);
                                    $c = 0;
                                    foreach ($turPasifHostesListe as $turPasifHostesListee) {
                                        $turHostes[$c]['turHostesID'] = $turPasifHostesListee['BSHostesID'];
                                        $turHostes[$c]['turHostesAd'] = $turPasifHostesListee['BSHostesAd'];
                                        $turHostes[$c]['turHostesSoyad'] = $turPasifHostesListee['BSHostesSoyad'];
                                        $turHostes[$c]['turHostesLocation'] = $turPasifHostesListee['BSHostesLocation'];
                                        $c++;
                                    }
                                }
                            } else {//aktif şoför yoksa
                                $pasifHostes = implode(',', $turAracHostes);
                                $turPasifHostesListe = $Panel_Model->turAracPasifHostesListele($pasifHostes);
                                $c = 0;
                                foreach ($turPasifHostesListe as $turPasifHostesListee) {
                                    $turHostes[$c]['turHostesID'] = $turPasifHostesListee['BSHostesID'];
                                    $turHostes[$c]['turHostesAd'] = $turPasifHostesListee['BSHostesAd'];
                                    $turHostes[$c]['turHostesSoyad'] = $turPasifHostesListee['BSHostesSoyad'];
                                    $turHostes[$c]['turHostesLocation'] = $turPasifHostesListee['BSHostesLocation'];
                                    $c++;
                                }
                            }
                        }
                        $sonuc["pasifHostes"] = $turHostes;
                    }
                    break;
                case "turDonusKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");

                        $form->post("turSaat1", true);
                        $form->post("turSaat2", true);
                        $form->post("aracID", true);
                        $form->post("aracPlaka", true);
                        $form->post("aracKapasite", true);
                        $form->post("soforID", true);
                        $form->post("soforAd", true);
                        $form->post("soforLocation", true);
                        $form->post("hostesID", true);
                        $form->post("hostesAd", true);
                        $form->post("hostesLocation", true);
                        $form->post("turID", true);
                        $form->post("turGidisID", true);
                        $form->post("turDonusID", true);
                        $form->post("kurumTip", true);
                        $form->post("bolgeID", true);
                        $form->post("bolgead", true);
                        $form->post("turAdi", true);
                        $form->post("turAciklama", true);
                        $form->post("kurumad", true);
                        $form->post("kurumId", true);
                        $form->post("kurumLocation", true);
                        $form->post("turKm", true);
                        $bolgeID = $form->values['bolgeID'];
                        $bolgeAd = $form->values['bolgead'];
                        $kurumID = $form->values['kurumId'];
                        $kurumAd = $form->values['kurumad'];
                        $kurumLocation = $form->values['kurumLocation'];
                        $turTipGidisID = $form->values['turGidisID'];
                        $turTipDonusID = $form->values['turDonusID'];
                        $turAdi = $form->values['turAdi'];
                        $turAciklama = $form->values['turAciklama'];
                        $turSaat1 = $form->values['turSaat1'];
                        $turSaat2 = $form->values['turSaat2'];
                        $turAracID = $form->values['aracID'];
                        $turAracPlaka = $form->values['aracPlaka'];
                        $turAracKapasite = $form->values['aracKapasite'];
                        $turSoforID = $form->values['soforID'];
                        $turSoforAd = $form->values['soforAd'];
                        $turSoforLocation = $form->values['soforLocation'];
                        $turHostesID = $form->values['hostesID'];
                        $turHostesAd = $form->values['hostesAd'];
                        $turHostesLocation = $form->values['hostesLocation'];
                        $kurumTip = $form->values['kurumTip'];
                        $turID = $form->values['turID'];
                        $turKm = $form->values['turKm'];
                        $turGunler = $_REQUEST['turGun'];
                        $turOgrenciID = $_REQUEST['turOgrenciID'];
                        $turOgrenciAd = $_REQUEST['turOgrenciAd'];
                        $turOgrenciLocation = $_REQUEST['turOgrenciLocation'];
                        $turOgrenciSira = $_REQUEST['turOgrenciSira'];
                        $turIsciID = $_REQUEST['turKisiIsciID'];
                        $turIsciAd = $_REQUEST['turKisiIsciAd'];
                        $turIsciLocation = $_REQUEST['turKisiIsciLocation'];
                        $turIsciSira = $_REQUEST['turKisiIsciSira'];
                        $turGunReturn = $form->sqlGunInsert($turGunler);
                        $turGunReturnUpdate = $form->sqlGunUpdate($turGunler);

                        //gidiş Tur düzenleme
                        if ($form->submit()) {
                            $updateGidisTur = array(
                                'SBTurAd' => $turAdi,
                                'SBTurAciklama' => $turAciklama,
                                'SBTurGidis' => 1,
                                'SBTurKm' => $turKm,
                            );
                            $turGidisUpdate = array_merge($updateGidisTur, $turGunReturnUpdate);
                        }
                        $resultTurUpdate = $Panel_Model->turTipDuzenle($turGidisUpdate, $turID);

                        //Tur Dönüş varsa Düzenleme
                        if ($turTipDonusID) {//daha önce kaydedilmişse güncelleme yapılacak
                            //Dönüş tur tip düzenleme
                            if ($form->submit()) {
                                $gidisTurTipdata = array(
                                    'BSTurAracID' => $turAracID,
                                    'BSTurAracPlaka' => $turAracPlaka,
                                    'BSTurAracKapasite' => $turAracKapasite,
                                    'BSTurSoforID' => $turSoforID,
                                    'BSTurSoforAd' => $turSoforAd,
                                    'BSTurSoforLocation' => $turSoforLocation,
                                    'BSTurHostesID' => $turHostesID,
                                    'BSTurHostesAd' => $turHostesAd,
                                    'BSTurHostesLocation' => $turHostesLocation,
                                    'BSTurBslngc' => $turSaat1,
                                    'BSTurBts' => $turSaat2,
                                    'BSTurKm' => $turKm,
                                );
                                $turTipGidisDatam = array_merge($gidisTurTipdata, $turGunReturnUpdate);
                            }
                            $resultTurTip = $Panel_Model->turTipDonusDuzenle($turTipGidisDatam, $turTipDonusID);
                            //şoföre bildirim gönderme
                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                            $resultSoforCihaz = $Panel_Model->soforCihaz($turSoforID);
                            if (count($resultSoforCihaz) > 0) {
                                foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                    $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                }
                                $soforCihazlar = implode(',', $soforCihaz);
                                $form->shuttleNotification($soforCihazlar, $alert, $degerbildirim["TurDuzen"]);
                            }
                            //hostes varsa
                            if ($turHostesID) {
                                //hostese bildirim gönderme
                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                $resultHostesCihaz = $Panel_Model->hostesCihaz($turHostesID);
                                if (count($resultHostesCihaz) > 0) {
                                    foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                        $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                    }
                                    $hostesCihazlar = implode(',', $hostesCihaz);
                                    $form->shuttleNotification($hostesCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                }
                            }
                            //gidişi varmı kontrolü
                            if ($turTipGidisID) {//varsa
                                if ($kurumTip == 0) {//öğrenci
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurGidis' => $turTipGidisID,
                                                'BSTurDonus' => $turTipDonusID
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurOgrenci($turDataOgrenci[$o]);

                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else if ($kurumTip == 1) {//işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisIsciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'SBTurSira' => $turIsciSira[$i],
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
                                                'SBTurGidis' => $turTipGidisID,
                                                'SBTurDonus' => $turTipDonusID
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsci($turDataIsci);

                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else {//öğrenci ve işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciIsciDelete($turID);
                                    if ($deleteresultt) {
                                        //öğrenci için
                                        if (count($turOgrenciID) > 0) {
                                            for ($o = 0; $o < count($turOgrenciID); $o++) {
                                                $updateGidisOgrenci[$o] = array(
                                                    'BSTurSira' => $turOgrenciSira[$o],
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
                                                    'BSTurGidis' => $turTipGidisID,
                                                    'BSTurDonus' => $turTipDonusID
                                                );
                                                $turUpdateDataOgrenci[$o] = array_merge($updateGidisOgrenci[$o], $turGunReturn);
                                                $turOgrenciBildirim[] = $turOgrenciID[$o];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataOgrenci);
                                            //öğrenciye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                            $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                            $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                            if (count($resultOgrenciCihaz) > 0) {
                                                foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                    $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                                }
                                                $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                                $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }

                                            //veliye bildirim gönderme
                                            $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                            if (count($resultVeliOgrenci) > 0) {
                                                foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                    $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                                }
                                                $ogrenciVelim = implode(',', $ogrenciVeliler);
                                                $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                                foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                    $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                                }
                                                $veliCihazlar = implode(',', $veliCihaz);
                                                $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                        //işçi için
                                        if (count($turIsciID) > 0) {
                                            for ($i = 0; $i < count($turIsciID); $i++) {
                                                $dataUpdateIsci[$i] = array(
                                                    'BSTurSira' => $turIsciSira[$i],
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
                                                    'BSTurGidis' => $turTipGidisID,
                                                    'BSTurDonus' => $turTipDonusID
                                                );
                                                $turUpdateDataIsci[$i] = array_merge($dataUpdateIsci[$i], $turGunReturn);

                                                $turIsciBildirim[] = $turIsciID[$i];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataIsci);

                                            //işçiye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                            $isciBildirimID = implode(",", $turIsciBildirim);
                                            $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                            if (count($resultIsciCihaz) > 0) {
                                                foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                    $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                                }
                                                $isciCihazlar = implode(',', $isciCihaz);
                                                $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                    }
                                }
                            } else {//yoksa
                                if ($kurumTip == 0) {//öğrenci
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $dataOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurDonus' => $turTipDonusID
                                            );
                                            $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurOgrenci($turDataOgrenci[$o]);

                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }

                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else if ($kurumTip == 1) {//işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisIsciDelete($turID);
                                    if ($deleteresultt) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataIsci[$i] = array(
                                                'SBTurSira' => $turIsciSira[$i],
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
                                                'SBTurDonus' => $turTipDonusID
                                            );
                                            $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);
                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsci($turDataIsci);

                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                } else {//öğrenci ve işçi
                                    //önce silip sonra kaydedeceğiz
                                    $deleteresultt = $Panel_Model->detailGidisOgrenciIsciDelete($turID);
                                    if ($deleteresultt) {
                                        //öğrenci için
                                        if (count($turOgrenciID) > 0) {
                                            for ($o = 0; $o < count($turOgrenciID); $o++) {
                                                $updateGidisOgrenci[$o] = array(
                                                    'BSTurSira' => $turOgrenciSira[$o],
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
                                                    'BSTurDonus' => $turTipDonusID
                                                );
                                                $turUpdateDataOgrenci[$o] = array_merge($updateGidisOgrenci[$o], $turGunReturn);
                                                $turOgrenciBildirim[] = $turOgrenciID[$o];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataOgrenci);

                                            //öğrenciye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                            $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                            $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                            if (count($resultOgrenciCihaz) > 0) {
                                                foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                    $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                                }
                                                $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                                $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }

                                            //veliye bildirim gönderme
                                            $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                            if (count($resultVeliOgrenci) > 0) {
                                                foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                    $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                                }
                                                $ogrenciVelim = implode(',', $ogrenciVeliler);
                                                $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                                foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                    $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                                }
                                                $veliCihazlar = implode(',', $veliCihaz);
                                                $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                        //işçi için
                                        if (count($turIsciID) > 0) {
                                            for ($i = 0; $i < count($turIsciID); $i++) {
                                                $dataUpdateIsci[$i] = array(
                                                    'BSTurSira' => $turIsciSira[$i],
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
                                                    'BSTurDonus' => $turTipDonusID
                                                );
                                                $turUpdateDataIsci[$i] = array_merge($dataUpdateIsci[$i], $turGunReturn);
                                                $turIsciBildirim[] = $turIsciID[$i];
                                            }
                                            $Panel_Model->addNewTurIsciOgrenci($turUpdateDataIsci);

                                            //işçiye bildirim gönderme
                                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                            $isciBildirimID = implode(",", $turIsciBildirim);
                                            $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                            if (count($resultIsciCihaz) > 0) {
                                                foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                    $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                                }
                                                $isciCihazlar = implode(',', $isciCihaz);
                                                $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                            }
                                        }
                                    }
                                }
                            }
                        } else {//daha önce kaydedilmemişse insert yapacak
                            if ($form->submit()) {
                                $dataInsertGidis = array(
                                    'BSTurID' => $turID,
                                    'BSTurTip' => $kurumTip,
                                    'BSTurBolgeID' => $bolgeID,
                                    'BSTurBolgeAd' => $bolgeAd,
                                    'BSTurKurumID' => $kurumID,
                                    'BSTurKurumAd' => $kurumAd,
                                    'BSTurKurumLocation' => $kurumLocation,
                                    'BSTurAracID' => $turAracID,
                                    'BSTurAracPlaka' => $turAracPlaka,
                                    'BSTurAracKapasite' => $turAracKapasite,
                                    'BSTurSoforID' => $turSoforID,
                                    'BSTurSoforAd' => $turSoforAd,
                                    'BSTurSoforLocation' => $turSoforLocation,
                                    'BSTurHostesID' => $turHostesID,
                                    'BSTurHostesAd' => $turHostesAd,
                                    'BSTurHostesLocation' => $turHostesLocation,
                                    'BSTurBslngc' => $turSaat1,
                                    'BSTurBts' => $turSaat2,
                                    'BSTurGidisDonus' => 0,
                                    'BSTurKm' => $turKm,
                                );
                                $turUpdateDatam = array_merge($dataInsertGidis, $turGunReturn);
                            }
                            $resultTurTip = $Panel_Model->addNewTurTip($turUpdateDatam);

                            //şoföre bildirim gönderme
                            $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusAtama"];
                            $resultSoforCihaz = $Panel_Model->soforCihaz($turSoforID);
                            if (count($resultSoforCihaz) > 0) {
                                foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                    $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                }
                                $soforCihazlar = implode(',', $soforCihaz);
                                $form->shuttleNotification($soforCihazlar, $alert, $degerbildirim["TurAta"]);
                            }
                            //hostes varsa
                            if ($turHostesID) {
                                //hostese bildirim gönderme
                                $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusAtama"];
                                $resultHostesCihaz = $Panel_Model->hostesCihaz($turHostesID);
                                if (count($resultHostesCihaz) > 0) {
                                    foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                        $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                    }
                                    $hostesCihazlar = implode(',', $hostesCihaz);
                                    $form->shuttleNotification($hostesCihazlar, $alert, $degerbildirim["TurAta"]);
                                }
                            }
                            //eğer bu ilk defa ekleniyorsa gidişe ait bilgiler mevcuttur
                            if ($kurumTip == 0) {//öğrenci
                                //önce silip sonra kaydedeceğiz
                                $deleteresultt = $Panel_Model->detailGidisOgrenciDelete($turID);
                                if ($deleteresultt) {
                                    for ($o = 0; $o < count($turOgrenciID); $o++) {
                                        $dataOgrenci[$o] = array(
                                            'BSTurSira' => $turOgrenciSira[$o],
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
                                            'BSTurGidis' => $turGidisID,
                                            'BSTurDonus' => $turTipDonusID
                                        );
                                        $turDataOgrenci[$o] = array_merge($dataOgrenci[$o], $turGunReturn);
                                        $turOgrenciBildirim[] = $turOgrenciID[$o];
                                    }
                                    $Panel_Model->addNewTurOgrenci($turDataOgrenci[$o]);
                                    //öğrenciye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                    $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                    $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                    if (count($resultOgrenciCihaz) > 0) {
                                        foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                            $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                        $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                    //veliye bildirim gönderme
                                    $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                    if (count($resultVeliOgrenci) > 0) {
                                        foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                            $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                        }
                                        $ogrenciVelim = implode(',', $ogrenciVeliler);
                                        $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                        foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                            $veliCihaz[] = $resultVeliCihazz ['bsvelicihazRecID'];
                                        }
                                        $veliCihazlar = implode(',', $veliCihaz);
                                        $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            } else if ($kurumTip == 1) {//işçi
                                //önce silip sonra kaydedeceğiz
                                $deleteresultt = $Panel_Model->detailGidisIsciDelete($turID);
                                if ($deleteresultt) {
                                    for ($i = 0; $i < count($turIsciID); $i++) {
                                        $dataIsci[$i] = array(
                                            'SBTurSira' => $turIsciSira[$i],
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
                                            'SBTurGidis' => $turGidisID,
                                            'SBTurDonus' => $turTipDonusID
                                        );
                                        $turDataIsci[$i] = array_merge($dataIsci[$i], $turGunReturn);

                                        $turIsciBildirim[] = $turIsciID[$i];
                                    }
                                    $Panel_Model->addNewTurIsci($turDataIsci);
                                    //işçiye bildirim gönderme
                                    $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                    $isciBildirimID = implode(",", $turIsciBildirim);
                                    $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            } else {//öğrenci ve işçi
                                //önce silip sonra kaydedeceğiz
                                $deleteresultt = $Panel_Model->detailGidisOgrenciIsciDelete($turID);
                                if ($deleteresultt) {
                                    //öğrenci için
                                    if (count($turOgrenciID) > 0) {
                                        for ($o = 0; $o < count($turOgrenciID); $o++) {
                                            $updateGidisOgrenci[$o] = array(
                                                'BSTurSira' => $turOgrenciSira[$o],
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
                                                'BSTurGidis' => $turGidisID,
                                                'BSTurDonus' => $turTipDonusID
                                            );
                                            $turUpdateDataOgrenci[$o] = array_merge($updateGidisOgrenci[$o], $turGunReturn);
                                            $turOgrenciBildirim[] = $turOgrenciID[$o];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turUpdateDataOgrenci);

                                        //öğrenciye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                        $ogrenciBildirimID = implode(",", $turOgrenciBildirim);
                                        $resultOgrenciCihaz = $Panel_Model->ogrenciCihaz($ogrenciBildirimID);
                                        if (count($resultOgrenciCihaz) > 0) {
                                            foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                                $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                            }
                                            $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                            $form->shuttleNotification($ogrenciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                        //veliye bildirim gönderme
                                        $resultVeliOgrenci = $Panel_Model->veliOgrenci($ogrenciBildirimID);
                                        if (count($resultVeliOgrenci) > 0) {
                                            foreach ($resultVeliOgrenci as $resultVeliOgrencii) {
                                                $ogrenciVeliler[] = $resultVeliOgrencii['BSVeliID'];
                                            }
                                            $ogrenciVelim = implode(',', $ogrenciVeliler);
                                            $resultVeliCihaz = $Panel_Model->veliCihaz($ogrenciVelim);
                                            foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                                $veliCihaz[] = $resultVeliCihazz ['bsvelicihazRecID'];
                                            }
                                            $veliCihazlar = implode(',', $veliCihaz);
                                            $form->shuttleNotification($veliCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                    //işçi için
                                    if (count($turIsciID) > 0) {
                                        for ($i = 0; $i < count($turIsciID); $i++) {
                                            $dataUpdateIsci[$i] = array(
                                                'BSTurSira' => $turIsciSira[$i],
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
                                                'BSTurGidis' => $turGidisID,
                                                'BSTurDonus' => $turTipDonusID
                                            );
                                            $turUpdateDataIsci[$i] = array_merge($dataUpdateIsci[$i], $turGunReturn);
                                            $turIsciBildirim[] = $turIsciID[$i];
                                        }
                                        $Panel_Model->addNewTurIsciOgrenci($turUpdateDataIsci);
                                        //işçiye bildirim gönderme
                                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                                        $isciBildirimID = implode(",", $turIsciBildirim);
                                        $resultIsciCihaz = $Panel_Model->isciCihaz($isciBildirimID);
                                        if (count($resultIsciCihaz) > 0) {
                                            foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                                $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                            }
                                            $isciCihazlar = implode(',', $isciCihaz);
                                            $form->shuttleNotification($isciCihazlar, $alert, $degerbildirim["TurDuzen"]);
                                        }
                                    }
                                }
                            }
                        }
                        $alert = $adSoyad . ' ' . $turAdi . $degerbildirim["TurDonusDuzenleme"];
                        $kurumRenk = 'info';
                        $kurumUrl = 'turliste';
                        $kurumIcon = 'fa fa-refresh';
                        //bildirim ayarları
                        if ($adminRutbe != 1) {//normal admin
                            $adminIDLer = array(1, $adminID);
                            $adminImplodeID = implode(',', $adminIDLer);
                            $resultAdminBolgeler = $Panel_Model->digerOrtakTekBolge($bolgeID, $adminImplodeID);
                            $adminBolgeCount = count($resultAdminBolgeler);
                            if ($adminBolgeCount > 0) {//diğer adminler
                                $multiData[0] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 52);
                                for ($b = 0; $b < $adminBolgeCount; $b++) {
                                    $multiData[$b + 1] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultAdminBolgeler[$b]['BSAdminID'], 52);
                                } $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                if ($resultBildirim) {
                                    $adminNotfIDLer = array(1, $adminImplodeID);
                                    $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                    $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                    if (count($resultAdminCihaz) > 0) {
                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                        }
                                        $adminCihaz = implode(',', $adminCihaz);
                                        $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            } else {
                                $dataBildirim = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, 1, 52);
                                $resultBildirim = $Panel_Model->addNewAdminBildirim($dataBildirim);
                                if ($resultBildirim) {
                                    $resultAdminCihaz = $Panel_Model->adminCihaz();
                                    if (count($resultAdminCihaz) > 0) {
                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                        }
                                        $adminCihaz = implode(',', $adminCihaz);
                                        $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            }
                        } else {//üst admin
                            $resultBolgeAdminID = $Panel_Model->ortakAdminBolge($bolgeID);
                            $adminIDCount = count($resultBolgeAdminID);
                            if ($adminIDCount > 0) {
                                for ($b = 0; $b < $adminIDCount; $b++) {
                                    $multiData[$b] = $form->adminBildirimDuzen($alert, $kurumIcon, $kurumUrl, $kurumRenk, $adminID, $adSoyad, $resultBolgeAdminID[$b]['BSAdminID'], 52);
                                }
                                $resultBildirim = $Panel_Model->addNewAdminMultiBildirim($multiData);
                                if ($resultBildirim) {
                                    $adminImplodeID = implode(',', $resultBolgeAdminID);
                                    $adminNotfIDLer = array($adminImplodeID);
                                    $adminImplodeNtf = implode(',', $adminNotfIDLer);
                                    $resultAdminCihaz = $Panel_Model->digerAdminCihaz($adminImplodeNtf);
                                    if (count($resultAdminCihaz) > 0) {
                                        foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                            $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                        }
                                        $adminCihaz = implode(',', $adminCihaz);
                                        $form->shuttleNotification($adminCihaz, $alert, $degerbildirim["TurDuzen"]);
                                    }
                                }
                            }
                        }

                        //log ayarları
                        $dataLog = $form->adminBildirimLogDuzen($adminID, $adSoyad, $alert);
                        $resultLog = $Panel_Model->addNewAdminBildirimLog($dataLog);
                        if ($resultLog) {
                            $sonuc["turDonusID"] = $resultTurTip;
                            $sonuc["turDonusReply"] = $deger["DonusTurDuzenle"];
                        } else {
                            $sonuc["hata"] = $deger["Hata"];
                        }
                    }
                    break;
                case "turRapor":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("turID", true);
                        $turID = $form->values['turID'];
                        $turLogDetay = $Panel_Model->turDetayRapor($turID);
                        if (count($turLogDetay) > 0) {
                            $raporList = array();
                            $o = 0;
                            foreach ($turLogDetay as $turLogDetayy) {
                                $raporList[$o]['Km'] = $turLogDetayy['BSTurKm'];
                                $raporList[$o]['Saat'] = $turLogDetayy['BSTurSaat'];
                                $raporList[$o]['BsSaat'] = $turLogDetayy['BSTurBslngcSaat'];
                                $raporList[$o]['BtsSaat'] = $turLogDetayy['BSTurBtsSaat'];
                                if ($turLogDetayy['BSTurGun'] == 0) {
                                    $raporList[$o]['Gun'] = $deger["Pazartesi"];
                                } elseif ($turLogDetayy['BSTurGun'] == 1) {
                                    $raporList[$o]['Gun'] = $deger["Sali"];
                                } elseif ($turLogDetayy['BSTurGun'] == 2) {
                                    $raporList[$o]['Gun'] = $deger["Carsamba"];
                                } elseif ($turLogDetayy['BSTurGun'] == 3) {
                                    $raporList[$o]['Gun'] = $deger["Persembe"];
                                } elseif ($turLogDetayy['BSTurGun'] == 4) {
                                    $raporList[$o]['Gun'] = $deger["Cuma"];
                                } elseif ($turLogDetayy['BSTurGun'] == 5) {
                                    $raporList[$o]['Gun'] = $deger["Cumartesi"];
                                } elseif ($turLogDetayy['BSTurGun'] == 6) {
                                    $raporList[$o]['Gun'] = $deger["Pazar"];
                                }
                                if ($turLogDetayy['BSTurTip'] == 0) {
                                    $raporList[$o]['TipDeger'] = 0;
                                    $raporList[$o]['Tip'] = $deger["Ogrenci"];
                                } elseif ($turLogDetayy['BSTurTip'] == 1) {
                                    $raporList[$o]['TipDeger'] = 1;
                                    $raporList[$o]['Tip'] = $deger["Personel"];
                                } elseif ($turLogDetayy['BSTurTip'] == 2) {
                                    $raporList[$o]['TipDeger'] = 2;
                                    $raporList[$o]['Tip'] = $deger["OgrPer"];
                                }
                                $raporList[$o]['Tarih'] = $turLogDetayy['BSTurTarih'];
                                $raporList[$o]['KisiSayi'] = $turLogDetayy['BSTurKisiSayi'];
                                if ($turLogDetayy['BSTurGidisDonus'] == 0) {
                                    $raporList[$o]['GidDonDeger'] = 0;
                                    $raporList[$o]['GidDon'] = $deger['Gidis'];
                                } else if ($turLogDetayy['BSTurGidisDonus'] == 1) {
                                    $raporList[$o]['GidDonDeger'] = 1;
                                    $raporList[$o]['GidDon'] = $deger['Donus'];
                                }
                                $o++;
                            }
                        }
                        $sonuc["Detail"] = $raporList;
                    }
                    break;
                case "raporDetay":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post("rowID", true);
                        $form->post("ttip", true);
                        $form->post("tarih", true);
                        $form->post("tur", true);
                        $rowID = $form->values['rowID'];
                        $ttip = $form->values['ttip'];
                        $tarih = $form->values['tarih'];
                        $tur = $form->values['tur'];
                        $turLogDetay = array();
                        $list = array();
                        if ($ttip == 0) {//Öğrenci
                            if ($tur != 1) {//Gidiş
                                $turLogDetay = $Panel_Model->turDetayRaporOG($rowID, $tarih);
                                if ($turLogDetay) {
                                    //Gelen Kişiler
                                    $od = 0;
                                    foreach ($turLogDetay as $turLogDetayy) {
                                        $ogrlist[] = $turLogDetayy['BsKisiID'];
                                        $list[$od]['Saat'] = $turLogDetayy['BSTurSaat'];
                                        $od++;
                                    }
                                    $ogrIDler = implode(',', $ogrlist);
                                    $ogrAdSoyad = $Panel_Model->turDetayRaporOgrIdler($ogrIDler);
                                    $o = 0;
                                    foreach ($ogrAdSoyad as $ogrAdSoyadd) {
                                        $list[$o]["Ad"] = $ogrAdSoyadd['BSOgrenciAd'];
                                        $list[$o]["Soyad"] = $ogrAdSoyadd['BSOgrenciSoyad'];
                                        $list[$o]["Tip"] = $deger["Ogrenci"];
                                        $o++;
                                    }
                                    //Turun tamamındaki öğrenciler
                                    $turKisi = $Panel_Model->turDetayRaporOTur($rowID);
                                    foreach ($turKisi as $turKisii) {
                                        $ogrTumlist[] = $turKisii['BSOgrenciID'];
                                    }
                                    //Gelmeyen Öğrenciler
                                    $ogrGId = array_diff($ogrTumlist, $ogrlist);
                                    if (count($ogrGId) > 0) {
                                        $ogrGIDler = implode(',', $ogrGId);
                                        $ogrAdSyd = $Panel_Model->turDetayRaporOgrIdler($ogrGIDler);
                                        $og = 0;
                                        foreach ($ogrAdSyd as $ogrAdSydd) {
                                            $listGelmeyen[$og]["Ad"] = $ogrAdSydd['BSOgrenciAd'];
                                            $listGelmeyen[$og]["Soyad"] = $ogrAdSydd['BSOgrenciSoyad'];
                                            $listGelmeyen[$og]["Tip"] = $deger["Ogrenci"];
                                            $og++;
                                        }
                                    }
                                }
                            } else {//Dönüş
                                $turLogDetay = $Panel_Model->turDetayRaporOD($rowID, $tarih);
                                if ($turLogDetay) {
                                    $od = 0;
                                    foreach ($turLogDetay as $turLogDetayy) {
                                        $ogrlist[] = $turLogDetayy['BsKisiID'];
                                        $list[$od]['Saat'] = $turLogDetayy['BSTurSaat'];
                                        $od++;
                                    }
                                    $ogrIDler = implode(',', $ogrlist);
                                    $ogrAdSoyad = $Panel_Model->turDetayRaporOgrIdler($ogrIDler);
                                    $o = 0;
                                    foreach ($ogrAdSoyad as $ogrAdSoyadd) {
                                        $list[$o]["Ad"] = $ogrAdSoyadd['BSOgrenciAd'];
                                        $list[$o]["Soyad"] = $ogrAdSoyadd['BSOgrenciSoyad'];
                                        $list[$o]["Tip"] = $deger["Ogrenci"];
                                        $o++;
                                    }
                                    //Turun tamamındaki öğrenciler
                                    $turKisi = $Panel_Model->turDetayRaporOTur($rowID);
                                    foreach ($turKisi as $turKisii) {
                                        $ogrTumlist[] = $turKisii['BSOgrenciID'];
                                    }
                                    //Gelmeyen Öğrenciler
                                    $ogrGId = array_diff($ogrTumlist, $ogrlist);
                                    if (count($ogrGId) > 0) {
                                        $ogrGIDler = implode(',', $ogrGId);
                                        $ogrAdSyd = $Panel_Model->turDetayRaporOgrIdler($ogrGIDler);
                                        $og = 0;
                                        foreach ($ogrAdSyd as $ogrAdSydd) {
                                            $listGelmeyen[$og]["Ad"] = $ogrAdSydd['BSOgrenciAd'];
                                            $listGelmeyen[$og]["Soyad"] = $ogrAdSydd['BSOgrenciSoyad'];
                                            $listGelmeyen[$og]["Tip"] = $deger["Ogrenci"];
                                            $og++;
                                        }
                                    }
                                }
                            }
                        } else if ($ttip == 1) {//Personel
                            if ($tur != 1) {//Gidiş
                                $turLogDetay = $Panel_Model->turDetayRaporIG($rowID, $tarih);
                                if ($turLogDetay) {
                                    $id = 0;
                                    foreach ($turLogDetay as $turLogDetayy) {
                                        $isclist[] = $turLogDetayy['BsKisiID'];
                                        $list[$id]['Saat'] = $turLogDetayy['BSTurSaat'];
                                        $id++;
                                    }
                                    $iscIDler = implode(',', $isclist);
                                    $isciAdSoyad = $Panel_Model->turDetayRaporIscIdler($iscIDler);
                                    $i = 0;
                                    foreach ($isciAdSoyad as $isciAdSoyadd) {
                                        $list[$i]["Ad"] = $isciAdSoyadd['SBIsciAd'];
                                        $list[$i]["Soyad"] = $isciAdSoyadd['SBIsciSoyad'];
                                        $list[$i]["Tip"] = $deger["Personel"];
                                        $i++;
                                    }
                                    //Turun tamamındaki işçiler
                                    $turKisi = $Panel_Model->turDetayRaporITur($rowID);
                                    foreach ($turKisi as $turKisii) {
                                        $iscTumlist[] = $turKisii['SBIsciID'];
                                    }
                                    //Gelmeyen Öğrenciler
                                    $iscGId = array_diff($iscTumlist, $isclist);
                                    if (count($iscGId) > 0) {
                                        $iscGIDler = implode(',', $iscGId);
                                        $iscAdSyd = $Panel_Model->turDetayRaporIscIdler($iscGIDler);
                                        $ig = 0;
                                        foreach ($iscAdSyd as $iscAdSydd) {
                                            $listGelmeyen[$ig]["Ad"] = $iscAdSydd['SBIsciAd'];
                                            $listGelmeyen[$ig]["Soyad"] = $iscAdSydd['SBIsciSoyad'];
                                            $listGelmeyen[$ig]["Tip"] = $deger["Personel"];
                                            $ig++;
                                        }
                                    }
                                }
                            } else {//Dönüş
                                $turLogDetay = $Panel_Model->turDetayRaporID($rowID, $tarih);
                                if ($turLogDetay) {
                                    $id = 0;
                                    foreach ($turLogDetay as $turLogDetayy) {
                                        $isclist[] = $turLogDetayy['BsKisiID'];
                                        $list[$id]['Saat'] = $turLogDetayy['BSTurSaat'];
                                        $id++;
                                    }
                                    $iscIDler = implode(',', $isclist);
                                    $isciAdSoyad = $Panel_Model->turDetayRaporIscIdler($iscIDler);
                                    $i = 0;
                                    foreach ($isciAdSoyad as $isciAdSoyadd) {
                                        $list[$i]["Ad"] = $isciAdSoyadd['SBIsciAd'];
                                        $list[$i]["Soyad"] = $isciAdSoyadd['SBIsciSoyad'];
                                        $list[$i]["Tip"] = $deger["Personel"];
                                        $i++;
                                    }
                                    //Turun tamamındaki işçiler
                                    $turKisi = $Panel_Model->turDetayRaporITur($rowID);
                                    foreach ($turKisi as $turKisii) {
                                        $iscTumlist[] = $turKisii['SBIsciID'];
                                    }
                                    //Gelmeyen Öğrenciler
                                    $iscGId = array_diff($iscTumlist, $isclist);
                                    if (count($iscGId) > 0) {
                                        $iscGIDler = implode(',', $iscGId);
                                        $iscAdSyd = $Panel_Model->turDetayRaporIscIdler($iscGIDler);
                                        $ig = 0;
                                        foreach ($iscAdSyd as $iscAdSydd) {
                                            $listGelmeyen[$ig]["Ad"] = $iscAdSydd['SBIsciAd'];
                                            $listGelmeyen[$ig]["Soyad"] = $iscAdSydd['SBIsciSoyad'];
                                            $listGelmeyen[$ig]["Tip"] = $deger["Personel"];
                                            $ig++;
                                        }
                                    }
                                }
                            }
                        } else if ($ttip == 2) {//Öğrenci-Personel
                            if ($tur != 1) {//Gidiş
                                $turLogDetay = $Panel_Model->turDetayRaporOIG($rowID, $tarih);
                                if ($turLogDetay) {
                                    $od = 0;
                                    $o = 0;
                                    $i = 0;
                                    foreach ($turLogDetay as $turLogDetayy) {
                                        if ($turLogDetayy['BSKisiTip'] != 1) {//Öğrenci
                                            $ogrlist[] = $turLogDetayy['BsKisiID'];
                                            $ogrlistSaat[$o]['Saat'] = $turLogDetayy['BSTurSaat'];
                                            $o++;
                                        } else {//personel
                                            $isclist[] = $turLogDetayy['BsKisiID'];
                                            $isclistSaat[$i]['Saat'] = $turLogDetayy['BSTurSaat'];
                                            $i++;
                                        }
                                        $od++;
                                    }
                                    $oi = 0;
                                    $yo = 0;
                                    $ogrIDler = implode(',', $ogrlist);
                                    if (count($ogrIDler) > 0) {
                                        $ogrAdSoyad = $Panel_Model->turDetayRaporOgrIdler($ogrIDler);
                                        foreach ($ogrAdSoyad as $ogrAdSoyadd) {
                                            $list[$oi]["Ad"] = $ogrAdSoyadd['BSOgrenciAd'];
                                            $list[$oi]["Soyad"] = $ogrAdSoyadd['BSOgrenciSoyad'];
                                            $list[$oi]["Tip"] = $deger["Ogrenci"];
                                            $list[$oi]['Saat'] = $ogrlistSaat[$yo]['Saat'];
                                            $oi++;
                                            $yo++;
                                        }
                                    }
                                    $yi = 0;
                                    $iscIDler = implode(',', $isclist);
                                    if (count($iscIDler) > 0) {
                                        $isciAdSoyad = $Panel_Model->turDetayRaporIscIdler($iscIDler);
                                        foreach ($isciAdSoyad as $isciAdSoyadd) {
                                            $list[$oi]["Ad"] = $isciAdSoyadd['SBIsciAd'];
                                            $list[$oi]["Soyad"] = $isciAdSoyadd['SBIsciSoyad'];
                                            $list[$oi]["Tip"] = $deger["Personel"];
                                            $list[$oi]['Saat'] = $isclistSaat[$yi]['Saat'];
                                            $oi++;
                                            $yi++;
                                        }
                                    }
                                    //Gelmeyenleri bulacağız
                                    //Turun tamamındaki işçi ve öğrenciler
                                    $turKisi = $Panel_Model->turDetayRaporOITur($rowID);
                                    foreach ($turKisi as $turKisii) {
                                        if ($turKisii['BSKullaniciTip'] != 1) {//Öğrenci
                                            $ogrTumlist[] = $turKisii['BSOgrenciIsciID'];
                                        } else {//personel
                                            $iscTumlist[] = $turKisii['BSOgrenciIsciID'];
                                        }
                                    }
                                    //Gelmeyen Öğrenciler
                                    $ogrGId = array_diff($ogrTumlist, $ogrlist);
                                    if (count($ogrGId) > 0) {
                                        $ogrGIDler = implode(',', $ogrGId);
                                        $ogrAdSyd = $Panel_Model->turDetayRaporOgrIdler($ogrGIDler);
                                        $og = 0;
                                        foreach ($ogrAdSyd as $ogrAdSydd) {
                                            $listGelmeyen[$og]["Ad"] = $ogrAdSydd['BSOgrenciAd'];
                                            $listGelmeyen[$og]["Soyad"] = $ogrAdSydd['BSOgrenciSoyad'];
                                            $listGelmeyen[$og]["Tip"] = $deger["Ogrenci"];
                                            $og++;
                                        }
                                    }
                                    //Gelmeyen Personeller
                                    $iscGId = array_diff($iscTumlist, $isclist);
                                    if (count($iscGId) > 0) {
                                        $iscGIDler = implode(',', $iscGId);
                                        $iscAdSyd = $Panel_Model->turDetayRaporIscIdler($iscGIDler);
                                        $ig = 0;
                                        foreach ($iscAdSyd as $iscAdSydd) {
                                            $listGelmeyen[$ig]["Ad"] = $iscAdSydd['SBIsciAd'];
                                            $listGelmeyen[$ig]["Soyad"] = $iscAdSydd['SBIsciSoyad'];
                                            $listGelmeyen[$ig]["Tip"] = $deger["Personel"];
                                            $ig++;
                                        }
                                    }
                                }
                            } else {//Dönüş
                                $turLogDetay = $Panel_Model->turDetayRaporOID($rowID, $tarih);
                                if ($turLogDetay) {
                                    $od = 0;
                                    $o = 0;
                                    $i = 0;
                                    foreach ($turLogDetay as $turLogDetayy) {
                                        if ($turLogDetayy['BSKisiTip'] != 1) {//Öğrenci
                                            $ogrlist[] = $turLogDetayy['BsKisiID'];
                                            $ogrlistSaat[$o]['Saat'] = $turLogDetayy['BSTurSaat'];
                                            $o++;
                                        } else {//personel
                                            $isclist[] = $turLogDetayy['BsKisiID'];
                                            $isclistSaat[$i]['Saat'] = $turLogDetayy['BSTurSaat'];
                                            $i++;
                                        }
                                        $od++;
                                    }
                                    $oi = 0;
                                    $yo = 0;
                                    $ogrIDler = implode(',', $ogrlist);
                                    if (count($ogrIDler) > 0) {
                                        $ogrAdSoyad = $Panel_Model->turDetayRaporOgrIdler($ogrIDler);
                                        foreach ($ogrAdSoyad as $ogrAdSoyadd) {
                                            $list[$oi]["Ad"] = $ogrAdSoyadd['BSOgrenciAd'];
                                            $list[$oi]["Soyad"] = $ogrAdSoyadd['BSOgrenciSoyad'];
                                            $list[$oi]["Tip"] = $deger["Ogrenci"];
                                            $list[$oi]['Saat'] = $ogrlistSaat[$yo]['Saat'];
                                            $oi++;
                                            $yo++;
                                        }
                                    }
                                    $yi = 0;
                                    $iscIDler = implode(',', $isclist);
                                    if (count($iscIDler) > 0) {
                                        $isciAdSoyad = $Panel_Model->turDetayRaporIscIdler($iscIDler);
                                        foreach ($isciAdSoyad as $isciAdSoyadd) {
                                            $list[$oi]["Ad"] = $isciAdSoyadd['SBIsciAd'];
                                            $list[$oi]["Soyad"] = $isciAdSoyadd['SBIsciSoyad'];
                                            $list[$oi]["Tip"] = $deger["Personel"];
                                            $list[$oi]['Saat'] = $isclistSaat[$yi]['Saat'];
                                            $oi++;
                                            $yi++;
                                        }
                                    }
                                    //Gelmeyenleri bulacağız
                                    //Turun tamamındaki işçi ve öğrenciler
                                    $turKisi = $Panel_Model->turDetayRaporOITur($rowID);
                                    foreach ($turKisi as $turKisii) {
                                        if ($turKisii['BSKullaniciTip'] != 1) {//Öğrenci
                                            $ogrTumlist[] = $turKisii['BSOgrenciIsciID'];
                                        } else {//personel
                                            $iscTumlist[] = $turKisii['BSOgrenciIsciID'];
                                        }
                                    }
                                    //Gelmeyen Öğrenciler
                                    $ogrGId = array_diff($ogrTumlist, $ogrlist);
                                    if (count($ogrGId) > 0) {
                                        $ogrGIDler = implode(',', $ogrGId);
                                        $ogrAdSyd = $Panel_Model->turDetayRaporOgrIdler($ogrGIDler);
                                        $og = 0;
                                        foreach ($ogrAdSyd as $ogrAdSydd) {
                                            $listGelmeyen[$og]["Ad"] = $ogrAdSydd['BSOgrenciAd'];
                                            $listGelmeyen[$og]["Soyad"] = $ogrAdSydd['BSOgrenciSoyad'];
                                            $listGelmeyen[$og]["Tip"] = $deger["Ogrenci"];
                                            $og++;
                                        }
                                    }
                                    //Gelmeyen Personeller
                                    $iscGId = array_diff($iscTumlist, $isclist);
                                    if (count($iscGId) > 0) {
                                        $iscGIDler = implode(',', $iscGId);
                                        $iscAdSyd = $Panel_Model->turDetayRaporIscIdler($iscGIDler);
                                        $ig = 0;
                                        foreach ($iscAdSyd as $iscAdSydd) {
                                            $listGelmeyen[$ig]["Ad"] = $iscAdSydd['SBIsciAd'];
                                            $listGelmeyen[$ig]["Soyad"] = $iscAdSydd['SBIsciSoyad'];
                                            $listGelmeyen[$ig]["Tip"] = $deger["Personel"];
                                            $ig++;
                                        }
                                    }
                                }
                            }
                        }
                        $sonuc["Detail"] = $list;
                        $sonuc["DetailG"] = $listGelmeyen;
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

