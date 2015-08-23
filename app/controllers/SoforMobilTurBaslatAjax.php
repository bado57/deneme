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

                case "turservisloc":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("aracid", true);
                        $form->post("turid", true);
                        $form->post("turtip", true);
                        $form->post("soforid", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $aracID = $form->values['aracid'];
                        $turID = $form->values['turid'];
                        $turTip = $form->values['turtip'];
                        $soforID = $form->values['soforid'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];

                        $resultAnlikLoc = $Panel_Model->aracAnlikLoc($aracID, $turID);
                        if ($resultAnlikLoc) {//update
                            $dataLocUptade = array(
                                'BSAracLokasyon' => $enlem . ',' . $boylam,
                            );

                            $locupdate = $Panel_Model->aracAnlikUpdate($dataLocUptade, $resultAnlikLoc[0]["BSAracLokasyonID"]);
                            if ($locupdate) {
                                $sonuc["result"] = "1";
                            } else {
                                $locupdate = $Panel_Model->aracAnlikUpdate($dataLocUptade, $resultAnlikLoc[0]["BSAracLokasyonID"]);
                                if ($locupdate) {
                                    $sonuc["result"] = "1";
                                } else {
                                    $sonuc["result"] = "0";
                                }
                            }
                        } else {//insert
                            if ($form->submit()) {
                                $dataInsert = array(
                                    'BSAracID' => $aracID,
                                    'BSAracLokasyon' => $enlem . ',' . $boylam,
                                    'BSAracTurTip' => $turTip,
                                    'BSAracTurID' => $turID,
                                    'BSSoforID' => $soforID
                                );
                            }
                            $rsltAnlikLocInsert = $Panel_Model->addNewAnlikLoc($dataInsert);
                            if ($rsltAnlikLocInsert) {
                                $sonuc["result"] = "1";
                            } else {
                                $rsltAnlikLocInsert = $Panel_Model->addNewAnlikLoc($dataInsert);
                                if ($rsltAnlikLocInsert) {
                                    $sonuc["result"] = "1";
                                } else {
                                    $sonuc["result"] = "0";
                                }
                            }
                        }
                    }
                    break;

                case "turbaslatilk":

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
                        $time = date('H:i', time());
                        $gun = date('D', strtotime($date));
                        //zaman planlaması
                        $newTime = explode(':', trim($time));
                        $sonTime = '';
                        if ($newTime[0][0] != 1) {//ilki 0 ise
                            if ($newTime[0][1] == 0) {//ikinci 0 ise
                                if ($newTime[1][0] == 0) {//üçüncü 0 ise
                                    if ($newTime[1][1] == 0) {//dördüncü 0 ise
                                        $sonTime = 0;
                                    } else {
                                        $sonTime = $newTime[1][1];
                                    }
                                } else {
                                    $sonTime = $newTime[1];
                                }
                            } else {
                                $sonTime = $newTime[0][1] . $newTime[1];
                            }
                        } else {
                            $sonTime = $newTime[0] . $newTime[1];
                        }

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

                        $resultTurBaslat = $Panel_Model->soforTurBaslatID($kid, $yeniGun);
                        if (count($resultTurBaslat) > 0) {//tur varsa
                            $turBaslat = [];
                            $oncekideger = 0;
                            $veritabanıSaati = 0;
                            $timerSaati = 0;
                            $b = 0;
                            foreach ($resultTurBaslat as $resultTurBaslatt) {
                                if ($resultTurBaslatt['BsTurBitis'] != 1) {//tur yapılmadı ise
                                    $yenideger = $sonTime - $resultTurBaslatt['BSTurBslngc'];
                                    if ($yenideger < 0) {
                                        $yenideger = -$yenideger;
                                    }
                                    if ($b == 0) {//bir defaya mahsus if e girmesini sağladım
                                        $oncekideger = $yenideger;
                                    }
                                    if ($yenideger <= $oncekideger) {//önceki değer daha yakın olmakta
                                        $turBaslat[0]['GidisDonus'] = $resultTurBaslatt['BSTurGidisDonus'];
                                        $turID = $resultTurBaslatt['BSTurID'];
                                        //tur yapılmamış olsa bile normal saati geçip geçmediğini kontrol ediyoruz
                                        if ($sonTime < $resultTurBaslatt['BSTurBslngc']) {//tur saati geçmemiş
                                            $turBaslat[0]['ZamanKontrol'] = 1;
                                        } else if ($sonTime > $resultTurBaslatt['BSTurBslngc']) {//tur saati geçmiş ama yapılmamış daha
                                            $turBaslat[0]['ZamanKontrol'] = 1;
                                        } else {//şimdi tur başlamalı
                                            $turBaslat[0]['ZamanKontrol'] = 2;
                                        }
                                        $veritabanıSaati = $resultTurBaslatt['BSTurBslngc'];
                                        $oncekideger = $yenideger;
                                        $turBaslat[0]['HostesID'] = $resultTurBaslatt['BSTurHostesID'];
                                        $turBaslat[0]['AracID'] = $resultTurBaslatt['BSTurAracID'];
                                    }
                                }
                                $b++;
                            }

                            $result = $Panel_Model->soforTurBaslatIlk($turID);
                            if (count($result) > 0) {
                                foreach ($result as $resultt) {
                                    $turBaslat[0]['ID'] = $resultt['SBTurID'];
                                    $turBaslat[0]['Ad'] = $resultt['SBTurAd'];
                                    $turBaslat[0]['Tip'] = $resultt['SBTurTip'];
                                    $turBaslat[0]['Km'] = $resultt['SBTurKm'];
                                    $turBaslat[0]['Gun'] = $yeniGun;
                                }
                            }

                            //Tur veritabnaı saati
                            $baslangic;
                            if (strlen((string) $veritabanıSaati) == 1) {
                                $baslangic = '00:00';
                            } else if (strlen((string) $veritabanıSaati) == 2) {
                                $baslangic = '00:' . $veritabanıSaati;
                            } else if (strlen((string) $veritabanıSaati) == 3) {
                                $ilkHarf1 = substr($veritabanıSaati, 0, 1);
                                $sondaikiHarf1 = substr($veritabanıSaati, 1, 3);
                                $baslangic = '0' . $ilkHarf1 . ':' . $sondaikiHarf1;
                            } else {
                                $ilkikiHarf1 = substr($veritabanıSaati, 0, 2);
                                $sondaikiHarf1 = substr($veritabanıSaati, 2, 4);
                                $baslangic = $ilkikiHarf1 . ':' . $sondaikiHarf1;
                            }
                            $turBaslat[0]['Saat'] = $baslangic;

                            //timer saati
                            if ($turBaslat[0]['ZamanKontrol'] == 0) {
                                $son = explode(':', trim($form->get_time_difference($time, $baslangic)));
                                $ms = $son[0] * 60 * 60 * 1000 + $son[1] * 60 * 1000;
                                $turBaslat[0]['Timer'] = $ms;
                            }
                            $turBaslat[0]['Var'] = 1;
                            $turBaslat[0]['Tarih'] = $date;
                            $turBaslat[0]['BasSaat'] = $time;
                        } else {//tur yok
                            $turBaslat[0]['Var'] = 0;
                        }

                        $sonuc = $turBaslat;
                    }

                    break;

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

                case "turkisidetay":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("kisiID", true);
                        $form->post("kisiTip", true);
                        $kisiID = $form->values['kisiID'];
                        $kisiTip = $form->values['kisiTip'];

                        $turKisiDetay = [];
                        if ($kisiTip != 1) {//öğrenci
                            $resultOgrenci = $Panel_Model->soforTurBaslatKOgrenciDetay($kisiID);
                            if (count($resultOgrenci) > 0) {
                                $o = 0;
                                foreach ($resultOgrenci as $resultOgrencii) {
                                    $turKisiDetay[$o]['ID'] = $resultOgrencii['BSOgrenciID'];
                                    $turKisiDetay[$o]['Ad'] = $resultOgrencii['BSOgrenciAd'];
                                    $turKisiDetay[$o]['Soyad'] = $resultOgrencii['BSOgrenciSoyad'];
                                    $turKisiDetay[$o]['Telefon'] = $resultOgrencii['BSOgrenciPhone'];
                                    $turKisiDetay[$o]['Tip'] = 0;
                                    $o++;
                                }

                                $resultVeliID = $Panel_Model->soforTurBaslatKOgrVeliID($kisiID); //veli
                                if (count($resultVeliID) > 0) {
                                    $ogrenciVeliID = [];
                                    foreach ($resultVeliID as $resultVeliID) {
                                        $ogrenciVeliID[] = $resultVeliID['BSVeliID'];
                                    }

                                    $ogrenciVeli = implode(',', $ogrenciVeliID);

                                    $resultVeli = $Panel_Model->soforTurBaslatKVeliDetay($ogrenciVeli); //veli
                                    foreach ($resultVeli as $resultVelii) {
                                        $turKisiDetay[$o]['ID'] = $resultVelii['SBVeliID'];
                                        $turKisiDetay[$o]['Ad'] = $resultVelii['SBVeliAd'];
                                        $turKisiDetay[$o]['Soyad'] = $resultVelii['SBVeliSoyad'];
                                        $turKisiDetay[$o]['Telefon'] = $resultVelii['SBVeliPhone'];
                                        $turKisiDetay[$o]['Tip'] = 2;
                                        $o++;
                                    }
                                }
                            }
                        } else {//öğrenci-işçi
                            $resultIsci = $Panel_Model->soforTurBaslatKIsciDetay($kisiID);
                            if (count($resultIsci) > 0) {
                                $i = 0;
                                foreach ($resultIsci as $resultIscii) {
                                    $turKisiDetay[$i]['ID'] = $resultIscii['SBIsciID'];
                                    $turKisiDetay[$i]['Ad'] = $resultIscii['SBIsciAd'];
                                    $turKisiDetay[$i]['Soyad'] = $resultIscii['SBIsciSoyad'];
                                    $turKisiDetay[$i]['Telefon'] = $resultIscii['SBIsciPhone'];
                                    $turKisiDetay[$i]['Tip'] = 1;
                                    $i++;
                                }
                            }
                        }
                        $sonuc = $turKisiDetay;
                    }
                    break;

                case "turbaslatmaps":
                    $form->post("turID", true);
                    $form->post("turAdi", true);
                    $form->post("turTip", true);
                    $form->post("turGun", true);
                    $form->post("enlem", true);
                    $form->post("boylam", true);
                    $form->post("language", true);
                    $form->post("turGidisDonus", true);
                    $form->post("turBasSaat", true);
                    $turID = $form->values['turID'];
                    $turAdi = $form->values['turAdi'];
                    $enlem = $form->values['enlem'];
                    $boylam = $form->values['boylam'];
                    $turTip = $form->values['turTip'];
                    $yeniGun = $form->values['turGun'];
                    $lang = $form->values['language'];
                    $turGidisDonus = $form->values['turGidisDonus'];
                    $turBasSaat = $form->values['turBasSaat'];
                    //dil yapılandırması
                    $formLanguage = $this->load->mobillanguage($lang);
                    $language = $formLanguage->mobillanguage();
                    $turGelen = [];
                    if ($turTip == 0) {//öğrenci
                        $resultOgrenciID = $Panel_Model->soforTurBaslatOgrenciID($turID);
                        $ogrenciGelenID = [];
                        foreach ($resultOgrenciID as $resultOgrenciIDD) {
                            $ogrenciGelenID[] = $resultOgrenciIDD['BSOgrenciID'];
                            $kurumIslem[0]['KurumID'] = $resultOgrenciIDD['BSKurumID'];
                            $kurumIslem[0]['KurumAd'] = $resultOgrenciIDD['BSKurumAd'];
                            $kurumIslem[0]['KurumLoc'] = $resultOgrenciIDD['BSKurumLocation'];
                        }

                        $resultOgrenciGID = $Panel_Model->soforTurBaslatOgrenciGID($turID, $yeniGun, $turGidisDonus);
                        $ogrenciGelmeyenID = [];
                        foreach ($resultOgrenciGID as $resultOgrenciGID) {
                            $ogrenciGelmeyenID[] = $resultOgrenciGID['BSOgrenciID'];
                        }
                        //gelenlerin
                        $ogrenciID = array_diff($ogrenciGelenID, $ogrenciGelmeyenID);
                        $gelenID = implode(',', $ogrenciID);

                        $resultOgrenciIID = $Panel_Model->soforTBMapsOgrenciIID($gelenID);
                        if (count($resultOgrenciIID) > 0) {
                            $o = 0;
                            foreach ($resultOgrenciIID as $resultOgrenciIID) {
                                $turGelen[$o]['ID'] = $resultOgrenciIID['BSOgrenciID'];
                                $turGelen[$o]['Ad'] = $resultOgrenciIID['BSOgrenciAd'];
                                $turGelen[$o]['Soyad'] = $resultOgrenciIID['BSOgrenciSoyad'];
                                $turGelen[$o]['KPhone'] = $resultOgrenciIID['BSOgrenciPhone'];
                                if ($resultOgrenciIID['BSOgrenciPhone'] != "") {
                                    $turGelen[$o]['KPhone'] = $resultOgrenciIID['BSOgrenciPhone'];
                                } else {
                                    $turGelen[$o]['KPhone'] = "0";
                                }
                                $turGelen[$o]['Location'] = $resultOgrenciIID['BSOgrenciLocation'];
                                $turGelen[$o]['Tip'] = 0;
                                $o++;
                            }

                            //öğrenciye gönderilecek bildirimler
                            $resultOgrCihaz = $Panel_Model->ogrenciTumTurCihaz($gelenID);
                            if (count($resultOgrCihaz) > 0) {
                                foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                    $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                }
                                $ogrCihazlar = implode(',', $ogrCihaz);
                                $duyuruOgrText = $turAdi . ' ' . $language["TurBaslat"];
                                $form->shuttleNotification($ogrCihazlar, $duyuruOgrText, $language["TurBaslatTitle"]);
                            }

                            //tüm turdaki öğrenci velilerine gönderilecek bildirimler
                            $resultOgrVeliIDler = $Panel_Model->ogrenciVeliIDler($gelenID);
                            if (count($resultOgrVeliIDler) > 0) {
                                foreach ($resultOgrVeliIDler as $resultOgrVeliIDlerr) {
                                    $veliidler[] = $resultOgrVeliIDlerr['BSVeliID'];
                                }
                                $veliid = implode(',', $veliidler);
                                $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($veliid);
                                if (count($resultOgrVeliCihaz) > 0) {
                                    foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                        $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                    }
                                    $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                    $duyuruOgrText = $turAdi . ' ' . $language["TurBaslat"];
                                    $form->shuttleNotification($ogrVeliCihazlar, $duyuruOgrText, $language["TurBaslatTitle"]);
                                }
                            }
                        }
                        //tur başladı bilgisi
                        $dataTurUptade = array(
                            'SBTurAktiflik' => 1,
                            'SBTurBasSaat' => $turBasSaat,
                        );

                        $turupdate = $Panel_Model->soforTurBaslatUpdate($dataTurUptade, $turID);
                        if ($turupdate) {
                            //kurum bilgileri
                            $turGelen[$o]['ID'] = $kurumIslem[0]['KurumID'];
                            $turGelen[$o]['Ad'] = $kurumIslem[0]['KurumAd'];
                            $turGelen[$o]['Soyad'] = "";
                            $turGelen[$o]['KPhone'] = "0";
                            $turGelen[$o]['Tip'] = 2;
                            $turGelen[$o]['Location'] = $kurumIslem[0]['KurumLoc'];
                        }
                        $sonuc["KisiBilgi"] = $turGelen;
                    } else if ($turTip == 1) {//işçi
                        $resultIsciID = $Panel_Model->soforTurBaslatIsciID($turID);
                        $isciGelenID = [];
                        $kurumIslem = [];
                        foreach ($resultIsciID as $resultIsciIDD) {
                            $isciGelenID[] = $resultIsciIDD['SBIsciID'];
                            $kurumIslem[0]['KurumID'] = $resultIsciIDD['SBKurumID'];
                            $kurumIslem[0]['KurumAd'] = $resultIsciIDD['SBKurumAd'];
                            $kurumIslem[0]['KurumLoc'] = $resultIsciIDD['SBKurumLocation'];
                        }

                        $resultIsciGID = $Panel_Model->soforTurBaslatIsciGID($turID, $yeniGun, $turGidisDonus);
                        $isciGelmeyenID = [];
                        foreach ($resultIsciGID as $resultIsciGIDD) {
                            $isciGelmeyenID[] = $resultIsciGIDD['BSIsciID'];
                        }

                        $isciID = array_diff($isciGelenID, $isciGelmeyenID);
                        $gelenID = implode(',', $isciID);

                        $resultIsciIID = $Panel_Model->soforTBMapsIsciIID($gelenID);
                        if (count($resultIsciIID) > 0) {
                            $i = 0;
                            foreach ($resultIsciIID as $resultIsciIIDD) {
                                $turGelen[$i]['ID'] = $resultIsciIIDD['SBIsciID'];
                                $turGelen[$i]['Ad'] = $resultIsciIIDD['SBIsciAd'];
                                $turGelen[$i]['Soyad'] = $resultIsciIIDD['SBIsciSoyad'];
                                $turGelen[$i]['KPhone'] = $resultIsciIIDD['SBIsciPhone'];
                                if ($resultIsciIIDD['SBIsciPhone'] != "") {
                                    $turGelen[$i]['KPhone'] = $resultIsciIIDD['SBIsciPhone'];
                                } else {
                                    $turGelen[$i]['KPhone'] = "0";
                                }
                                $turGelen[$i]['Location'] = $resultIsciIIDD['SBIsciLocation'];
                                $turGelen[$i]['Tip'] = 1;
                                $i++;
                            }

                            //işçiye gönderilecek bildirimler
                            $resultIsciCihaz = $Panel_Model->isciTumTurCihaz($gelenID);
                            if (count($resultIsciCihaz) > 0) {
                                foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                    $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                }
                                $isciCihazlar = implode(',', $isciCihaz);
                                $duyuruIsciText = $turAdi . ' ' . $language["TurBaslat"];
                                $form->shuttleNotification($isciCihazlar, $duyuruIsciText, $language["TurBaslatTitle"]);
                            }
                        }
                        //tur başladı bilgisi
                        $dataTurUptade = array(
                            'SBTurAktiflik' => 1,
                            'SBTurBasSaat' => $turBasSaat,
                        );

                        $turupdate = $Panel_Model->soforTurBaslatUpdate($dataTurUptade, $turID);
                        if ($turupdate) {
                            //kurum bilgileri
                            $turGelen[$i]['ID'] = $kurumIslem[0]['KurumID'];
                            $turGelen[$i]['Ad'] = $kurumIslem[0]['KurumAd'];
                            $turGelen[$i]['Soyad'] = "";
                            $turGelen[$i]['KPhone'] = "0";
                            $turGelen[$i]['Tip'] = 2;
                            $turGelen[$i]['Location'] = $kurumIslem[0]['KurumLoc'];
                        }
                        $sonuc["KisiBilgi"] = $turGelen;
                    } else {//öğrenci-işçi
                        $resultOgrenciIsciID = $Panel_Model->soforTurBaslatOgrenciIsciID($turID);
                        $ogrenciGID = [];
                        $isciGID = [];
                        $kurumIslem = [];
                        $opislem = [];
                        $op = 0;
                        foreach ($resultOgrenciIsciID as $resultOgrenciIsciIDD) {
                            if ($resultOgrenciIsciIDD['BSKullaniciTip'] != 1) {//öğrenci
                                $ogrenciGID[] = $resultOgrenciIsciIDD['BSOgrenciIsciID'];
                                $opislem[$op] = 0;
                            } else {
                                $isciGID[] = $resultOgrenciIsciIDD['BSOgrenciIsciID'];
                                $opislem[$op] = 1;
                            }
                            $op++;
                            $kurumIslem[0]['KurumID'] = $resultOgrenciIsciIDD['BSKurumID'];
                            $kurumIslem[0]['KurumAd'] = $resultOgrenciIsciIDD['BSKurumAd'];
                            $kurumIslem[0]['KurumLoc'] = $resultOgrenciIsciIDD['BSKurumLocation'];
                        }

                        $resultOgrenciIsciGID = $Panel_Model->soforTurBaslatOgrenciIsciGID($turID, $yeniGun, $turGidisDonus);
                        $ogrenciGeID = [];
                        $isciGeID = [];
                        foreach ($resultOgrenciIsciGID as $resultOgrenciIsciGIDD) {
                            if ($resultOgrenciIsciGIDD['BSKullaniciTip'] != 1) {//işçi
                                $ogrenciGeID[] = $resultOgrenciIsciGIDD['BSKisiID'];
                            } else {
                                $isciGeID[] = $resultOgrenciIsciGIDD['BSKisiID'];
                            }
                            $kurumIslem[0]['KurumID'] = $resultOgrenciIsciIDD['BSKurumID'];
                            $kurumIslem[0]['KurumAd'] = $resultOgrenciIsciIDD['BSKurumAd'];
                            $kurumIslem[0]['KurumLoc'] = $resultOgrenciIsciIDD['BSKurumLocation'];
                        }

                        $ogrenciSonID = array_diff($ogrenciGID, $ogrenciGeID);
                        $ogrID = implode(',', $ogrenciSonID);
                        $isciSonID = array_diff($isciGID, $isciGeID);
                        $iscID = implode(',', $isciSonID);

                        if (count($ogrenciSonID) > 0) {
                            $resultOgrenciIID = $Panel_Model->soforTBMapsOgrenciIID($ogrID);
                            if (count($resultOgrenciIID) > 0) {
                                $o = 0;
                                $turGelenO = [];
                                foreach ($resultOgrenciIID as $resultOgrenciIID) {
                                    $turGelenO[$o]['ID'] = $resultOgrenciIID['BSOgrenciID'];
                                    $turGelenO[$o]['Ad'] = $resultOgrenciIID['BSOgrenciAd'];
                                    $turGelenO[$o]['Soyad'] = $resultOgrenciIID['BSOgrenciSoyad'];
                                    if ($resultOgrenciIID['BSOgrenciPhone'] != "") {
                                        $turGelenO[$o]['KPhone'] = $resultOgrenciIID['BSOgrenciPhone'];
                                    } else {
                                        $turGelenO[$o]['KPhone'] = "0";
                                    }
                                    $turGelenO[$o]['Location'] = $resultOgrenciIID['BSOgrenciLocation'];
                                    $turGelenO[$o]['Tip'] = 0;
                                    $o++;
                                }
                            }
                            //öğrenciye gönderilecek bildirimler
                            $resultOgrCihaz = $Panel_Model->ogrenciTumTurCihaz($ogrID);
                            if (count($resultOgrCihaz) > 0) {
                                foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                    $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                }
                                $ogrCihazlar = implode(',', $ogrCihaz);
                                $duyuruOgrText = $turAdi . ' ' . $language["TurBaslat"];
                                $form->shuttleNotification($ogrCihazlar, $duyuruOgrText, $language["TurBaslatTitle"]);
                            }

                            //tüm turdaki öğrenci velilerine gönderilecek bildirimler
                            $resultOgrVeliIDler = $Panel_Model->ogrenciVeliIDler($ogrID);
                            if (count($resultOgrVeliIDler) > 0) {
                                foreach ($resultOgrVeliIDler as $resultOgrVeliIDlerr) {
                                    $veliidler[] = $resultOgrVeliIDlerr['BSVeliID'];
                                }
                                $veliid = implode(',', $veliidler);
                                $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($veliid);
                                if (count($resultOgrVeliCihaz) > 0) {
                                    foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                        $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                    }
                                    $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                    $duyuruOgrText = $turAdi . ' ' . $language["TurBaslat"];
                                    $form->shuttleNotification($ogrVeliCihazlar, $duyuruOgrText, $language["TurBaslatTitle"]);
                                }
                            }
                        }
                        if (count($isciSonID) > 0) {
                            $resultIsciIID = $Panel_Model->soforTBMapsIsciIID($iscID);
                            if (count($resultIsciIID) > 0) {
                                $i = 0;
                                $turGelenP = [];
                                foreach ($resultIsciIID as $resultIsciIIDD) {
                                    $turGelenP[$i]['ID'] = $resultIsciIIDD['SBIsciID'];
                                    $turGelenP[$i]['Ad'] = $resultIsciIIDD['SBIsciAd'];
                                    $turGelenP[$i]['Soyad'] = $resultIsciIIDD['SBIsciSoyad'];
                                    if ($resultOgrenciIID['BSOgrenciPhone'] != "") {
                                        $turGelenP[$i]['KPhone'] = $resultOgrenciIID['BSOgrenciPhone'];
                                    } else {
                                        $turGelenP[$i]['KPhone'] = "0";
                                    }
                                    $turGelenP[$i]['Location'] = $resultIsciIIDD['SBIsciLocation'];
                                    $turGelenP[$i]['Tip'] = 1;
                                    $i++;
                                }
                            }

                            //işçiye gönderilecek bildirimler
                            $resultIsciCihaz = $Panel_Model->isciTumTurCihaz($iscID);
                            if (count($resultIsciCihaz) > 0) {
                                foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                    $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                }
                                $isciCihazlar = implode(',', $isciCihaz);
                                $duyuruIsciText = $turAdi . ' ' . $language["TurBaslat"];
                                $form->shuttleNotification($isciCihazlar, $duyuruIsciText, $language["TurBaslatTitle"]);
                            }
                        }
                        //tur başladı bilgisi
                        $dataTurUptade = array(
                            'SBTurAktiflik' => 1,
                            'SBTurBasSaat' => $turBasSaat,
                        );

                        $turupdate = $Panel_Model->soforTurBaslatUpdate($dataTurUptade, $turID);
                        if ($turupdate) {
                            $turGelenK = [];
                            //kurum bilgileri
                            $turGelenK[0]['ID'] = $kurumIslem[0]['KurumID'];
                            $turGelenK[0]['Ad'] = $kurumIslem[0]['KurumAd'];
                            $turGelenK[0]['Soyad'] = "";
                            $turGelenK[0]['KPhone'] = "0";
                            $turGelenK[0]['Tip'] = 2;
                            $turGelenK[0]['Location'] = $kurumIslem[0]['KurumLoc'];
                        }
                        $sonuc["Ogrenci"] = $turGelenO;
                        $sonuc["Personel"] = $turGelenP;
                        $sonuc["Kurum"] = $turGelenK;
                        $sonuc["Sira"] = $opislem;
                    }

                    //aaktif olan tudaki son durum
                    $kisidurum = 0;
                    $turKisiDurum = [];
                    if ($turGidisDonus != 1) {//gidiş turu
                        $resultOgrBinen = $Panel_Model->soforTurOgrGidisBinen($turID);
                        foreach ($resultOgrBinen as $resultOgrBinenn) {
                            $turKisiDurum[$kisidurum]['Sira'] = $resultOgrBinenn['BSKisiSira'];
                            $kisidurum++;
                        }
                    } else {
                        $resultOgrBinen = $Panel_Model->soforTurOgrDonusInen($turID);
                        foreach ($resultOgrBinen as $resultOgrBinenn) {
                            $turKisiDurum[$kisidurum]['Sira'] = $resultOgrBinenn['BSKisiSira'];
                            $kisidurum++;
                        }
                    }
                    $sonuc["KisiDurum"] = $turKisiDurum;
                    break;

                case "turkisiindibindi":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("kisiID", true);
                        $form->post("kisiTip", true);
                        $form->post("kisiAd", true);
                        $form->post("dgrKisiID", true);
                        $form->post("dgrKisiTip", true);
                        $form->post("language", true);
                        $form->post("turGidisDonus", true);
                        $form->post("turID", true);
                        $form->post("turTip", true);
                        $form->post("anlikkonum", true);
                        $form->post("kullaniciSira", true);
                        $form->post("turTarih", true);
                        $form->post("turGun", true);
                        $form->post("turAdi", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $kisiID = $form->values['kisiID'];
                        $kisiTip = $form->values['kisiTip'];
                        $kisiAd = $form->values['kisiAd'];
                        $dgrKisiID = $form->values['dgrKisiID'];
                        $dgrKisiTip = $form->values['dgrKisiTip'];
                        $gdsDonus = $form->values['turGidisDonus'];
                        $turID = $form->values['turID'];
                        $turTip = $form->values['turTip'];
                        $lang = $form->values['language'];
                        $kisiKonum = $form->values['anlikkonum'];
                        $kisiSira = $form->values['kullaniciSira'];
                        $turTarih = $form->values['turTarih'];
                        $turGun = $form->values['turGun'];
                        $turAdi = $form->values['turAdi'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];

                        //date ve time bilgilerini bölgeye göre alma
                        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                        $url = str_replace(' ', '', $url);
                        $json_timezone = file_get_contents($url);
                        $obj = json_decode($json_timezone, true);
                        date_default_timezone_set($obj["timeZoneId"]);
                        $time = date('H:i', time());

                        $formLanguage = $this->load->mobillanguage($lang);
                        $language = $formLanguage->mobillanguage();
                        if ($gdsDonus != 1) {//Gidiş turu
                            if ($kisiTip == 0) {//binen öğrenci ise
                                if ($turTip == 0) {//öğrenci turu
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addGidisOgrenciLog($dataLogGidis);
                                } else if ($turTip == 2) {//öğrenci-işçi turunda
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 0,
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addGidisOgrenciIsciLog($dataLogGidis);
                                }
                                //binen kişinin velisine bildirim gönderme
                                if ($resultOgrenciLog) {
                                    $resultOgrVeli = $Panel_Model->ogrenciTurVeli($kisiID);
                                    if (count($resultOgrVeli) > 0) {
                                        $turVeliID = [];
                                        foreach ($resultOgrVeli as $resultOgrVelii) {
                                            $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                        }
                                        $ogrVeliIDler = implode(',', $turVeliID);
                                        $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                        if (count($resultOgrVeliCihaz) > 0) {
                                            foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                                $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                            $duyuruOgrText = $kisiAd . ' ' . $language["OgrenciBindi"];
                                            $form->shuttleNotification($ogrVeliCihazlar, $duyuruOgrText, $language["ServiseBinmeTitle"]);
                                        }
                                    }
                                }
                            } elseif ($kisiTip == 1) {//işçi ise
                                if ($turTip == 1) {//işçi turu
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addGidisIsciLog($dataLogGidis);
                                } else if ($turTip == 2) {//öğrenci ve işçi
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 1
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addGidisOgrenciIsciLog($dataLogGidis);
                                }
                            }
                            //diğer kişi için bildirim gönderme eğer kurum ise bildirim gönderilmeyeck
                            if ($dgrKisiTip == 0) {//öğrenci ise
                                $resultOgrCihaz = $Panel_Model->ogrenciTurCihaz($dgrKisiID);
                                if (count($resultOgrCihaz) > 0) {
                                    $ogrCihaz = [];
                                    foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                        $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                    }
                                    $ogrCihazlar = implode(',', $ogrCihaz);
                                    $form->shuttleNotification($ogrCihazlar, $language["ServisYaklasti"], $language["ServisYaklastiTitle"]);
                                }
                                //öğrenci velisi varsa ona bildirim
                                $resultOgrDgrVeli = $Panel_Model->ogrenciTurVeli($dgrKisiID);
                                if (count($resultOgrDgrVeli) > 0) {
                                    $turVeliID = [];
                                    foreach ($resultOgrDgrVeli as $resultOgrDgrVelii) {
                                        $turVeliID[] = $resultOgrDgrVelii['BSVeliID'];
                                    }
                                    $ogrVeliIDler = implode(',', $turVeliID);
                                    $resultOgrVeliDgrCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                    if (count($resultOgrVeliDgrCihaz) > 0) {
                                        foreach ($resultOgrVeliDgrCihaz as $resultOgrVeliDgrCihazz) {
                                            $ogrVeliCihaz[] = $resultOgrVeliDgrCihazz['bsvelicihazRecID'];
                                        }
                                        $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                        $form->shuttleNotification($ogrVeliCihazlar, $language["ServisYaklasti"], $language["ServiseBinmeTitle"]);
                                    }
                                }
                            } elseif ($dgrKisiTip == 1) {//işçi ise
                                $resultIsciCihaz = $Panel_Model->isciTurCihaz($dgrKisiID);
                                if (count($resultIsciCihaz) > 0) {
                                    foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                        $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                    }
                                    $isciCihazlar = implode(',', $isciCihaz);
                                    $form->shuttleNotification($isciCihazlar, $language["ServisYaklasti"], $language["ServisYaklastiTitle"]);
                                }
                            }
                            //binen kişiyi veritabanına kaydetme
                            if ($form->submit()) {
                                $dataGidis = array(
                                    'BSKisiDurum' => 1, //kişi bindi ise
                                    'BSTurID' => $turID,
                                    'BSKisiID' => $kisiID,
                                    'BSKisiTip' => $kisiTip,
                                    'BSKisiKonum' => $kisiKonum,
                                    'BSKisiSira' => $kisiSira
                                );
                            }
                            $resultBinis = $Panel_Model->addNewBinisTur($dataGidis);
                            if ($resultBinis) {
                                $sonuc["result"] = "1";
                            } else {
                                $resultBinisTkrr = $Panel_Model->addNewBinisTur($dataGidis);
                                if ($resultBinisTkrr) {
                                    $sonuc["result"] = "1";
                                }
                            }
                        } else {//dönüş turu ise
                            if ($kisiTip != 1) {//binen öğrenci ise
                                if ($turTip == 0) {//öğrenci turu
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addDonusOgrenciLog($dataLogDonus);
                                } else if ($turTip == 2) {//öğrenci-işçi turunda
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 0
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addDonusOgrenciIsciLog($dataLogDonus);
                                }
                                if ($resultOgrenciLog) {
                                    $resultOgrVeli = $Panel_Model->ogrenciTurVeli($kisiID);
                                    if (count($resultOgrVeli) > 0) {
                                        $turVeliID = [];
                                        foreach ($resultOgrVeli as $resultOgrVelii) {
                                            $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                        }
                                        $ogrVeliIDler = implode(',', $turVeliID);
                                        $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                        if (count($resultOgrVeliCihaz) > 0) {
                                            foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                                $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                            $duyuruOgrText = $kisiAd . ' ' . $language["OgrenciIndi"];
                                            $form->shuttleNotification($ogrVeliCihazlar, $duyuruOgrText, $language["ServiseInmeTitle"]);
                                        }
                                    }
                                }
                            } elseif ($kisiTip == 1) {//işçi ise
                                if ($turTip == 1) {//işçi turu
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addDonusIsciLog($dataLogDonus);
                                } else if ($turTip == 2) {//öğrenci ve işçi
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 1,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 1
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addDonusOgrenciIsciLog($dataLogDonus);
                                }
                            }

                            //diğer kişi için bildirim gönderme eğer kurum ise bildirim gönderilmeyeck
                            if ($dgrKisiTip == 0) {//öğrenci ise
                                //öğrenci velisi varsa ona bildirim
                                $resultOgrDgrVeli = $Panel_Model->ogrenciTurVeli($dgrKisiID);
                                if (count($resultOgrDgrVeli) > 0) {
                                    $turVeliID = [];
                                    foreach ($resultOgrDgrVeli as $resultOgrDgrVelii) {
                                        $turVeliID[] = $resultOgrDgrVelii['BSVeliID'];
                                    }
                                    $ogrVeliIDler = implode(',', $turVeliID);
                                    $resultOgrVeliDgrCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                    if (count($resultOgrVeliDgrCihaz) > 0) {
                                        foreach ($resultOgrVeliDgrCihaz as $resultOgrVeliDgrCihazz) {
                                            $ogrVeliCihaz[] = $resultOgrVeliDgrCihazz['bsvelicihazRecID'];
                                        }
                                        $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                        $form->shuttleNotification($ogrVeliCihazlar, $language["ServisYaklasti"], $language["ServiseInmeTitle"]);
                                    }
                                }
                            }
                            //inen kişiyi veritabanına kaydetme
                            if ($form->submit()) {
                                $dataDonus = array(
                                    'BSKisiDurum' => 1, //kişi indi ise
                                    'BSTurID' => $turID,
                                    'BSKisiID' => $kisiID,
                                    'BSKisiTip' => $kisiTip,
                                    'BSKisiKonum' => $kisiKonum,
                                    'BSKisiSira' => $kisiSira
                                );
                            }
                            $resultInis = $Panel_Model->addNewInisTur($dataDonus);
                            if ($resultInis) {
                                $sonuc["result"] = "1";
                            } else {
                                $resultInisTkrr = $Panel_Model->addNewInisTur($dataDonus);
                                if ($resultInisTkrr) {
                                    $sonuc["result"] = "1";
                                }
                            }
                        }
                    }
                    break;

                case "turkisiinmedibinmedi":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("kisiID", true);
                        $form->post("kisiTip", true);
                        $form->post("kisiAd", true);
                        $form->post("dgrKisiID", true);
                        $form->post("dgrKisiTip", true);
                        $form->post("language", true);
                        $form->post("turGidisDonus", true);
                        $form->post("turID", true);
                        $form->post("turTip", true);
                        $form->post("turTarih", true);
                        $form->post("turGun", true);
                        $form->post("anlikkonum", true);
                        $form->post("kullaniciSira", true);
                        $form->post("turAdi", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $kisiID = $form->values['kisiID'];
                        $kisiTip = $form->values['kisiTip'];
                        $kisiAd = $form->values['kisiAd'];
                        $dgrKisiID = $form->values['dgrKisiID'];
                        $dgrKisiTip = $form->values['dgrKisiTip'];
                        $gdsDonus = $form->values['turGidisDonus'];
                        $turID = $form->values['turID'];
                        $turTip = $form->values['turTip'];
                        $lang = $form->values['language'];
                        $kisiKonum = $form->values['anlikkonum'];
                        $kisiSira = $form->values['kullaniciSira'];
                        $turTarih = $form->values['turTarih'];
                        $turGun = $form->values['turGun'];
                        $turAdi = $form->values['turAdi'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];

                        //date ve time bilgilerini bölgeye göre alma
                        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                        $url = str_replace(' ', '', $url);
                        $json_timezone = file_get_contents($url);
                        $obj = json_decode($json_timezone, true);
                        date_default_timezone_set($obj["timeZoneId"]);
                        $time = date('H:i', time());

                        $formLanguage = $this->load->mobillanguage($lang);
                        $language = $formLanguage->mobillanguage();
                        if ($gdsDonus != 1) {//Gidiş turu
                            if ($kisiTip != 1) {//binmeyen öğrenci ise
                                if ($turTip == 0) {//öğrenci turu
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addGidisOgrenciLog($dataLogGidis);
                                } else if ($turTip == 2) {//öğrenci-işçi turunda
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 0
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addGidisOgrenciIsciLog($dataLogGidis);
                                }
                                if ($resultOgrenciLog) {
                                    $resultOgrVeli = $Panel_Model->ogrenciTurVeli($kisiID);
                                    if (count($resultOgrVeli) > 0) {
                                        $turVeliID = [];
                                        foreach ($resultOgrVeli as $resultOgrVelii) {
                                            $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                        }
                                        $ogrVeliIDler = implode(',', $turVeliID);
                                        $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                        if (count($resultOgrVeliCihaz) > 0) {
                                            foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                                $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                            $duyuruOgrText = $kisiAd . ' ' . $language["OgrenciBinmedi"];
                                            $form->shuttleNotification($ogrVeliCihazlar, $duyuruOgrText, $language["ServiseBinmeTitle"]);
                                        }
                                    }
                                }
                            } elseif ($kisiTip == 1) {//işçi ise
                                if ($turTip == 1) {//işçi turu
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addGidisIsciLog($dataLogGidis);
                                } else if ($turTip == 2) {//öğrenci ve işçi
                                    if ($form->submit()) {
                                        $dataLogGidis = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 1
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addGidisOgrenciIsciLog($dataLogGidis);
                                }
                            }
                            //diğer kişi için bildirim gönderme eğer kurum ise bildirim gönderilmeyeck
                            if ($dgrKisiTip == 0) {//öğrenci ise
                                $resultOgrCihaz = $Panel_Model->ogrenciTurCihaz($dgrKisiID);
                                if (count($resultOgrCihaz) > 0) {
                                    foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                        $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                    }
                                    $ogrCihazlar = implode(',', $ogrCihaz);
                                    $form->shuttleNotification($ogrCihazlar, $language["ServisYaklasti"], $language["ServisYaklastiTitle"]);
                                }
                                //öğrenci velisi varsa ona bildirim
                                $resultOgrDgrVeli = $Panel_Model->ogrenciTurVeli($dgrKisiID);
                                if (count($resultOgrDgrVeli) > 0) {
                                    $turVeliID = [];
                                    foreach ($resultOgrDgrVeli as $resultOgrDgrVelii) {
                                        $turVeliID[] = $resultOgrDgrVelii['BSVeliID'];
                                    }
                                    $ogrVeliIDler = implode(',', $turVeliID);
                                    $resultOgrVeliDgrCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                    if (count($resultOgrVeliDgrCihaz) > 0) {
                                        foreach ($resultOgrVeliDgrCihaz as $resultOgrVeliDgrCihazz) {
                                            $ogrVeliCihaz[] = $resultOgrVeliDgrCihazz['bsvelicihazRecID'];
                                        }
                                        $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                        $form->shuttleNotification($ogrVeliCihazlar, $language["ServisYaklasti"], $language["ServiseBinmeTitle"]);
                                    }
                                }
                            } elseif ($dgrKisiTip == 1) {//işçi ise
                                $resultIsciCihaz = $Panel_Model->isciTurCihaz($dgrKisiID);
                                if (count($resultIsciCihaz) > 0) {
                                    foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                        $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                    }
                                    $isciCihazlar = implode(',', $isciCihaz);
                                    $form->shuttleNotification($isciCihazlar, $language["ServisYaklasti"], $language["ServisYaklastiTitle"]);
                                }
                            }
                            //binmeyen kişiyi veritabanına kaydetme
                            if ($form->submit()) {
                                $dataGidis = array(
                                    'BSKisiDurum' => 0, //kişi binmedi ise
                                    'BSTurID' => $turID,
                                    'BSKisiID' => $kisiID,
                                    'BSKisiTip' => $kisiTip,
                                    'BSKisiKonum' => $kisiKonum,
                                    'BSKisiSira' => $kisiSira
                                );
                            }
                            $resultBinis = $Panel_Model->addNewBinisTur($dataGidis);
                            if ($resultBinis) {
                                $sonuc["result"] = "1";
                            } else {
                                $resultBinisTkrr = $Panel_Model->addNewBinisTur($dataGidis);
                                if ($resultBinisTkrr) {
                                    $sonuc["result"] = "1";
                                }
                            }
                        } else {//dönüş turu ise
                            if ($kisiTip != 1) {//binmeyen öğrenci ise
                                if ($turTip == 0) {//öğrenci turu
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addDonusOgrenciLog($dataLogDonus);
                                } else if ($turTip == 2) {//öğrenci-işçi turunda
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 0
                                        );
                                    }
                                    $resultOgrenciLog = $Panel_Model->addDonusOgrenciIsciLog($dataLogDonus);
                                }
                                if ($resultOgrenciLog) {
                                    $resultOgrVeli = $Panel_Model->ogrenciTurVeli($kisiID);
                                    if (count($resultOgrVeli) > 0) {
                                        $turVeliID = [];
                                        foreach ($resultOgrVeli as $resultOgrVelii) {
                                            $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                        }
                                        $ogrVeliIDler = implode(',', $turVeliID);
                                        $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                        if (count($resultOgrVeliCihaz) > 0) {
                                            foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                                $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                            $duyuruOgrText = $kisiAd . ' ' . $language["OgrenciInmedi"];
                                            $form->shuttleNotification($ogrVeliCihazlar, $duyuruOgrText, $language["ServiseInmeTitle"]);
                                        }
                                    }
                                }
                            } elseif ($kisiTip == 1) {//işçi ise
                                if ($turTip == 1) {//işçi turu
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addDonusIsciLog($dataLogDonus);
                                } else if ($turTip == 2) {//öğrenci ve işçi
                                    if ($form->submit()) {
                                        $dataLogDonus = array(
                                            'BSTurID' => $turID,
                                            'BSTurAd' => $turAdi,
                                            'BSTurSaat' => $time,
                                            'BSTurGun' => $turGun,
                                            'BSTurTarih' => $turTarih,
                                            'BSTurKonum' => $kisiKonum,
                                            'BSKisiDurum' => 0,
                                            'BsKisiID' => $kisiID,
                                            'BSKisiTip' => 1
                                        );
                                    }
                                    $resultIsciLog = $Panel_Model->addDonusOgrenciIsciLog($dataLogDonus);
                                }
                            }
                            //diğer kişi için bildirim gönderme eğer kurum ise bildirim gönderilmeyeck
                            if ($dgrKisiTip == 0) {//öğrenci ise
                                //öğrenci velisi varsa ona bildirim
                                $resultOgrDgrVeli = $Panel_Model->ogrenciTurVeli($dgrKisiID);
                                if (count($resultOgrDgrVeli) > 0) {
                                    $turVeliID = [];
                                    foreach ($resultOgrDgrVeli as $resultOgrDgrVelii) {
                                        $turVeliID[] = $resultOgrDgrVelii['BSVeliID'];
                                    }
                                    $ogrVeliIDler = implode(',', $turVeliID);
                                    $resultOgrVeliDgrCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                    if (count($resultOgrVeliDgrCihaz) > 0) {
                                        foreach ($resultOgrVeliDgrCihaz as $resultOgrVeliDgrCihazz) {
                                            $ogrVeliCihaz[] = $resultOgrVeliDgrCihazz['bsvelicihazRecID'];
                                        }
                                        $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                        $form->shuttleNotification($ogrVeliCihazlar, $language["ServisYaklasti"], $language["ServiseInmeTitle"]);
                                    }
                                }
                            }

                            //inmeyen kişiyi veritabanına kaydetme
                            if ($form->submit()) {
                                $dataDonus = array(
                                    'BSKisiDurum' => 0, //kişi inmedi ise
                                    'BSTurID' => $turID,
                                    'BSKisiID' => $kisiID,
                                    'BSKisiTip' => $kisiTip,
                                    'BSKisiKonum' => $kisiKonum,
                                    'BSKisiSira' => $kisiSira
                                );
                            }
                            $resultInis = $Panel_Model->addNewInisTur($dataDonus);
                            if ($resultInis) {
                                $sonuc["result"] = "1";
                            } else {
                                $resultInisTkrr = $Panel_Model->addNewInisTur($dataDonus);
                                if ($resultInisTkrr) {
                                    $sonuc["result"] = "1";
                                }
                            }
                        }
                    }
                    break;

                case "turbitir":

                    if (!$loginfirmaID) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post("language", true);
                        $form->post("anlikkonum", true);
                        $form->post("turGidisDonus", true);
                        $form->post("turID", true);
                        $form->post("turAdi", true);
                        $form->post("turGun", true);
                        $form->post("turTarih", true);
                        $form->post("enlem", true);
                        $form->post("boylam", true);
                        $form->post("turBasSaat", true);
                        $form->post("arryGlnKllnciID", true);
                        $form->post("arryGlnKllnciTip", true);
                        $lang = $form->values['language'];
                        $gdsDonus = $form->values['turGidisDonus'];
                        $anlikKonum = $form->values['anlikkonum'];
                        $turID = $form->values['turID'];
                        $turAdi = $form->values['turAdi'];
                        $turGun = $form->values['turGun'];
                        $turTarih = $form->values['turTarih'];
                        $enlem = $form->values['enlem'];
                        $boylam = $form->values['boylam'];
                        $baslangicSaat = $form->values['turBasSaat'];
                        $gelenKullaniciID = $form->values['arryGlnKllnciID'];
                        $gelenKullaniciTip = $form->values['arryGlnKllnciTip'];

                        //date ve time bilgilerini bölgeye göre alma
                        $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                        $url = str_replace(' ', '', $url);
                        $json_timezone = file_get_contents($url);
                        $obj = json_decode($json_timezone, true);
                        date_default_timezone_set($obj["timeZoneId"]);
                        $time = date('H:i', time());

                        //gelen tip dizisini parçalam istenilen biçime getirme
                        $strglnKllnciTip = ltrim($gelenKullaniciTip, '[');
                        $strglnKllnciTip1 = rtrim($strglnKllnciTip, ']');
                        $gelenKullaniciTip = explode(',', $strglnKllnciTip1);
                        //gelen id dizisini parçalama istenilen hale getirme
                        $glnKllnci = ltrim($gelenKullaniciID, '[');
                        $glnKllnci1 = rtrim($glnKllnci, ']');
                        $gelenKullaniciID = explode(',', $glnKllnci1);
                        $kullaniciGelenLength = count($gelenKullaniciID) - 1;
                        $ogrenciGeID = [];
                        $isciGeID = [];
                        for ($gid = 0; $gid < $kullaniciGelenLength; $gid++) {
                            if (ltrim($gelenKullaniciTip[$gid] != 1)) {//öğrenci
                                $ogrenciGID[] = $gelenKullaniciID[$gid];
                            } else {//personel
                                $isciGeID[] = $gelenKullaniciID[$gid];
                            }
                        }
                        $ogrIDler = implode(',', $ogrenciGID);
                        $isciIDler = implode(',', $isciGeID);


                        $formLanguage = $this->load->mobillanguage($lang);
                        $language = $formLanguage->mobillanguage();

                        $resultTurTip = $Panel_Model->turTipOzellik($turID, $gdsDonus);
                        if (count($resultTurTip) > 0) {
                            $turTip = [];
                            foreach ($resultTurTip as $resultTurTipp) {
                                $turTip[0]['TurTip'] = $resultTurTipp['BSTurTip'];
                                $turTip[0]['KurumID'] = $resultTurTipp['BSTurKurumID'];
                                $turTip[0]['KurumAd'] = $resultTurTipp['BSTurKurumAd'];
                                $turTip[0]['KurumLoc'] = $resultTurTipp['BSTurKurumLocation'];
                                $turTip[0]['AracID'] = $resultTurTipp['BSTurAracID'];
                                $turTip[0]['AracPlaka'] = $resultTurTipp['BSTurAracPlaka'];
                                $turTip[0]['SoforID'] = $resultTurTipp['BSTurSoforID'];
                                $turTip[0]['HostesID'] = $resultTurTipp['BSTurHostesID'];
                                $turTip[0]['TurKm'] = $resultTurTipp['BSTurKm'];
                            }
                        }
                        //saat ayarlaması
                        $saatFarki = trim($form->get_time_difference($time, $baslangic));

                        if ($gdsDonus != 1) {//gidiş turu
                            if ($turTip[0]['TurTip'] == 0) {//öğrenci
                                //öğrencilere bildirim gönderme
                                $resultOgrCihaz = $Panel_Model->ogrenciTurCihazlar($ogrIDler);
                                if (count($resultOgrCihaz) > 0) {
                                    foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                        $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                    }
                                    $ogrCihazlar = implode(',', $ogrCihaz);
                                    $form->shuttleNotification($ogrCihazlar, $language["ServisBitisGidis"], $language["ServisBitisTitle"]);
                                }
                                //Bildirimleri gönderme velilere
                                $resultOgrVeli = $Panel_Model->ogrenciTurVeliler($ogrIDler);
                                if (count($resultOgrVeli) > 0) {
                                    $turVeliID = [];
                                    foreach ($resultOgrVeli as $resultOgrVelii) {
                                        $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                    }
                                    $ogrVeliIDler = implode(',', $turVeliID);
                                    $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                    if (count($resultOgrVeliCihaz) > 0) {
                                        foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                            $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                        }
                                        $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                        $form->shuttleNotification($ogrVeliCihazlar, $language["ServisBitisGidis"], $language["ServisBitisTitle"]);
                                    }
                                }
                            } else if ($turTip[0]['TurTip'] == 1) {//işçi
                                //işçi için
                                $resultIsciCihaz = $Panel_Model->isciTurCihazlar($isciIDler);
                                if (count($resultIsciCihaz) > 0) {
                                    foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                        $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                    }
                                    $isciCihazlar = implode(',', $isciCihaz);
                                    $form->shuttleNotification($isciCihazlar, $language["ServisBitisGidis"], $language["ServisBitisTitle"]);
                                }
                            } else {//öğrenci-işçi
                                //öğrencilere bildirim gönderme
                                if (count($ogrenciGID) > 0) {
                                    $resultOgrCihaz = $Panel_Model->ogrenciTurCihazlar($ogrIDler);
                                    if (count($resultOgrCihaz) > 0) {
                                        foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                            $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrCihazlar = implode(',', $ogrCihaz);
                                        $form->shuttleNotification($ogrCihazlar, $language["ServisBitisGidis"], $language["ServisBitisTitle"]);
                                    }
                                    //Bildirimleri gönderme velilere
                                    $resultOgrVeli = $Panel_Model->ogrenciTurVeliler($ogrIDler);
                                    if (count($resultOgrVeli) > 0) {
                                        $turVeliID = [];
                                        foreach ($resultOgrVeli as $resultOgrVelii) {
                                            $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                        }
                                        $ogrVeliIDler = implode(',', $turVeliID);
                                        $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                        if (count($resultOgrVeliCihaz) > 0) {
                                            foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                                $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                            $form->shuttleNotification($ogrVeliCihazlar, $language["ServisBitisGidis"], $language["ServisBitisTitle"]);
                                        }
                                    }
                                }
                                //işçi için
                                if (count($isciGeID) > 0) {
                                    $resultIsciCihaz = $Panel_Model->isciTurCihazlar($isciIDler);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $language["ServisBitisGidis"], $language["ServisBitisTitle"]);
                                    }
                                }
                            }
                            //gidiş turundaki binenleri silme
                            $deleteresult = $Panel_Model->turGidisDelete($turID);
                        } else {//dönüş turu
                            if ($turTip[0]['TurTip'] == 0) {//öğrenci
                                //öğrencilere bildirim gönderme
                                $resultOgrCihaz = $Panel_Model->ogrenciTurCihazlar($ogrIDler);
                                if (count($resultOgrCihaz) > 0) {
                                    foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                        $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                    }
                                    $ogrCihazlar = implode(',', $ogrCihaz);
                                    $form->shuttleNotification($ogrCihazlar, $language["ServisBitisDonus"], $language["ServisBitisTitle"]);
                                }
                                //Bildirimleri gönderme velilere
                                $resultOgrVeli = $Panel_Model->ogrenciTurVeliler($ogrIDler);
                                if (count($resultOgrVeli) > 0) {
                                    $turVeliID = [];
                                    foreach ($resultOgrVeli as $resultOgrVelii) {
                                        $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                    }
                                    $ogrVeliIDler = implode(',', $turVeliID);
                                    $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                    if (count($resultOgrVeliCihaz) > 0) {
                                        foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                            $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                        }
                                        $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                        $form->shuttleNotification($ogrVeliCihazlar, $language["ServisBitisDonus"], $language["ServisBitisTitle"]);
                                    }
                                }
                            } else if ($turTip[0]['TurTip'] == 1) {
                                //işçi için
                                $resultIsciCihaz = $Panel_Model->isciTurCihazlar($isciIDler);
                                if (count($resultIsciCihaz) > 0) {
                                    foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                        $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                    }
                                    $isciCihazlar = implode(',', $isciCihaz);
                                    $form->shuttleNotification($isciCihazlar, $language["ServisBitisDonus"], $language["ServisBitisTitle"]);
                                }
                            } else {
                                //öğrencilere bildirim gönderme
                                if (count($ogrenciGID) > 0) {
                                    $resultOgrCihaz = $Panel_Model->ogrenciTurCihazlar($ogrIDler);
                                    if (count($resultOgrCihaz) > 0) {
                                        foreach ($resultOgrCihaz as $resultOgrCihazz) {
                                            $ogrCihaz[] = $resultOgrCihazz['bsogrencicihazRecID'];
                                        }
                                        $ogrCihazlar = implode(',', $ogrCihaz);
                                        $form->shuttleNotification($ogrCihazlar, $language["ServisBitisDonus"], $language["ServisBitisTitle"]);
                                    }
                                    //Bildirimleri gönderme velilere
                                    $resultOgrVeli = $Panel_Model->ogrenciTurVeliler($ogrIDler);
                                    if (count($resultOgrVeli) > 0) {
                                        $turVeliID = [];
                                        foreach ($resultOgrVeli as $resultOgrVelii) {
                                            $turVeliID[] = $resultOgrVelii['BSVeliID'];
                                        }
                                        $ogrVeliIDler = implode(',', $turVeliID);
                                        $resultOgrVeliCihaz = $Panel_Model->ogrenciVeliTurCihaz($ogrVeliIDler);
                                        if (count($resultOgrVeliCihaz) > 0) {
                                            foreach ($resultOgrVeliCihaz as $resultOgrVeliCihazz) {
                                                $ogrVeliCihaz[] = $resultOgrVeliCihazz['bsvelicihazRecID'];
                                            }
                                            $ogrVeliCihazlar = implode(',', $ogrVeliCihaz);
                                            $form->shuttleNotification($ogrVeliCihazlar, $language["ServisBitisDonus"], $language["ServisBitisTitle"]);
                                        }
                                    }
                                }
                                //işçi için
                                if (count($isciGeID) > 0) {
                                    $resultIsciCihaz = $Panel_Model->isciTurCihazlar($isciIDler);
                                    if (count($resultIsciCihaz) > 0) {
                                        foreach ($resultIsciCihaz as $resultIsciCihazz) {
                                            $isciCihaz[] = $resultIsciCihazz['sbiscicihazRecID'];
                                        }
                                        $isciCihazlar = implode(',', $isciCihaz);
                                        $form->shuttleNotification($isciCihazlar, $language["ServisBitisDonus"], $language["ServisBitisTitle"]);
                                    }
                                }
                            }
                            //dönüş turundaki binenleri silme
                            $deleteresult = $Panel_Model->turDonusDelete($turID);
                        }
                        if ($deleteresult) {
                            //dönüş turundaki binenleri silme
                            $deleteAnlikLoc = $Panel_Model->aracAnlikLocDel($turID);
                            if ($deleteAnlikLoc) {
                                //tur bitiş bilgisi
                                $dataTurUptade = array(
                                    'SBTurAktiflik' => 0,
                                    'SBTurBitSaat' => $time,
                                );

                                $turupdate = $Panel_Model->soforTurBaslatUpdate($dataTurUptade, $turID);
                                if ($turupdate) {
                                    $dataTurTipUptade = array(
                                        'BsTurBitis' => 1,
                                    );
                                    $turtipupdate = $Panel_Model->soforTurTipUpdate($dataTurTipUptade, $turID);
                                    if ($turtipupdate) {
                                        if ($form->submit()) {
                                            $dataInsert = array(
                                                'BSTurID' => $turID,
                                                'BSTurAd' => $turAdi,
                                                'BSSoforID' => $turTip[0]['SoforID'],
                                                'BSHostesID' => $turTip[0]['HostesID'],
                                                'BSTurKm' => $turTip[0]['TurKm'],
                                                'BSTurSaat' => $saatFarki,
                                                'BSTurBslngcSaat' => $baslangicSaat,
                                                'BSTurBtsSaat' => $time,
                                                'BSTurGun' => $turGun,
                                                'BSTurTip' => $turTip[0]['TurTip'],
                                                'BSTurTarih' => $turTarih,
                                                'BSTurKisiSayi' => $kullaniciGelenLength,
                                                'BSTurSonKonum' => $anlikKonum,
                                                'BSKurumID' => $turTip[0]['KurumID'],
                                                'BSKurumAd' => $turTip[0]['KurumAd'],
                                                'BSKurumLokasyon' => $turTip[0]['KurumLoc'],
                                                'BSAracID' => $turTip[0]['AracID'],
                                                'BSAracPlaka' => $turTip[0]['AracPlaka'],
                                                'BSTurGidisDonus' => $gdsDonus
                                            );
                                        }
                                        $rsltTurBtsID = $Panel_Model->addNewTurBitis($dataInsert);
                                        if ($rsltTurBtsID) {//işlem tamamlanmıştır demektir
                                            $sonuc["result"] = "1";
                                        }
                                    }
                                }
                            }
                        }
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

