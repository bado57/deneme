<?php

class SoforMobilTurBaslatAjax extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->mobilPage();
    }

    public function mobilPage() {

        if ($_POST) {
            $sonuc = array();

            $form = $this->load->otherClasses('Form');

            $form->post("tip", true);
            $tip = $form->values['tip'];

            $form->post('username', true);
            $loginKadi = $form->values['username'];

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $usersselect_model = $this->load->model("adminselectdb_mobil");

            $loginfirmaID = $form->substrEnd($loginKadi, 8);
            //return database results
            $UserSelectDb = $usersselect_model->MkullaniciSelectDb($loginfirmaID);
            $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
            $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
            $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
            $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];
            $SelectdbFirmaKod = $UserSelectDb[0]['rootfirmaKodu'];

            $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model_mobile");
            Switch ($tip) {

                case "turbaslatislem":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("id", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $kid = $form->values['id'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];


                        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                        $url = str_replace(' ', '', $url);
                        $json_timezone = file_get_contents($url);
                        $obj = json_decode($json_timezone, true);
                        date_default_timezone_set($obj["timeZoneId"]);
                        $date = date('m/d/Y', time());
                        $gun = date('D', strtotime($date));
                        $yeniGun = '';
                        $turBaslat = [];
                        switch ($gun) {
                            case "Sun":
                                $yeniGun = "SBTurPzr";
                                break;
                            case "Mon":
                                $yeniGun = "SBTurPzt";
                                break;
                            case "Tue":
                                $yeniGun = "SBTurSli";
                                break;
                            case "Wed":
                                $yeniGun = "SBTurCrs";
                                break;
                            case "Thu":
                                $yeniGun = "SBTurPrs";
                                break;
                            case "Fri":
                                $yeniGun = "SBTurCma";
                                break;
                            case "Sat":
                                $yeniGun = "SBTurCmt";
                                break;
                            default:
                                break;
                        }

                        $resultTur = $Panel_Model->soforTurID($kid, $yeniGun);

                        $b = 0;
                        $turBaslat = [];
                        $turID = [];
                        foreach ($resultTur as $resultTurr) {
                            $turID[] = $resultTurr['BSTurID'];
                            $turBaslat[$b]['Plaka'] = $resultTurr['BSTurAracPlaka'];
                            $b++;
                        }
                        $soforTurID = implode(',', $turID);

                        $result = $Panel_Model->soforTurBaslat($soforTurID);
                        if (count($result) > 0) {
                            $a = 0;
                            foreach ($result as $resultt) {
                                $turBaslat[$a]['ID'] = $resultt['SBTurID'];
                                $turBaslat[$a]['Ad'] = $resultt['SBTurAd'];
                                $turBaslat[$a]['KurumAd'] = $resultt['SBKurumAd'];
                                $turBaslat[$a]['Tip'] = $resultt['SBTurTip'];
                                $turBaslat[$a]['Gun'] = $yeniGun;
                                $a++;
                            }
                        }

                        $sonuc = $turBaslat;
                    }

                    break;

                case "turbaslatdetayislem":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("turid", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $form->post("language", true);
                        $turid = $form->values['turid'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];
                        $lang = $form->values['language'];

                        $formLanguage = $this->load->mobillanguage($lang);
                        $language = $formLanguage->mobillanguage();


                        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                        $url = str_replace(' ', '', $url);
                        $json_timezone = file_get_contents($url);
                        $obj = json_decode($json_timezone, true);
                        date_default_timezone_set($obj["timeZoneId"]);
                        $date = date('m/d/Y', time());
                        $gun = date('D', strtotime($date));
                        $yeniGun = '';

                        switch ($gun) {
                            case "Sun":
                                $yeniGun = "SBTurPzr";
                                break;
                            case "Mon":
                                $yeniGun = "SBTurPzt";
                                break;
                            case "Tue":
                                $yeniGun = "SBTurSli";
                                break;
                            case "Wed":
                                $yeniGun = "SBTurCrs";
                                break;
                            case "Thu":
                                $yeniGun = "SBTurPrs";
                                break;
                            case "Fri":
                                $yeniGun = "SBTurCma";
                                break;
                            case "Sat":
                                $yeniGun = "SBTurCmt";
                                break;
                            default:
                                break;
                        }

                        $resultTur = $Panel_Model->soforTurBaslatDetay($turid, $yeniGun);

                        $turBaslatDetay = [];
                        if (count($resultTur) > 0) {
                            $b = 0;
                            $turBaslatDetay = [];
                            foreach ($resultTur as $resultTurr) {
                                if ($resultTurr['BSTurGidisDonus'] != 1) {//Gidiş turu
                                    $saat1 = '';
                                    if (strlen($resultTurr['BSTurBslngc']) == 1) {
                                        $saat1 = '00:00';
                                    } else if (strlen($resultTurr['BSTurBslngc']) == 2) {
                                        $saat1 = '00:' . $resultTurr['BSTurBslngc'];
                                    } else if (strlen($resultTurr['BSTurBslngc']) == 3) {
                                        $ilkHarf1 = substr($resultTurr['BSTurBslngc'], 0, 1);
                                        $sondaikiHarf1 = substr($resultTurr['BSTurBslngc'], 1, 3);
                                        $saat1 = '0' . $ilkHarf1 . ':' . $sondaikiHarf1;
                                    } else {
                                        $ilkikiHarf1 = substr($resultTurr['BSTurBslngc'], 0, 2);
                                        $sondaikiHarf1 = substr($resultTurr['BSTurBslngc'], 2, 4);
                                        $saat1 = $ilkikiHarf1 . ':' . $sondaikiHarf1;
                                    }

                                    $saat2 = '';
                                    if (strlen($resultTurr['BSTurBts']) == 1) {
                                        $saat2 = '00:00';
                                    } else if (strlen($resultTurr['BSTurBts']) == 2) {
                                        $saat2 = '00:' . $resultTurr['BSTurBts'];
                                    } else if (strlen($resultTurr['BSTurBts']) == 3) {
                                        $ilkHarf2 = substr($resultTurr['BSTurBts'], 0, 1);
                                        $sondaikiHarf2 = substr($resultTurr['BSTurBts'], 1, 3);
                                        $saat2 = '0' . $ilkHarf2 . ':' . $sondaikiHarf2;
                                    } else {
                                        $ilkHarf2 = substr($resultTurr['BSTurBts'], 0, 2);
                                        $sondaikiHarf2 = substr($resultTurr['BSTurBts'], 2, 4);
                                        $saat2 = $ilkHarf2 . ':' . $sondaikiHarf2;
                                    }
                                    $saat3 = $saat1 . ' - ' . $saat2;
                                    $turBaslatDetay[$b]['Saat'] = $saat3;
                                    $turBaslatDetay[$b]['Ad'] = $language['Gidis'];
                                    $turBaslatDetay[$b]['Plaka'] = $resultTurr['BSTurAracPlaka'];
                                    $turBaslatDetay[$b]['ID'] = $resultTurr['BSTurID'];
                                    $turBaslatDetay[$b]['Tip'] = $resultTurr['BSTurTip'];
                                    $turBaslatDetay[$b]['Gun'] = $yeniGun;
                                } else {
                                    $saat1 = '';
                                    if (strlen($resultTurr['BSTurBslngc']) == 1) {
                                        $saat1 = '00:00';
                                    } else if (strlen($resultTurr['BSTurBslngc']) == 2) {
                                        $saat1 = '00:' . $resultTurr['BSTurBslngc'];
                                    } else if (strlen($resultTurr['BSTurBslngc']) == 3) {
                                        $ilkHarf1 = substr($resultTurr['BSTurBslngc'], 0, 1);
                                        $sondaikiHarf1 = substr($resultTurr['BSTurBslngc'], 1, 3);
                                        $saat1 = '0' . $ilkHarf1 . ':' . $sondaikiHarf1;
                                    } else {
                                        $ilkikiHarf1 = substr($resultTurr['BSTurBslngc'], 0, 2);
                                        $sondaikiHarf1 = substr($resultTurr['BSTurBslngc'], 2, 4);
                                        $saat1 = $ilkikiHarf1 . ':' . $sondaikiHarf1;
                                    }

                                    $saat2 = '';
                                    if (strlen($resultTurr['BSTurBts']) == 1) {
                                        $saat2 = '00:00';
                                    } else if (strlen($resultTurr['BSTurBts']) == 2) {
                                        $saat2 = '00:' . $resultTurr['BSTurBts'];
                                    } else if (strlen($resultTurr['BSTurBts']) == 3) {
                                        $ilkHarf2 = substr($resultTurr['BSTurBts'], 0, 1);
                                        $sondaikiHarf2 = substr($resultTurr['BSTurBts'], 1, 3);
                                        $saat2 = '0' . $ilkHarf2 . ':' . $sondaikiHarf2;
                                    } else {
                                        $ilkHarf2 = substr($resultTurr['BSTurBts'], 0, 2);
                                        $sondaikiHarf2 = substr($resultTurr['BSTurBts'], 2, 4);
                                        $saat2 = $ilkHarf2 . ':' . $sondaikiHarf2;
                                    }
                                    $saat3 = $saat1 . ' - ' . $saat2;
                                    $turBaslatDetay[$b]['Saat'] = $saat3;
                                    $turBaslatDetay[$b]['Ad'] = $language['Donus'];
                                    $turBaslatDetay[$b]['Plaka'] = $resultTurr['BSTurAracPlaka'];
                                    $turBaslatDetay[$b]['ID'] = $resultTurr['BSTurID'];
                                    $turBaslatDetay[$b]['Tip'] = $resultTurr['BSTurTip'];
                                    $turBaslatDetay[$b]['Gun'] = $yeniGun;
                                }
                                $b++;
                            }
                        }
                        $sonuc = $turBaslatDetay;
                    }

                    break;

                case "turgelen":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("turID", true);
                        $form->post("turTip", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $form->post("turTur", true);
                        $turID = $form->values['turID'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];
                        $turTip = $form->values['turTip'];
                        $turTur = $form->values['turTur'];

                        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                        $url = str_replace(' ', '', $url);
                        $json_timezone = file_get_contents($url);
                        $obj = json_decode($json_timezone, true);
                        date_default_timezone_set($obj["timeZoneId"]);
                        $date = date('m/d/Y', time());
                        $gun = date('D', strtotime($date));
                        $yeniGun = '';

                        switch ($gun) {
                            case "Sun":
                                $yeniGun = "SBTurPzr";
                                break;
                            case "Mon":
                                $yeniGun = "SBTurPzt";
                                break;
                            case "Tue":
                                $yeniGun = "SBTurSli";
                                break;
                            case "Wed":
                                $yeniGun = "SBTurCrs";
                                break;
                            case "Thu":
                                $yeniGun = "SBTurPrs";
                                break;
                            case "Fri":
                                $yeniGun = "SBTurCma";
                                break;
                            case "Sat":
                                $yeniGun = "SBTurCmt";
                                break;
                            default:
                                break;
                        }
                        $turGelen = [];
                        if ($turTip == 0) {//öğrenci
                            $resultOgrenciID = $Panel_Model->soforTurBaslatOgrenciID($turID);
                            $ogrenciGelenID = [];
                            foreach ($resultOgrenciID as $resultOgrenciIDD) {
                                $ogrenciGelenID[] = $resultOgrenciIDD['BSOgrenciID'];
                            }

                            $resultOgrenciGID = $Panel_Model->soforTurBaslatOgrenciGID($turID, $yeniGun, $turTur);
                            $ogrenciGelmeyenID = [];
                            foreach ($resultOgrenciGID as $resultOgrenciGID) {
                                $ogrenciGelmeyenID[] = $resultOgrenciGID['BSOgrenciID'];
                            }

                            $ogrenciID = array_diff($ogrenciGelenID, $ogrenciGelmeyenID);
                            $gelenID = implode(',', $ogrenciID);

                            $resultOgrenciIID = $Panel_Model->soforTurBaslatOgrenciIID($gelenID);
                            if (count($resultOgrenciIID) > 0) {
                                $o = 0;
                                foreach ($resultOgrenciIID as $resultOgrenciIID) {
                                    $turGelen[$o]['ID'] = $resultOgrenciIID['BSOgrenciID'];
                                    $turGelen[$o]['Ad'] = $resultOgrenciIID['BSOgrenciAd'];
                                    $turGelen[$o]['Soyad'] = $resultOgrenciIID['BSOgrenciSoyad'];
                                    $turGelen[$o]['Telefon'] = $resultOgrenciIID['BSOgrenciPhone'];
                                    $turGelen[$o]['Tip'] = 0;
                                    $o++;
                                }
                            }
                        } else if ($turTip == 1) {//işçi
                            $resultIsciID = $Panel_Model->soforTurBaslatIsciID($turID);
                            $isciGelenID = [];
                            foreach ($resultIsciID as $resultIsciIDD) {
                                $isciGelenID[] = $resultIsciIDD['SBIsciID'];
                            }

                            $resultIsciGID = $Panel_Model->soforTurBaslatIsciGID($turID, $yeniGun, $turTur);
                            $isciGelmeyenID = [];
                            foreach ($resultIsciGID as $resultIsciGIDD) {
                                $isciGelmeyenID[] = $resultIsciGIDD['BSIsciID'];
                            }

                            $isciID = array_diff($isciGelenID, $isciGelmeyenID);
                            $gelenID = implode(',', $isciID);

                            $resultIsciIID = $Panel_Model->soforTurBaslatIsciIID($gelenID);
                            if (count($resultIsciIID) > 0) {
                                $i = 0;
                                foreach ($resultIsciIID as $resultIsciIIDD) {
                                    $turGelen[$i]['ID'] = $resultIsciIIDD['SBIsciID'];
                                    $turGelen[$i]['Ad'] = $resultIsciIIDD['SBIsciAd'];
                                    $turGelen[$i]['Soyad'] = $resultIsciIIDD['SBIsciSoyad'];
                                    $turGelen[$i]['Telefon'] = $resultIsciIIDD['SBIsciPhone'];
                                    $turGelen[$i]['Tip'] = 1;
                                    $i++;
                                }
                            }
                        } else {//öğrenci-işçi
                            $resultOgrenciIsciID = $Panel_Model->soforTurBaslatOgrenciIsciID($turID);
                            $ogrenciGID = [];
                            $isciGID = [];
                            foreach ($resultOgrenciIsciID as $resultOgrenciIsciIDD) {
                                if ($resultOgrenciIsciIDD['BSKullaniciTip'] != 1) {//öğrenci
                                    $ogrenciGID[] = $resultOgrenciIsciIDD['BSOgrenciIsciID'];
                                } else {
                                    $isciGID[] = $resultOgrenciIsciIDD['BSOgrenciIsciID'];
                                }
                            }

                            $resultOgrenciIsciGID = $Panel_Model->soforTurBaslatOgrenciIsciGID($turID, $yeniGun, $turTur);
                            $ogrenciGeID = [];
                            $isciGeID = [];
                            foreach ($resultOgrenciIsciGID as $resultOgrenciIsciGIDD) {
                                if ($resultOgrenciIsciGIDD['BSKullaniciTip'] != 1) {//öğrenci
                                    $ogrenciGeID[] = $resultOgrenciIsciGIDD['BSKisiID'];
                                } else {
                                    $isciGeID[] = $resultOgrenciIsciGIDD['BSKisiID'];
                                }
                            }

                            $ogrenciSonID = array_diff($ogrenciGID, $ogrenciGeID);
                            $ogrID = implode(',', $ogrenciSonID);
                            $isciSonID = array_diff($isciGID, $isciGeID);
                            $iscID = implode(',', $isciSonID);

                            if (count($ogrenciSonID) > 0) {
                                $resultOgrenciIID = $Panel_Model->soforTurBaslatOgrenciIID($ogrID);
                                if (count($resultOgrenciIID) > 0) {
                                    $oi = 0;
                                    foreach ($resultOgrenciIID as $resultOgrenciIID) {
                                        $turGelen[$oi]['ID'] = $resultOgrenciIID['BSOgrenciID'];
                                        $turGelen[$oi]['Ad'] = $resultOgrenciIID['BSOgrenciAd'];
                                        $turGelen[$oi]['Soyad'] = $resultOgrenciIID['BSOgrenciSoyad'];
                                        $turGelen[$oi]['Telefon'] = $resultOgrenciIID['BSOgrenciPhone'];
                                        $turGelen[$oi]['Tip'] = 0;
                                        $oi++;
                                    }
                                }
                            }

                            if (count($isciSonID) > 0) {
                                $resultIsciIID = $Panel_Model->soforTurBaslatIsciIID($iscID);
                                if (count($resultIsciIID) > 0) {
                                    foreach ($resultIsciIID as $resultIsciIIDD) {
                                        $turGelen[$oi]['ID'] = $resultIsciIIDD['SBIsciID'];
                                        $turGelen[$oi]['Ad'] = $resultIsciIIDD['SBIsciAd'];
                                        $turGelen[$oi]['Soyad'] = $resultIsciIIDD['SBIsciSoyad'];
                                        $turGelen[$oi]['Telefon'] = $resultIsciIIDD['SBIsciPhone'];
                                        $turGelen[$oi]['Tip'] = 1;
                                        $oi++;
                                    }
                                }
                            }
                        }
                        $sonuc = $turGelen;
                    }

                    break;

                case "turgelmeyen":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("turID", true);
                        $form->post("turTip", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $form->post("turTur", true);
                        $turID = $form->values['turID'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];
                        $turTip = $form->values['turTip'];
                        $turTur = $form->values['turTur'];

                        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                        $url = str_replace(' ', '', $url);
                        $json_timezone = file_get_contents($url);
                        $obj = json_decode($json_timezone, true);
                        date_default_timezone_set($obj["timeZoneId"]);
                        $date = date('m/d/Y', time());
                        $gun = date('D', strtotime($date));
                        $yeniGun = '';

                        switch ($gun) {
                            case "Sun":
                                $yeniGun = "SBTurPzr";
                                break;
                            case "Mon":
                                $yeniGun = "SBTurPzt";
                                break;
                            case "Tue":
                                $yeniGun = "SBTurSli";
                                break;
                            case "Wed":
                                $yeniGun = "SBTurCrs";
                                break;
                            case "Thu":
                                $yeniGun = "SBTurPrs";
                                break;
                            case "Fri":
                                $yeniGun = "SBTurCma";
                                break;
                            case "Sat":
                                $yeniGun = "SBTurCmt";
                                break;
                            default:
                                break;
                        }
                        $turGelmeyen = [];
                        if ($turTip == 0) {//öğrenci
                            $resultOgrenciGID = $Panel_Model->soforTurBaslatOgrenciGID($turID, $yeniGun, $turTur);
                            $ogrenciGelmeyenID = [];
                            foreach ($resultOgrenciGID as $resultOgrenciGID) {
                                $ogrenciGelmeyenID[] = $resultOgrenciGID['BSOgrenciID'];
                            }

                            $gelmeyenID = implode(',', $ogrenciGelmeyenID);

                            $resultOgrenciIID = $Panel_Model->soforTurBaslatOgrenciIID($gelmeyenID);
                            if (count($resultOgrenciIID) > 0) {
                                $o = 0;
                                foreach ($resultOgrenciIID as $resultOgrenciIID) {
                                    $turGelmeyen[$o]['ID'] = $resultOgrenciIID['BSOgrenciID'];
                                    $turGelmeyen[$o]['Ad'] = $resultOgrenciIID['BSOgrenciAd'];
                                    $turGelmeyen[$o]['Soyad'] = $resultOgrenciIID['BSOgrenciSoyad'];
                                    $turGelmeyen[$o]['Telefon'] = $resultOgrenciIID['BSOgrenciPhone'];
                                    $turGelmeyen[$o]['Tip'] = 0;
                                    $o++;
                                }
                            }
                        } else if ($turTip == 1) {//işçi
                            $resultIsciGID = $Panel_Model->soforTurBaslatIsciGID($turID, $yeniGun, $turTur);
                            $isciGelmeyenID = [];
                            foreach ($resultIsciGID as $resultIsciGIDD) {
                                $isciGelmeyenID[] = $resultIsciGIDD['BSIsciID'];
                            }

                            $gelmeyenID = implode(',', $isciGelmeyenID);

                            $resultIsciIID = $Panel_Model->soforTurBaslatIsciIID($gelmeyenID);
                            if (count($resultIsciIID) > 0) {
                                $i = 0;
                                foreach ($resultIsciIID as $resultIsciIIDD) {
                                    $turGelmeyen[$i]['ID'] = $resultIsciIIDD['SBIsciID'];
                                    $turGelmeyen[$i]['Ad'] = $resultIsciIIDD['SBIsciAd'];
                                    $turGelmeyen[$i]['Soyad'] = $resultIsciIIDD['SBIsciSoyad'];
                                    $turGelmeyen[$i]['Telefon'] = $resultIsciIIDD['SBIsciPhone'];
                                    $turGelmeyen[$i]['Tip'] = 1;
                                    $i++;
                                }
                            }
                        } else {//öğrenci-işçi
                            error_log("girdi");
                            $resultOgrenciIsciGID = $Panel_Model->soforTurBaslatOgrenciIsciGID($turID, $yeniGun, $turTur);
                            $ogrenciGeID = [];
                            $isciGeID = [];
                            foreach ($resultOgrenciIsciGID as $resultOgrenciIsciGIDD) {
                                if ($resultOgrenciIsciGIDD['BSKullaniciTip'] != 1) {//öğrenci
                                    $ogrenciGeID[] = $resultOgrenciIsciGIDD['BSKisiID'];
                                } else {
                                    $isciGeID[] = $resultOgrenciIsciGIDD['BSKisiID'];
                                }
                            }

                            $ogrGelmeyenID = implode(',', $ogrenciGeID);
                            $iscGelmeyenID = implode(',', $isciGeID);

                            if (count($ogrenciGeID) > 0) {
                                $resultOgrenciIID = $Panel_Model->soforTurBaslatOgrenciIID($ogrGelmeyenID);
                                if (count($resultOgrenciIID) > 0) {
                                    $oi = 0;
                                    foreach ($resultOgrenciIID as $resultOgrenciIID) {
                                        $turGelmeyen[$oi]['ID'] = $resultOgrenciIID['BSOgrenciID'];
                                        $turGelmeyen[$oi]['Ad'] = $resultOgrenciIID['BSOgrenciAd'];
                                        $turGelmeyen[$oi]['Soyad'] = $resultOgrenciIID['BSOgrenciSoyad'];
                                        $turGelmeyen[$oi]['Telefon'] = $resultOgrenciIID['BSOgrenciPhone'];
                                        $turGelmeyen[$oi]['Tip'] = 0;
                                        $oi++;
                                    }
                                }
                            }

                            if (count($isciGeID) > 0) {
                                $resultIsciIID = $Panel_Model->soforTurBaslatIsciIID($iscGelmeyenID);
                                if (count($resultIsciIID) > 0) {
                                    foreach ($resultIsciIID as $resultIsciIIDD) {
                                        $turGelmeyen[$oi]['ID'] = $resultIsciIIDD['SBIsciID'];
                                        $turGelmeyen[$oi]['Ad'] = $resultIsciIIDD['SBIsciAd'];
                                        $turGelmeyen[$oi]['Soyad'] = $resultIsciIIDD['SBIsciSoyad'];
                                        $turGelmeyen[$oi]['Telefon'] = $resultIsciIIDD['SBIsciPhone'];
                                        $turGelmeyen[$oi]['Tip'] = 1;
                                        $oi++;
                                    }
                                }
                            }
                        }
                        $sonuc = $turGelmeyen;
                    }

                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

