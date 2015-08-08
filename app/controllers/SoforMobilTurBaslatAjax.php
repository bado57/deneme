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
                    $form->post("turTip", true);
                    $form->post("turGun", true);
                    $form->post("enlem", true);
                    $form->post("boylam", true);
                    $form->post("turGidisDonus", true);
                    $turID = $form->values['turID'];
                    $enlem = $form->values['enlem'];
                    $boylam = $form->values['boylam'];
                    $turTip = $form->values['turTip'];
                    $yeniGun = $form->values['turGun'];
                    $turGidisDonus = $form->values['turGidisDonus'];

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
                        }
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
                        }
                    } else {//öğrenci-işçi
                        $resultOgrenciIsciID = $Panel_Model->soforTurBaslatOgrenciIsciID($turID);
                        $ogrenciGID = [];
                        $isciGID = [];
                        $kurumIslem = [];
                        foreach ($resultOgrenciIsciID as $resultOgrenciIsciIDD) {
                            if ($resultOgrenciIsciIDD['BSKullaniciTip'] != 1) {//öğrenci
                                $ogrenciGID[] = $resultOgrenciIsciIDD['BSOgrenciIsciID'];
                            } else {
                                $isciGID[] = $resultOgrenciIsciIDD['BSOgrenciIsciID'];
                            }
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
                                $oi = 0;
                                foreach ($resultOgrenciIID as $resultOgrenciIID) {
                                    $turGelen[$oi]['ID'] = $resultOgrenciIID['BSOgrenciID'];
                                    $turGelen[$oi]['Ad'] = $resultOgrenciIID['BSOgrenciAd'];
                                    $turGelen[$oi]['Soyad'] = $resultOgrenciIID['BSOgrenciSoyad'];
                                    if ($resultOgrenciIID['BSOgrenciPhone'] != "") {
                                        $turGelen[$oi]['KPhone'] = $resultOgrenciIID['BSOgrenciPhone'];
                                    } else {
                                        $turGelen[$oi]['KPhone'] = "0";
                                    }
                                    $turGelen[$oi]['Location'] = $resultOgrenciIID['BSOgrenciLocation'];
                                    $turGelen[$oi]['Tip'] = 0;
                                    $oi++;
                                }
                            }
                        }
                        if (count($isciSonID) > 0) {
                            $resultIsciIID = $Panel_Model->soforTBMapsIsciIID($iscID);
                            if (count($resultIsciIID) > 0) {
                                foreach ($resultIsciIID as $resultIsciIIDD) {
                                    $turGelen[$oi]['ID'] = $resultIsciIIDD['SBIsciID'];
                                    $turGelen[$oi]['Ad'] = $resultIsciIIDD['SBIsciAd'];
                                    $turGelen[$oi]['Soyad'] = $resultIsciIIDD['SBIsciSoyad'];
                                    if ($resultOgrenciIID['BSOgrenciPhone'] != "") {
                                        $turGelen[$oi]['KPhone'] = $resultOgrenciIID['BSOgrenciPhone'];
                                    } else {
                                        $turGelen[$oi]['KPhone'] = "0";
                                    }
                                    $turGelen[$oi]['Location'] = $resultIsciIIDD['SBIsciLocation'];
                                    $turGelen[$oi]['Tip'] = 1;
                                    $oi++;
                                }
                            }
                        }
                        //kurum bilgileri
                        $turGelen[$oi]['ID'] = $kurumIslem[0]['KurumID'];
                        $turGelen[$oi]['Ad'] = $kurumIslem[0]['KurumAd'];
                        $turGelen[$oi]['Soyad'] = "";
                        $turGelen[$oi]['KPhone'] = "0";
                        $turGelen[$oi]['Tip'] = 2;
                        $turGelen[$oi]['Location'] = $kurumIslem[0]['KurumLoc'];
                    }
                    $sonuc = $turGelen;
                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

