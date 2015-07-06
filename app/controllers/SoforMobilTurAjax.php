<?php

class SoforMobilTurAjax extends Controller {

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

            $formDbConfig = $this->load->otherClasses('DatabaseConfig');
            $usersselect_model = $this->load->model("adminselectdb_mobil");

            //return database results
            $UserSelectDb = $usersselect_model->adminFirmMobilID($firmId);

            $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
            $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
            $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
            $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];


            $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);


            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model_mobile");

            Switch ($tip) {

                case "soforTurDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('turid', true);
                        $turID = $form->values['turid'];

                        $turOzellik = $Panel_Model->soforTurDetay($turID);
                        if ($turOzellik) {
                            foreach ($turOzellik as $turOzellikk) {
                                $turList['Ad'] = $turOzellikk['SBTurAd'];
                                $turList['Aciklama'] = $turOzellikk['SBTurAciklama'];
                                $turList['Aktiflik'] = $turOzellikk['SBTurAktiflik'];
                                $turList['KurumID'] = $turOzellikk['SBKurumID'];
                                $turList['Kurum'] = $turOzellikk['SBKurumAd'];
                                $turList['KurumLoc'] = $turOzellikk['SBKurumLocation'];
                                $turList['Bolge'] = $turOzellikk['SBBolgeAd'];
                                $turList['BolgeID'] = $turOzellikk['SBBolgeID'];
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
                            //gidiş varsa
                            if ($turList['Gidis'] != 0) {
                                $turOGidis = $Panel_Model->soforTurGidis($turID);
                                foreach ($turOGidis as $turOGidiss) {
                                    $turGidis['ID'] = $turOGidiss['BSTurTipID'];
                                    $turGidis['Plaka'] = $turOGidiss['BSTurAracPlaka'];
                                    $turGidis['PlakaID'] = $turOGidiss['BSTurAracID'];
                                    $turGidis['Sofor'] = $turOGidiss['BSTurSoforAd'];
                                    $turGidis['SoforID'] = $turOGidiss['BSTurSoforID'];
                                    $turGidis['Hostes'] = $turOGidiss['BSTurHostesAd'];
                                    $turGidis['HostesID'] = $turOGidiss['BSTurHostesID'];
                                    $turGidis['Bslngc'] = $turOGidiss['BSTurBslngc'];
                                    $turGidis['Bts'] = $turOGidiss['BSTurBts'];
                                }
                            }
                            //dönüş varsa
                            if ($turList['Donus'] != 0) {
                                $turODonus = $Panel_Model->soforTurDonus($turID);
                                foreach ($turODonus as $turODonuss) {
                                    $turDonus['ID'] = $turODonuss['BSTurTipID'];
                                    $turDonus['Plaka'] = $turODonuss['BSTurAracPlaka'];
                                    $turDonus['PlakaID'] = $turODonuss['BSTurAracID'];
                                    $turDonus['Sofor'] = $turODonuss['BSTurSoforAd'];
                                    $turDonus['SoforID'] = $turODonuss['BSTurSoforID'];
                                    $turDonus['Hostes'] = $turODonuss['BSTurHostesAd'];
                                    $turDonus['HostesID'] = $turODonuss['BSTurHostesID'];
                                    $turDonus['Bslngc'] = $turODonuss['BSTurBslngc'];
                                    $turDonus['Bts'] = $turODonuss['BSTurBts'];
                                }
                            }

                            $sonuc["Detay"] = $turList;
                            $sonuc["Gidis"] = $turGidis;
                            $sonuc["Donus"] = $turDonus;
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "soforTurYolcu":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('turid', true);
                        $form->post('bolgeid', true);
                        $form->post('turtip', true);
                        $turID = $form->values['turid'];
                        $bolgeID = $form->values['bolgeid'];
                        $turTip = $form->values['turtip'];

                        if ($turTip == 0) {//öğrenci
                            $turOgrenci = $Panel_Model->soforTurOgrenci($turID);
                            $a = 0;
                            foreach ($turOgrenci as $turOgrencii) {
                                $turYolcu[$a]['Id'] = $turOgrencii['BSOgrenciID'];
                                $turYolcu[$a]['Ad'] = $turOgrencii['BSOgrenciAd'];
                                $a++;
                            }
                        } else if ($turTip == 1) {//işçi
                            $turIsci = $Panel_Model->soforTurIsci($turID);
                            $a = 0;
                            foreach ($turIsci as $turIscii) {
                                $turYolcu[$a]['Id'] = $turIscii['SBIsciID'];
                                $turYolcu[$a]['Ad'] = $turIscii['SBIsciAd'];
                                $a++;
                            }
                        } else {//öğrenci-personel
                            $turOgrenci = $Panel_Model->soforTurIsciOgrenci($turID);
                            if (count($turOgrenci) > 0) {
                                $a = 0;
                                foreach ($turOgrenci as $turOgrencii) {
                                    $turYolcu[$a]['Id'] = $turOgrencii['BSOgrenciIsciID'];
                                    $turYolcu[$a]['Ad'] = $turOgrencii['BSOgrenciIsciAd'];
                                    $turYolcu[$a]['Tip'] = $turOgrencii['BSKullaniciTip'];
                                    $a++;
                                }
                            }
                        }

                        $turSofor = $Panel_Model->soforTurDiger($turID);
                        $c = 0;
                        foreach ($turSofor as $turSoforr) {
                            $turSoforler[$c]['Id'] = $turSoforr['BSTurSoforID'];
                            $turSoforler[$c]['Ad'] = $turSoforr['BSTurSoforAd'];
                            $c++;
                        }

                        $turHostes = $Panel_Model->soforTurHostes($turID);
                        if (count($turHostes) > 0) {
                            $e = 0;
                            foreach ($turHostes as $turHostess) {
                                $turHostesler[$e]['Id'] = $turHostess['BSTurHostesID'];
                                $turHostesler[$e]['Ad'] = $turHostess['BSTurHostesAd'];
                                $e++;
                            }
                        }

                        $turYonetici = $Panel_Model->soforTurYonetici($bolgeID);
                        foreach ($turYonetici as $turYoneticii) {
                            $turyoneticiid[] = $turYoneticii['BSAdminID'];
                        }
                        $turyoneticiler = implode(',', $turyoneticiid);

                        $turSoforYoneti = $Panel_Model->soforTurYoneticiler($turyoneticiler);
                        $d = 0;
                        foreach ($turSoforYoneti as $turSoforYonetici) {
                            $turYonet[$d]['Id'] = $turSoforYonetici['BSAdminID'];
                            $turYonet[$d]['Ad'] = $turSoforYonetici['BSAdminAd'];
                            $turYonet[$d]['Soyad'] = $turSoforYonetici['BSAdminSoyad'];
                            $d++;
                        }

                        $sonuc["TurYolcu"] = $turYolcu;
                        $sonuc["TurSofor"] = $turSoforler;
                        $sonuc["TurHostes"] = $turHostesler;
                        $sonuc["TurYonet"] = $turYonet;
                    }

                    break;

                case "soforYolcuDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('kisiid', true);
                        $form->post('kisitip', true);
                        $kisiID = $form->values['kisiid'];
                        $kisiTip = $form->values['kisitip'];

                        switch ($kisiTip) {
                            case 0:
                                $yolcuOzellik = $Panel_Model->soforOYolcu($kisiID);
                                foreach ($yolcuOzellik as $yolcuOzellikk) {
                                    $kisiList['Ad'] = $yolcuOzellikk['BSOgrenciAd'];
                                    $kisiList['Soyad'] = $yolcuOzellikk['BSOgrenciSoyad'];
                                    $kisiList['Tel'] = $yolcuOzellikk['BSOgrenciPhone'];
                                    $kisiList['Mail'] = $yolcuOzellikk['BSOgrenciEmail'];
                                    $kisiList['Lokasyon'] = $yolcuOzellikk['BSOgrenciLocation'];
                                    $kisiList['Adres'] = $yolcuOzellikk['BSOgrenciDetayAdres'];
                                }

                                $yolcuVeliID = $Panel_Model->soforOVIDYolcu($kisiID);
                                if (count($yolcuVeliID) > 0) {
                                    foreach ($yolcuVeliID as $yolcuVeliIDD) {
                                        $ogrenciVeli[] = $yolcuVeliIDD['BSVeliID'];
                                    }
                                    $ogrenciveliid = implode(',', $ogrenciVeli);

                                    $ogrenciVeliler = $Panel_Model->soforOVYolcu($ogrenciveliid);
                                    $d = 0;
                                    foreach ($ogrenciVeliler as $ogrenciVelilerr) {
                                        $kisiVeli[$d]['Ad'] = $ogrenciVelilerr['SBVeliAd'];
                                        $kisiVeli[$d]['Soyad'] = $ogrenciVelilerr['SBVeliSoyad'];
                                        $kisiVeli[$d]['Tel'] = $ogrenciVelilerr['SBVeliPhone'];
                                        $kisiVeli[$d]['Mail'] = $ogrenciVelilerr['SBVeliEmail'];
                                        $d++;
                                    }
                                }

                                break;
                            case 1:
                                $yolcuOzellik = $Panel_Model->soforPYolcu($kisiID);
                                foreach ($yolcuOzellik as $yolcuOzellikk) {
                                    $kisiList['Ad'] = $yolcuOzellikk['SBIsciAd'];
                                    $kisiList['Soyad'] = $yolcuOzellikk['SBIsciSoyad'];
                                    $kisiList['Tel'] = $yolcuOzellikk['SBIsciPhone'];
                                    $kisiList['Mail'] = $yolcuOzellikk['SBIsciEmail'];
                                    $kisiList['Lokasyon'] = $yolcuOzellikk['SBIsciLocation'];
                                    $kisiList['Adres'] = $yolcuOzellikk['SBIsciDetayAdres'];
                                }
                                break;
                            case 2:
                                $yolcuOzellik = $Panel_Model->soforSYolcu($kisiID);
                                foreach ($yolcuOzellik as $yolcuOzellikk) {
                                    $kisiList['Ad'] = $yolcuOzellikk['BSSoforAd'];
                                    $kisiList['Soyad'] = $yolcuOzellikk['BSSoforSoyad'];
                                    $kisiList['Tel'] = $yolcuOzellikk['BSSoforPhone'];
                                    $kisiList['Mail'] = $yolcuOzellikk['BSSoforEmail'];
                                    $kisiList['Lokasyon'] = $yolcuOzellikk['BSSoforLocation'];
                                    $kisiList['Adres'] = $yolcuOzellikk['BSSoforDetayAdres'];
                                }
                                break;
                            case 3:
                                $yolcuOzellik = $Panel_Model->soforYYolcu($kisiID);
                                foreach ($yolcuOzellik as $yolcuOzellikk) {
                                    $kisiList['Ad'] = $yolcuOzellikk['BSAdminAd'];
                                    $kisiList['Soyad'] = $yolcuOzellikk['BSAdminSoyad'];
                                    $kisiList['Tel'] = $yolcuOzellikk['BSAdminPhone'];
                                    $kisiList['Mail'] = $yolcuOzellikk['BSAdminEmail'];
                                    $kisiList['Lokasyon'] = $yolcuOzellikk['BSAdminLocation'];
                                    $kisiList['Adres'] = $yolcuOzellikk['BSAdminDetayAdres'];
                                }
                                break;
                            case 4:
                                $yolcuOzellik = $Panel_Model->soforHYolcu($kisiID);
                                foreach ($yolcuOzellik as $yolcuOzellikk) {
                                    $kisiList['Ad'] = $yolcuOzellikk['BSHostesAd'];
                                    $kisiList['Soyad'] = $yolcuOzellikk['BSHostesSoyad'];
                                    $kisiList['Tel'] = $yolcuOzellikk['BSHostesPhone'];
                                    $kisiList['Mail'] = $yolcuOzellikk['BSHostesEmail'];
                                    $kisiList['Lokasyon'] = $yolcuOzellikk['BSHostesLocation'];
                                    $kisiList['Adres'] = $yolcuOzellikk['BSHostesDetayAdres'];
                                }
                                break;

                            default:
                                break;
                        }

                        $sonuc["Detay"] = $kisiList;
                        $sonuc["DetayVeli"] = $kisiVeli;
                    }

                    break;

                case "soforDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('kisiid', true);
                        $kisiID = $form->values['kisiid'];

                        $yolcuOzellik = $Panel_Model->soforSYolcu($kisiID);
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

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('kisiid', true);
                        $kisiID = $form->values['kisiid'];

                        $yolcuOzellik = $Panel_Model->soforHYolcu($kisiID);
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

                case "aracDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('aracid', true);
                        $aracID = $form->values['aracid'];

                        $aracOzellik = $Panel_Model->soforArac($aracID);
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

                case "turDetay":

                    if (!$firmId) {
                        $sonuc["hata"] = "Hacking?";
                    } else {
                        $form->post('turtip', true);
                        $form->post('turid', true);
                        $turTip = $form->values['turtip'];
                        $turID = $form->values['turid'];

                        if ($turTip == 0) {
                            $turYolcu = $Panel_Model->soforHTurOgrenci($turID);
                            $a = 0;
                            foreach ($turYolcu as $turYolcuu) {
                                $turList['ID'][$a] = $turYolcuu['BSOgrenciID'];
                                $turList['Ad'][$a] = $turYolcuu['BSOgrenciAd'];
                                $turList['Loc'][$a] = $turYolcuu['BSOgrenciLocation'];
                                $turList['Tip'][$a] = 0;
                                $a++;
                            }
                        } else if ($turTip == 1) {
                            $turYolcu = $Panel_Model->soforHTurIsci($turID);
                            $a = 0;
                            foreach ($turYolcu as $turYolcuu) {
                                $turList['ID'][$a] = $turYolcuu['SBIsciID'];
                                $turList['Ad'][$a] = $turYolcuu['SBIsciAd'];
                                $turList['Loc'][$a] = $turYolcuu['SBIsciLocation'];
                                $turList['Tip'][$a] = 1;
                                $a++;
                            }
                        } else {
                            $turYolcu = $Panel_Model->soforHTurIsciOgrenci($turID);
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

                case "soforTakvim":
                    $calendar = $this->load->otherClasses('Calendar');
                    // Short-circuit if the client did not give us a date range.
                    if (!isset($_POST['start']) || !isset($_POST['end'])) {
                        error_log("die");
                        die("Please provide a date range.");
                    }
                    // Parse the start/end parameters.
                    // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
                    // Since no timezone will be present, they will parsed as UTC.
                    $range_start = parseDateTime($_POST['start']);
                    $range_end = parseDateTime($_POST['end']);
                    // Parse the timezone parameter if it is present.
                    $timezone = null;
                    if (isset($_POST['timezone'])) {
                        $timezone = new DateTimeZone($_POST['timezone']);
                    }

                    $form->post("id", true);
                    $id = $form->values['id'];
                    $soforTakvim = $Panel_Model->soforTakvim($id);
                    $a = 0;
                    foreach ($soforTakvim as $soforTakvimm) {
                        $tkvimID[$a] = $soforTakvimm['BSTurID'];
                        $soforTkvim[$a]['Pzt'] = $soforTakvimm['SBTurPzt'];
                        $soforTkvim[$a]['Sli'] = $soforTakvimm['SBTurSli'];
                        $soforTkvim[$a]['Crs'] = $soforTakvimm['SBTurCrs'];
                        $soforTkvim[$a]['Prs'] = $soforTakvimm['SBTurPrs'];
                        $soforTkvim[$a]['Cma'] = $soforTakvimm['SBTurCma'];
                        $soforTkvim[$a]['Cmt'] = $soforTakvimm['SBTurCmt'];
                        $soforTkvim[$a]['Pzr'] = $soforTakvimm['SBTurPzr'];
                        $soforTkvim[$a]['Bslngc'] = $soforTakvimm['BSTurBslngc'];
                        $soforTkvim[$a]['Bts'] = $soforTakvimm['BSTurBts'];
                        $a++;
                    }

                    $count = count($tkvimID);
                    foreach ($tkvimID as $value) {
                        $sql .= 'SELECT SBTurAd FROM sbtur WHERE SBTurID=' . $value . ' UNION ALL ';
                    }
                    $uzunluk = strlen($sql);
                    $uzunluk = $uzunluk - 10;
                    $sqlTitle = substr($sql, 0, $uzunluk);
                    $takvimTitle = $Panel_Model->takvimTitle($sqlTitle);
                    $c = 0;
                    foreach ($takvimTitle as $takvimTitlee) {
                        $title[$c] = $takvimTitlee['SBTurAd'];
                        $c++;
                    }

                    $input_arrays = [];
                    $input_arrays = $form->calendar($soforTkvim, $title);

                    // Accumulate an output array of event data arrays.
//                    foreach ($input_arrays as $array) {
//
//                        // Convert the input array into a useful Event object
//                        $event = new Calendar($array, $timezone);
//
//                        // If the event is in-bounds, add it to the output
//                        if ($event->isWithinDayRange($range_start, $range_end)) {
//                            //$sonuc[] = $event->toArray();
//                        }
//                    }
                    $sonuc = $input_arrays;
                    break;

                case "hostesTakvim":
                    $calendar = $this->load->otherClasses('Calendar');
                    // Short-circuit if the client did not give us a date range.
                    if (!isset($_POST['start']) || !isset($_POST['end'])) {
                        error_log("die");
                        die("Please provide a date range.");
                    }
                    // Parse the start/end parameters.
                    // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
                    // Since no timezone will be present, they will parsed as UTC.
                    $range_start = parseDateTime($_POST['start']);
                    $range_end = parseDateTime($_POST['end']);
                    // Parse the timezone parameter if it is present.
                    $timezone = null;
                    if (isset($_POST['timezone'])) {
                        $timezone = new DateTimeZone($_POST['timezone']);
                    }

                    $form->post("id", true);
                    $id = $form->values['id'];
                    $hostesTakvim = $Panel_Model->hostesTakvim($id);
                    $a = 0;
                    foreach ($hostesTakvim as $hostesTakvimm) {
                        $tkvimID[$a] = $hostesTakvimm['BSTurID'];
                        $hostesTkvim[$a]['Pzt'] = $hostesTakvimm['SBTurPzt'];
                        $hostesTkvim[$a]['Sli'] = $hostesTakvimm['SBTurSli'];
                        $hostesTkvim[$a]['Crs'] = $hostesTakvimm['SBTurCrs'];
                        $hostesTkvim[$a]['Prs'] = $hostesTakvimm['SBTurPrs'];
                        $hostesTkvim[$a]['Cma'] = $hostesTakvimm['SBTurCma'];
                        $hostesTkvim[$a]['Cmt'] = $hostesTakvimm['SBTurCmt'];
                        $hostesTkvim[$a]['Pzr'] = $hostesTakvimm['SBTurPzr'];
                        $hostesTkvim[$a]['Bslngc'] = $hostesTakvimm['BSTurBslngc'];
                        $hostesTkvim[$a]['Bts'] = $hostesTakvimm['BSTurBts'];
                        $a++;
                    }

                    $count = count($tkvimID);
                    foreach ($tkvimID as $value) {
                        $sql .= 'SELECT SBTurAd FROM sbtur WHERE SBTurID=' . $value . ' UNION ALL ';
                    }
                    $uzunluk = strlen($sql);
                    $uzunluk = $uzunluk - 10;
                    $sqlTitle = substr($sql, 0, $uzunluk);
                    $takvimTitle = $Panel_Model->takvimTitle($sqlTitle);
                    $c = 0;
                    foreach ($takvimTitle as $takvimTitlee) {
                        $title[$c] = $takvimTitlee['SBTurAd'];
                        $c++;
                    }

                    $input_arrays = [];
                    $input_arrays = $form->calendar($hostesTkvim, $title);

                    // Accumulate an output array of event data arrays.
//                    foreach ($input_arrays as $array) {
//
//                        // Convert the input array into a useful Event object
//                        $event = new Calendar($array, $timezone);
//
//                        // If the event is in-bounds, add it to the output
//                        if ($event->isWithinDayRange($range_start, $range_end)) {
//                            //$sonuc[] = $event->toArray();
//                        }
//                    }
                    $sonuc = $input_arrays;
                    break;

                case "aracTakvim":
                    $calendar = $this->load->otherClasses('Calendar');
                    // Short-circuit if the client did not give us a date range.
                    if (!isset($_POST['start']) || !isset($_POST['end'])) {
                        error_log("die");
                        die("Please provide a date range.");
                    }
                    // Parse the start/end parameters.
                    // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
                    // Since no timezone will be present, they will parsed as UTC.
                    $range_start = parseDateTime($_POST['start']);
                    $range_end = parseDateTime($_POST['end']);
                    // Parse the timezone parameter if it is present.
                    $timezone = null;
                    if (isset($_POST['timezone'])) {
                        $timezone = new DateTimeZone($_POST['timezone']);
                    }

                    $form->post("id", true);
                    $id = $form->values['id'];
                    $aracTakvim = $Panel_Model->hostesTakvim($id);
                    $a = 0;
                    foreach ($aracTakvim as $aracTakvimm) {
                        $tkvimID[$a] = $aracTakvimm['BSTurID'];
                        $aracTkvim[$a]['Pzt'] = $aracTakvimm['SBTurPzt'];
                        $aracTkvim[$a]['Sli'] = $aracTakvimm['SBTurSli'];
                        $aracTkvim[$a]['Crs'] = $aracTakvimm['SBTurCrs'];
                        $aracTkvim[$a]['Prs'] = $aracTakvimm['SBTurPrs'];
                        $aracTkvim[$a]['Cma'] = $aracTakvimm['SBTurCma'];
                        $aracTkvim[$a]['Cmt'] = $aracTakvimm['SBTurCmt'];
                        $aracTkvim[$a]['Pzr'] = $aracTakvimm['SBTurPzr'];
                        $aracTkvim[$a]['Bslngc'] = $aracTakvimm['BSTurBslngc'];
                        $aracTkvim[$a]['Bts'] = $aracTakvimm['BSTurBts'];
                        $a++;
                    }

                    $count = count($tkvimID);
                    foreach ($tkvimID as $value) {
                        $sql .= 'SELECT SBTurAd FROM sbtur WHERE SBTurID=' . $value . ' UNION ALL ';
                    }
                    $uzunluk = strlen($sql);
                    $uzunluk = $uzunluk - 10;
                    $sqlTitle = substr($sql, 0, $uzunluk);
                    $takvimTitle = $Panel_Model->takvimTitle($sqlTitle);
                    $c = 0;
                    foreach ($takvimTitle as $takvimTitlee) {
                        $title[$c] = $takvimTitlee['SBTurAd'];
                        $c++;
                    }

                    $input_arrays = [];
                    $input_arrays = $form->calendar($aracTkvim, $title);

                    // Accumulate an output array of event data arrays.
//                    foreach ($input_arrays as $array) {
//
//                        // Convert the input array into a useful Event object
//                        $event = new Calendar($array, $timezone);
//
//                        // If the event is in-bounds, add it to the output
//                        if ($event->isWithinDayRange($range_start, $range_end)) {
//                            //$sonuc[] = $event->toArray();
//                        }
//                    }
                    $sonuc = $input_arrays;
                    break;

                case "yolcuTakvim":
                    $calendar = $this->load->otherClasses('Calendar');
                    // Short-circuit if the client did not give us a date range.
                    if (!isset($_POST['start']) || !isset($_POST['end'])) {
                        error_log("die");
                        die("Please provide a date range.");
                    }
                    // Parse the start/end parameters.
                    // These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
                    // Since no timezone will be present, they will parsed as UTC.
                    $range_start = parseDateTime($_POST['start']);
                    $range_end = parseDateTime($_POST['end']);
                    // Parse the timezone parameter if it is present.
                    $timezone = null;
                    if (isset($_POST['timezone'])) {
                        $timezone = new DateTimeZone($_POST['timezone']);
                    }

                    $form->post("id", true);
                    $form->post("yolcutip", true);
                    $id = $form->values['id'];
                    $yolcuTip = $form->values['yolcutip'];
                    if ($yolcuTip == 0) {//şoför
                        $aracTakvim = $Panel_Model->soforTakvim($id);
                    } else if ($yolcuTip == 1) {//hostes
                        $aracTakvim = $Panel_Model->hostesTakvim($id);
                    }

                    $a = 0;
                    foreach ($aracTakvim as $aracTakvimm) {
                        $tkvimID[$a] = $aracTakvimm['BSTurID'];
                        $aracTkvim[$a]['Pzt'] = $aracTakvimm['SBTurPzt'];
                        $aracTkvim[$a]['Sli'] = $aracTakvimm['SBTurSli'];
                        $aracTkvim[$a]['Crs'] = $aracTakvimm['SBTurCrs'];
                        $aracTkvim[$a]['Prs'] = $aracTakvimm['SBTurPrs'];
                        $aracTkvim[$a]['Cma'] = $aracTakvimm['SBTurCma'];
                        $aracTkvim[$a]['Cmt'] = $aracTakvimm['SBTurCmt'];
                        $aracTkvim[$a]['Pzr'] = $aracTakvimm['SBTurPzr'];
                        $aracTkvim[$a]['Bslngc'] = $aracTakvimm['BSTurBslngc'];
                        $aracTkvim[$a]['Bts'] = $aracTakvimm['BSTurBts'];
                        $a++;
                    }

                    $count = count($tkvimID);
                    foreach ($tkvimID as $value) {
                        $sql .= 'SELECT SBTurAd FROM sbtur WHERE SBTurID=' . $value . ' UNION ALL ';
                    }
                    $uzunluk = strlen($sql);
                    $uzunluk = $uzunluk - 10;
                    $sqlTitle = substr($sql, 0, $uzunluk);
                    $takvimTitle = $Panel_Model->takvimTitle($sqlTitle);
                    $c = 0;
                    foreach ($takvimTitle as $takvimTitlee) {
                        $title[$c] = $takvimTitlee['SBTurAd'];
                        $c++;
                    }

                    $input_arrays = [];
                    $input_arrays = $form->calendar($aracTkvim, $title);

                    // Accumulate an output array of event data arrays.
//                    foreach ($input_arrays as $array) {
//
//                        // Convert the input array into a useful Event object
//                        $event = new Calendar($array, $timezone);
//
//                        // If the event is in-bounds, add it to the output
//                        if ($event->isWithinDayRange($range_start, $range_end)) {
//                            //$sonuc[] = $event->toArray();
//                        }
//                    }
                    $sonuc = $input_arrays;
                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

