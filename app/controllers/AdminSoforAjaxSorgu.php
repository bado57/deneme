<?php

class AdminSoforAjaxSorgu extends Controller {

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

                case "soforEkleSelect":
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
                        } else {
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $bolgeListe = $Panel_Model->soforRutbeBolgeListele($rutbebolgedizi);

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

                case "soforAracMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $aracBolgeID = $_REQUEST['soforBolgeID'];
                        $multisofordizi = implode(',', $aracBolgeID);

                        $soforBolgeListe = $Panel_Model->aracMultiSelectBolge($multisofordizi);
                        foreach ($soforBolgeListe as $soforBolgeListee) {
                            $aracrutbeId[] = $soforBolgeListee['SBAracID'];
                        }
                        $rutbearacdizi = implode(',', $aracrutbeId);
                        //bölgeleri getirir
                        $aracListe = $Panel_Model->aracMultiSelect($rutbearacdizi);

                        $a = 0;
                        foreach ($aracListe as $aracListee) {
                            $soforAracSelect['AracSelectID'][$a] = $aracListee['SBAracID'];
                            $soforAracSelect['AracSelectPlaka'][$a] = $aracListee['SBAracPlaka'];
                            $a++;
                        }
                        $sonuc["aracMultiSelect"] = $soforAracSelect;
                    }
                    break;

                case "soforKaydet":

                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $userTip = 2;

                        $firmaID = Session::get("FirmaId");

                        $userKadi = $form->kadiOlustur($firmaID);
                        if ($userKadi) {
                            $realSifre = $form->sifreOlustur();
                            if ($realSifre) {
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $uniqueKey = Session::get("username");
                                    $uniqueKey = $uniqueKey . '_ASofor';

                                    $form->post('soforAd', true);
                                    $form->post('soforSoyad', true);
                                    $form->post('soforEmail', true);
                                    $form->post('soforDurum', true);
                                    $form->post('soforLokasyon', true);
                                    $form->post('soforTelefon', true);
                                    $form->post('soforAdres', true);
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

                                    $soforAd = $form->values['soforAd'];
                                    $soforSoyad = $form->values['soforSoyad'];
                                    $soforAdSoyad = $soforAd . ' ' . $soforSoyad;

                                    $soforBolgeID = $_REQUEST['soforBolgeID'];
                                    $soforBolgeAdi = $_REQUEST['soforBolgeAdi'];
                                    $soforAracID = $_REQUEST['soforAracID'];
                                    $soforAracPlaka = $_REQUEST['soforAracPlaka'];

                                    if ($form->submit()) {
                                        $data = array(
                                            'BSSoforAd' => $soforAd,
                                            'BSSoforSoyad' => $soforSoyad,
                                            'BSSoforKadi' => $userKadi,
                                            'BSSoforSifre' => $adminSifre,
                                            'BSSoforRSifre' => $realSifre,
                                            'BSSoforPhone' => $form->values['soforTelefon'],
                                            'BSSoforEmail' => $form->values['soforEmail'],
                                            'BSSoforLocation' => $form->values['soforLokasyon'],
                                            'BSSoforUlke' => $form->values['ulke'],
                                            'BSSoforIl' => $form->values['il'],
                                            'BSSoforIlce' => $form->values['ilce'],
                                            'BSSoforSemt' => $form->values['semt'],
                                            'BSSoforMahalle' => $form->values['mahalle'],
                                            'BSSoforSokak' => $form->values['sokak'],
                                            'BSSoforPostaKodu' => $form->values['postakodu'],
                                            'BSSoforCaddeNo' => $form->values['caddeno'],
                                            'BSSoforAdres' => $form->values['soforAdres'],
                                            'BSSoforDetayAdres' => $form->values['detayAdres'],
                                            'Status' => $form->values['soforDurum'],
                                            'BSSoforAciklama' => $form->values['aciklama']
                                        );
                                    }
                                    $resultSoforID = $Panel_Model->addNewSofor($data);

                                    if ($resultSoforID != 'unique') {
                                        $bolgeID = count($soforBolgeID);
                                        if ($bolgeID > 0) {
                                            for ($b = 0; $b < $bolgeID; $b++) {
                                                $bolgedata[$b] = array(
                                                    'BSSoforID' => $resultSoforID,
                                                    'BSSoforAd' => $soforAdSoyad,
                                                    'BSBolgeID' => $soforBolgeID[$b],
                                                    'BSBolgeAdi' => $soforBolgeAdi[$b]
                                                );
                                            }
                                            $resultBolgeID = $Panel_Model->addNewBolgeSofor($bolgedata);
                                            if ($resultBolgeID) {
                                                //şoföre araç seçildi ise
                                                $aracID = count($soforAracID);
                                                if ($aracID > 0) {
                                                    for ($c = 0; $c < $aracID; $c++) {
                                                        $aracdata[$c] = array(
                                                            'BSAracID' => $soforAracID[$c],
                                                            'BSAracPlaka' => $soforAracPlaka[$c],
                                                            'BSSoforID' => $resultSoforID,
                                                            'BSSoforAd' => $soforAdSoyad
                                                        );
                                                    }

                                                    $resultAracID = $Panel_Model->addNewAracSofor($aracdata);

                                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newSoforID"] = $resultSoforID;
                                                    $sonuc["insert"] = "Başarıyla Şoför Eklenmiştir.";
                                                } else {
                                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newSoforID"] = $resultSoforID;
                                                    $sonuc["insert"] = "Başarıyla Şoför Eklenmiştir.";
                                                }
                                            } else {
                                                //admin kaydedilirken hata geldi ise
                                                $deleteresult = $Panel_Model->soforDelete($resultSoforID);

                                                if ($deleteresult) {
                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                                }
                                            }
                                        } else {
                                            //eğer şoförün bölgesi yoksa
                                            $deleteresult = $Panel_Model->soforDelete($resultSoforID);
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

                case "soforDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('soforRowid', true);
                            $soforDetailID = $form->values['soforRowid'];

                            $soforBolge = $Panel_Model->soforDetailBolge($soforDetailID);
                            //arac bölge idler
                            $a = 0;
                            foreach ($soforBolge as $soforBolgee) {
                                $selectSoforBolge[$a]['SelectSoforBolgeID'] = $soforBolgee['BSBolgeID'];
                                $selectSoforBolge[$a]['SelectSoforBolgeAdi'] = $soforBolgee['BSBolgeAdi'];
                                $soforbolgeId[] = $soforBolgee['BSBolgeID'];
                                $a++;
                            }

                            //araca ait bölge varmı(kesin oalcak arac a bölge seçtirmeden ekletmiyoruz
                            $soforCountBolge = count($soforbolgeId);
                            if ($soforCountBolge > 0) {
                                $soforbolgedizi = implode(',', $soforbolgeId);
                                //aracın bolgesi dışındakiler
                                $digerBolge = $Panel_Model->soforDetailSBolge($soforbolgedizi);
                                //arac diğer bölgeler
                                $b = 0;
                                foreach ($digerBolge as $digerBolgee) {
                                    $digerSoforBolge[$b]['DigerSoforBolgeID'] = $digerBolgee['SBBolgeID'];
                                    $digerSoforBolge[$b]['DigerSoforBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                    $b++;
                                }
                            }

                            //admin araç seçili şoför
                            $adminSoforArac = $Panel_Model->adminDetailSoforArac($soforDetailID);
                            $soforAracCount = count($adminSoforArac);
                            //eğer aracın seçili şoförü varsa burası gelecek
                            if ($soforAracCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminSoforArac as $adminSoforAracc) {
                                    $selectSoforArac[$c]['SelectSoforAracID'] = $adminSoforAracc['BSAracID'];
                                    $selectSoforArac[$c]['SelectSoforAracPlaka'] = $adminSoforAracc['BSAracPlaka'];
                                    $soforaracId[] = $adminSoforAracc['BSAracID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //seöili olan arac
                                $soforbolgearac = implode(',', $soforaracId);
                                //adamın seçili olab bölgedeki diğer aracları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectSoforBolge($soforbolgedizim, $soforbolgearac);

                                if (count($adminSoforBolgeArac) > 0) {
                                    $d = 0;
                                    foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                        $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                        $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                        $d++;
                                    }
                                }
                            } else {
                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //adamın seçili olab bölgedeki diğer araçları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectBolgeArac($soforbolgedizim);

                                $d = 0;
                                foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }

                            //araç Özellikleri
                            $soforOzellik = $Panel_Model->soforDetail($soforDetailID);
                            $e = 0;
                            foreach ($soforOzellik as $soforOzellikk) {
                                $soforList[$e]['SoforListID'] = $soforOzellikk['BSSoforID'];
                                $soforList[$e]['SoforListAd'] = $soforOzellikk['BSSoforAd'];
                                $soforList[$e]['SoforListSoyad'] = $soforOzellikk['BSSoforSoyad'];
                                $soforList[$e]['SoforListTelefon'] = $soforOzellikk['BSSoforPhone'];
                                $soforList[$e]['SoforListMail'] = $soforOzellikk['BSSoforEmail'];
                                $soforList[$e]['SoforListLokasyon'] = $soforOzellikk['BSSoforLocation'];
                                $soforList[$e]['SoforListUlke'] = $soforOzellikk['BSSoforUlke'];
                                $soforList[$e]['SoforListIl'] = $soforOzellikk['BSSoforIl'];
                                $soforList[$e]['SoforListIlce'] = $soforOzellikk['BSSoforIlce'];
                                $soforList[$e]['SoforListSemt'] = $soforOzellikk['BSSoforSemt'];
                                $soforList[$e]['SoforListMahalle'] = $soforOzellikk['BSSoforMahalle'];
                                $soforList[$e]['SoforListSokak'] = $soforOzellikk['BSSoforSokak'];
                                $soforList[$e]['SoforListPostaKodu'] = $soforOzellikk['BSSoforPostaKodu'];
                                $soforList[$e]['SoforListCaddeNo'] = $soforOzellikk['BSSoforCaddeNo'];
                                $soforList[$e]['SoforListAdres'] = $soforOzellikk['BSSoforAdres'];
                                $soforList[$e]['SoforListDetayAdres'] = $soforOzellikk['BSSoforDetayAdres'];
                                $soforList[$e]['SoforListDurum'] = $soforOzellikk['Status'];
                                $soforList[$e]['SoforListAciklama'] = $soforOzellikk['BSSoforAciklama'];
                                $e++;
                            }
                        } else {
                            $adminID = Session::get("userId");
                            //normal adminse
                            $form->post('soforRowid', true);
                            $soforDetailID = $form->values['soforRowid'];

                            //küçük adminin olan bölgeleri
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            //bölge idler
                            $r = 0;
                            foreach ($bolgeListeRutbe as $bolgeListeRutbee) {
                                $bolgerutbeId[] = $bolgeListeRutbee['BSBolgeID'];
                                $r++;
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $soforBolge = $Panel_Model->adminDetailSoforBolge($soforDetailID);

                            //arac bölge idler
                            //arac bölge idler
                            $a = 0;
                            foreach ($soforBolge as $soforBolgee) {
                                $selectSoforBolge[$a]['SelectSoforBolgeID'] = $soforBolgee['BSBolgeID'];
                                $selectSoforBolge[$a]['SelectSoforBolgeAdi'] = $soforBolgee['BSBolgeAdi'];
                                $soforbolgeId[] = $soforBolgee['BSBolgeID'];
                                $a++;
                            }

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz
                            $bolgefark = array_diff($bolgerutbeId, $soforbolgeId);
                            $bolgefarkk = implode(',', $bolgefark);

                            //aracın bolgesi dışındakiler
                            $digerBolge = $Panel_Model->adminRutbeDetailAracSBolge($bolgefarkk);
                            //arac diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerSoforBolge[$b]['DigerSoforBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerSoforBolge[$b]['DigerSoforBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }

                            //admin araç seçili şoför
                            $adminSoforArac = $Panel_Model->adminDetailSoforArac($soforDetailID);
                            $soforAracCount = count($adminSoforArac);
                            if ($soforAracCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminSoforArac as $adminSoforAracc) {
                                    $selectSoforArac[$c]['SelectSoforAracID'] = $adminSoforAracc['BSAracID'];
                                    $selectSoforArac[$c]['SelectSoforAracPlaka'] = $adminSoforAracc['BSAracPlaka'];
                                    $soforaracId[] = $adminSoforAracc['BSAracID'];
                                    $c++;
                                }

                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //seöili olan arac
                                $soforbolgearac = implode(',', $soforaracId);
                                //adamın seçili olab bölgedeki diğer aracları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectSoforBolge($soforbolgedizim, $soforbolgearac);

                                if (count($adminSoforBolgeArac) > 0) {
                                    $d = 0;
                                    foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                        $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                        $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                        $d++;
                                    }
                                }
                            } else {

                                //seçili olan bölge
                                $soforbolgedizim = implode(',', $soforbolgeId);
                                //adamın seçili olab bölgedeki diğer araçları
                                $adminSoforBolgeArac = $Panel_Model->adminSelectBolgeArac($rutbebolgedizi);

                                $d = 0;
                                foreach ($adminSoforBolgeArac as $adminSoforBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $adminSoforBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminSoforBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }
                            //araç Özellikleri
                            $soforOzellik = $Panel_Model->soforDetail($soforDetailID);
                            $e = 0;
                            foreach ($soforOzellik as $soforOzellikk) {
                                $soforList[$e]['SoforListID'] = $soforOzellikk['BSSoforID'];
                                $soforList[$e]['SoforListAd'] = $soforOzellikk['BSSoforAd'];
                                $soforList[$e]['SoforListSoyad'] = $soforOzellikk['BSSoforSoyad'];
                                $soforList[$e]['SoforListTelefon'] = $soforOzellikk['BSSoforPhone'];
                                $soforList[$e]['SoforListMail'] = $soforOzellikk['BSSoforEmail'];
                                $soforList[$e]['SoforListLokasyon'] = $soforOzellikk['BSSoforLocation'];
                                $soforList[$e]['SoforListUlke'] = $soforOzellikk['BSSoforUlke'];
                                $soforList[$e]['SoforListIl'] = $soforOzellikk['BSSoforIl'];
                                $soforList[$e]['SoforListIlce'] = $soforOzellikk['BSSoforIlce'];
                                $soforList[$e]['SoforListSemt'] = $soforOzellikk['BSSoforSemt'];
                                $soforList[$e]['SoforListMahalle'] = $soforOzellikk['BSSoforMahalle'];
                                $soforList[$e]['SoforListSokak'] = $soforOzellikk['BSSoforSokak'];
                                $soforList[$e]['SoforListPostaKodu'] = $soforOzellikk['BSSoforPostaKodu'];
                                $soforList[$e]['SoforListCaddeNo'] = $soforOzellikk['BSSoforCaddeNo'];
                                $soforList[$e]['SoforListAdres'] = $soforOzellikk['BSSoforAdres'];
                                $soforList[$e]['SoforListDetayAdres'] = $soforOzellikk['BSSoforDetayAdres'];
                                $soforList[$e]['SoforListDurum'] = $soforOzellikk['Status'];
                                $soforList[$e]['SoforListAciklama'] = $soforOzellikk['BSSoforAciklama'];
                                $e++;
                            }
                        }
                        //sonuçlar
                        $sonuc["soforSelectBolge"] = $selectSoforBolge;
                        $sonuc["soforBolge"] = $digerSoforBolge;
                        $sonuc["soforSelectArac"] = $selectSoforArac;
                        $sonuc["soforArac"] = $digerSoforArac;
                        $sonuc["soforDetail"] = $soforList;
                    }

                    break;

                case "soforDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_ASofor';


                        $form->post('sofordetail_id', true);
                        $soforDetailID = $form->values['sofordetail_id'];

                        $deleteresult = $Panel_Model->detailSoforDelete($soforDetailID);
                        if ($deleteresult) {

                            $deleteresultt = $Panel_Model->detailSoforAracDelete($soforDetailID);
                            if ($deleteresultt) {
                                $deleteresulttt = $Panel_Model->detailSoforBolgeDelete($soforDetailID);
                                if ($deleteresulttt) {
                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Şoför kaydı başarıyla silinmiştir.";
                                }
                            } else {
                                $deleteresulttt = $Panel_Model->detailSoforBolgeDelete($soforDetailID);
                                if ($deleteresulttt) {
                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "Şoför kaydı başarıyla silinmiştir.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["soforDetail"] = $data["soforDetail"];

                    break;

                case "soforDetailKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('sofordetail_id', true);
                        $soforID = $form->values['sofordetail_id'];

                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_ASofor';

                        $form->post('soforDetayAd', true);
                        $form->post('soforDetaySoyad', true);
                        $form->post('soforDetayEmail', true);
                        $form->post('soforDetayDurum', true);
                        $form->post('soforDetayLokasyon', true);
                        $form->post('soforDetayTelefon', true);
                        $form->post('soforDetayAdres', true);
                        $form->post('soforDetayAciklama', true);
                        $form->post('soforDetayUlke', true);
                        $form->post('soforDetayIl', true);
                        $form->post('soforDetayIlce', true);
                        $form->post('soforDetaySemt', true);
                        $form->post('soforDetayMahalle', true);
                        $form->post('soforDetaySokak', true);
                        $form->post('soforDetayPostaKodu', true);
                        $form->post('soforDetayCaddeNo', true);
                        $form->post('detayAdres', true);

                        $form->post('eskiAd', true);
                        $form->post('eskiSoyad', true);
                        $eskiAd = $form->values['eskiAd'];
                        $eskiSoyad = $form->values['eskiSoyad'];


                        $soforAd = $form->values['soforDetayAd'];
                        $soforSoyad = $form->values['soforDetaySoyad'];
                        $soforAdSoyad = $soforAd . ' ' . $soforSoyad;

                        $soforBolgeID = $_REQUEST['soforBolgeID'];
                        $soforBolgeAdi = $_REQUEST['soforBolgeAd'];
                        $soforAracID = $_REQUEST['soforAracID'];
                        $soforAracPlaka = $_REQUEST['soforAracPlaka'];

                        if ($form->submit()) {
                            $data = array(
                                'BSSoforAd' => $soforAd,
                                'BSSoforSoyad' => $soforSoyad,
                                'BSSoforPhone' => $form->values['soforDetayTelefon'],
                                'BSSoforEmail' => $form->values['soforDetayEmail'],
                                'BSSoforLocation' => $form->values['soforDetayLokasyon'],
                                'BSSoforUlke' => $form->values['soforDetayUlke'],
                                'BSSoforIl' => $form->values['soforDetayIl'],
                                'BSSoforIlce' => $form->values['soforDetayIlce'],
                                'BSSoforSemt' => $form->values['soforDetaySemt'],
                                'BSSoforMahalle' => $form->values['soforDetayMahalle'],
                                'BSSoforSokak' => $form->values['soforDetaySokak'],
                                'BSSoforPostaKodu' => $form->values['soforDetayPostaKodu'],
                                'BSSoforCaddeNo' => $form->values['soforDetayCaddeNo'],
                                'BSSoforAdres' => $form->values['soforDetayAdres'],
                                'BSSoforDetayAdres' => $form->values['detayAdres'],
                                'BSSoforAciklama' => $form->values['soforDetayAciklama'],
                                'Status' => $form->values['soforDetayDurum']
                            );
                        }
                        if ($ad != $eskiAd || $soyad != $eskiSoyad) {
                            $dataTur = array(
                                'BSTurSoforAd' => $adSoyad,
                            );
                            $dataBolge = array(
                                'BSSoforAd' => $adSoyad,
                            );
                            $dataArac = array(
                                'BSSoforAd' => $adSoyad,
                            );

                            $resultupdate1 = $Panel_Model->soforOzelliklerDuzenle1($dataTur, $soforID);
                            $resultupdate2 = $Panel_Model->soforOzelliklerDuzenle2($dataBolge, $soforID);
                            $resultupdate3 = $Panel_Model->soforOzelliklerDuzenle3($dataArac, $soforID);
                        }

                        $resultSoforUpdate = $Panel_Model->soforOzelliklerDuzenle($data, $soforID);
                        if ($resultSoforUpdate) {
                            $aracID = count($soforAracID);
                            if ($aracID > 0) {
                                $deleteresultt = $Panel_Model->adminSoforAracDelete($soforID);
                                for ($a = 0; $a < $aracID; $a++) {
                                    $sofordata[$a] = array(
                                        'BSAracID' => $soforAracID[$a],
                                        'BSAracPlaka' => $soforAracPlaka[$a],
                                        'BSSoforID' => $soforID,
                                        'BSSoforAd' => $soforAdSoyad
                                    );
                                }
                                $resultSoforUpdate = $Panel_Model->addNewSoforArac($sofordata);
                                if ($resultSoforUpdate) {
                                    $bolgeID = count($soforBolgeID);
                                    $deleteresulttt = $Panel_Model->adminDetailSoforBolgeDelete($bolgeID);
                                    if ($deleteresulttt) {
                                        for ($b = 0; $b < $bolgeID; $b++) {
                                            $bolgedata[$b] = array(
                                                'BSSoforID' => $soforID,
                                                'BSSoforAd' => $soforAdSoyad,
                                                'BSBolgeID' => $soforBolgeID[$b],
                                                'BSBolgeAdi' => $soforBolgeAdi[$b]
                                            );
                                        }
                                        $resultBolgeID = $Panel_Model->addNewSoforBolge($bolgedata);
                                        if ($resultBolgeID) {
                                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                                            if ($resultMemcache) {
                                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                            }

                                            $sonuc["newSoforID"] = $soforID;
                                            $sonuc["update"] = "Başarıyla Şoför Düzenlenmiştir.";
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
                                $deleteresultt = $Panel_Model->adminSoforAracDelete($soforID);
                                $deleteresulttt = $Panel_Model->adminDetailSoforBolgeDelete($soforID);
                                if ($deleteresulttt) {
                                    $bolgeID = count($soforBolgeID);
                                    for ($b = 0; $b < $bolgeID; $b++) {
                                        $bolgedata[$b] = array(
                                            'BSSoforID' => $soforID,
                                            'BSSoforAd' => $soforAdSoyad,
                                            'BSBolgeID' => $soforBolgeID[$b],
                                            'BSBolgeAdi' => $soforBolgeAdi[$b]
                                        );
                                    }
                                    $resultBolgeID = $Panel_Model->addNewSoforBolge($bolgedata);
                                    if ($resultBolgeID) {
                                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                                        if ($resultMemcache) {
                                            $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                        }

                                        $sonuc["newSoforID"] = $soforID;
                                        $sonuc["update"] = "Başarıyla Şoför Düzenlenmiştir.";
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

                case "SoforDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $soforDetailBolgeID = $_REQUEST['soforDetailBolgeID'];
                        $form->post('soforID', true);
                        $soforID = $form->values['soforID'];

                        //şoföre ait araçlar
                        $adminSoforArac = $Panel_Model->soforDetailMultiSelectSofor($soforID);
                        if (count($adminSoforArac) > 0) {
                            $a = 0;
                            foreach ($adminSoforArac as $adminSoforAracc) {
                                $soforaracId[] = $adminSoforAracc['BSAracID'];
                                $a++;
                            }
                            //şoföre ait araçlar
                            $soforbolgearac = implode(',', $soforaracId);
                            //seçilen bölgeler
                            $soforbolgedizim = implode(',', $soforDetailBolgeID);
                            //seçilen bölgedeki araçlar
                            $SoforBolgeArac = $Panel_Model->adminSelectBolgeAracc($soforbolgedizim);
                            $b = 0;
                            foreach ($SoforBolgeArac as $SoforBolgeAracc) {
                                $soforDigerAracId[] = $SoforBolgeAracc['SBAracID'];
                                $b++;
                            }
                            //gelen arac ıdlerinde aynı olan idler, seçili araçlardır.
                            $ortakIDler = array_intersect($soforaracId, $soforDigerAracId);
                            //gelen idlerde ki farklı olanlar seçili olmayan araçlardır yani diğer araçlar
                            $arac_fark = array_diff($soforDigerAracId, $soforaracId);
                            $diger_arac_fark = implode(',', $arac_fark);

                            //ortak ıd ye sahip arac varmı
                            if (count($ortakIDler) > 0) {
                                //seçili araçlar
                                $secilenIdArac = implode(',', $ortakIDler);
                                $selectBolgeArac = $Panel_Model->soforNotSelectArac($secilenIdArac);
                                $c = 0;
                                foreach ($selectBolgeArac as $selectBolgeAracc) {
                                    $selectSoforArac[$c]['SelectSoforAracID'] = $selectBolgeAracc['SBAracID'];
                                    $selectSoforArac[$c]['SelectSoforAracPlaka'] = $selectBolgeAracc['SBAracPlaka'];
                                    $c++;
                                }

                                //diğer şoförler
                                $digerBolgeArac = $Panel_Model->soforNotSelectArac($diger_arac_fark);

                                $d = 0;
                                foreach ($digerBolgeArac as $digerBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $digerBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $digerBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili şoför yoktur
                                //diğer şoförler
                                $digerBolgeArac = $Panel_Model->soforNotSelectArac($diger_arac_fark);

                                $d = 0;
                                foreach ($digerBolgeArac as $digerBolgeAracc) {
                                    $digerSoforArac[$d]['DigerSoforAracID'] = $digerBolgeAracc['SBAracID'];
                                    $digerSoforArac[$d]['DigerSoforAracPlaka'] = $digerBolgeAracc['SBAracPlaka'];
                                    $d++;
                                }
                            }
                        } else {
                            $soforDetailBollgeID = implode(',', $soforDetailBolgeID);
                            //adamın seçili olab bölgedeki diğer şoförleri
                            $adminAracBolgeSofor = $Panel_Model->adminSelectBolgeAracc($soforDetailBollgeID);

                            $d = 0;
                            foreach ($adminAracBolgeSofor as $adminAracBolgeSoforr) {
                                $digerSoforArac[$d]['DigerSoforAracID'] = $adminAracBolgeSoforr['SBAracID'];
                                $digerSoforArac[$d]['DigerSoforAracPlaka'] = $adminAracBolgeSoforr['SBAracPlaka'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminSoforSelectArac"] = $selectSoforArac;
                        $sonuc["adminSoforArac"] = $digerSoforArac;
                    }
                    break;

                case "adminSoforTakvim":

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
                    $adminSoforTakvim = $Panel_Model->adminSoforTakvim($id);
                    $a = 0;
                    foreach ($adminSoforTakvim as $adminSoforTakvimm) {
                        $tkvimID[$a] = $adminSoforTakvimm['BSTurID'];
                        $soforTkvim[$a]['Pzt'] = $adminSoforTakvimm['SBTurPzt'];
                        $soforTkvim[$a]['Sli'] = $adminSoforTakvimm['SBTurSli'];
                        $soforTkvim[$a]['Crs'] = $adminSoforTakvimm['SBTurCrs'];
                        $soforTkvim[$a]['Prs'] = $adminSoforTakvimm['SBTurPrs'];
                        $soforTkvim[$a]['Cma'] = $adminSoforTakvimm['SBTurCma'];
                        $soforTkvim[$a]['Cmt'] = $adminSoforTakvimm['SBTurCmt'];
                        $soforTkvim[$a]['Pzr'] = $adminSoforTakvimm['SBTurPzr'];
                        $soforTkvim[$a]['Bslngc'] = $adminSoforTakvimm['BSTurBslngc'];
                        $soforTkvim[$a]['Bts'] = $adminSoforTakvimm['BSTurBts'];
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

                    $sonuc = $input_arrays;
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

