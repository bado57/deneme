<?php

class OgrenciMobilDetayAjax extends Controller {

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

            //db ye  bağlanma
            $form->post("firma_id", true);
            $firmId = $form->values['firma_id'];

            $form->post("lang", true);
            $lang = $form->values['lang'];

            $formLanguage = $this->load->mobillanguage($lang);
            $languagedeger = $formLanguage->ajaxlanguage();

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $usersselect_model = $this->load->model("AdminSelectDb_Mobil");

            //return database results
            $UserSelectDb = $usersselect_model->adminFirmMobilID($firmId);
            if (count($UserSelectDb) > 0) {
                $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];

                $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);

                //model bağlantısı
                $Panel_Model = $this->load->model("Panel_Model_Mobile");

                Switch ($tip) {
                    case "veliListe":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {

                            $resultOgrVeli = $Panel_Model->ogrenciVeli($ogrID);
                            if (count($resultOgrVeli) > 0) {
                                $k = 0;
                                foreach ($resultOgrVeli as $resultOgrVelii) {
                                    $veli[0][$k]['ID'] = $resultOgrVelii['BSVeliID'];
                                    $veli[0][$k]['Ad'] = $resultOgrVelii['BSVeliAd'];
                                    $k++;
                                }
                            } else {
                                $veli[1][0]['Yok'] = $languagedeger['VeliYok'];
                            }
                            $sonuc["result"] = $veli;
                        }
                        break;
                    case "veliDetay":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];

                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('id', true);
                            $id = $form->values['id'];

                            $resultVeli = $Panel_Model->ogrVeliDetay($id);
                            if (count($resultVeli) > 0) {
                                foreach ($resultVeli as $resultVelii) {
                                    $veli[0][0]['ID'] = $resultVelii['SBVeliID'];
                                    $veli[0][0]['Ad'] = $resultVelii['SBVeliAd'] . " " . $resultVelii['SBVeliSoyad'];
                                    $veli[0][0]['Phone'] = $resultVelii['SBVeliPhone'];
                                    $veli[0][0]['Email'] = $resultVelii['SBVeliEmail'];
                                    $veli[0][0]['Loc'] = $resultVelii['SBVeliLocation'];
                                    $veli[0][0]['Adres'] = $resultVelii['SBVeliDetayAdres'];
                                    if ($resultVelii['Status'] != 0) {
                                        $veli[0][0]['Status'] = $languagedeger['Aktif'];
                                        $veli[0][0]['Stts'] = 1;
                                    } else {
                                        $veli[0][0]['Status'] = $languagedeger['Pasif'];
                                        $veli[0][0]['Stts'] = 1;
                                    }
                                }
                                $sonuc["result"] = $veli;
                            } else {
                                $sonuc["Hata"] = $languagedeger['Hata'];
                            }
                        }

                        break;
                    case "kurumListe":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {

                            $resultOgrenciKurum = $Panel_Model->veliOgrenciKurum($ogrID);
                            if (count($resultOgrenciKurum) > 0) {
                                $k = 0;
                                foreach ($resultOgrenciKurum as $resultOgrenciKurumm) {
                                    $kurum[0][$k]['ID'] = $resultOgrenciKurumm['BSKurumID'];
                                    $kurum[0][$k]['Ad'] = $resultOgrenciKurumm['BSKurumAd'];
                                    $k++;
                                }
                            } else {
                                $kurum[1][0]['Yok'] = $languagedeger['KurumYok'];
                            }
                            $sonuc["result"] = $kurum;
                        }
                        break;
                    case "kurumDetay":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];

                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('id', true);
                            $id = $form->values['id'];

                            $resultKurum = $Panel_Model->ogrKurumDetay($id);
                            if (count($resultKurum) > 0) {
                                foreach ($resultKurum as $resultKurumm) {
                                    $kurum[0]['Ad'] = $resultKurumm['SBKurumAdi'];
                                    $kurum[0]['Phone'] = $resultKurumm['SBKurumTelefon'];
                                    $kurum[0]['Email'] = $resultKurumm['SBKurumEmail'];
                                    $kurum[0]['WebSite'] = $resultKurumm['SBKurumWebsite'];
                                    $kurum[0]['Loc'] = $resultKurumm['SBKurumLokasyon'];
                                    $kurum[0]['Adres'] = $resultKurumm['SBKurumDetayAdres'];
                                }

                                $sonuc["result"] = $kurum;
                            } else {
                                $sonuc["Hata"] = $languagedeger['Hata'];
                            }
                        }

                        break;
                    case "turListe":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];

                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            //öğrenci tur tablosu için
                            $ogrTurDetail = $Panel_Model->ogrenciTurDetail($ogrID);
                            $ogrturId = array();
                            foreach ($ogrTurDetail as $ogrTurDetaill) {
                                $ogrturId[] = $ogrTurDetaill['BSTurID'];
                            }
                            //öğrenciişçi tur tablosu için
                            $ogrTurDetailler = $Panel_Model->ogrenciTurDetail2($ogrID);
                            $ogrisciturId = array();
                            foreach ($ogrTurDetailler as $ogrTurDetaillerr) {
                                $ogrisciturId[] = $ogrTurDetaillerr['BSTurID'];
                            }
                            $yeni_dizi = array_merge($ogrturId, $ogrisciturId);
                            $turId = implode(',', $yeni_dizi);

                            $ogrTur = $Panel_Model->veliOgrenciTurList($turId);
                            $ogrenciDetailTur = [];
                            if (count($ogrTur) > 0) {
                                $b = 0;
                                foreach ($ogrTur as $ogrTurr) {
                                    $ogrenciDetailTur[0][$b]['ID'] = $ogrTurr['SBTurID'];
                                    $ogrenciDetailTur[0][$b]['Ad'] = $ogrTurr['SBTurAd'];
                                    $ogrenciDetailTur[0][$b]['Kurum'] = $ogrTurr['SBKurumAd'];
                                    $b++;
                                }
                            } else {
                                $ogrenciDetailTur[1][0]["Yok"] = $languagedeger['TurYok'];
                            }
                            $sonuc["result"] = $ogrenciDetailTur;
                        }
                        break;
                    case "turDetayListe":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('id', true);
                            $id = $form->values['id'];

                            $turOzellik = $Panel_Model->ogrenciTurDetayList($id);
                            if (count($turOzellik) > 0) {
                                foreach ($turOzellik as $turOzellikk) {
                                    $turList['ID'] = $turOzellikk['SBTurID'];
                                    $turList['Ad'] = $turOzellikk['SBTurAd'];
                                    $turList['Aciklama'] = $turOzellikk['SBTurAciklama'];
                                    $turList['Aktiflik'] = $turOzellikk['SBTurAktiflik'];
                                    $turList['KurumID'] = $turOzellikk['SBKurumID'];
                                    $turList['Kurum'] = $turOzellikk['SBKurumAd'];
                                    $turList['KurumLoc'] = $turOzellikk['SBKurumLocation'];
                                    $turList['Pzt'] = $turOzellikk['SBTurPzt'];
                                    $turList['Sli'] = $turOzellikk['SBTurSli'];
                                    $turList['Crs'] = $turOzellikk['SBTurCrs'];
                                    $turList['Prs'] = $turOzellikk['SBTurPrs'];
                                    $turList['Cma'] = $turOzellikk['SBTurCma'];
                                    $turList['Cmt'] = $turOzellikk['SBTurCmt'];
                                    $turList['Pzr'] = $turOzellikk['SBTurPzr'];
                                    $turList['Gidis'] = $turOzellikk['SBTurGidis'];
                                    $turList['Donus'] = $turOzellikk['SBTurDonus'];
                                    $turList['Tip'] = $turOzellikk['SBTurTip'];
                                    $turList['Km'] = $turOzellikk['SBTurKm'];
                                }
                                if ($turList['Gidis'] == 1) {
                                    $turList['Gidis'] = $languagedeger['GidisTur'];
                                } else {
                                    $turList['Gidis'] = "";
                                }
                                if ($turList['Donus'] == 1) {
                                    $turList['Donus'] = $languagedeger['DonusTur'];
                                } else {
                                    $turList['Donus'] = "";
                                }
                            }
                            $sonuc["Detay"] = $turList;
                        }
                        break;
                    case "turDetayMap":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('turtip', true);
                            $form->post('turid', true);
                            $turTip = $form->values['turtip'];
                            $turID = $form->values['turid'];

                            if ($turTip == 0) {
                                $turYolcu = $Panel_Model->veliHTurOgrenci($turID);
                                $a = 0;
                                foreach ($turYolcu as $turYolcuu) {
                                    $turList['ID'][$a] = $turYolcuu['BSOgrenciID'];
                                    $turList['Ad'][$a] = $turYolcuu['BSOgrenciAd'];
                                    $turList['Loc'][$a] = $turYolcuu['BSOgrenciLocation'];
                                    $turList['Tip'][$a] = 0;
                                    $a++;
                                }
                            } else if ($turTip == 1) {
                                $turYolcu = $Panel_Model->veliHTurIsci($turID);
                                $a = 0;
                                foreach ($turYolcu as $turYolcuu) {
                                    $turList['ID'][$a] = $turYolcuu['SBIsciID'];
                                    $turList['Ad'][$a] = $turYolcuu['SBIsciAd'];
                                    $turList['Loc'][$a] = $turYolcuu['SBIsciLocation'];
                                    $turList['Tip'][$a] = 1;
                                    $a++;
                                }
                            } else {
                                $turYolcu = $Panel_Model->veliHTurIsciOgrenci($turID);
                                $a = 0;
                                foreach ($turYolcu as $turYolcuu) {
                                    $turList['ID'][$a] = $turYolcuu['BSOgrenciIsciID'];
                                    $turList['Ad'][$a] = $turYolcuu['BSOgrenciIsciAd'];
                                    $turList['Loc'][$a] = $turYolcuu['BSOgrenciIsciLocation'];
                                    if ($turYolcuu['BSKullaniciTip'] != 1) {
                                        $turList['Tip'][$a] = 0;
                                    } else {
                                        $turList['Tip'][$a] = 1;
                                    }
                                    $a++;
                                }
                            }
                            $sonuc["Tur"] = $turList;
                        }

                        break;
                    case "turGDListe":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('turtip', true);
                            $form->post('turid', true);
                            $form->post('turgd', true);
                            $turtip = $form->values['turtip'];
                            $turid = $form->values['turid'];
                            $turgd = $form->values['turgd'];

                            $turTipOzellik = $Panel_Model->ogrTurTipDetayList($turid, $turgd);
                            if (count($turTipOzellik) > 0) {
                                foreach ($turTipOzellik as $turTipOzellikk) {
                                    $turList['GDID'] = $turTipOzellikk['BSTurTipID'];
                                    $turList['AracID'] = $turTipOzellikk['BSTurAracID'];
                                    $turList['AracPlaka'] = $turTipOzellikk['BSTurAracPlaka'];
                                    $turList['SoforID'] = $turTipOzellikk['BSTurSoforID'];
                                    $turList['SoforAd'] = $turTipOzellikk['BSTurSoforAd'];
                                    $turList['HostesID'] = $turTipOzellikk['BSTurHostesID'];
                                    $turList['HostesAd'] = $turTipOzellikk['BSTurHostesAd'];
                                    $turList['Bslngc'] = $turTipOzellikk['BSTurBslngc'];
                                    $turList['Bts'] = $turTipOzellikk['BSTurBts'];
                                }
                            }
                            $sonuc["Detay"] = $turList;
                        }
                        break;
                    case "aracDetay":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('aracid', true);
                            $aracID = $form->values['aracid'];

                            $aracOzellik = $Panel_Model->veliArac($aracID);
                            foreach ($aracOzellik as $aracOzellikk) {
                                $aracList['Marka'] = $aracOzellikk['SBAracMarka'];
                                $aracList['Yil'] = $aracOzellikk['SBAracModelYili'];
                                $aracList['Plaka'] = $aracOzellikk['SBAracPlaka'];
                                $aracList['Kapasite'] = $aracOzellikk['SBAracKapasite'];
                                $aracList['Km'] = $aracOzellikk['SBAracKm'];
                                $aracList['Aciklama'] = $aracOzellikk['SBAracAciklama'];
                            }

                            $sonuc["Detay"] = $aracList;
                        }

                        break;
                    case "soforDetay":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('kisiid', true);
                            $kisiID = $form->values['kisiid'];

                            $yolcuOzellik = $Panel_Model->veliSYolcu($kisiID);
                            foreach ($yolcuOzellik as $yolcuOzellikk) {
                                $kisiList['Ad'] = $yolcuOzellikk['BSSoforAd'];
                                $kisiList['Soyad'] = $yolcuOzellikk['BSSoforSoyad'];
                                $kisiList['Tel'] = $yolcuOzellikk['BSSoforPhone'];
                                $kisiList['Mail'] = $yolcuOzellikk['BSSoforEmail'];
                                $kisiList['Lokasyon'] = $yolcuOzellikk['BSSoforLocation'];
                                $kisiList['Adres'] = $yolcuOzellikk['BSSoforDetayAdres'];
                            }

                            $sonuc["Detay"] = $kisiList;
                        }

                        break;
                    case "hostesDetay":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('kisiid', true);
                            $kisiID = $form->values['kisiid'];

                            $yolcuOzellik = $Panel_Model->veliHYolcu($kisiID);
                            foreach ($yolcuOzellik as $yolcuOzellikk) {
                                $kisiList['Ad'] = $yolcuOzellikk['BSHostesAd'];
                                $kisiList['Soyad'] = $yolcuOzellikk['BSHostesSoyad'];
                                $kisiList['Tel'] = $yolcuOzellikk['BSHostesPhone'];
                                $kisiList['Mail'] = $yolcuOzellikk['BSHostesEmail'];
                                $kisiList['Lokasyon'] = $yolcuOzellikk['BSHostesLocation'];
                                $kisiList['Adres'] = $yolcuOzellikk['BSHostesDetayAdres'];
                            }

                            $sonuc["Detay"] = $kisiList;
                        }

                        break;
                    case "bilmesafayar":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('giddon', true);
                            $giddon = $form->values['giddon'];
                            if ($giddon != 1) {//gidiş
                                $ayar = $Panel_Model->ogrGidisAyar($ogrID);
                                foreach ($ayar as $ayarr) {
                                    $ayarDeger['Deger'] = $ayarr['BildirimMesafeGidis'];
                                }
                            } else {//dönüş
                                $ayar = $Panel_Model->ogrDonusAyar($ogrID);
                                foreach ($ayar as $ayarr) {
                                    $ayarDeger['Deger'] = $ayarr['BildirimMesafeDonus'];
                                }
                            }
                            $sonuc["Detay"] = $ayarDeger;
                        }
                        break;
                    case "bilmesafayarkaydet":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('giddon', true);
                            $form->post('bilval', true);
                            $form->post('bildayarDeger', true);
                            $giddon = $form->values['giddon'];
                            $bilval = $form->values['bilval'];
                            $bildayarDeger = $form->values['bildayarDeger'];
                            if ($bilval != $bildayarDeger) {
                                if ($giddon != 1) {//gidiş
                                    if ($form->submit()) {
                                        $data = array(
                                            'BildirimMesafeGidis' => $bilval
                                        );
                                    }
                                } else {//dönüş
                                    if ($form->submit()) {
                                        $data = array(
                                            'BildirimMesafeDonus' => $bilval
                                        );
                                    }
                                }
                                $resultupdate = $Panel_Model->ogrBilMes($data, $ogrID);
                                if ($resultupdate) {
                                    $sonuc["update"] = $languagedeger['MesafeAyarUpdate'];
                                } else {
                                    $sonuc["hata"] = $languagedeger['Hata'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['DegisiklikYok'];
                            }
                        }

                        break;
                    case "haftlktkvim":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('giddon', true);
                            $form->post('turid', true);
                            $form->post('enlem', true);
                            $form->post('boylam', true);
                            $form->post('turtip', true);
                            $giddon = $form->values['giddon'];
                            $turid = $form->values['turid'];
                            $enlem = $form->values['enlem'];
                            $boylam = $form->values['boylam'];
                            $turtip = $form->values['turtip'];
                            $url = "https://maps.googleapis.com/maps/api/timezone/json?location=" . $enlem . "," . $boylam . "&timestamp=1419283200&sensor=false";
                            $url = str_replace(' ', '', $url);
                            $json_timezone = file_get_contents($url);
                            $obj = json_decode($json_timezone, true);
                            date_default_timezone_set($obj["timeZoneId"]);
                            $date = date('m/d/Y', time());
                            $time = date('H:i', time());
                            $gun = date('D', strtotime($date));

                            $ts = strtotime($date);
                            $start = (date('w', $ts) == 0) ? $ts : strtotime('last Monday', $ts);
                            $start_date = date('d-m-Y', $start);
                            $end_date = date('d-m-Y', strtotime('next sunday', $start));

                            /*
                             * Bu tabloda ters bir ilişki vardır eğer kullancı pazartesi gelmek istemiyorsa
                             * tabloda pazartesi 1 olur yai gelmyecek anlamında.Eğer salı gelecekse de 
                             * 0 Olur.Yani bura ile benim alakam yok der gibi.
                             */
                            if ($turtip == 0) {//Öğrenci
                                $tkvim = $Panel_Model->ogrSefrTkvim($turid, $ogrID, $giddon);
                                if (count($tkvim) > 0) {
                                    foreach ($tkvim as $tkvim) {
                                        $resultTkvim['Pzt'] = $tkvim['SBTurPzt'];
                                        $resultTkvim['Sli'] = $tkvim['SBTurSli'];
                                        $resultTkvim['Crs'] = $tkvim['SBTurCrs'];
                                        $resultTkvim['Prs'] = $tkvim['SBTurPrs'];
                                        $resultTkvim['Cma'] = $tkvim['SBTurCma'];
                                        $resultTkvim['Cmt'] = $tkvim['SBTurCmt'];
                                        $resultTkvim['Pzr'] = $tkvim['SBTurPzr'];
                                    }
                                } else {
                                    $resultTkvim['Pzt'] = 0;
                                    $resultTkvim['Sli'] = 0;
                                    $resultTkvim['Crs'] = 0;
                                    $resultTkvim['Prs'] = 0;
                                    $resultTkvim['Cma'] = 0;
                                    $resultTkvim['Cmt'] = 0;
                                    $resultTkvim['Pzr'] = 0;
                                }
                            } else if ($turtip == 2) {//öğrenci-işçi
                                $tkvim = $Panel_Model->ogrIsciSefrTkvim($turid, $ogrID, $giddon);
                                if (count($tkvim) > 0) {
                                    foreach ($tkvim as $tkvim) {
                                        $resultTkvim['Pzt'] = $tkvim['SBTurPzt'];
                                        $resultTkvim['Sli'] = $tkvim['SBTurSli'];
                                        $resultTkvim['Crs'] = $tkvim['SBTurCrs'];
                                        $resultTkvim['Prs'] = $tkvim['SBTurPrs'];
                                        $resultTkvim['Cma'] = $tkvim['SBTurCma'];
                                        $resultTkvim['Cmt'] = $tkvim['SBTurCmt'];
                                        $resultTkvim['Pzr'] = $tkvim['SBTurPzr'];
                                    }
                                } else {
                                    $resultTkvim['Pzt'] = 0;
                                    $resultTkvim['Sli'] = 0;
                                    $resultTkvim['Crs'] = 0;
                                    $resultTkvim['Prs'] = 0;
                                    $resultTkvim['Cma'] = 0;
                                    $resultTkvim['Cmt'] = 0;
                                    $resultTkvim['Pzr'] = 0;
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                            $resultTkvim['IlkGun'] = $start_date;
                            $resultTkvim['SonGun'] = $end_date;
                            $sonuc["result"] = $resultTkvim;
                        }
                        break;
                    case "hftlikTkvimKaydet":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('giddon', true);
                            $form->post('turid', true);
                            $form->post('turtip', true);
                            $form->post('Pzt', true);
                            $form->post('Sli', true);
                            $form->post('Crs', true);
                            $form->post('Prs', true);
                            $form->post('Cma', true);
                            $form->post('Cmt', true);
                            $form->post('Pzr', true);
                            $turtip = $form->values['turtip'];
                            $giddon = $form->values['giddon'];
                            $turid = $form->values['turid'];
                            $Pzt = $form->values['Pzt'];
                            $Sli = $form->values['Sli'];
                            $Crs = $form->values['Crs'];
                            $Prs = $form->values['Prs'];
                            $Cma = $form->values['Cma'];
                            $Cmt = $form->values['Cmt'];
                            $Pzr = $form->values['Pzr'];
                            /*
                             * Bu tabloda ters bir ilişki vardır eğer kullancı pazartesi gelmek istemiyorsa
                             * tabloda pazartesi 1 olur yai gelmyecek anlamında.Eğer salı gelecekse de 
                             * 0 Olur.Yani bura ile benim alakam yok der gibi.
                             */
                            if ($turtip == 0) {//Öğrenci
                                $tkvim = $Panel_Model->ogrSefrTkvimID($turid, $ogrID, $giddon);
                                if (count($tkvim) > 0) {//update
                                    if ($form->submit()) {
                                        $dataUpdate = array(
                                            'SBTurPzt' => $Pzt,
                                            'SBTurSli' => $Sli,
                                            'SBTurCrs' => $Crs,
                                            'SBTurPrs' => $Prs,
                                            'SBTurCma' => $Cma,
                                            'SBTurCmt' => $Cmt,
                                            'SBTurPzr' => $Pzr
                                        );
                                    }
                                    $resultupdate = $Panel_Model->ogrTkvimUpdate($dataUpdate, $tkvim[0]["BSOgrenciSeferID"]);
                                    if ($resultupdate) {
                                        $sonuc["result"] = $languagedeger['HaftlikTkvim'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                } else {//insert
                                    if ($form->submit()) {
                                        $dataInsert = array(
                                            'BSTurID' => $turid,
                                            'BSOgrenciID' => $ogrID,
                                            'SBTurPzt' => $Pzt,
                                            'SBTurSli' => $Sli,
                                            'SBTurCrs' => $Crs,
                                            'SBTurPrs' => $Prs,
                                            'SBTurCma' => $Cma,
                                            'SBTurCmt' => $Cmt,
                                            'SBTurPzr' => $Pzr,
                                            'BSTurTip' => $giddon
                                        );
                                    }
                                    $resultinsert = $Panel_Model->ogrTkvimInsert($dataInsert);
                                    if ($resultinsert) {
                                        $sonuc["result"] = $languagedeger['HaftlikTkvim'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                }
                            } else if ($turtip == 2) {//öğrenci-işçi
                                $tkvim = $Panel_Model->ogrIsciSefrTkvimID($turid, $ogrID, $giddon);
                                if (count($tkvim) > 0) {//update
                                    if ($form->submit()) {
                                        $dataUpdate = array(
                                            'SBTurPzt' => $Pzt,
                                            'SBTurSli' => $Sli,
                                            'SBTurCrs' => $Crs,
                                            'SBTurPrs' => $Prs,
                                            'SBTurCma' => $Cma,
                                            'SBTurCmt' => $Cmt,
                                            'SBTurPzr' => $Pzr
                                        );
                                    }
                                    $resultupdate = $Panel_Model->ogrIscTkvimUpdate($dataUpdate, $tkvim[0]["BSSeferOgrenciIsciID"]);
                                    if ($resultupdate) {
                                        $sonuc["result"] = $languagedeger['HaftlikTkvim'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                } else {//insert
                                    if ($form->submit()) {
                                        $dataInsert = array(
                                            'BSTurID' => $turid,
                                            'BSKisiID' => $ogrID,
                                            'BSKullaniciTip' => 0,
                                            'SBTurPzt' => $Pzt,
                                            'SBTurSli' => $Sli,
                                            'SBTurCrs' => $Crs,
                                            'SBTurPrs' => $Prs,
                                            'SBTurCma' => $Cma,
                                            'SBTurCmt' => $Cmt,
                                            'SBTurPzr' => $Pzr,
                                            'BSTurTip' => $giddon
                                        );
                                    }
                                    $resultinsert = $Panel_Model->ogrIscTkvimInsert($dataInsert);
                                    if ($resultinsert) {
                                        $sonuc["result"] = $languagedeger['HaftlikTkvim'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        }
                        break;
                    case "turbildirim":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('giddon', true);
                            $giddon = $form->values['giddon'];
                            if ($giddon != 1) {//gidiş
                                $hftlikbild = $Panel_Model->ogrHaftlikBildirimGid($ogrID);
                                if (count($hftlikbild) > 0) {
                                    foreach ($hftlikbild as $hftlikbildd) {
                                        $resultBild['Basla'] = $hftlikbildd['GidisTurBasladi'];
                                        $resultBild['Yaklas'] = $hftlikbildd['GidisAracYaklasti'];
                                        $resultBild['BinInBin'] = $hftlikbildd['GidisAracBindi'];
                                        $resultBild['Bitti'] = $hftlikbildd['GidisKurumVardi'];
                                    }
                                } else {
                                    $resultBild['Basla'] = 0;
                                    $resultBild['Yaklas'] = 0;
                                    $resultBild['BinInBin'] = 0;
                                    $resultBild['Bitti'] = 0;
                                }
                            } else {//dönüş
                                $hftlikbild = $Panel_Model->ogrHaftlikBildirimDon($ogrID);
                                if (count($hftlikbild) > 0) {
                                    foreach ($hftlikbild as $hftlikbildd) {
                                        $resultBild['Basla'] = $hftlikbildd['DonusTurBasladi'];
                                        $resultBild['Yaklas'] = $hftlikbildd['DonusAracYaklasti'];
                                        $resultBild['BinInBin'] = $hftlikbildd['DonusAracIndi'];
                                        $resultBild['Bitti'] = $hftlikbildd['DonusTurBitti'];
                                    }
                                } else {
                                    $resultBild['Basla'] = 0;
                                    $resultBild['Yaklas'] = 0;
                                    $resultBild['BinInBin'] = 0;
                                    $resultBild['Bitti'] = 0;
                                }
                            }
                            $sonuc["result"] = $resultBild;
                        }
                        break;
                    case "bldrimKaydet":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('giddon', true);
                            $form->post('android_id', true);
                            $form->post('Basla', true);
                            $form->post('Yaklas', true);
                            $form->post('InBin', true);
                            $form->post('Bts', true);
                            $giddon = $form->values['giddon'];
                            $android_id = $form->values['android_id'];
                            $Basla = $form->values['Basla'];
                            $Yaklas = $form->values['Yaklas'];
                            $InBin = $form->values['InBin'];
                            $Bts = $form->values['Bts'];

                            $cihazSorgu = $Panel_Model->ogrCihazSorgu($ogrID);
                            if (count($cihazSorgu) > 0) {
                                if ($giddon != 1) {//Gidiş
                                    if ($form->submit()) {
                                        $dataUpdate = array(
                                            'GidisTurBasladi' => $Basla,
                                            'GidisAracYaklasti' => $Yaklas,
                                            'GidisAracBindi' => $InBin,
                                            'GidisKurumVardi' => $Bts
                                        );
                                    }
                                    $resultupdate = $Panel_Model->ogrCihazUpdate($dataUpdate, $ogrID);
                                    if ($resultupdate) {
                                        $sonuc["result"] = $languagedeger['BildKaydet'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                } else {//Dönüş
                                    if ($form->submit()) {
                                        $dataUpdate = array(
                                            'DonusTurBasladi' => $Basla,
                                            'DonusAracYaklasti' => $Yaklas,
                                            'DonusAracIndi' => $InBin,
                                            'DonusTurBitti' => $Bts
                                        );
                                    }
                                    $resultupdate = $Panel_Model->ogrCihazUpdate($dataUpdate, $ogrID);
                                    if ($resultupdate) {
                                        $sonuc["result"] = $languagedeger['BildKaydet'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                }
                            } else {
                                if ($giddon != 1) {//Gidiş
                                    if ($form->submit()) {
                                        $dataInsert = array(
                                            'bsogrencicihazID' => $android_id,
                                            'bsogrenciID' => $ogrID,
                                            'GidisTurBasladi' => $Basla,
                                            'GidisAracYaklasti' => $Yaklas,
                                            'GidisAracBindi' => $InBin,
                                            'GidisKurumVardi' => $Bts
                                        );
                                    }
                                    $resultinsert = $Panel_Model->ogrCihazInsert($dataInsert);
                                    if ($resultinsert) {
                                        $sonuc["result"] = $languagedeger['BildKaydet'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                } else {//Dönüş
                                    if ($form->submit()) {
                                        $dataInsert = array(
                                            'bsogrencicihazID' => $android_id,
                                            'bsogrenciID' => $ogrID,
                                            'DonusTurBasladi' => $Basla,
                                            'DonusAracYaklasti' => $Yaklas,
                                            'DonusAracIndi' => $InBin,
                                            'DonusTurBitti' => $Bts
                                        );
                                    }
                                    $resultinsert = $Panel_Model->ogrCihazInsert($dataInsert);
                                    if ($resultinsert) {
                                        $sonuc["result"] = $languagedeger['BildKaydet'];
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                }
                            }
                        }
                        break;
                    case "aracLocTurListe":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            //öğrenci tur tablosu için
                            $ogrTurDetail = $Panel_Model->veliOgrenciTurDetail($ogrID);
                            $ogrturId = array();
                            foreach ($ogrTurDetail as $ogrTurDetaill) {
                                $ogrturId[] = $ogrTurDetaill['BSTurID'];
                            }
                            //öğrenciişçi tur tablosu için
                            $ogrTurDetailler = $Panel_Model->veliOgrenciTurDetail2($ogrID);
                            $ogrisciturId = array();
                            foreach ($ogrTurDetailler as $ogrTurDetaillerr) {
                                $ogrisciturId[] = $ogrTurDetaillerr['BSTurID'];
                            }
                            $yeni_dizi = array_merge($ogrturId, $ogrisciturId);
                            $turId = implode(',', $yeni_dizi);

                            //aktif tur araçları
                            $turListesi = [];
                            $aktifTurListe = $Panel_Model->veliAktifTurListele($turId);
                            if (count($aktifTurListe) > 0) {
                                //tur adlar
                                $turAdListe = $Panel_Model->veliTurAdListe($turId);
                                if (count($turAdListe) > 0) {
                                    foreach ($turAdListe as $turAdListee) {
                                        $turListesi[0]['TurAd'] = $turAdListee['SBTurAd'];
                                    }
                                }

                                foreach ($aktifTurListe as $aktifTurListee) {
                                    $turListesi[0]['AracID'] = $aktifTurListee['BSTurAracID'];
                                    $turListesi[0]['AracPlaka'] = $aktifTurListee['BSTurAracPlaka'];
                                    $turListesi[0]['TurID'] = $aktifTurListee['BSTurID'];
                                    $turListesi[0]['TurTip'] = $aktifTurListee['BSTurTip'];
                                    $turListesi[0]['KurumID'] = $aktifTurListee['BSTurKurumID'];
                                    $turListesi[0]['KurumAd'] = $aktifTurListee['BSTurKurumAd'];
                                    $turListesi[0]['KurumLoc'] = $aktifTurListee['BSTurKurumLocation'];
                                    $turListesi[0]['SoforID'] = $aktifTurListee['BSTurSoforID'];
                                    $turListesi[0]['SoforAd'] = $aktifTurListee['BSTurSoforAd'];
                                    $turListesi[0]['SoforLoc'] = $aktifTurListee['BSTurSoforLocation'];
                                    $turListesi[0]['Kapasite'] = $aktifTurListee['BSTurAracKapasite'];
                                    $turListesi[0]['TurKm'] = $aktifTurListee['BSTurKm'];
                                    $turListesi[0]['GidDon'] = $aktifTurListee['BSTurGidisDonus'];
                                }
                            } else {
                                $turListesi[1] = $languagedeger['AktifTurYok'];
                            }
                            $sonuc["result"] = $turListesi;
                        }
                        break;
                    case "aracLokasyonDetail":
                        $form->post('ogr_id', true);
                        $ogrID = $form->values['ogr_id'];
                        if (!$ogrID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('aracID', true);
                            $form->post('turID', true);
                            $form->post('turTipID', true);
                            $form->post('turGidisDonus', true);
                            $aracID = $form->values['aracID'];
                            $turID = $form->values['turID'];
                            $turTip = $form->values['turTipID'];
                            $turGidisDonus = $form->values['turGidisDonus'];

                            $yeniGun = $form->gunCevirme(date("D"));

                            //araç anlık lokasyon
                            $aracLokasyon = $Panel_Model->veliAracLokasyon($aracID);
                            if ($turGidisDonus != 1) {//Gidiş
                                if ($turTip == 0) {//öğrenci turu
                                    $ogrenciTurListele = $Panel_Model->vturOgrenciIDListele($turID);
                                    foreach ($ogrenciTurListele as $ogrenciTurListelee) {
                                        $turGelen[] = $ogrenciTurListelee['BSOgrenciID'];
                                    }
                                    //o gün gelemeyen öğrenci
                                    $ogrenciTurGunListele = $Panel_Model->vturOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                    foreach ($ogrenciTurGunListele as $ogrenciTurGunListelee) {
                                        $turGelmeyen[] = $ogrenciTurGunListelee['BSOgrenciID'];
                                    }
                                    if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                        $turagelenler = array_diff($turGelen, $turGelmeyen);
                                        //tura giderken binenler kimler
                                        $ogrenciBinen = $Panel_Model->vturOgrenciBinenIDListele($turID);
                                        foreach ($ogrenciBinen as $ogrenciBinenn) {
                                            $turBinen[] = $ogrenciBinenn['BSKisiID'];
                                        }
                                        //tur binmeyenler
                                        if (count($ogrenciBinen) > 0) {
                                            $turbinmeyen = array_diff($turagelenler, $turBinen);
                                        } else {
                                            $turbinmeyen = $turagelenler;
                                        }
                                        $turaBinenler = implode(',', $turBinen);

                                        $ogrenciBinenListele = $Panel_Model->vturGidisOgrenciBinenListele($turID, $turaBinenler);
                                        if (count($ogrenciBinenListele) > 0) {
                                            $a = 0;
                                            foreach ($ogrenciBinenListele as $ogrenciBinenListelee) {
                                                $turBinenler['TurBinenTip'][$a] = 0;
                                                $turBinenler['TurBinenID'][$a] = $ogrenciBinenListelee['BSOgrenciID'];
                                                $turBinenler['TurBinenAd'][$a] = $ogrenciBinenListelee['BSOgrenciAd'];
                                                $turBinenler['TurBinenLocation'][$a] = $ogrenciBinenListelee['BSOgrenciLocation'];
                                                $a++;
                                            }
                                        }
                                        $turaBinemeyen = implode(',', $turbinmeyen);
                                        $ogrenciBinmeyenListele = $Panel_Model->vturGidisOgrenciBinmeyenListele($turID, $turaBinemeyen);
                                        $b = 0;
                                        foreach ($ogrenciBinmeyenListele as $ogrenciBinmeyenListelee) {
                                            $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                            $turBinmeyen['TurBinmeyenID'][$b] = $ogrenciBinmeyenListelee['BSOgrenciID'];
                                            $turBinmeyen['TurBinmeyenAd'][$b] = $ogrenciBinmeyenListelee['BSOgrenciAd'];
                                            $turBinmeyen['TurBinmeyenLocation'][$b] = $ogrenciBinmeyenListelee['BSOgrenciLocation'];
                                            $b++;
                                        }
                                    } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                        //tura giderken binenler kimler
                                        $ogrenciBinen = $Panel_Model->vturOgrenciBinenIDListele($turID);
                                        foreach ($ogrenciBinen as $ogrenciBinenn) {
                                            $turBinen[] = $ogrenciBinenn['BSKisiID'];
                                        }
                                        //tur binmeyenler
                                        if (count($ogrenciBinen) > 0) {
                                            $turbinmeyen = array_diff($turGelen, $turBinen);
                                        } else {
                                            $turbinmeyen = $turGelen;
                                        }

                                        $turaBinenler = implode(',', $turBinen);

                                        $ogrenciBinenListele = $Panel_Model->vturGidisOgrenciBinenListele($turID, $turaBinenler);
                                        if (count($ogrenciBinenListele) > 0) {
                                            $a = 0;
                                            foreach ($ogrenciBinenListele as $ogrenciBinenListelee) {
                                                $turBinenler['TurBinenTip'][$a] = 0;
                                                $turBinenler['TurBinenID'][$a] = $ogrenciBinenListelee['BSOgrenciID'];
                                                $turBinenler['TurBinenAd'][$a] = $ogrenciBinenListelee['BSOgrenciAd'];
                                                $turBinenler['TurBinenLocation'][$a] = $ogrenciBinenListelee['BSOgrenciLocation'];
                                                $a++;
                                            }
                                        }
                                        $turaBinemeyen = implode(',', $turbinmeyen);
                                        $ogrenciBinmeyenListele = $Panel_Model->vturGidisOgrenciBinmeyenListele($turID, $turaBinemeyen);
                                        $b = 0;
                                        foreach ($ogrenciBinmeyenListele as $ogrenciBinmeyenListelee) {
                                            $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                            $turBinmeyen['TurBinmeyenID'][$b] = $ogrenciBinmeyenListelee['BSOgrenciID'];
                                            $turBinmeyen['TurBinmeyenAd'][$b] = $ogrenciBinmeyenListelee['BSOgrenciAd'];
                                            $turBinmeyen['TurBinmeyenLocation'][$b] = $ogrenciBinmeyenListelee['BSOgrenciLocation'];
                                            $b++;
                                        }
                                    }
                                } else if ($turTip == 2) {//hem işçi hem öğrenci
                                    $isciOgrenciTurListele = $Panel_Model->vturIsciOgrenciIDListele($turID);
                                    foreach ($isciOgrenciTurListele as $isciOgrenciTurListelee) {
                                        if ($isciOgrenciTurListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            $turGelen[] = 'o' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                        } else {//personel
                                            $turGelen[] = 'p' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                        }
                                    }
                                    //o gün gelemeyen öğrenci
                                    $isciOgrenciTurGunListele = $Panel_Model->vturIsciOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                    foreach ($isciOgrenciTurGunListele as $isciOgrenciTurGunListelee) {
                                        if ($isciOgrenciTurGunListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            $turGelmeyen[] = 'o' . $isciOgrenciTurGunListelee['BSKisiID'];
                                        } else {//personel
                                            $turGelmeyen[] = 'p' . $isciOgrenciTurGunListelee['BSKisiID'];
                                        }
                                    }
                                    if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                        $turagelenler = array_diff($turGelen, $turGelmeyen);
                                        //tura giderken binenler kimler
                                        $isciogrenciBinen = $Panel_Model->vturIsciOgrenciBinenIDListele($turID);
                                        foreach ($isciogrenciBinen as $isciogrenciBinenn) {
                                            if ($isciogrenciBinenn['BSKisiTip'] != 1) {//öğrenci
                                                $turBinen[] = 'o' . $isciogrenciBinenn['BSKisiID'];
                                                $turBinenTip[] = 0;
                                            } else {//işçi
                                                $turBinen[] = 'p' . $isciogrenciBinenn['BSKisiID'];
                                                $turBinenTip[] = 1;
                                            }
                                        }
                                        $turaBinenTip = implode(',', $turBinenTip);
                                        //tur binmeyenler
                                        if (count($isciogrenciBinen) > 0) {
                                            $turbinmeyen = array_diff($turagelenler, $turBinen);
                                        } else {
                                            $turbinmeyen = $turagelenler;
                                        }

                                        //turbinenin baştaki işaretlemeleri kaldıracağız
                                        foreach ($turBinen as $turBinenn) {
                                            $turBinennn[] = ltrim($turBinenn, $turBinenn[0]);
                                        }
                                        $turaBinen = implode(',', $turBinennn);

                                        $isciOgrenciBinenListele = $Panel_Model->vturGidisIsciOgrenciBinenListele($turID, $turaBinen, $turaBinenTip);
                                        if (count($isciOgrenciBinenListele) > 0) {
                                            $a = 0;
                                            foreach ($isciOgrenciBinenListele as $isciOgrenciBinenListelee) {
                                                if ($isciOgrenciBinenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                    $turBinenler['TurBinenTip'][$a] = 0;
                                                } else {//işçi
                                                    $turBinenler['TurBinenTip'][$a] = 1;
                                                }
                                                $turBinenler['TurBinenID'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciID'];
                                                $turBinenler['TurBinenAd'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciAd'];
                                                $turBinenler['TurBinenLocation'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciLocation'];
                                                $a++;
                                            }
                                        }

                                        //tura binmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turbinmeyen as $turbinmeyenn) {
                                            $turaBinemeyen[] = ltrim($turbinmeyenn, $turbinmeyenn[0]);
                                        }
                                        //tura binmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turbinmeyen as $turbinmeyenIlk) {
                                            if ($turbinmeyenIlk[0] == 'o') {
                                                $turBinmeyenTip[] = 0;
                                            } else {
                                                $turBinmeyenTip[] = 1;
                                            }
                                        }
                                        $turaBinmeyen = implode(',', $turaBinemeyen);
                                        $turaBinmeyenTip = implode(',', $turBinmeyenTip);
                                        $isciOgrenciBinmeyenListele = $Panel_Model->vturGidisOgrenciIsciBinmeyenListele($turID, $turaBinmeyen, $turaBinmeyenTip);
                                        $b = 0;
                                        foreach ($isciOgrenciBinmeyenListele as $isciOgrenciBinmeyenListelee) {
                                            if ($isciOgrenciBinmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                if (!in_array('o' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                    $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                                    $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                    $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                    $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            } else {//işçi
                                                if (!in_array('p' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                    $turBinmeyen['TurBinmeyenTip'][$b] = 1;
                                                    $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                    $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                    $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            }
                                        }
                                    } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                        //tura giderken binenler kimler
                                        $isciogrenciBinen = $Panel_Model->vturIsciOgrenciBinenIDListele($turID);
                                        foreach ($isciogrenciBinen as $isciogrenciBinenn) {
                                            if ($isciogrenciBinenn['BSKisiTip'] != 1) {//öğrenci
                                                $turBinen[] = 'o' . $isciogrenciBinenn['BSKisiID'];
                                                $turBinenTip[] = 0;
                                            } else {//işçi
                                                $turBinen[] = 'p' . $isciogrenciBinenn['BSKisiID'];
                                                $turBinenTip[] = 1;
                                            }
                                        }
                                        $turaBinenTip = implode(',', $turBinenTip);
                                        //tur binmeyenler
                                        if (count($isciogrenciBinen) > 0) {
                                            $turbinmeyen = array_diff($turGelen, $turBinen);
                                        } else {
                                            $turbinmeyen = $turGelen;
                                        }
                                        //turbinenin baştaki işaretlemeleri kaldıracağız
                                        foreach ($turBinen as $turBinenn) {
                                            $turBinennn[] = ltrim($turBinenn, $turBinenn[0]);
                                        }
                                        $turaBinen = implode(',', $turBinennn);

                                        $isciOgrenciBinenListele = $Panel_Model->vturGidisIsciOgrenciBinenListele($turID, $turaBinen, $turaBinenTip);
                                        if (count($isciOgrenciBinenListele) > 0) {
                                            $a = 0;
                                            foreach ($isciOgrenciBinenListele as $isciOgrenciBinenListelee) {
                                                if ($isciOgrenciBinenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                    $turBinenler['TurBinenTip'][$a] = 0;
                                                } else {//işçi
                                                    $turBinenler['TurBinenTip'][$a] = 1;
                                                }
                                                $turBinenler['TurBinenID'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciID'];
                                                $turBinenler['TurBinenAd'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciAd'];
                                                $turBinenler['TurBinenLocation'][$a] = $isciOgrenciBinenListelee['BSOgrenciIsciLocation'];
                                                $a++;
                                            }
                                        }

                                        //tura binmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turbinmeyen as $turbinmeyenn) {
                                            $turaBinemeyen[] = ltrim($turbinmeyenn, $turbinmeyenn[0]);
                                        }
                                        //tura binmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turbinmeyen as $turbinmeyenIlk) {
                                            if ($turbinmeyenIlk[0] == 'o') {
                                                $turBinmeyenTip[] = 0;
                                            } else {
                                                $turBinmeyenTip[] = 1;
                                            }
                                        }
                                        $turaBinmeyen = implode(',', $turaBinemeyen);
                                        $turaBinmeyenTip = implode(',', $turBinmeyenTip);
                                        $isciOgrenciBinmeyenListele = $Panel_Model->vturGidisOgrenciIsciBinmeyenListele($turID, $turaBinmeyen, $turaBinmeyenTip);
                                        $b = 0;
                                        foreach ($isciOgrenciBinmeyenListele as $isciOgrenciBinmeyenListelee) {
                                            if ($isciOgrenciBinmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                if (!in_array('o' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                    $turBinmeyen['TurBinmeyenTip'][$b] = 0;
                                                    $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                    $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                    $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            } else {//işçi
                                                if (!in_array('p' . $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'], $turBinen)) {
                                                    $turBinmeyen['TurBinmeyenTip'][$b] = 1;
                                                    $turBinmeyen['TurBinmeyenID'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciID'];
                                                    $turBinmeyen['TurBinmeyenAd'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciAd'];
                                                    $turBinmeyen['TurBinmeyenLocation'][$b] = $isciOgrenciBinmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            }
                                        }
                                    }
                                }
                            } else {//Dönüş
                                if ($turTip == 0) {//öğrenci turu
                                    $ogrenciTurListele = $Panel_Model->vturOgrenciIDListele($turID);
                                    foreach ($ogrenciTurListele as $ogrenciTurListelee) {
                                        $turGelen[] = $ogrenciTurListelee['BSOgrenciID'];
                                    }
                                    //o gün gelemeyen öğrenci
                                    $ogrenciTurGunListele = $Panel_Model->vturOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                    foreach ($ogrenciTurGunListele as $ogrenciTurGunListelee) {
                                        $turGelmeyen[] = $ogrenciTurGunListelee['BSOgrenciID'];
                                    }
                                    if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                        $turagelenler = array_diff($turGelen, $turGelmeyen);
                                        //tura giderken binenler kimler
                                        $ogrenciInen = $Panel_Model->vturOgrenciInenIDListele($turID);
                                        foreach ($ogrenciInen as $ogrenciInenn) {
                                            $turInen[] = $ogrenciInenn['BSKisiID'];
                                        }
                                        //tur inmeyenler
                                        if (count($ogrenciInen) > 0) {
                                            $turinmeyen = array_diff($turagelenler, $turInen);
                                        } else {
                                            $turinmeyen = $turagelenler;
                                        }
                                        $turaInenler = implode(',', $turInen);

                                        $ogrenciInenListele = $Panel_Model->vturDonusOgrenciInenListele($turID, $turaInenler);
                                        if (count($ogrenciInenListele) > 0) {
                                            $a = 0;
                                            foreach ($ogrenciInenListele as $ogrenciInenListelee) {
                                                $turInenler['TurInenTip'][$a] = 0;
                                                $turInenler['TurInenID'][$a] = $ogrenciInenListelee['BSOgrenciID'];
                                                $turInenler['TurInenAd'][$a] = $ogrenciInenListelee['BSOgrenciAd'];
                                                $turInenler['TurInenLocation'][$a] = $ogrenciInenListelee['BSOgrenciLocation'];
                                                $a++;
                                            }
                                        }
                                        $turaInemeyen = implode(',', $turinmeyen);
                                        $ogrenciInmeyenListele = $Panel_Model->vturDonusOgrenciInmeyenListele($turID, $turaInemeyen);
                                        $b = 0;
                                        foreach ($ogrenciInmeyenListele as $ogrenciInmeyenListelee) {
                                            $turInmeyen['TurInmeyenTip'][$b] = 0;
                                            $turInmeyen['TurInmeyenID'][$b] = $ogrenciInmeyenListelee['BSOgrenciID'];
                                            $turInmeyen['TurInmeyenAd'][$b] = $ogrenciInmeyenListelee['BSOgrenciAd'];
                                            $turInmeyen['TurInmeyenLocation'][$b] = $ogrenciInmeyenListelee['BSOgrenciLocation'];
                                            $b++;
                                        }
                                    } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                        //tura giderken inenler kimler
                                        $ogrenciInen = $Panel_Model->vturOgrenciInenIDListele($turID);
                                        foreach ($ogrenciInen as $ogrenciInenn) {
                                            $turInen[] = $ogrenciInenn['BSKisiID'];
                                        }
                                        //tur inmeyenler
                                        if (count($ogrenciInen) > 0) {
                                            $turinmeyen = array_diff($turGelen, $turInen);
                                        } else {
                                            $turinmeyen = $turGelen;
                                        }
                                        $turaInenler = implode(',', $turInen);

                                        $ogrenciInenListele = $Panel_Model->vturDonusOgrenciInenListele($turID, $turaInenler);
                                        if (count($ogrenciInenListele) > 0) {
                                            $a = 0;
                                            foreach ($ogrenciInenListele as $ogrenciInenListelee) {
                                                $turInenler['TurInenTip'][$a] = 0;
                                                $turInenler['TurInenID'][$a] = $ogrenciInenListelee['BSOgrenciID'];
                                                $turInenler['TurInenAd'][$a] = $ogrenciInenListelee['BSOgrenciAd'];
                                                $turInenler['TurInenLocation'][$a] = $ogrenciInenListelee['BSOgrenciLocation'];
                                                $a++;
                                            }
                                        }
                                        $turaInemeyen = implode(',', $turinmeyen);
                                        $ogrenciInmeyenListele = $Panel_Model->vturDonusOgrenciInmeyenListele($turID, $turaInemeyen);
                                        $b = 0;
                                        foreach ($ogrenciInmeyenListele as $ogrenciInmeyenListelee) {
                                            $turInmeyen['TurInmeyenTip'][$b] = 0;
                                            $turInmeyen['TurInmeyenID'][$b] = $ogrenciInmeyenListelee['BSOgrenciID'];
                                            $turInmeyen['TurInmeyenAd'][$b] = $ogrenciInmeyenListelee['BSOgrenciAd'];
                                            $turInmeyen['TurInmeyenLocation'][$b] = $ogrenciInmeyenListelee['BSOgrenciLocation'];
                                            $b++;
                                        }
                                    }
                                } else if ($turTip == 2) {//hem işçi hem öğrenci
                                    $isciOgrenciTurListele = $Panel_Model->vturIsciOgrenciIDListele($turID);
                                    foreach ($isciOgrenciTurListele as $isciOgrenciTurListelee) {
                                        if ($isciOgrenciTurListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            $turGelen[] = 'o' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                        } else {//personel
                                            $turGelen[] = 'p' . $isciOgrenciTurListelee['BSOgrenciIsciID'];
                                        }
                                    }
                                    //o gün gelemeyen öğrenci
                                    $isciOgrenciTurGunListele = $Panel_Model->vturIsciOgrenciGunIDListele($turID, $yeniGun, $turGidisDonus);
                                    foreach ($isciOgrenciTurGunListele as $isciOgrenciTurGunListelee) {
                                        if ($isciOgrenciTurGunListelee['BSKullaniciTip'] != 1) {//öğrenci
                                            $turGelmeyen[] = 'o' . $isciOgrenciTurGunListelee['BSKisiID'];
                                        } else {//personel
                                            $turGelmeyen[] = 'p' . $isciOgrenciTurGunListelee['BSKisiID'];
                                        }
                                    }
                                    if (count($turGelmeyen) > 0) {//o tura gelmeyen varsa
                                        $turagelenler = array_diff($turGelen, $turGelmeyen);
                                        //tura giderken binenler kimler
                                        $isciogrenciInen = $Panel_Model->vturIsciOgrenciInenIDListele($turID);
                                        foreach ($isciogrenciInen as $isciogrenciInenn) {
                                            if ($isciogrenciInenn['BSKisiTip'] != 1) {//öğrenci
                                                $turInen[] = 'o' . $isciogrenciInenn['BSKisiID'];
                                                $turInenTip[] = 0;
                                            } else {//işçi
                                                $turInen[] = 'p' . $isciogrenciInenn['BSKisiID'];
                                                $turInenTip[] = 1;
                                            }
                                        }
                                        $turaInenTip = implode(',', $turInenTip);
                                        //tur inmeyenler
                                        if (count($isciogrenciInen) > 0) {
                                            $turinmeyen = array_diff($turagelenler, $turInen);
                                        } else {
                                            $turinmeyen = $turagelenler;
                                        }
                                        //turbinenin baştaki işaretlemeleri kaldıracağız
                                        foreach ($turInen as $turInenn) {
                                            $turInennn[] = ltrim($turInenn, $turInenn[0]);
                                        }
                                        $turaInen = implode(',', $turInennn);

                                        $isciOgrenciInenListele = $Panel_Model->vturDonusIsciOgrenciInenListele($turID, $turaInen, $turaInenTip);
                                        if (count($isciOgrenciInenListele) > 0) {
                                            $a = 0;
                                            foreach ($isciOgrenciInenListele as $isciOgrenciInenListelee) {
                                                if ($isciOgrenciInenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                    $turInenler['TurInenTip'][$a] = 0;
                                                } else {//işçi
                                                    $turInenler['TurInenTip'][$a] = 1;
                                                }
                                                $turInenler['TurInenID'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciID'];
                                                $turInenler['TurInenAd'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciAd'];
                                                $turInenler['TurInenLocation'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciLocation'];
                                                $a++;
                                            }
                                        }

                                        //tura inmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turinmeyen as $turinmeyenn) {
                                            $turaInemeyen[] = ltrim($turinmeyenn, $turinmeyenn[0]);
                                        }
                                        //tura inmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turinmeyen as $turinmeyenIlk) {
                                            if ($turinmeyenIlk[0] == 'o') {
                                                $turInmeyenTip[] = 0;
                                            } else {
                                                $turInmeyenTip[] = 1;
                                            }
                                        }
                                        $turaInmeyen = implode(',', $turaInemeyen);
                                        $turaInmeyenTip = implode(',', $turInmeyenTip);
                                        $isciOgrenciInmeyenListele = $Panel_Model->vturDonusOgrenciIsciInmeyenListele($turID, $turaInmeyen, $turaInmeyenTip);
                                        $b = 0;
                                        foreach ($isciOgrenciInmeyenListele as $isciOgrenciInmeyenListelee) {
                                            if ($isciOgrenciInmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                if (!in_array('o' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                    $turInmeyen['TurInmeyenTip'][$b] = 0;
                                                    $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                    $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                    $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            } else {//işçi
                                                if (!in_array('p' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                    $turInmeyen['TurInmeyenTip'][$b] = 1;
                                                    $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                    $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                    $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            }
                                        }
                                    } else {//tura gelmeyen yoksa yani herkes geliyorsa
                                        //tura gelirken inenler kimler
                                        $isciogrenciInen = $Panel_Model->vturIsciOgrenciInenIDListele($turID);
                                        foreach ($isciogrenciInen as $isciogrenciInenn) {
                                            if ($isciogrenciInenn['BSKisiTip'] != 1) {//öğrenci
                                                $turInen[] = 'o' . $isciogrenciInenn['BSKisiID'];
                                                $turInenTip[] = 0;
                                            } else {//işçi
                                                $turInen[] = 'p' . $isciogrenciInenn['BSKisiID'];
                                                $turInenTip[] = 1;
                                            }
                                        }
                                        $turaInenTip = implode(',', $turInenTip);
                                        //tur inmeyenler
                                        if (count($isciogrenciInen) > 0) {
                                            $turinmeyen = array_diff($turGelen, $turInen);
                                        } else {
                                            $turinmeyen = $turGelen;
                                        }
                                        //turbinenin baştaki işaretlemeleri kaldıracağız
                                        foreach ($turInen as $turInenn) {
                                            $turInennn[] = ltrim($turInenn, $turInenn[0]);
                                        }
                                        $turaInen = implode(',', $turInennn);

                                        $isciOgrenciInenListele = $Panel_Model->vturDonusIsciOgrenciInenListele($turID, $turaInen, $turaInenTip);
                                        if (count($isciOgrenciInenListele) > 0) {
                                            $a = 0;
                                            foreach ($isciOgrenciInenListele as $isciOgrenciInenListelee) {
                                                if ($isciOgrenciInenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                    $turInenler['TurInenTip'][$a] = 0;
                                                } else {//işçi
                                                    $turInenler['TurInenTip'][$a] = 1;
                                                }
                                                $turInenler['TurInenID'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciID'];
                                                $turInenler['TurInenAd'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciAd'];
                                                $turInenler['TurInenLocation'][$a] = $isciOgrenciInenListelee['BSOgrenciIsciLocation'];
                                                $a++;
                                            }
                                        }

                                        //tura inmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turinmeyen as $turinmeyenn) {
                                            $turaInemeyen[] = ltrim($turinmeyenn, $turinmeyenn[0]);
                                        }
                                        //tura inmeyenlerin tiplerinin ayrıştırma
                                        foreach ($turinmeyen as $turinmeyenIlk) {
                                            if ($turinmeyenIlk[0] == 'o') {
                                                $turInmeyenTip[] = 0;
                                            } else {
                                                $turInmeyenTip[] = 1;
                                            }
                                        }
                                        $turaInmeyen = implode(',', $turaInemeyen);
                                        $turaInmeyenTip = implode(',', $turInmeyenTip);
                                        $isciOgrenciInmeyenListele = $Panel_Model->vturDonusOgrenciIsciInmeyenListele($turID, $turaInmeyen, $turaInmeyenTip);
                                        $b = 0;
                                        foreach ($isciOgrenciInmeyenListele as $isciOgrenciInmeyenListelee) {
                                            if ($isciOgrenciInmeyenListelee['BSKullaniciTip'] != 1) {//öğrenci
                                                if (!in_array('o' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                    $turInmeyen['TurInmeyenTip'][$b] = 0;
                                                    $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                    $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                    $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            } else {//işçi
                                                if (!in_array('p' . $isciOgrenciInmeyenListelee['BSOgrenciIsciID'], $turInen)) {
                                                    $turInmeyen['TurInmeyenTip'][$b] = 1;
                                                    $turInmeyen['TurInmeyenID'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciID'];
                                                    $turInmeyen['TurInmeyenAd'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciAd'];
                                                    $turInmeyen['TurInmeyenLocation'][$b] = $isciOgrenciInmeyenListelee['BSOgrenciIsciLocation'];
                                                    $b++;
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $sonuc["turBinen"] = $turBinenler;
                            $sonuc["turBinemeyen"] = $turBinmeyen;
                            $sonuc["turInen"] = $turInenler;
                            $sonuc["turInemeyen"] = $turInmeyen;
                            $sonuc["aracLokasyon"] = $aracLokasyon[0]["BSAracLokasyon"];
                        }

                        break;
                    case "bakiyeListe":
                        $form->post('id', true);
                        $ID = $form->values['id'];
                        if (!$ID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $resultOgrenciBakiye = $Panel_Model->ogrenciBakiyeListe($ID);
                            if (count($resultOgrenciBakiye) > 0) {
                                $k = 0;
                                foreach ($resultOgrenciBakiye as $resultOgrenciBakiyee) {
                                    $bakiye[0][$k]['ID'] = $resultOgrenciBakiyee['BSOdemeID'];
                                    $bakiye[0][$k]['AlanTip'] = $resultOgrenciBakiyee['BSOdemeAlanTip'];
                                    $bakiye[0][$k]['Tutar'] = number_format($resultOgrenciBakiyee['BSOdemeTutar'], 2, '.', ',');
                                    $tarih = explode(" ", $resultOgrenciBakiyee['BSOdemeTarih']);
                                    $digerTarih = explode("-", $tarih[0]);
                                    $yeniTarih = $tarih[1] . '--' . $digerTarih[2] . '/' . $digerTarih[1] . '/' . $digerTarih[0];
                                    $bakiye[0][$k]['Tarih'] = $yeniTarih;
                                    $bakiye[0][$k]['Aciklama'] = $resultOgrenciBakiyee['BSOdemeAciklama'];
                                    $bakiye[0][$k]['DovizTip'] = $resultOgrenciBakiyee['BSDovizTip'];
                                    $k++;
                                }
                            } else {
                                $bakiye[1][0]['Yok'] = $languagedeger['OdemeYok'];
                            }
                            $sonuc["result"] = $bakiye;
                        }
                        break;
                    case "bakiyeDetay":
                        $form->post('id', true);
                        $ID = $form->values['id'];
                        if (!$ID) {
                            $sonuc["hata"] = $languagedeger['Hack'];
                        } else {
                            $form->post('odemeID', true);
                            $odemeID = $form->values['odemeID'];

                            $resultOgrenciBakiye = $Panel_Model->ogrenciBakiyeListDetay($odemeID);
                            foreach ($resultOgrenciBakiye as $resultOgrenciBakiyee) {
                                $bakiye[0]['ID'] = $resultOgrenciBakiyee['BSOdemeID'];
                                $bakiye[0]['AlanID'] = $resultOgrenciBakiyee['BSOdemeAlanID'];
                                $bakiye[0]['AlanAd'] = $resultOgrenciBakiyee['BSOdemeAlanAd'];
                                $bakiye[0]['AlanTip'] = $resultOgrenciBakiyee['BSOdemeAlanTip'];
                                $bakiye[0]['YapanID'] = $resultOgrenciBakiyee['BSOdemeYapanID'];
                                $bakiye[0]['YapanTip'] = $resultOgrenciBakiyee['BSOdemeYapanTip'];
                                $bakiye[0]['YapanAd'] = $resultOgrenciBakiyee['BSOdemeYapanAd'];
                                $bakiye[0]['OdenenTutar'] = number_format($resultOgrenciBakiyee['BSOdemeTutar'], 2, '.', ',');
                                $tarih = explode(" ", $resultOgrenciBakiyee['BSOdemeTarih']);
                                $digerTarih = explode("-", $tarih[0]);
                                $yeniTarih = $tarih[1] . '--' . $digerTarih[2] . '/' . $digerTarih[1] . '/' . $digerTarih[0];
                                $bakiye[0]['Tarih'] = $yeniTarih;
                                $bakiye[0]['Aciklama'] = $resultOgrenciBakiyee['BSOdemeAciklama'];
                                if ($resultOgrenciBakiyee['BSOdemeTip'] == 0) {
                                    $bakiye[0]['OdemeTipp'] = 0;
                                    $bakiye[0]['OdemeTip'] = $languagedeger['Elden'];
                                } elseif ($resultOgrenciBakiyee['BSOdemeTip'] == 1) {
                                    $bakiye[0]['OdemeTipp'] = 1;
                                    $bakiye[0]['OdemeTip'] = $languagedeger['KrediKartı'];
                                } else {
                                    $bakiye[0]['OdemeTipp'] = 2;
                                    $bakiye[0]['OdemeTip'] = $languagedeger['Havale'];
                                }
                                $bakiye[0]['DovizTip'] = $resultOgrenciBakiyee['BSDovizTip'];
                            }
                            $ogrencibak = $Panel_Model->bakiyeOgrenciOdenen($ID);
                            $bakiye[0]['OdemeTutar'] = number_format($ogrencibak[0]['OdemeTutar'], 2, '.', ',');
                            $bakiye[0]['KalanTutar'] = number_format($ogrencibak[0]['OdemeTutar'] - $bakiye[0]['OdenenTutar'], 2, '.', ',');
                            $sonuc["result"] = $bakiye;
                        }
                        break;
                }
            } else {
                $sonuc["hata"] = $languagedeger['Hata'];
            }

            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

