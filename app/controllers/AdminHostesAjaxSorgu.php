<?php

class AdminHostesAjaxSorgu extends Controller {

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

                case "hostesEkleSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            //bölgeleri getirir
                            $bolgeListe = $Panel_Model->hostesBolgeListelee();

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }
                        } else {
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $bolgeListe = $Panel_Model->hostesRutbeBolgeListele($rutbebolgedizi);

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }
                        }

                        $sonuc["adminBolge"] = $adminBolge;
                    }
                    break;

                case "hostesAracMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $hostesBolgeID = $_REQUEST['hostesBolgeID'];
                        $multihostesdizi = implode(',', $hostesBolgeID);

                        $soforBolgeListe = $Panel_Model->aracMultiSelectBolge($multihostesdizi);
                        foreach ($soforBolgeListe as $soforBolgeListee) {
                            $aracrutbeId[] = $soforBolgeListee['SBAracID'];
                        }
                        $rutbearacdizi = implode(',', $aracrutbeId);
                        //bölgeleri getirir
                        $aracListe = $Panel_Model->aracMultiSelect($rutbearacdizi);

                        $a = 0;
                        foreach ($aracListe as $aracListee) {
                            $hostesAracSelect['AracSelectID'][$a] = $aracListee['SBAracID'];
                            $hostesAracSelect['AracSelectPlaka'][$a] = $aracListee['SBAracPlaka'];
                            $a++;
                        }
                        $sonuc["aracMultiSelect"] = $hostesAracSelect;
                    }
                    break;

                case "hostesKaydet":

                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $userTip = 6;

                        $firmaID = Session::get("FirmaId");

                        $userKadi = $form->kadiOlustur($firmaID);
                        if ($userKadi) {
                            $realSifre = $form->sifreOlustur();
                            if ($realSifre) {
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $uniqueKey = Session::get("username");
                                    $uniqueKey = $uniqueKey . '_AHostes';

                                    $form->post('hostesAd', true);
                                    $form->post('hostesSoyad', true);
                                    $form->post('hostesEmail', true);
                                    $form->post('hostesDurum', true);
                                    $form->post('hostesLokasyon', true);
                                    $form->post('hostesTelefon', true);
                                    $form->post('hostesAdres', true);
                                    $form->post('aciklama', true);
                                    $form->post('ulke', true);
                                    $form->post('il', true);
                                    $form->post('ilce', true);
                                    $form->post('semt', true);
                                    $form->post('mahalle', true);
                                    $form->post('sokak', true);
                                    $form->post('postakodu', true);
                                    $form->post('caddeno', true);
                                    $form->post('detayAdres', true);

                                    $hostesAd = $form->values['hostesAd'];
                                    $hostesSoyad = $form->values['hostesSoyad'];
                                    $hostesAdSoyad = $hostesAd . ' ' . $hostesSoyad;

                                    $hostesBolgeID = $_REQUEST['hostesBolgeID'];
                                    $hostesBolgeAdi = $_REQUEST['hostesBolgeAdi'];
                                    $hostesAracID = $_REQUEST['hostesAracID'];
                                    $hostesAracPlaka = $_REQUEST['hostesAracPlaka'];

                                    if ($form->submit()) {
                                        $data = array(
                                            'BSHostesAd' => $hostesAd,
                                            'BSHostesSoyad' => $hostesSoyad,
                                            'BSHostesKadi' => $userKadi,
                                            'BSHostesSifre' => $adminSifre,
                                            'BSHostesRSifre' => $realSifre,
                                            'BSHostesPhone' => $form->values['hostesTelefon'],
                                            'BSHostesEmail' => $form->values['hostesEmail'],
                                            'BSHostesLocation' => $form->values['hostesLokasyon'],
                                            'BSHostesUlke' => $form->values['ulke'],
                                            'BSHostesIl' => $form->values['il'],
                                            'BSHostesIlce' => $form->values['ilce'],
                                            'BSHostesSemt' => $form->values['semt'],
                                            'BSHostesMahalle' => $form->values['mahalle'],
                                            'BSHostesSokak' => $form->values['sokak'],
                                            'BSHostesPostaKodu' => $form->values['postakodu'],
                                            'BSHostesCaddeNo' => $form->values['caddeno'],
                                            'BSHostesAdres' => $form->values['hostesAdres'],
                                            'BSHostesDetayAdres' => $form->values['detayAdres'],
                                            'Status' => $form->values['hostesDurum'],
                                            'BSHostesAciklama' => $form->values['aciklama']
                                        );
                                    }
                                    $resultHostesID = $Panel_Model->addNewHostes($data);

                                    if ($resultHostesID != 'unique') {
                                        $bolgeID = count($hostesBolgeID);
                                        if ($bolgeID > 0) {
                                            for ($b = 0; $b < $bolgeID; $b++) {
                                                $bolgedata[$b] = array(
                                                    'BSHostesID' => $resultHostesID,
                                                    'BSHostesAd' => $hostesAdSoyad,
                                                    'BSBolgeID' => $hostesBolgeID[$b],
                                                    'BSBolgeAdi' => $hostesBolgeAdi[$b]
                                                );
                                            }
                                            $resultBolgeID = $Panel_Model->addNewBolgeHostes($bolgedata);
                                            if ($resultBolgeID) {
                                                //şoföre araç seçildi ise
                                                $aracID = count($hostesAracID);
                                                if ($aracID > 0) {
                                                    for ($c = 0; $c < $aracID; $c++) {
                                                        $aracdata[$c] = array(
                                                            'BSAracID' => $hostesAracID[$c],
                                                            'BSAracPlaka' => $hostesAracPlaka[$c],
                                                            'BSHostesID' => $resultHostesID,
                                                            'BSHostesAd' => $hostesAdSoyad
                                                        );
                                                    }

                                                    $resultAracID = $Panel_Model->addNewAracHostes($aracdata);

                                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newHostesID"] = $resultHostesID;
                                                    $sonuc["insert"] = "Başarıyla Hostes Eklenmiştir.";
                                                } else {
                                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newHostesID"] = $resultHostesID;
                                                    $sonuc["insert"] = "Başarıyla Hostes Eklenmiştir.";
                                                }
                                            } else {
                                                //admin kaydedilirken hata geldi ise
                                                $deleteresult = $Panel_Model->hostesDelete($resultHostesID);

                                                if ($deleteresult) {
                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                                }
                                            }
                                        } else {
                                            //eğer şoförün bölgesi yoksa
                                            $deleteresult = $Panel_Model->hostesDelete($resultHostesID);
                                            $sonuc["hata"] = "Lütfen Bölge Seçmeyi Unutmayınız.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Yeni Bir Kullanıcı Adı yada Şifre Giriniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                case "hostesDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('hostesRowid', true);
                            $hostesDetailID = $form->values['hostesRowid'];

                            $hostesBolge = $Panel_Model->hostesDetailBolge($hostesDetailID);
                            //arac bölge idler
                            $a = 0;
                            foreach ($hostesBolge as $hostesBolgee) {
                                $selectHostesBolge[$a]['SelectHostesBolgeID'] = $hostesBolgee['BSBolgeID'];
                                $selectHostesBolge[$a]['SelectHostesBolgeAdi'] = $hostesBolgee['BSBolgeAdi'];
                                $hostesbolgeId[] = $hostesBolgee['BSBolgeID'];
                                $a++;
                            }

                            //araca ait bölge varmı(kesin oalcak arac a bölge seçtirmeden ekletmiyoruz
                            $hostesCountBolge = count($hostesbolgeId);
                            if ($hostesCountBolge > 0) {
                                $hostesbolgedizi = implode(',', $hostesbolgeId);
                                //aracın bolgesi dışındakiler
                                $digerBolge = $Panel_Model->hostesDetailSBolge($hostesbolgedizi);
                                //arac diğer bölgeler
                                $b = 0;
                                foreach ($digerBolge as $digerBolgee) {
                                    $digerHostesBolge[$b]['DigerHostesBolgeID'] = $digerBolgee['SBBolgeID'];
                                    $digerHostesBolge[$b]['DigerHostesBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                    $b++;
                                }
                            }

                            //admin araç seçili hostes
                            $adminHostesArac = $Panel_Model->adminDetailHostesArac($hostesDetailID);
                            $hostesAracCount = count($adminHostesArac);
                            //eğer aracın seçili hostes varsa burası gelecek
                            if ($hostesAracCount > 0) {
                                //arac Hostes idler
                                $c = 0;
                                foreach ($adminHostesArac as $adminHostesAracc) {
                                    $selectHostesArac[$c]['SelectHostesAracID'] = $adminHostesAracc['BSAracID'];
                                    $selectHostesArac[$c]['SelectHostesAracPlaka'] = $adminHostesAracc['BSAracPlaka'];
                                    $hostesaracId[] = $adminHostesAracc['BSAracID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $hostesbolgedizim = implode(',', $hostesbolgeId);
                                //seöili olan arac
                                $hostesbolgearac = implode(',', $hostesaracId);
                                //adamın seçili olab bölgedeki diğer aracları
                                $adminHostesBolgeArac = $Panel_Model->adminSelectHostesBolge($hostesbolgedizim, $hostesbolgearac);

                                if (count($adminHostesBolgeArac) > 0) {
                                    $d = 0;
                                    foreach ($adminHostesBolgeArac as $adminHostesBolgeAracc) {
                                        $digerHostesArac[$d]['DigerHostesAracID'] = $adminHostesBolgeAracc['SBAracID'];
                                        $digerHostesArac[$d]['DigerHostesAracPlaka'] = $adminHostesBolgeAracc['SBAracPlaka'];
                                        $d++;
                                    }
                                }
                            } else {
                                //seçili olan bölge
                                $hostesbolgedizim = implode(',', $hostesbolgeId);
                                //adamın seçili olab bölgedeki diğer araçları
                                $adminHostesBolgeArac = $Panel_Model->adminSelectBolgeArac($hostesbolgedizim);

                                $d = 0;
                                foreach ($adminHostesBolgeArac as $adminHostesBolgeAracc) {
                                    $digerHostesArac[$d]['DigerHostesAracID'] = $adminHostesBolgeAracc['SBAracID'];
                                    $digerHostesArac[$d]['DigerHostesAracPlaka'] = $adminHostesBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }

                            //araç Özellikleri
                            $hostesOzellik = $Panel_Model->hostesDetail($hostesDetailID);
                            $e = 0;
                            foreach ($hostesOzellik as $hostesOzellikk) {
                                $hostesList[$e]['HostesListID'] = $hostesOzellikk['BSHostesID'];
                                $hostesList[$e]['HostesListAd'] = $hostesOzellikk['BSHostesAd'];
                                $hostesList[$e]['HostesListSoyad'] = $hostesOzellikk['BSHostesSoyad'];
                                $hostesList[$e]['HostesListTelefon'] = $hostesOzellikk['BSHostesPhone'];
                                $hostesList[$e]['HostesListMail'] = $hostesOzellikk['BSHostesEmail'];
                                $hostesList[$e]['HostesListLokasyon'] = $hostesOzellikk['BSHostesLocation'];
                                $hostesList[$e]['HostesListUlke'] = $hostesOzellikk['BSHostesUlke'];
                                $hostesList[$e]['HostesListIl'] = $hostesOzellikk['BSHostesIl'];
                                $hostesList[$e]['HostesListIlce'] = $hostesOzellikk['BSHostesIlce'];
                                $hostesList[$e]['HostesListSemt'] = $hostesOzellikk['BSHostesSemt'];
                                $hostesList[$e]['HostesListMahalle'] = $hostesOzellikk['BSHostesMahalle'];
                                $hostesList[$e]['HostesListSokak'] = $hostesOzellikk['BSHostesSokak'];
                                $hostesList[$e]['HostesListPostaKodu'] = $hostesOzellikk['BSHostesPostaKodu'];
                                $hostesList[$e]['HostesListCaddeNo'] = $hostesOzellikk['BSHostesCaddeNo'];
                                $hostesList[$e]['HostesListAdres'] = $hostesOzellikk['BSHostesAdres'];
                                $hostesList[$e]['HostesListDetayAdres'] = $hostesOzellikk['BSHostesDetayAdres'];
                                $hostesList[$e]['HostesListDurum'] = $hostesOzellikk['Status'];
                                $hostesList[$e]['HostesListAciklama'] = $hostesOzellikk['BSHostesAciklama'];
                                $e++;
                            }
                        } else {
                            $adminID = Session::get("userId");
                            //normal adminse
                            $form->post('hostesRowid', true);
                            $hostesDetailID = $form->values['hostesRowid'];

                            //küçük adminin olan bölgeleri
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            //bölge idler
                            $r = 0;
                            foreach ($bolgeListeRutbe as $bolgeListeRutbee) {
                                $bolgerutbeId[] = $bolgeListeRutbee['BSBolgeID'];
                                $r++;
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $hostesBolge = $Panel_Model->adminDetailHostesBolge($hostesDetailID);

                            //arac bölge idler
                            //arac bölge idler
                            $a = 0;
                            foreach ($hostesBolge as $hostesBolgee) {
                                $selectHostesBolge[$a]['SelectHostesBolgeID'] = $hostesBolgee['BSBolgeID'];
                                $selectHostesBolge[$a]['SelectHostesBolgeAdi'] = $hostesBolgee['BSBolgeAdi'];
                                $hostesbolgeId[] = $hostesBolgee['BSBolgeID'];
                                $a++;
                            }

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz
                            $bolgefark = array_diff($bolgerutbeId, $hostesbolgeId);
                            $bolgefarkk = implode(',', $bolgefark);

                            //aracın bolgesi dışındakiler
                            $digerBolge = $Panel_Model->adminRutbeDetailAracSBolge($bolgefarkk);
                            //arac diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerHostesBolge[$b]['DigerHostesBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerHostesBolge[$b]['DigerHostesBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }

                            //admin araç seçili hostes
                            $adminHostesArac = $Panel_Model->adminDetailHostesArac($hostesDetailID);
                            $hostesAracCount = count($adminHostesArac);
                            //eğer aracın seçili hostes varsa burası gelecek
                            if ($hostesAracCount > 0) {
                                //arac Hostes idler
                                $c = 0;
                                foreach ($adminHostesArac as $adminHostesAracc) {
                                    $selectHostesArac[$c]['SelectHostesAracID'] = $adminHostesAracc['BSAracID'];
                                    $selectHostesArac[$c]['SelectHostesAracPlaka'] = $adminHostesAracc['BSAracPlaka'];
                                    $hostesaracId[] = $adminHostesAracc['BSAracID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $hostesbolgedizim = implode(',', $hostesbolgeId);
                                //seöili olan arac
                                $hostesbolgearac = implode(',', $hostesaracId);
                                //adamın seçili olab bölgedeki diğer aracları
                                $adminHostesBolgeArac = $Panel_Model->adminSelectHostesBolge($hostesbolgedizim, $hostesbolgearac);

                                if (count($adminHostesBolgeArac) > 0) {
                                    $d = 0;
                                    foreach ($adminHostesBolgeArac as $adminHostesBolgeAracc) {
                                        $digerHostesArac[$d]['DigerHostesAracID'] = $adminHostesBolgeAracc['SBAracID'];
                                        $digerHostesArac[$d]['DigerHostesAracPlaka'] = $adminHostesBolgeAracc['SBAracPlaka'];
                                        $d++;
                                    }
                                }
                            } else {
                                //seçili olan bölge
                                $hostesbolgedizim = implode(',', $hostesbolgeId);
                                //adamın seçili olab bölgedeki diğer araçları
                                $adminHostesBolgeArac = $Panel_Model->adminSelectBolgeArac($hostesbolgedizim);

                                $d = 0;
                                foreach ($adminHostesBolgeArac as $adminHostesBolgeAracc) {
                                    $digerHostesArac[$d]['DigerHostesAracID'] = $adminHostesBolgeAracc['SBAracID'];
                                    $digerHostesArac[$d]['DigerHostesAracPlaka'] = $adminHostesBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }

                            //araç Özellikleri
                            $hostesOzellik = $Panel_Model->hostesDetail($hostesDetailID);
                            $e = 0;
                            foreach ($hostesOzellik as $hostesOzellikk) {
                                $hostesList[$e]['HostesListID'] = $hostesOzellikk['BSHostesID'];
                                $hostesList[$e]['HostesListAd'] = $hostesOzellikk['BSHostesAd'];
                                $hostesList[$e]['HostesListSoyad'] = $hostesOzellikk['BSHostesSoyad'];
                                $hostesList[$e]['HostesListTelefon'] = $hostesOzellikk['BSHostesPhone'];
                                $hostesList[$e]['HostesListMail'] = $hostesOzellikk['BSHostesEmail'];
                                $hostesList[$e]['HostesListLokasyon'] = $hostesOzellikk['BSHostesLocation'];
                                $hostesList[$e]['HostesListUlke'] = $hostesOzellikk['BSHostesUlke'];
                                $hostesList[$e]['HostesListIl'] = $hostesOzellikk['BSHostesIl'];
                                $hostesList[$e]['HostesListIlce'] = $hostesOzellikk['BSHostesIlce'];
                                $hostesList[$e]['HostesListSemt'] = $hostesOzellikk['BSHostesSemt'];
                                $hostesList[$e]['HostesListMahalle'] = $hostesOzellikk['BSHostesMahalle'];
                                $hostesList[$e]['HostesListSokak'] = $hostesOzellikk['BSHostesSokak'];
                                $hostesList[$e]['HostesListPostaKodu'] = $hostesOzellikk['BSHostesPostaKodu'];
                                $hostesList[$e]['HostesListCaddeNo'] = $hostesOzellikk['BSHostesCaddeNo'];
                                $hostesList[$e]['HostesListAdres'] = $hostesOzellikk['BSHostesAdres'];
                                $hostesList[$e]['HostesListDetayAdres'] = $hostesOzellikk['BSHostesDetayAdres'];
                                $hostesList[$e]['HostesListDurum'] = $hostesOzellikk['Status'];
                                $hostesList[$e]['HostesListAciklama'] = $hostesOzellikk['BSHostesAciklama'];
                                $e++;
                            }
                        }
                        //sonuçlar
                        $sonuc["hostesSelectBolge"] = $selectHostesBolge;
                        $sonuc["hostesBolge"] = $digerHostesBolge;
                        $sonuc["hostesSelectArac"] = $selectHostesArac;
                        $sonuc["hostesArac"] = $digerHostesArac;
                        $sonuc["hostesDetail"] = $hostesList;
                    }

                    break;

                case "hostesDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AHostes';


                        $form->post('hostesdetail_id', true);
                        $hostesDetailID = $form->values['hostesdetail_id'];

                        $deleteresult = $Panel_Model->detailHostesDelete($hostesDetailID);
                        if ($deleteresult) {

                            $deleteresultt = $Panel_Model->detailHostesAracDelete($hostesDetailID);
                            if ($deleteresultt) {
                                $deleteresulttt = $Panel_Model->detailHostesBolgeDelete($hostesDetailID);
                                if ($deleteresulttt) {
                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Hostes kaydı başarıyla silinmiştir.";
                                }
                            } else {
                                $deleteresulttt = $Panel_Model->detailHostesBolgeDelete($hostesDetailID);
                                if ($deleteresulttt) {
                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Hostes kaydı başarıyla silinmiştir.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    break;

                case "hostesDetailKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('hostesdetail_id', true);
                        $hostesID = $form->values['hostesdetail_id'];

                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AHostes';

                        $form->post('hostesDetayAd', true);
                        $form->post('hostesDetaySoyad', true);
                        $form->post('hostesDetayEmail', true);
                        $form->post('hostesDetayDurum', true);
                        $form->post('hostesDetayLokasyon', true);
                        $form->post('hostesDetayTelefon', true);
                        $form->post('hostesDetayAdres', true);
                        $form->post('hostesDetayAciklama', true);
                        $form->post('hostesDetayUlke', true);
                        $form->post('hostesDetayIl', true);
                        $form->post('hostesDetayIlce', true);
                        $form->post('hostesDetaySemt', true);
                        $form->post('hostesDetayMahalle', true);
                        $form->post('hostesDetaySokak', true);
                        $form->post('hostesDetayPostaKodu', true);
                        $form->post('hostesDetayCaddeNo', true);
                        $form->post('detayAdres', true);

                        $hostesAd = $form->values['hostesDetayAd'];
                        $hostesSoyad = $form->values['hostesDetaySoyad'];
                        $hostesAdSoyad = $hostesAd . ' ' . $hostesSoyad;

                        $hostesBolgeID = $_REQUEST['hostesBolgeID'];
                        $hostesBolgeAdi = $_REQUEST['hostesBolgeAd'];
                        $hostesAracID = $_REQUEST['hostesAracID'];
                        $hostesAracPlaka = $_REQUEST['hostesAracPlaka'];

                        if ($form->submit()) {
                            $data = array(
                                'BSHostesAd' => $hostesAd,
                                'BSHostesSoyad' => $hostesSoyad,
                                'BSHostesPhone' => $form->values['hostesDetayTelefon'],
                                'BSHostesEmail' => $form->values['hostesDetayEmail'],
                                'BSHostesLocation' => $form->values['hostesDetayLokasyon'],
                                'BSHostesUlke' => $form->values['hostesDetayUlke'],
                                'BSHostesIl' => $form->values['hostesDetayIl'],
                                'BSHostesIlce' => $form->values['hostesDetayIlce'],
                                'BSHostesSemt' => $form->values['hostesDetaySemt'],
                                'BSHostesMahalle' => $form->values['hostesDetayMahalle'],
                                'BSHostesSokak' => $form->values['hostesDetaySokak'],
                                'BSHostesPostaKodu' => $form->values['hostesDetayPostaKodu'],
                                'BSHostesCaddeNo' => $form->values['hostesDetayCaddeNo'],
                                'BSHostesAdres' => $form->values['hostesDetayAdres'],
                                'BSHostesDetayAdres' => $form->values['detayAdres'],
                                'BSHostesAciklama' => $form->values['hostesDetayAciklama'],
                                'Status' => $form->values['hostesDetayDurum']
                            );
                        }
                        $resultHostesUpdate = $Panel_Model->hostesOzelliklerDuzenle($data, $hostesID);
                        if ($resultHostesUpdate) {
                            $aracID = count($hostesAracID);
                            if ($aracID > 0) {
                                $deleteresultt = $Panel_Model->adminHostesAracDelete($hostesID);
                                for ($a = 0; $a < $aracID; $a++) {
                                    $hostesdata[$a] = array(
                                        'BSAracID' => $hostesAracID[$a],
                                        'BSAracPlaka' => $hostesAracPlaka[$a],
                                        'BSHostesID' => $hostesID,
                                        'BSHostesAd' => $hostesAdSoyad
                                    );
                                }
                                $resultHostesUpdate = $Panel_Model->addNewHostesArac($hostesdata);
                                if ($resultHostesUpdate) {
                                    $bolgeID = count($hostesBolgeID);
                                    $deleteresulttt = $Panel_Model->adminDetailHostesBolgeDelete($bolgeID);
                                    if ($deleteresulttt) {
                                        for ($b = 0; $b < $bolgeID; $b++) {
                                            $bolgedata[$b] = array(
                                                'BSHostesID' => $hostesID,
                                                'BSHostesAd' => $hostesAdSoyad,
                                                'BSBolgeID' => $hostesBolgeID[$b],
                                                'BSBolgeAdi' => $hostesBolgeAdi[$b]
                                            );
                                        }
                                        $resultBolgeID = $Panel_Model->addNewHostesBolge($bolgedata);
                                        if ($resultBolgeID) {
                                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                                            if ($resultMemcache) {
                                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                            }

                                            $sonuc["newHostesID"] = $hostesID;
                                            $sonuc["update"] = "Başarıyla Hostes Düzenlenmiştir.";
                                        } else {
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            } else {
                                $deleteresultt = $Panel_Model->adminHostesAracDelete($hostesID);
                                $deleteresulttt = $Panel_Model->adminDetailHostesBolgeDelete($hostesID);
                                if ($deleteresulttt) {
                                    $bolgeID = count($hostesBolgeID);
                                    for ($b = 0; $b < $bolgeID; $b++) {
                                        $bolgedata[$b] = array(
                                            'BSHostesID' => $hostesID,
                                            'BSHostesAd' => $hostesAdSoyad,
                                            'BSBolgeID' => $hostesBolgeID[$b],
                                            'BSBolgeAdi' => $hostesBolgeAdi[$b]
                                        );
                                    }
                                    $resultBolgeID = $Panel_Model->addNewHostesBolge($bolgedata);
                                    if ($resultBolgeID) {
                                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                                        if ($resultMemcache) {
                                            $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                        }

                                        $sonuc["newHostesID"] = $hostesID;
                                        $sonuc["update"] = "Başarıyla Hostes Düzenlenmiştir.";
                                    } else {
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                case "hostesDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $hostesDetailBolgeID = $_REQUEST['hostesDetailBolgeID'];
                        $form->post('hostesID', true);
                        $hostesID = $form->values['hostesID'];

                        //hostese ait araçlar
                        $adminHostesArac = $Panel_Model->hostesDetailMultiSelectHostes($hostesID);
                        if (count($adminHostesArac) > 0) {
                            $a = 0;
                            foreach ($adminHostesArac as $adminHostesAracc) {
                                $hostesaracId[] = $adminHostesAracc['BSAracID'];
                                $a++;
                            }
                            //hostese ait araçlar
                            $hostesbolgearac = implode(',', $hostesaracId);
                            //seçilen bölgeler
                            $hostesbolgedizim = implode(',', $hostesDetailBolgeID);
                            //seçilen bölgedeki araçlar
                            $HostesBolgeArac = $Panel_Model->adminSelectBolgeAracc($hostesbolgedizim);
                            $b = 0;
                            foreach ($HostesBolgeArac as $HostesBolgeAracc) {
                                $hostesDigerAracId[] = $HostesBolgeAracc['SBAracID'];
                                $b++;
                            }
                            //gelen arac ıdlerinde aynı olan idler, seçili araçlardır.
                            $ortakIDler = array_intersect($hostesaracId, $hostesDigerAracId);
                            //gelen idlerde ki farklı olanlar seçili olmayan araçlardır yani diğer araçlar
                            $arac_fark = array_diff($hostesDigerAracId, $hostesaracId);
                            $diger_arac_fark = implode(',', $arac_fark);

                            //ortak ıd ye sahip arac varmı
                            if (count($ortakIDler) > 0) {
                                //seçili araçlar
                                error_log(count($ortakIDler));
                                $secilenIdArac = implode(',', $ortakIDler);
                                $selectBolgeArac = $Panel_Model->hostesNotSelectArac($secilenIdArac);
                                $c = 0;
                                foreach ($selectBolgeArac as $selectBolgeAracc) {
                                    $selectHostesArac[$c]['SelectHostesAracID'] = $selectBolgeAracc['SBAracID'];
                                    $selectHostesArac[$c]['SelectHostesAracPlaka'] = $selectBolgeAracc['SBAracPlaka'];
                                    $c++;
                                }

                                //diğer hostes
                                $digerBolgeArac = $Panel_Model->hostesNotSelectArac($diger_arac_fark);

                                $d = 0;
                                foreach ($digerBolgeArac as $digerBolgeAracc) {
                                    $digerHostesArac[$d]['DigerHostesAracID'] = $digerBolgeAracc['SBAracID'];
                                    $digerHostesArac[$d]['DigerHostesAracPlaka'] = $digerBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili hostes yoktur
                                //diğer hostesler
                                $digerBolgeArac = $Panel_Model->hostesNotSelectArac($diger_arac_fark);

                                $d = 0;
                                foreach ($digerBolgeArac as $digerBolgeAracc) {
                                    $digerHostesArac[$d]['DigerHostesAracID'] = $digerBolgeAracc['SBAracID'];
                                    $digerHostesArac[$d]['DigerHostesAracPlaka'] = $digerBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }
                        } else {
                            $hostesDetailBollgeID = implode(',', $hostesDetailBolgeID);
                            //adamın seçili olan bölgedeki diğer hostesleri
                            $adminAracBolgeHostes = $Panel_Model->adminSelectBolgeAracc($hostesDetailBollgeID);

                            $d = 0;
                            foreach ($adminAracBolgeHostes as $adminAracBolgeHostess) {
                                $digerHostesArac[$d]['DigerHostesAracID'] = $adminAracBolgeHostess['SBAracID'];
                                $digerHostesArac[$d]['DigerHostesAracPlaka'] = $adminAracBolgeHostess['SBAracPlaka'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminHostesSelectArac"] = $selectHostesArac;
                        $sonuc["adminHostesArac"] = $digerHostesArac;
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

