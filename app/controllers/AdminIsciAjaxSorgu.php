<?php

class AdminIsciAjaxSorgu extends Controller {

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
                case "isciEkleSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            //bölgeleri getirir
                            $bolgeListe = $Panel_Model->isciNewBolgeListele();

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

                case "isciKurumMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $isciBolgeID = $_REQUEST['isciBolgeID'];
                        $multiiscidizi = implode(',', $isciBolgeID);

                        $kurumListe = $Panel_Model->isciKurumMultiSelect($multiiscidizi);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $isciKurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $isciKurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $a++;
                        }
                        $sonuc["kurumMultiSelect"] = $isciKurumSelect;
                    }
                    break;

                case "isciKaydet":

                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $userTip = 5;

                        $firmaID = Session::get("FirmaId");

                        $userKadi = $form->kadiOlustur($firmaID);
                        if ($userKadi) {
                            $realSifre = $form->sifreOlustur();
                            if ($realSifre) {
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $uniqueKey = Session::get("username");
                                    $uniqueKey = $uniqueKey . '_AIsci';

                                    $form->post('isciAd', true);
                                    $form->post('isciSoyad', true);
                                    $form->post('isciEmail', true);
                                    $form->post('isciDurum', true);
                                    $form->post('isciLokasyon', true);
                                    $form->post('isciTelefon', true);
                                    $form->post('isciAdres', true);
                                    $form->post('aciklama', true);
                                    $form->post('ulke', true);
                                    $form->post('il', true);
                                    $form->post('ilce', true);
                                    $form->post('semt', true);
                                    $form->post('mahalle', true);
                                    $form->post('sokak', true);
                                    $form->post('postakodu', true);
                                    $form->post('caddeno', true);

                                    $isciAd = $form->values['isciAd'];
                                    $isciSoyad = $form->values['isciSoyad'];
                                    $isciAdSoyad = $isciAd . ' ' . $isciSoyad;

                                    $isciBolgeID = $_REQUEST['isciBolgeID'];
                                    $isciBolgeAdi = $_REQUEST['isciBolgeAdi'];
                                    $isciKurumID = $_REQUEST['isciKurumID'];
                                    $isciKurumAd = $_REQUEST['isciKurumAd'];

                                    if ($form->submit()) {
                                        $data = array(
                                            'SBIsciAd' => $isciAd,
                                            'SBIsciSoyad' => $isciSoyad,
                                            'SBIsciKadi' => $userKadi,
                                            'SBIsciSifre' => $adminSifre,
                                            'SBIsciRSifre' => $realSifre,
                                            'SBIsciPhone' => $form->values['isciTelefon'],
                                            'SBIsciEmail' => $form->values['isciEmail'],
                                            'SBIsciLocation' => $form->values['isciLokasyon'],
                                            'SBIsciUlke' => $form->values['ulke'],
                                            'SBIsciIl' => $form->values['il'],
                                            'SBIsciIlce' => $form->values['ilce'],
                                            'SBIsciSemt' => $form->values['semt'],
                                            'SBIsciMahalle' => $form->values['mahalle'],
                                            'SBIsciSokak' => $form->values['sokak'],
                                            'SBIsciPostaKodu' => $form->values['postakodu'],
                                            'SBIsciCaddeNo' => $form->values['caddeno'],
                                            'SBIsciAdres' => $form->values['isciAdres'],
                                            'Status' => $form->values['isciDurum'],
                                            'SBIsciAciklama' => $form->values['aciklama']
                                        );
                                    }
                                    $resultIsciID = $Panel_Model->addNewIsci($data);

                                    if ($resultIsciID != 'unique') {
                                        $bolgeID = count($isciBolgeID);
                                        if ($bolgeID > 0) {
                                            for ($b = 0; $b < $bolgeID; $b++) {
                                                $bolgedata[$b] = array(
                                                    'SBIsciID' => $resultIsciID,
                                                    'SBIsciAd' => $isciAdSoyad,
                                                    'SBBolgeID' => $isciBolgeID[$b],
                                                    'SBBolgeAd' => $isciBolgeAdi[$b]
                                                );
                                            }
                                            $resultBolgeID = $Panel_Model->addNewBolgeIsci($bolgedata);
                                            if ($resultBolgeID) {
                                                //işçiye kuurm seçildi ise
                                                $kurumID = count($isciKurumID);
                                                if ($kurumID > 0) {
                                                    for ($c = 0; $c < $kurumID; $c++) {
                                                        $kurumdata[$c] = array(
                                                            'SBKurumID' => $isciKurumID[$c],
                                                            'SBKurumAd' => $isciKurumAd[$c],
                                                            'SBIsciID' => $resultIsciID,
                                                            'SBIsciAd' => $isciAdSoyad
                                                        );
                                                    }

                                                    $resultKurumID = $Panel_Model->addNewIsciKurum($kurumdata);
                                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newIsciID"] = $resultIsciID;
                                                    $sonuc["insert"] = "Başarıyla İşçi Eklenmiştir.";
                                                } else {
                                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                                    if ($resultMemcache) {
                                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                                    }

                                                    $sonuc["newIsciID"] = $resultIsciID;
                                                    $sonuc["insert"] = "Başarıyla İşçi Eklenmiştir.";
                                                }
                                            } else {
                                                //işçi kaydedilirken hata geldi ise
                                                $deleteresult = $Panel_Model->isciDelete($resultIsciID);

                                                if ($deleteresult) {
                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                                }
                                            }
                                        } else {
                                            //eğer şoförün bölgesi yoksa
                                            $deleteresult = $Panel_Model->isciDelete($resultIsciID);
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

                case "isciDetail":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('isciRowid', true);
                            $isciDetailID = $form->values['isciRowid'];

                            $isciBolge = $Panel_Model->isciDetailBolge($isciDetailID);
                            //işçi bölge idler
                            $a = 0;
                            foreach ($isciBolge as $isciBolgee) {
                                $selectIsciBolge[$a]['SelectIsciBolgeID'] = $isciBolgee['SBBolgeID'];
                                $selectIsciBolge[$a]['SelectIsciBolgeAdi'] = $isciBolgee['SBBolgeAd'];
                                $iscibolgeId[] = $isciBolgee['SBBolgeID'];
                                $a++;
                            }

                            //işçiye ait bölge varmı(kesin oalcak işçiye a bölge seçtirmeden ekletmiyoruz
                            $isciCountBolge = count($iscibolgeId);
                            if ($isciCountBolge > 0) {
                                $iscibolgedizi = implode(',', $iscibolgeId);
                                //işçinin bolgesi dışındakiler
                                $digerBolge = $Panel_Model->isciDetailSBolge($iscibolgedizi);
                                //işçi diğer bölgeler
                                $b = 0;
                                foreach ($digerBolge as $digerBolgee) {
                                    $digerIsciBolge[$b]['DigerIsciBolgeID'] = $digerBolgee['SBBolgeID'];
                                    $digerIsciBolge[$b]['DigerIsciBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                    $b++;
                                }
                            }

                            // işçi seçili kurum
                            $adminIsciKurum = $Panel_Model->adminDetailIsciKurum($isciDetailID);
                            $isciKurumCount = count($adminIsciKurum);
                            //eğer işçinin seçili kurumu varsa burası gelecek
                            if ($isciKurumCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminIsciKurum as $adminIsciKurumm) {
                                    $selectIsciKurum[$c]['SelectIsciKurumID'] = $adminIsciKurumm['SBKurumID'];
                                    $selectIsciKurum[$c]['SelectIsciKurumAd'] = $adminIsciKurumm['SBKurumAd'];
                                    $iscikurumId[] = $adminIsciKurumm['SBKurumID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $iscibolgedizim = implode(',', $iscibolgeId);
                                //seçili olan kurum
                                $iscibolgekurum = implode(',', $iscikurumId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminIsciBolgeKurum = $Panel_Model->adminSelectIsciBolge($iscibolgedizim, $iscibolgekurum);

                                if (count($adminIsciBolgeKurum) > 0) {
                                    $d = 0;
                                    foreach ($adminIsciBolgeKurum as $adminIsciBolgeKurumm) {
                                        $digerIsciKurum[$d]['DigerIsciKurumID'] = $adminIsciBolgeKurumm['SBKurumID'];
                                        $digerIsciKurum[$d]['DigerIsciKurumAd'] = $adminIsciBolgeKurumm['SBKurumAdi'];
                                        $d++;
                                    }
                                }
                            } else {
                                //seçili olan bölge
                                $iscibolgedizim = implode(',', $iscibolgeId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminIsciBolgeKurum = $Panel_Model->adminSelectBolgeKurum($iscibolgedizim);

                                $d = 0;
                                foreach ($adminIsciBolgeKurum as $adminIsciBolgeKurumm) {
                                    $digerIsciKurum[$d]['DigerIsciKurumID'] = $adminIsciBolgeKurumm['SBKurumID'];
                                    $digerIsciKurum[$d]['DigerIsciKurumAd'] = $adminIsciBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            }

                            //işçi Özellikleri
                            $isciOzellik = $Panel_Model->isciDetail($isciDetailID);
                            $e = 0;
                            foreach ($isciOzellik as $isciOzellikk) {
                                $isciList[$e]['IsciListID'] = $isciOzellikk['SBIsciID'];
                                $isciList[$e]['IsciListAd'] = $isciOzellikk['SBIsciAd'];
                                $isciList[$e]['IsciListSoyad'] = $isciOzellikk['SBIsciSoyad'];
                                $isciList[$e]['IsciListTelefon'] = $isciOzellikk['SBIsciPhone'];
                                $isciList[$e]['IsciListMail'] = $isciOzellikk['SBIsciEmail'];
                                $isciList[$e]['IsciListLokasyon'] = $isciOzellikk['SBIsciLocation'];
                                $isciList[$e]['IsciListUlke'] = $isciOzellikk['SBIsciUlke'];
                                $isciList[$e]['IsciListIl'] = $isciOzellikk['SBIsciIl'];
                                $isciList[$e]['IsciListIlce'] = $isciOzellikk['SBIsciIlce'];
                                $isciList[$e]['IsciListSemt'] = $isciOzellikk['SBIsciSemt'];
                                $isciList[$e]['IsciListMahalle'] = $isciOzellikk['SBIsciMahalle'];
                                $isciList[$e]['IsciListSokak'] = $isciOzellikk['SBIsciSokak'];
                                $isciList[$e]['IsciListPostaKodu'] = $isciOzellikk['SBIsciPostaKodu'];
                                $isciList[$e]['IsciListCaddeNo'] = $isciOzellikk['SBIsciCaddeNo'];
                                $isciList[$e]['IsciListAdres'] = $isciOzellikk['SBIsciAdres'];
                                $isciList[$e]['IsciListDurum'] = $isciOzellikk['Status'];
                                $isciList[$e]['IsciListAciklama'] = $isciOzellikk['SBIsciAciklama'];
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


                            $isciBolge = $Panel_Model->isciDetailBolge($isciDetailID);

                            //işçi bölge idler
                            $a = 0;
                            foreach ($isciBolge as $isciBolgee) {
                                $selectIsciBolge[$a]['SelectIsciBolgeID'] = $isciBolgee['SBBolgeID'];
                                $selectIsciBolge[$a]['SelectIsciBolgeAdi'] = $isciBolgee['SBBolgeAd'];
                                $iscibolgeId[] = $isciBolgee['SBBolgeID'];
                                $a++;
                            }

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz
                            $bolgefark = array_diff($bolgerutbeId, $iscibolgeId);
                            $bolgefarkk = implode(',', $bolgefark);

                            //kurumun dılşındaki bölgeler
                            $digerBolge = $Panel_Model->isciDetailSBolge($bolgefarkk);
                            //işçi diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerIsciBolge[$b]['DigerIsciBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerIsciBolge[$b]['DigerIsciBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }

                            // işçi seçili kurum
                            $adminIsciKurum = $Panel_Model->adminDetailIsciKurum($isciDetailID);
                            $isciKurumCount = count($adminIsciKurum);
                            //eğer işçinin seçili kurumu varsa burası gelecek
                            if ($isciKurumCount > 0) {
                                //arac Şofor idler
                                $c = 0;
                                foreach ($adminIsciKurum as $adminIsciKurumm) {
                                    $selectIsciKurum[$c]['SelectIsciKurumID'] = $adminIsciKurumm['SBKurumID'];
                                    $selectIsciKurum[$c]['SelectIsciKurumAd'] = $adminIsciKurumm['SBKurumAd'];
                                    $iscikurumId[] = $adminIsciKurumm['SBKurumID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $iscibolgedizim = implode(',', $iscibolgeId);
                                //seçili olan kurum
                                $iscibolgekurum = implode(',', $iscikurumId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminIsciBolgeKurum = $Panel_Model->adminSelectIsciBolge($iscibolgedizim, $iscibolgekurum);

                                if (count($adminIsciBolgeKurum) > 0) {
                                    $d = 0;
                                    foreach ($adminIsciBolgeKurum as $adminIsciBolgeKurumm) {
                                        $digerIsciKurum[$d]['DigerIsciKurumID'] = $adminIsciBolgeKurumm['SBKurumID'];
                                        $digerIsciKurum[$d]['DigerIsciKurumAd'] = $adminIsciBolgeKurumm['SBKurumAdi'];
                                        $d++;
                                    }
                                }
                            } else {
                                //seçili olan bölge
                                $iscibolgedizim = implode(',', $iscibolgeId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminIsciBolgeKurum = $Panel_Model->adminSelectBolgeKurum($iscibolgedizim);

                                $d = 0;
                                foreach ($adminIsciBolgeKurum as $adminIsciBolgeKurumm) {
                                    $digerIsciKurum[$d]['DigerIsciKurumID'] = $adminIsciBolgeKurumm['SBKurumID'];
                                    $digerIsciKurum[$d]['DigerIsciKurumAd'] = $adminIsciBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            }
                            //işçi Özellikleri
                            $isciOzellik = $Panel_Model->isciDetail($isciDetailID);
                            $e = 0;
                            foreach ($isciOzellik as $isciOzellikk) {
                                $isciList[$e]['IsciListID'] = $isciOzellikk['SBIsciID'];
                                $isciList[$e]['IsciListAd'] = $isciOzellikk['SBIsciAd'];
                                $isciList[$e]['IsciListSoyad'] = $isciOzellikk['SBIsciSoyad'];
                                $isciList[$e]['IsciListTelefon'] = $isciOzellikk['SBIsciPhone'];
                                $isciList[$e]['IsciListMail'] = $isciOzellikk['SBIsciEmail'];
                                $isciList[$e]['IsciListLokasyon'] = $isciOzellikk['SBIsciLocation'];
                                $isciList[$e]['IsciListUlke'] = $isciOzellikk['SBIsciUlke'];
                                $isciList[$e]['IsciListIl'] = $isciOzellikk['SBIsciIl'];
                                $isciList[$e]['IsciListIlce'] = $isciOzellikk['SBIsciIlce'];
                                $isciList[$e]['IsciListSemt'] = $isciOzellikk['SBIsciSemt'];
                                $isciList[$e]['IsciListMahalle'] = $isciOzellikk['SBIsciMahalle'];
                                $isciList[$e]['IsciListSokak'] = $isciOzellikk['SBIsciSokak'];
                                $isciList[$e]['IsciListPostaKodu'] = $isciOzellikk['SBIsciPostaKodu'];
                                $isciList[$e]['IsciListCaddeNo'] = $isciOzellikk['SBIsciCaddeNo'];
                                $isciList[$e]['IsciListAdres'] = $isciOzellikk['SBIsciAdres'];
                                $isciList[$e]['IsciListDurum'] = $isciOzellikk['Status'];
                                $isciList[$e]['IsciListAciklama'] = $isciOzellikk['SBIsciAciklama'];
                                $e++;
                            }
                        }
                        //sonuçlar
                        $sonuc["isciSelectBolge"] = $selectIsciBolge;
                        $sonuc["isciBolge"] = $digerIsciBolge;
                        $sonuc["isciSelectKurum"] = $selectIsciKurum;
                        $sonuc["isciKurum"] = $digerIsciKurum;
                        $sonuc["isciDetail"] = $isciList;
                    }

                    break;

                case "isciDetailDelete":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AIsci';


                        $form->post('iscidetail_id', true);
                        $isciDetailID = $form->values['iscidetail_id'];

                        $deleteresult = $Panel_Model->detailIsciDelete($isciDetailID);
                        if ($deleteresult) {

                            $deleteresultt = $Panel_Model->detailIsciKurumDelete($isciDetailID);
                            if ($deleteresultt) {
                                $deleteresulttt = $Panel_Model->detailIsciBolgeDelete($isciDetailID);
                                if ($deleteresulttt) {
                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "İşçi kaydı başarıyla silinmiştir.";
                                }
                            } else {
                                $deleteresulttt = $Panel_Model->detailIsciBolgeDelete($isciDetailID);
                                if ($deleteresulttt) {
                                    $uniquePanelKey = Session::get("userFirmaKod") . '_APanel' . $adminID;
                                    $resultDeletee = $MemcacheModel->deleteKey($uniquePanelKey);
                                    $resultMemcache = $MemcacheModel->get($uniqueKey);
                                    if ($resultMemcache) {
                                        $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                    }
                                    $sonuc["delete"] = "İşçi kaydı başarıyla silinmiştir.";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    }

                    $sonuc["isciDetail"] = $data["isciDetail"];

                    break;

                case "isciDetailKaydet":

                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('iscidetail_id', true);
                        $isciID = $form->values['iscidetail_id'];

                        $uniqueKey = Session::get("username");
                        $uniqueKey = $uniqueKey . '_AIsci';

                        $form->post('isciDetayAd', true);
                        $form->post('isciDetaySoyad', true);
                        $form->post('isciDetayEmail', true);
                        $form->post('isciDetayDurum', true);
                        $form->post('isciDetayLokasyon', true);
                        $form->post('isciDetayTelefon', true);
                        $form->post('isciDetayAdres', true);
                        $form->post('isciDetayAciklama', true);
                        $form->post('isciDetayUlke', true);
                        $form->post('isciDetayIl', true);
                        $form->post('isciDetayIlce', true);
                        $form->post('isciDetaySemt', true);
                        $form->post('isciDetayMahalle', true);
                        $form->post('isciDetaySokak', true);
                        $form->post('isciDetayPostaKodu', true);
                        $form->post('isciDetayCaddeNo', true);

                        $isciAd = $form->values['isciDetayAd'];
                        $isciSoyad = $form->values['isciDetaySoyad'];
                        $isciAdSoyad = $isciAd . ' ' . $isciSoyad;

                        $isciBolgeID = $_REQUEST['isciBolgeID'];
                        $isciBolgeAdi = $_REQUEST['isciBolgeAd'];
                        $isciKurumID = $_REQUEST['isciKurumID'];
                        $isciKurumAd = $_REQUEST['isciKurumAd'];

                        if ($form->submit()) {
                            $data = array(
                                'SBIsciAd' => $isciAd,
                                'SBIsciSoyad' => $isciSoyad,
                                'SBIsciPhone' => $form->values['isciDetayTelefon'],
                                'SBIsciEmail' => $form->values['isciDetayEmail'],
                                'SBIsciLocation' => $form->values['isciDetayLokasyon'],
                                'SBIsciUlke' => $form->values['isciDetayUlke'],
                                'SBIsciIl' => $form->values['isciDetayIl'],
                                'SBIsciIlce' => $form->values['isciDetayIlce'],
                                'SBIsciSemt' => $form->values['isciDetaySemt'],
                                'SBIsciMahalle' => $form->values['isciDetayMahalle'],
                                'SBIsciSokak' => $form->values['isciDetaySokak'],
                                'SBIsciPostaKodu' => $form->values['isciDetayPostaKodu'],
                                'SBIsciCaddeNo' => $form->values['isciDetayCaddeNo'],
                                'SBIsciAdres' => $form->values['isciDetayAdres'],
                                'SBIsciAciklama' => $form->values['isciDetayAciklama'],
                                'Status' => $form->values['isciDetayDurum']
                            );
                        }
                        $resultIsciUpdate = $Panel_Model->isciOzelliklerDuzenle($data, $isciID);
                        if ($resultIsciUpdate) {
                            $isciKurumCount = count($isciKurumID);
                            if ($isciKurumCount > 0) {
                                $deleteresultt = $Panel_Model->detailIsciKurumDelete($isciID);
                                for ($a = 0; $a < $isciKurumCount; $a++) {
                                    $iscidata[$a] = array(
                                        'SBKurumID' => $isciKurumID[$a],
                                        'SBKurumAd' => $isciKurumAd[$a],
                                        'SBIsciID' => $isciID,
                                        'SBIsciAd' => $isciAdSoyad
                                    );
                                }
                                $resultIsciUpdatee = $Panel_Model->addNewIsciKurum($iscidata);
                                if ($resultIsciUpdatee) {
                                    $bolgeID = count($isciBolgeID);
                                    $deleteresulttt = $Panel_Model->detailIsciBolgeDelete($isciID);
                                    if ($deleteresulttt) {
                                        for ($b = 0; $b < $bolgeID; $b++) {
                                            $bolgedata[$b] = array(
                                                'SBIsciID' => $isciID,
                                                'SBIsciAd' => $isciAdSoyad,
                                                'SBBolgeID' => $isciBolgeID[$b],
                                                'SBBolgeAd' => $isciBolgeAdi[$b]
                                            );
                                        }
                                        $resultBolgeID = $Panel_Model->addNewBolgeIsci($bolgedata);
                                        if ($resultBolgeID) {
                                            $resultMemcache = $MemcacheModel->get($uniqueKey);
                                            if ($resultMemcache) {
                                                $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                            }

                                            $sonuc["newIsciID"] = $isciID;
                                            $sonuc["update"] = "Başarıyla İşçi Düzenlenmiştir.";
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
                                $deleteresultt = $Panel_Model->detailIsciKurumDelete($isciID);
                                $deleteresulttt = $Panel_Model->detailIsciBolgeDelete($isciID);
                                if ($deleteresulttt) {
                                    $bolgeID = count($isciBolgeID);
                                    for ($b = 0; $b < $bolgeID; $b++) {
                                        $bolgedata[$b] = array(
                                            'SBIsciID' => $isciID,
                                            'SBIsciAd' => $isciAdSoyad,
                                            'SBBolgeID' => $isciBolgeID[$b],
                                            'SBBolgeAd' => $isciBolgeAdi[$b]
                                        );
                                    }
                                    $resultBolgeID = $Panel_Model->addNewBolgeIsci($bolgedata);
                                    if ($resultBolgeID) {
                                        $resultMemcache = $MemcacheModel->get($uniqueKey);
                                        if ($resultMemcache) {
                                            $resultDelete = $MemcacheModel->deleteKey($uniqueKey);
                                        }

                                        $sonuc["newIsciID"] = $isciID;
                                        $sonuc["update"] = "Başarıyla İşçi Düzenlenmiştir.";
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

                case "IsciDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $isciDetailBolgeID = $_REQUEST['isciDetailBolgeID'];
                        $form->post('isciID', true);
                        $isciID = $form->values['isciID'];

                        //işçiye ait kurumlar
                        $adminIsciKurum = $Panel_Model->isciDetailMultiSelectIsci($isciID);
                        if (count($adminIsciKurum) > 0) {
                            $a = 0;
                            foreach ($adminIsciKurum as $adminIsciKurumm) {
                                $iscikurumId[] = $adminIsciKurumm['SBKurumID'];
                                $a++;
                            }
                            //işçiye ait kurumlar
                            $iscibolgekurum = implode(',', $iscikurumId);
                            //seçilen bölgeler
                            $iscibolgedizim = implode(',', $isciDetailBolgeID);
                            //seçilen bölgedeki kurumlar
                            $IsciBolgeKurum = $Panel_Model->adminSelectBolgeKurumm($iscibolgedizim);
                            $b = 0;
                            foreach ($IsciBolgeKurum as $IsciBolgeKurumm) {
                                $isciDigerKurumId[] = $IsciBolgeKurumm['SBKurumID'];
                                $b++;
                            }
                            //gelen kurum ıdlerinde aynı olan idler, seçili kurumlardır.
                            $ortakIDler = array_intersect($iscikurumId, $isciDigerKurumId);
                            //gelen idlerde ki farklı olanlar seçili olmayan kurumlardır yani diğer kurumlar
                            $kurum_fark = array_diff($isciDigerKurumId, $iscikurumId);
                            $diger_kurum_fark = implode(',', $kurum_fark);
                            //ortak ıd ye sahip kurum varmı
                            if (count($ortakIDler) > 0) {
                                //seçili kurumlar
                                $secilenIdKurum = implode(',', $ortakIDler);
                                $selectBolgeKurum = $Panel_Model->isciNotSelectKurum($secilenIdKurum);
                                $c = 0;
                                foreach ($selectBolgeKurum as $selectBolgeKurumm) {
                                    $selectIsciKurum[$c]['SelectIsciKurumID'] = $selectBolgeKurumm['SBKurumID'];
                                    $selectIsciKurum[$c]['SelectIsciKurumAd'] = $selectBolgeKurumm['SBKurumAdi'];
                                    $c++;
                                }

                                //diğer kurumlar
                                $digerBolgeKurum = $Panel_Model->isciNotSelectKurum($diger_kurum_fark);

                                $d = 0;
                                foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                    $digerIsciKurum[$d]['DigerIsciKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                    $digerIsciKurum[$d]['DigerIsciKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili kurum yoktur
                                //diğer kurumlar
                                $digerBolgeKurum = $Panel_Model->isciNotSelectKurum($diger_kurum_fark);

                                $d = 0;
                                foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                    $digerIsciKurum[$d]['DigerIsciKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                    $digerIsciKurum[$d]['DigerIsciKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            }
                        } else {
                            $isciDetailBollgeID = implode(',', $isciDetailBolgeID);
                            //adamın seçili olab bölgedeki diğer kurumları
                            $digerBolgeKurum = $Panel_Model->adminSelectBolgeKurumm($isciDetailBollgeID);

                            $d = 0;
                            foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                $digerIsciKurum[$d]['DigerIsciKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                $digerIsciKurum[$d]['DigerIsciKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminIsciSelectKurum"] = $selectIsciKurum;
                        $sonuc["adminIsciKurum"] = $digerIsciKurum;
                    }
                    break;
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL_LOGOUT);
        }
    }

}
?>

