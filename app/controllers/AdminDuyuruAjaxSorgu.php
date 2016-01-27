<?php

class AdminDuyuruAjaxSorgu extends Controller {

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
            //dil yapılandırılması
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (!Session::get("dil")) {
                Session::set("dil", $lang);
                $formm = $this->load->ajaxlanguage($lang);
                $deger = $formm->ajaxlanguage();
                $degerbildirim = $formm->bildirimlanguage();
            } else {
                $formm = $this->load->ajaxlanguage(Session::get("dil"));
                $deger = $formm->ajaxlanguage();
                $degerbildirim = $formm->bildirimlanguage();
            }
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            $adSoyad = Session::get("kullaniciad") . ' ' . Session::get("kullanicisoyad");
            Switch ($tip) {

                case "duyuruBolgeSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            //bölgeleri getirir
                            $bolgeListe = $Panel_Model->aracBolgeListele();

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }
                        } else {//değilse admin ıd ye göre bölge görür
                            $bolgeListeRutbe = $Panel_Model->adminAracBolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            //rütbeye göre bölge listele
                            $bolgeListe = $Panel_Model->adminRutbeAracBolgeListele($rutbebolgedizi);

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }
                        }

                        $sonuc["adminDuyuruBolge"] = $adminBolge;
                    }
                    break;
                case "duyuruBolgeAdminMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multiadmindizi = implode(',', $duyuruBolgeID);

                        $adminBolgeListe = $Panel_Model->duyuruBolgeMultiAdmin($multiadmindizi, $adminID);
                        foreach ($adminBolgeListe as $adminBolgeListee) {
                            $bolgeAdminId[] = $adminBolgeListee['BSAdminID'];
                        }
                        $bolgeAdminIdler = implode(',', $bolgeAdminId);
                        //adminleri getirir
                        $adminListe = $Panel_Model->duyuruAdmin($bolgeAdminIdler);

                        $a = 0;
                        foreach ($adminListe as $adminListee) {
                            $duyuruAdmin['AdminID'][$a] = $adminListee['BSAdminID'];
                            $duyuruAdmin['AdminAd'][$a] = $adminListee['BSAdminAd'];
                            $duyuruAdmin['AdminSoyad'][$a] = $adminListee['BSAdminSoyad'];
                            $a++;
                        }

                        $sonuc["duyuruAdmin"] = $duyuruAdmin;
                    }
                    break;
                case "duyuruBolgeSoforMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multisofordizi = implode(',', $duyuruBolgeID);

                        $soforBolgeListe = $Panel_Model->duyuruBolgeMultiSofor($multisofordizi);
                        $a = 0;
                        foreach ($soforBolgeListe as $soforBolgeListee) {
                            $duyuruSofor['SoforID'][$a] = $soforBolgeListee['BSSoforID'];
                            $duyuruSofor['SoforAd'][$a] = $soforBolgeListee['BSSoforAd'];
                            $a++;
                        }

                        $sonuc["duyuruSofor"] = $duyuruSofor;
                    }
                    break;
                case "duyuruBolgeHostesMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multihostesdizi = implode(',', $duyuruBolgeID);

                        $hostesBolgeListe = $Panel_Model->duyuruBolgeMultiHostes($multihostesdizi);
                        $a = 0;
                        foreach ($hostesBolgeListe as $hostesBolgeListee) {
                            $duyuruHostes['HostesID'][$a] = $hostesBolgeListee['BSHostesID'];
                            $duyuruHostes['HostesAd'][$a] = $hostesBolgeListee['BSHostesAd'];
                            $a++;
                        }

                        $sonuc["duyuruHostes"] = $duyuruHostes;
                    }
                    break;
                case "duyuruBolgeVeliMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multivelidizi = implode(',', $duyuruBolgeID);

                        $veliBolgeListe = $Panel_Model->duyuruBolgeMultiVeli($multivelidizi);
                        $a = 0;
                        foreach ($veliBolgeListe as $veliBolgeListee) {
                            $duyuruVeli['VeliID'][$a] = $veliBolgeListee['BSVeliID'];
                            $duyuruVeli['VeliAd'][$a] = $veliBolgeListee['BSVeliAd'];
                            $a++;
                        }

                        $sonuc["duyuruVeli"] = $duyuruVeli;
                    }
                    break;
                case "duyuruBolgeOgrenciMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multiogrencidizi = implode(',', $duyuruBolgeID);

                        $ogrenciBolgeListe = $Panel_Model->duyuruBolgeMultiOgrenci($multiogrencidizi);
                        $a = 0;
                        foreach ($ogrenciBolgeListe as $ogrenciBolgeListee) {
                            $duyuruOgrenci['OgrenciID'][$a] = $ogrenciBolgeListee['BSOgrenciID'];
                            $duyuruOgrenci['OgrenciAd'][$a] = $ogrenciBolgeListee['BSOgrenciAd'];
                            $a++;
                        }

                        $sonuc["duyuruOgrenci"] = $duyuruOgrenci;
                    }
                    break;
                case "duyuruBolgePersonelMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multiiscidizi = implode(',', $duyuruBolgeID);

                        $isciBolgeListe = $Panel_Model->duyuruBolgeMultiIsci($multiiscidizi);
                        $a = 0;
                        foreach ($isciBolgeListe as $isciBolgeListee) {
                            $duyuruIsci['PersonelID'][$a] = $isciBolgeListee['SBIsciID'];
                            $duyuruIsci['PersonelAd'][$a] = $isciBolgeListee['SBIsciAd'];
                            $a++;
                        }

                        $sonuc["duyuruPersonel"] = $duyuruIsci;
                    }
                    break;
                case "duyuruKurumMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multikurumdizi = implode(',', $duyuruBolgeID);

                        $kurumListe = $Panel_Model->duyuruKurumMultiSelect($multikurumdizi);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $kurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $kurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $a++;
                        }
                        $sonuc["kurumMultiSelect"] = $kurumSelect;
                    }
                    break;
                case "duyuruKurumVeli":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $duyuruKurum = implode(',', $duyuruKurumID);

                        $veliListe = $Panel_Model->duyuruKurumVeli($duyuruKurum);

                        $a = 0;
                        foreach ($veliListe as $veliListee) {
                            $duyuruKurumVeli['VeliID'][$a] = $veliListee['BSVeliID'];
                            $duyuruKurumVeli['VeliAd'][$a] = $veliListee['BSVeliAd'];
                            $a++;
                        }
                        $sonuc["duyuruVeli"] = $duyuruKurumVeli;
                    }
                    break;
                case "duyuruKurumOgrenci":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $kurumOgrenciDizi = implode(',', $duyuruKurumID);

                        $ogrenciListe = $Panel_Model->duyuruKurumOgrenci($kurumOgrenciDizi);

                        $a = 0;
                        foreach ($ogrenciListe as $ogrenciListee) {
                            $duyuruKurumOgrenci['OgrenciID'][$a] = $ogrenciListee['BSOgrenciID'];
                            $duyuruKurumOgrenci['OgrenciAd'][$a] = $ogrenciListee['BSOgrenciAd'];
                            $a++;
                        }
                        $sonuc["duyuruOgrenci"] = $duyuruKurumOgrenci;
                    }
                    break;
                case "duyuruKurumIsci":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $kurumIsciDizi = implode(',', $duyuruKurumID);

                        $isciListe = $Panel_Model->duyuruKurumIsci($kurumIsciDizi);

                        $a = 0;
                        foreach ($isciListe as $isciListee) {
                            $duyuruPersonel['PersonelID'][$a] = $isciListee['SBIsciID'];
                            $duyuruPersonel['PersonelAd'][$a] = $isciListee['SBIsciAd'];
                            $a++;
                        }
                        $sonuc["duyuruPersonel"] = $duyuruPersonel;
                    }
                    break;
                case "duyuruTurMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $multiturdizi = implode(',', $duyuruKurumID);

                        $turListe = $Panel_Model->duyuruTurMultiSelect($multiturdizi);

                        $a = 0;
                        foreach ($turListe as $turListee) {
                            $turSelect['TurSelectID'][$a] = $turListee['SBTurID'];
                            $turSelect['TurSelectAd'][$a] = $turListee['SBTurAd'];
                            $a++;
                        }
                        $sonuc["turMultiSelect"] = $turSelect;
                    }
                    break;
                case "duyuruGonder":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $admin = $_REQUEST['admin'];
                        $adminText = $_REQUEST['adminText'];
                        $sofor = $_REQUEST['sofor'];
                        $soforText = $_REQUEST['soforText'];
                        $hostes = $_REQUEST['hostes'];
                        $hostesText = $_REQUEST['hostesText'];
                        $veli = $_REQUEST['veli'];
                        $veliText = $_REQUEST['veliText'];
                        $ogrenci = $_REQUEST['ogrenci'];
                        $ogrenciText = $_REQUEST['ogrenciText'];
                        $isci = $_REQUEST['personel'];
                        $isciText = $_REQUEST['personelText'];
                        $ad = Session::get("kullaniciad");
                        $soyad = Session::get("kullanicisoyad");
                        $adSoyad = $ad . ' ' . $soyad;
                        $form->post("duyuruText", true);
                        $form->post("hedef", true);
                        $duyuruText = $form->values['duyuruText'];
                        $hedef = $form->values['hedef'];

                        //admin
                        if (count($admin) > 0) {
                            $countAdmin = count($admin);
                            for ($a = 0; $a < $countAdmin; $a++) {
                                $admindata[$a] = array(
                                    'BSDuyuruText' => $duyuruText,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $adminID,
                                    'BSGonderenAdSoyad' => $adSoyad,
                                    'BSGonderenTip' => 5,
                                    'BSAlanID' => $admin[$a],
                                    'BSAlanAdSoyad' => $adminText[$a],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultAdminDuyuru = $Panel_Model->addAdminDuyuru($admindata);
                            if ($resultAdminDuyuru) {
                                $adminIDler = implode(',', $admin);
                                $resultAdminCihaz = $Panel_Model->duyuruAdminCihaz($adminIDler);
                                if (count($resultAdminCihaz) > 0) {
                                    foreach ($resultAdminCihaz as $resultAdminCihazz) {
                                        $adminCihaz[] = $resultAdminCihazz['bsadmincihazRecID'];
                                    }
                                    $adminCihazlar = implode(',', $adminCihaz);
                                    $form->shuttleNotification($adminCihazlar, $duyuruText, $degerbildirim["YeniDuyuru"]);
                                }
                            }
                        }

                        //şoför
                        if (count($sofor) > 0) {
                            $countSofor = count($sofor);
                            for ($s = 0; $s < $countSofor; $s++) {
                                $sofordata[$s] = array(
                                    'BSDuyuruText' => $duyuruText,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $adminID,
                                    'BSGonderenAdSoyad' => $adSoyad,
                                    'BSGonderenTip' => 5,
                                    'BSAlanID' => $sofor[$s],
                                    'BSAlanAdSoyad' => $soforText[$s],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultSoforDuyuru = $Panel_Model->addSoforDuyuru($sofordata);
                            if ($resultSoforDuyuru) {
                                $soforIDler = implode(',', $sofor);
                                $resultSoforCihaz = $Panel_Model->duyuruSoforCihaz($soforIDler);
                                if (count($resultSoforCihaz) > 0) {
                                    foreach ($resultSoforCihaz as $resultSoforCihazz) {
                                        $soforCihaz[] = $resultSoforCihazz['sbsoforcihazRecID'];
                                    }
                                    $soforCihazlar = implode(',', $soforCihaz);
                                    $form->shuttleNotification($soforCihazlar, $duyuruText, $degerbildirim["YeniDuyuru"]);
                                }
                            }
                        }

                        //hostes
                        if (count($hostes) > 0) {
                            $countHostes = count($hostes);
                            for ($h = 0; $h < $countHostes; $h++) {
                                $hostesdata[$h] = array(
                                    'BSDuyuruText' => $duyuruText,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $adminID,
                                    'BSGonderenAdSoyad' => $adSoyad,
                                    'BSGonderenTip' => 5,
                                    'BSAlanID' => $hostes[$h],
                                    'BSAlanAdSoyad' => $hostesText[$h],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultHostesDuyuru = $Panel_Model->addHostesDuyuru($hostesdata);
                            if ($resultHostesDuyuru) {
                                $hostesIDler = implode(',', $hostes);
                                $resultHostesCihaz = $Panel_Model->duyuruHostesCihaz($hostesIDler);
                                if (count($resultHostesCihaz) > 0) {
                                    foreach ($resultHostesCihaz as $resultHostesCihazz) {
                                        $hostesCihaz[] = $resultHostesCihazz['bshostescihazRecID'];
                                    }
                                    $hostesCihazlar = implode(',', $hostesCihaz);
                                    $form->shuttleNotification($hostesCihazlar, $duyuruText, $degerbildirim["YeniDuyuru"]);
                                }
                            }
                        }

                        //veli
                        if (count($veli) > 0) {
                            $countVeli = count($veli);
                            for ($v = 0; $v < $countVeli; $v++) {
                                $velidata[$v] = array(
                                    'BSDuyuruText' => $duyuruText,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $adminID,
                                    'BSGonderenAdSoyad' => $adSoyad,
                                    'BSGonderenTip' => 5,
                                    'BSAlanID' => $veli[$v],
                                    'BSAlanAdSoyad' => $veliText[$v],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultVeliDuyuru = $Panel_Model->addVeliDuyuru($velidata);
                            if ($resultVeliDuyuru) {
                                $veliIDler = implode(',', $veli);
                                $resultVeliCihaz = $Panel_Model->duyuruVeliCihaz($veliIDler);
                                if (count($resultVeliCihaz) > 0) {
                                    foreach ($resultVeliCihaz as $resultVeliCihazz) {
                                        $veliCihaz[] = $resultVeliCihazz['bsvelicihazRecID'];
                                    }
                                    $veliCihazlar = implode(',', $veliCihaz);
                                    $form->shuttleNotification($veliCihazlar, $duyuruText, $degerbildirim["YeniDuyuru"]);
                                }
                            }
                        }

                        //öğrenci
                        if (count($ogrenci) > 0) {
                            $countOgrenci = count($ogrenci);
                            for ($o = 0; $o < $countOgrenci; $o++) {
                                $ogrencidata[$o] = array(
                                    'BSDuyuruText' => $duyuruText,
                                    'BSDuyuruHedef' => $hedef,
                                    'BSGonderenID' => $adminID,
                                    'BSGonderenAdSoyad' => $adSoyad,
                                    'BSGonderenTip' => 5,
                                    'BSAlanID' => $ogrenci[$o],
                                    'BSAlanAdSoyad' => $ogrenciText[$o],
                                    'BSOkundu' => 0,
                                    'BSGoruldu' => 0
                                );
                            }
                            $resultOgrenciDuyuru = $Panel_Model->addOgrenciDuyuru($ogrencidata);
                            if ($resultOgrenciDuyuru) {
                                $ogrenciIDler = implode(',', $ogrenci);
                                $resultOgrenciCihaz = $Panel_Model->duyuruOgrenciCihaz($ogrenciIDler);
                                if (count($resultOgrenciCihaz) > 0) {
                                    foreach ($resultOgrenciCihaz as $resultOgrenciCihazz) {
                                        $ogrenciCihaz[] = $resultOgrenciCihazz['bsogrencicihazRecID'];
                                    }
                                    $ogrenciCihazlar = implode(',', $ogrenciCihaz);
                                    $form->shuttleNotification($ogrenciCihazlar, $duyuruText, $degerbildirim["YeniDuyuru"]);
                                }
                            }
                        }

                        //işçi
                        if (count($isci) > 0) {
                            $countIsci = count($isci);
                            for ($i = 0; $i < $countIsci; $i++) {
                                $iscidata[$i] = array(
                                    'SBDuyuruText' => $duyuruText,
                                    'SBDuyuruHedef' => $hedef,
                                    'SBGonderenID' => $adminID,
                                    'SBGonderenAdSoyad' => $adSoyad,
                                    'SBGonderenTip' => 5,
                                    'SBAlanID' => $isci[$i],
                                    'SBAlanAdSoyad' => $isciText[$i],
                                    'SBOkundu' => 0,
                                    'SBGoruldu' => 0
                                );
                            }
                            $resultIsciDuyuru = $Panel_Model->addIsciDuyuru($iscidata);
                            if ($resultIsciDuyuru) {
                                $isciIDler = implode(',', $isci);
                                $resultIsciCihaz = $Panel_Model->duyuruIsciCihaz($isciIDler);
                                if (count($resultIsciCihaz) > 0) {
                                    foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                        $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                    }
                                    $isciCihazlar = implode(',', $isciCihaz);
                                    $form->shuttleNotification($isciCihazlar, $duyuruText, $degerbildirim["YeniDuyuru"]);
                                }
                            }
                        }

                        //log ayarları
                        $dataLog = array(
                            'BSEkleyenID' => $adminID,
                            'BSEkleyenAdSoyad' => $adSoyad,
                            'BSLogText' => $duyuruText,
                            'BSLogHedef' => $hedef
                        );
                        $resultLog = $Panel_Model->addNewAdminDuyuruLog($dataLog);
                        if ($resultLog) {
                            $duyuruList[0] = $adSoyad;
                            $duyuruList[1] = $degerbildirim["DuyuruGonder"];
                            $sonuc["duyuru"] = $duyuruList;
                        } else {
                            $sonuc["hata"] = $degerbildirim["DuyuruGonder"];
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

