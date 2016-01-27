<?php

class AdminVeliAjaxSorgu extends Controller {

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
            $Panel_Model = $this->load->model("Panel_Model");
            //language 
            $lang = Session::get("dil");
            $formlanguage = $this->load->ajaxlanguage($lang);
            $languagedeger = $formlanguage->ajaxlanguage();

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

                case "veliEkleSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            //bölgeleri getirir
                            $bolgeListe = $Panel_Model->veliNewBolgeListele();

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

                            $bolgeListe = $Panel_Model->veliRutbeBolgeListele($rutbebolgedizi);

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
                case "veliKurumMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $veliBolgeID = $_REQUEST['veliBolgeID'];
                        $multivelidizi = implode(',', $veliBolgeID);

                        $kurumListe = $Panel_Model->veliKurumMultiSelect($multivelidizi);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $veliKurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $veliKurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $a++;
                        }
                        $sonuc["kurumMultiSelect"] = $veliKurumSelect;
                    }
                    break;
                case "veliOgrenciMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $kurumBolgeID = $_REQUEST['kurumBolgeID'];
                        $multiveliogrencidizi = implode(',', $kurumBolgeID);

                        $ogrenciListe = $Panel_Model->veliOgrenciMultiSelect($multiveliogrencidizi);

                        $a = 0;
                        foreach ($ogrenciListe as $ogrenciListee) {
                            $veliKurumSelect['OgrenciSelectID'][$a] = $ogrenciListee['BSOgrenciID'];
                            $veliKurumSelect['OgrenciSelectAd'][$a] = $ogrenciListee['BSOgrenciAd'];
                            $a++;
                        }
                        $sonuc["ogrenciMultiSelect"] = $veliKurumSelect;
                    }
                    break;
                case "veliKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $userTip = 4;

                        $firmaID = Session::get("FirmaId");

                        $userKadi = $form->kadiOlustur($firmaID);
                        if ($userKadi) {
                            $realSifre = $form->sifreOlustur();
                            if ($realSifre) {
                                $adminSifre = $form->userSifreOlustur($userKadi, $realSifre, $userTip);
                                if ($adminSifre) {

                                    $form->post('veliAd', true);
                                    $form->post('veliSoyad', true);
                                    $form->post('veliEmail', true);
                                    $form->post('veliDurum', true);
                                    $form->post('veliLokasyon', true);
                                    $form->post('veliTelefon', true);
                                    $form->post('veliAdres', true);
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

                                    $veliAd = $form->values['veliAd'];
                                    $veliSoyad = $form->values['veliSoyad'];
                                    $veliAdSoyad = $veliAd . ' ' . $veliSoyad;
                                    $veliEmail = $form->values['veliEmail'];

                                    $veliBolgeID = $_REQUEST['veliBolgeID'];
                                    $veliBolgeAdi = $_REQUEST['veliBolgeAdi'];
                                    $veliKurumID = $_REQUEST['veliKurumID'];
                                    $veliKurumAd = $_REQUEST['veliKurumAd'];
                                    $veliOgrenciID = $_REQUEST['veliOgrenciID'];
                                    $veliOgrenciAd = $_REQUEST['veliOgrenciAd'];

                                    if (!filter_var($veliEmail, FILTER_VALIDATE_EMAIL) === false) {
                                        $emailValidate = $form->mailControl1($veliEmail);
                                        if ($emailValidate == 1) {
                                            $kullaniciliste = $Panel_Model->veliEmailDbKontrol($veliEmail);
                                            if (count($kullaniciliste) <= 0) {
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'SBVeliAd' => $veliAd,
                                                        'SBVeliSoyad' => $veliSoyad,
                                                        'SBVeliKadi' => $userKadi,
                                                        'SBVeliSifre' => $adminSifre,
                                                        'SBVeliRSifre' => $realSifre,
                                                        'SBVeliPhone' => $form->values['veliTelefon'],
                                                        'SBVeliEmail' => $veliEmail,
                                                        'SBVeliLocation' => $form->values['veliLokasyon'],
                                                        'SBVeliUlke' => $form->values['ulke'],
                                                        'SBVeliIl' => $form->values['il'],
                                                        'SBVeliIlce' => $form->values['ilce'],
                                                        'SBVeliSemt' => $form->values['semt'],
                                                        'SBVeliMahalle' => $form->values['mahalle'],
                                                        'SBVeliSokak' => $form->values['sokak'],
                                                        'SBVeliPostaKodu' => $form->values['postakodu'],
                                                        'SBVeliCaddeNo' => $form->values['caddeno'],
                                                        'SBVeliAdres' => $form->values['veliAdres'],
                                                        'SBVeliDetayAdres' => $form->values['detayAdres'],
                                                        'Status' => $form->values['veliDurum'],
                                                        'SBVeliAciklama' => $form->values['aciklama']
                                                    );
                                                }
                                                $resultVeliID = $Panel_Model->addNewVeli($data);

                                                if ($resultVeliID != 'unique') {
                                                    $bolgeID = count($veliBolgeID);
                                                    if ($bolgeID > 0) {
                                                        for ($b = 0; $b < $bolgeID; $b++) {
                                                            $bolgedata[$b] = array(
                                                                'BSVeliID' => $resultVeliID,
                                                                'BSVeliAd' => $veliAdSoyad,
                                                                'BSBolgeID' => $veliBolgeID[$b],
                                                                'BSBolgeAd' => $veliBolgeAdi[$b]
                                                            );
                                                        }
                                                        $resultBolgeID = $Panel_Model->addNewBolgeVeli($bolgedata);
                                                        if ($resultBolgeID) {
                                                            //veliye kurum seçildi ise
                                                            $kurumID = count($veliKurumID);
                                                            if ($kurumID > 0) {
                                                                for ($c = 0; $c < $kurumID; $c++) {
                                                                    $kurumdata[$c] = array(
                                                                        'BSKurumID' => $veliKurumID[$c],
                                                                        'BSKurumAd' => $veliKurumAd[$c],
                                                                        'BSVeliID' => $resultVeliID,
                                                                        'BSVeliAd' => $veliAdSoyad
                                                                    );
                                                                }
                                                                $resultKurumID = $Panel_Model->addNewVeliKurum($kurumdata);
                                                                if ($resultKurumID) {
                                                                    //kullanıcıya gerekli giriş mail yazısı
                                                                    $setTitle = $languagedeger['UyelikBilgi'];
                                                                    $subject = $languagedeger['SHtrltMail'];
                                                                    $body = $languagedeger['Merhaba'] . ' ' . $veliAdSoyad . '!<br/>' . $languagedeger['KullaniciAdi'] . ' = ' . $userKadi . '<br/>'
                                                                            . $languagedeger['KullaniciSifre'] . ' = ' . $realSifre . '<br/>'
                                                                            . $languagedeger['IyiGunler'];
                                                                    $ogrenciID = count($veliOgrenciID);
                                                                    if ($ogrenciID > 0) {
                                                                        for ($d = 0; $d < $ogrenciID; $d++) {
                                                                            $ogrencidata[$d] = array(
                                                                                'BSOgrenciID' => $veliOgrenciID[$d],
                                                                                'BSOgrenciAd' => $veliOgrenciAd[$d],
                                                                                'BSVeliID' => $resultVeliID,
                                                                                'BSVeliAd' => $veliAdSoyad
                                                                            );
                                                                        }
                                                                        $resultOgrenciID = $Panel_Model->addNewVeliOgrenci($ogrencidata);
                                                                        //kullanıcıya gerekli giriş bilgileri gönderiliyor.
                                                                        $resultMail = $form->sifreHatirlatMail($veliEmail, $setTitle, $veliAdSoyad, $subject, $body);
                                                                        $sonuc["newVeliID"] = $resultVeliID;
                                                                        $sonuc["insert"] = $languagedeger['VeliEkle'];
                                                                    } else {
                                                                        //kullanıcıya gerekli giriş bilgileri gönderiliyor.
                                                                        $resultMail = $form->sifreHatirlatMail($veliEmail, $setTitle, $veliAdSoyad, $subject, $body);
                                                                        $sonuc["newVeliID"] = $resultVeliID;
                                                                        $sonuc["insert"] = $languagedeger['VeliEkle'];
                                                                    }
                                                                } else {
                                                                    //bölge kaydedilirken hata geldi ise
                                                                    $deleteresult = $Panel_Model->veliDelete($resultVeliID);
                                                                    $deleteresultt = $Panel_Model->veliBolgeDelete($resultVeliID);

                                                                    if ($deleteresultt) {
                                                                        $sonuc["hata"] = $languagedeger['KurumSec'];
                                                                    }
                                                                }
                                                            } else {
                                                                //bölge kaydedilirken hata geldi ise
                                                                $deleteresult = $Panel_Model->veliDelete($resultVeliID);
                                                                $deleteresultt = $Panel_Model->veliBolgeDelete($resultVeliID);

                                                                if ($deleteresultt) {
                                                                    $sonuc["hata"] = $languagedeger['KurumSec'];
                                                                }
                                                            }
                                                        } else {
                                                            //bölge kaydedilirken hata geldi ise
                                                            $deleteresult = $Panel_Model->veliDelete($resultVeliID);
                                                            $deleteresultt = $Panel_Model->veliBolgeDelete($resultVeliID);

                                                            if ($deleteresultt) {
                                                                $sonuc["hata"] = $languagedeger['Hata'];
                                                            }
                                                        }
                                                    } else {
                                                        //eğer velinin bölgesi yoksa
                                                        $deleteresult = $Panel_Model->veliDelete($resultVeliID);
                                                        $sonuc["hata"] = $languagedeger['BolgeSec'];
                                                    }
                                                } else {
                                                    $sonuc["hata"] = $languagedeger['GecersizKullanici'];
                                                }
                                            } else {
                                                $sonuc["hata"] = $languagedeger['KullanilmisEmail'];
                                            }
                                        } else {
                                            $sonuc["hata"] = $languagedeger['BaskaEmail'];
                                        }
                                    } else {
                                        $sonuc["hata"] = $languagedeger['GecerliEmail'];
                                    }
                                } else {
                                    $sonuc["hata"] = $languagedeger['Hata'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['Hata'];
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }
                case "veliDetail":
                    $adminID = Session::get("userId");

                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('veliRowid', true);
                            $veliDetailID = $form->values['veliRowid'];

                            $veliBolge = $Panel_Model->veliDetailBolge($veliDetailID);
                            //işçi bölge idler
                            $a = 0;
                            foreach ($veliBolge as $veliBolgee) {
                                $selectVeliBolge[$a]['SelectVeliBolgeID'] = $veliBolgee['BSBolgeID'];
                                $selectVeliBolge[$a]['SelectVeliBolgeAdi'] = $veliBolgee['BSBolgeAd'];
                                $velibolgeId[] = $veliBolgee['BSBolgeID'];
                                $a++;
                            }

                            //veliye ait bölge varmı(kesin oalcak veliye a bölge seçtirmeden ekletmiyoruz
                            $veliCountBolge = count($velibolgeId);
                            if ($veliCountBolge > 0) {
                                $velibolgedizi = implode(',', $velibolgeId);
                                //velinin bolgesi dışındakiler
                                $digerBolge = $Panel_Model->veliDetailSBolge($velibolgedizi);
                                //veli diğer bölgeler
                                $b = 0;
                                foreach ($digerBolge as $digerBolgee) {
                                    $digerVeliBolge[$b]['DigerVeliBolgeID'] = $digerBolgee['SBBolgeID'];
                                    $digerVeliBolge[$b]['DigerVeliBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                    $b++;
                                }
                            }

                            // veli seçili kurum
                            $adminVeliKurum = $Panel_Model->adminDetailVeliKurum($veliDetailID);
                            $veliKurumCount = count($adminVeliKurum);
                            //eğer velinin seçili kurumu varsa burası gelecek
                            if ($veliKurumCount > 0) {
                                //kurum Veli idler
                                $c = 0;
                                foreach ($adminVeliKurum as $adminVeliKurumm) {
                                    $selectVeliKurum[$c]['SelectVeliKurumID'] = $adminVeliKurumm['BSKurumID'];
                                    $selectVeliKurum[$c]['SelectVeliKurumAd'] = $adminVeliKurumm['BSKurumAd'];
                                    $velikurumId[] = $adminVeliKurumm['BSKurumID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $velibolgedizim = implode(',', $velibolgeId);
                                //seçili olan kurum
                                $velibolgekurum = implode(',', $velikurumId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminVeliBolgeKurum = $Panel_Model->adminSelectIsciBolge($velibolgedizim, $velibolgekurum);

                                if (count($adminVeliBolgeKurum) > 0) {
                                    $d = 0;
                                    foreach ($adminVeliBolgeKurum as $adminVeliBolgeKurumm) {
                                        $digerVeliKurum[$d]['DigerVeliKurumID'] = $adminVeliBolgeKurumm['SBKurumID'];
                                        $digerVeliKurum[$d]['DigerVeliKurumAd'] = $adminVeliBolgeKurumm['SBKurumAdi'];
                                        $d++;
                                    }
                                }
                            }

                            // veli seçili öğrenci
                            $adminVeliOgrenci = $Panel_Model->adminDetailVeliOgrenci($veliDetailID);
                            $veliOgrenciCount = count($adminVeliOgrenci);
                            //eğer velinin seçili öğrenci varsa burası gelecek
                            if ($veliOgrenciCount > 0) {
                                //öğrenci Veli idler
                                $f = 0;
                                foreach ($adminVeliOgrenci as $adminVeliOgrencii) {
                                    $selectVeliOgrenci[$f]['SelectVeliOgrenciID'] = $adminVeliOgrencii['BSOgrenciID'];
                                    $selectVeliOgrenci[$f]['SelectVeliOgrenciAd'] = $adminVeliOgrencii['BSOgrenciAd'];
                                    $veliogrenciId[] = $adminVeliOgrencii['BSOgrenciID'];
                                    $f++;
                                }
                                //seçili olan kurum
                                $velikurumdizim = implode(',', $velikurumId);
                                //seçili olan kurum
                                $velibolgeogrenci = implode(',', $veliogrenciId);
                                //adamın seçili olab kurumdaki diğer öğrenciler
                                $adminVeliKurumOgrenci = $Panel_Model->adminSelectVeliKurum($velikurumdizim, $velibolgeogrenci);

                                if (count($adminVeliKurumOgrenci) > 0) {
                                    $g = 0;
                                    foreach ($adminVeliKurumOgrenci as $adminVeliKurumOgrencii) {
                                        $digerVeliOgrenci[$g]['DigerVeliOgrenciID'] = $adminVeliKurumOgrencii['BSOgrenciID'];
                                        $digerVeliOgrenci[$g]['DigerVeliOgrenciAd'] = $adminVeliKurumOgrencii['BSOgrenciAd'];
                                        $g++;
                                    }
                                }
                            } else {
                                //seçili olan kurum
                                $velikurumdizim = implode(',', $velikurumId);
                                //adamın seçili olab kurumdaki diğer öğrencileri
                                $adminVeliKurumOgrenci = $Panel_Model->adminSelectKurumOgrenci($velikurumdizim);

                                $g = 0;
                                foreach ($adminVeliKurumOgrenci as $adminVeliKurumOgrencii) {
                                    $digerVeliOgrenci[$g]['DigerVeliOgrenciID'] = $adminVeliKurumOgrencii['BSOgrenciID'];
                                    $digerVeliOgrenci[$g]['DigerVeliOgrenciAd'] = $adminVeliKurumOgrencii['BSOgrenciAd'];
                                    $g++;
                                }
                            }


                            //veli Özellikleri
                            $veliOzellik = $Panel_Model->veliDetail($veliDetailID);
                            $e = 0;
                            foreach ($veliOzellik as $veliOzellikk) {
                                $veliList[$e]['VeliListID'] = $veliOzellikk['SBVeliID'];
                                $veliList[$e]['VeliListAd'] = $veliOzellikk['SBVeliAd'];
                                $veliList[$e]['VeliListSoyad'] = $veliOzellikk['SBVeliSoyad'];
                                $veliList[$e]['VeliListTelefon'] = $veliOzellikk['SBVeliPhone'];
                                $veliList[$e]['VeliListMail'] = $veliOzellikk['SBVeliEmail'];
                                $veliList[$e]['VeliListLokasyon'] = $veliOzellikk['SBVeliLocation'];
                                $veliList[$e]['VeliListUlke'] = $veliOzellikk['SBVeliUlke'];
                                $veliList[$e]['VeliListIl'] = $veliOzellikk['SBVeliIl'];
                                $veliList[$e]['VeliListIlce'] = $veliOzellikk['SBVeliIlce'];
                                $veliList[$e]['VeliListSemt'] = $veliOzellikk['SBVeliSemt'];
                                $veliList[$e]['VeliListMahalle'] = $veliOzellikk['SBVeliMahalle'];
                                $veliList[$e]['VeliListSokak'] = $veliOzellikk['SBVeliSokak'];
                                $veliList[$e]['VeliListPostaKodu'] = $veliOzellikk['SBVeliPostaKodu'];
                                $veliList[$e]['VeliListCaddeNo'] = $veliOzellikk['SBVeliCaddeNo'];
                                $veliList[$e]['VeliListAdres'] = $veliOzellikk['SBVeliAdres'];
                                $veliList[$e]['VeliListDetayAdres'] = $veliOzellikk['SBVeliDetayAdres'];
                                $veliList[$e]['VeliListDurum'] = $veliOzellikk['Status'];
                                $veliList[$e]['VeliListAciklama'] = $veliOzellikk['SBVeliAciklama'];
                                $e++;
                            }
                        } else {
                            $adminID = Session::get("userId");
                            //normal adminse
                            $form->post('veliRowid', true);
                            $veliDetailID = $form->values['veliRowid'];

                            //küçük adminin olan bölgeleri
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            //bölge idler
                            $bolgerutbeId = [];
                            foreach ($bolgeListeRutbe as $bolgeListeRutbee) {
                                $bolgerutbeId[] = $bolgeListeRutbee['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $veliBolge = $Panel_Model->veliDetailBolge($veliDetailID);
                            //işçi bölge idler
                            $velibolgeId = [];
                            $a = 0;
                            foreach ($veliBolge as $veliBolgee) {
                                $selectVeliBolge[$a]['SelectVeliBolgeID'] = $veliBolgee['BSBolgeID'];
                                $selectVeliBolge[$a]['SelectVeliBolgeAdi'] = $veliBolgee['BSBolgeAd'];
                                $velibolgeId[] = $veliBolgee['BSBolgeID'];
                                $a++;
                            }

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz
                            $bolgefark = array_diff($bolgerutbeId, $velibolgeId);
                            $bolgefarkk = implode(',', $bolgefark);

                            //velinin bolgesi dışındakiler
                            $digerBolge = $Panel_Model->veliDetailSBolge($bolgefarkk);
                            //veli diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerVeliBolge[$b]['DigerVeliBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerVeliBolge[$b]['DigerVeliBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }

                            // veli seçili kurum
                            $adminVeliKurum = $Panel_Model->adminDetailVeliKurum($veliDetailID);
                            $veliKurumCount = count($adminVeliKurum);
                            //eğer velinin seçili kurumu varsa burası gelecek
                            if ($veliKurumCount > 0) {
                                //kurum Veli idler
                                $c = 0;
                                foreach ($adminVeliKurum as $adminVeliKurumm) {
                                    $selectVeliKurum[$c]['SelectVeliKurumID'] = $adminVeliKurumm['BSKurumID'];
                                    $selectVeliKurum[$c]['SelectVeliKurumAd'] = $adminVeliKurumm['BSKurumAd'];
                                    $velikurumId[] = $adminVeliKurumm['BSKurumID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $velibolgedizim = implode(',', $velibolgeId);
                                //seçili olan kurum
                                $velibolgekurum = implode(',', $velikurumId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminVeliBolgeKurum = $Panel_Model->adminSelectIsciBolge($velibolgedizim, $velibolgekurum);

                                if (count($adminVeliBolgeKurum) > 0) {
                                    $d = 0;
                                    foreach ($adminVeliBolgeKurum as $adminVeliBolgeKurumm) {
                                        $digerVeliKurum[$d]['DigerVeliKurumID'] = $adminVeliBolgeKurumm['SBKurumID'];
                                        $digerVeliKurum[$d]['DigerVeliKurumAd'] = $adminVeliBolgeKurumm['SBKurumAdi'];
                                        $d++;
                                    }
                                }
                            }

                            // veli seçili öğrenci
                            $adminVeliOgrenci = $Panel_Model->adminDetailVeliOgrenci($veliDetailID);
                            $veliOgrenciCount = count($adminVeliOgrenci);
                            //eğer velinin seçili öğrenci varsa burası gelecek
                            if ($veliOgrenciCount > 0) {
                                //öğrenci Veli idler
                                $f = 0;
                                foreach ($adminVeliOgrenci as $adminVeliOgrencii) {
                                    $selectVeliOgrenci[$f]['SelectVeliOgrenciID'] = $adminVeliOgrencii['BSOgrenciID'];
                                    $selectVeliOgrenci[$f]['SelectVeliOgrenciAd'] = $adminVeliOgrencii['BSOgrenciAd'];
                                    $veliogrenciId[] = $adminVeliOgrencii['BSOgrenciID'];
                                    $f++;
                                }
                                //seçili olan kurum
                                $velikurumdizim = implode(',', $velikurumId);
                                //seçili olan kurum
                                $velibolgeogrenci = implode(',', $veliogrenciId);
                                //adamın seçili olab kurumdaki diğer öğrenciler
                                $adminVeliKurumOgrenci = $Panel_Model->adminSelectVeliKurum($velikurumdizim, $velibolgeogrenci);

                                if (count($adminVeliKurumOgrenci) > 0) {
                                    $g = 0;
                                    foreach ($adminVeliKurumOgrenci as $adminVeliKurumOgrencii) {
                                        $digerVeliOgrenci[$g]['DigerVeliOgrenciID'] = $adminVeliKurumOgrencii['BSOgrenciID'];
                                        $digerVeliOgrenci[$g]['DigerVeliOgrenciAd'] = $adminVeliKurumOgrencii['BSOgrenciAd'];
                                        $g++;
                                    }
                                }
                            } else {
                                //seçili olan kurum
                                $velikurumdizim = implode(',', $velikurumId);
                                //adamın seçili olab kurumdaki diğer öğrencileri
                                $adminVeliKurumOgrenci = $Panel_Model->adminSelectKurumOgrenci($velikurumdizim);

                                $g = 0;
                                foreach ($adminVeliKurumOgrenci as $adminVeliKurumOgrencii) {
                                    $digerVeliOgrenci[$g]['DigerVeliOgrenciID'] = $adminVeliKurumOgrencii['BSOgrenciID'];
                                    $digerVeliOgrenci[$g]['DigerVeliOgrenciAd'] = $adminVeliKurumOgrencii['BSOgrenciAd'];
                                    $g++;
                                }
                            }


                            //veli Özellikleri
                            $veliOzellik = $Panel_Model->veliDetail($veliDetailID);
                            $e = 0;
                            foreach ($veliOzellik as $veliOzellikk) {
                                $veliList[$e]['VeliListID'] = $veliOzellikk['SBVeliID'];
                                $veliList[$e]['VeliListAd'] = $veliOzellikk['SBVeliAd'];
                                $veliList[$e]['VeliListSoyad'] = $veliOzellikk['SBVeliSoyad'];
                                $veliList[$e]['VeliListTelefon'] = $veliOzellikk['SBVeliPhone'];
                                $veliList[$e]['VeliListMail'] = $veliOzellikk['SBVeliEmail'];
                                $veliList[$e]['VeliListLokasyon'] = $veliOzellikk['SBVeliLocation'];
                                $veliList[$e]['VeliListUlke'] = $veliOzellikk['SBVeliUlke'];
                                $veliList[$e]['VeliListIl'] = $veliOzellikk['SBVeliIl'];
                                $veliList[$e]['VeliListIlce'] = $veliOzellikk['SBVeliIlce'];
                                $veliList[$e]['VeliListSemt'] = $veliOzellikk['SBVeliSemt'];
                                $veliList[$e]['VeliListMahalle'] = $veliOzellikk['SBVeliMahalle'];
                                $veliList[$e]['VeliListSokak'] = $veliOzellikk['SBVeliSokak'];
                                $veliList[$e]['VeliListPostaKodu'] = $veliOzellikk['SBVeliPostaKodu'];
                                $veliList[$e]['VeliListCaddeNo'] = $veliOzellikk['SBVeliCaddeNo'];
                                $veliList[$e]['VeliListAdres'] = $veliOzellikk['SBVeliAdres'];
                                $veliList[$e]['VeliListDetayAdres'] = $veliOzellikk['SBVeliDetayAdres'];
                                $veliList[$e]['VeliListDurum'] = $veliOzellikk['Status'];
                                $veliList[$e]['VeliListAciklama'] = $veliOzellikk['SBVeliAciklama'];
                                $e++;
                            }
                        }
                        //sonuçlar
                        $sonuc["veliSelectBolge"] = $selectVeliBolge;
                        $sonuc["veliBolge"] = $digerVeliBolge;
                        $sonuc["veliSelectKurum"] = $selectVeliKurum;
                        $sonuc["veliKurum"] = $digerVeliKurum;
                        $sonuc["veliSelectOgrenci"] = $selectVeliOgrenci;
                        $sonuc["veliOgrenci"] = $digerVeliOgrenci;
                        $sonuc["veliDetail"] = $veliList;
                    }

                    break;
                case "veliDetailDelete":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('velidetail_id', true);
                        $veliDetailID = $form->values['velidetail_id'];
                        $deleteresult = $Panel_Model->detailVeliDelete($veliDetailID);
                        if ($deleteresult) {
                            $deleteresultt = $Panel_Model->detailVeliBolgeDelete($veliDetailID);
                            if ($deleteresultt) {
                                $deleteresulttt = $Panel_Model->detailVeliKurumDelete($veliDetailID);
                                if ($deleteresulttt) {
                                    $deleteresultttt = $Panel_Model->detailVeliOgrenciDelete($veliDetailID);
                                    if ($deleteresultttt) {
                                        $sonuc["delete"] = $languagedeger['VeliSil'];
                                    }
                                }
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }

                    $sonuc["veliDetail"] = $data["veliDetail"];

                    break;
                case "veliDetailKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('velidetail_id', true);
                        $veliID = $form->values['velidetail_id'];

                        $form->post('veliDetayAd', true);
                        $form->post('veliDetaySoyad', true);
                        $form->post('veliDetayEmail', true);
                        $form->post('veliDetayDurum', true);
                        $form->post('veliDetayLokasyon', true);
                        $form->post('veliDetayTelefon', true);
                        $form->post('veliDetayAdres', true);
                        $form->post('veliDetayAciklama', true);
                        $form->post('veliDetayUlke', true);
                        $form->post('veliDetayIl', true);
                        $form->post('veliDetayIlce', true);
                        $form->post('veliDetaySemt', true);
                        $form->post('veliDetayMahalle', true);
                        $form->post('veliDetaySokak', true);
                        $form->post('veliDetayPostaKodu', true);
                        $form->post('veliDetayCaddeNo', true);
                        $form->post('detayAdres', true);
                        $form->post('eskiAd', true);
                        $form->post('eskiSoyad', true);
                        $eskiAd = $form->values['eskiAd'];
                        $eskiSoyad = $form->values['eskiSoyad'];

                        $veliAd = $form->values['veliDetayAd'];
                        $veliSoyad = $form->values['veliDetaySoyad'];
                        $veliAdSoyad = $veliAd . ' ' . $veliSoyad;
                        $veliEmail = $form->values['veliDetayEmail'];

                        $veliBolgeID = $_REQUEST['veliBolgeID'];
                        $veliBolgeAdi = $_REQUEST['veliBolgeAd'];
                        $veliKurumID = $_REQUEST['veliKurumID'];
                        $veliKurumAd = $_REQUEST['veliKurumAd'];
                        $veliOgrenciID = $_REQUEST['veliOgrenciID'];
                        $veliOgrenciAd = $_REQUEST['veliOgrenciAd'];

                        if (!filter_var($veliEmail, FILTER_VALIDATE_EMAIL) === false) {
                            $emailValidate = $form->mailControl1($veliEmail);
                            if ($emailValidate == 1) {
                                $kullaniciliste = $Panel_Model->veliEmailDbKontrol($veliEmail);
                                if (count($kullaniciliste) <= 0) {
                                    if ($form->submit()) {
                                        $data = array(
                                            'SBVeliAd' => $veliAd,
                                            'SBVeliSoyad' => $veliSoyad,
                                            'SBVeliPhone' => $form->values['veliDetayTelefon'],
                                            'SBVeliEmail' => $veliEmail,
                                            'SBVeliLocation' => $form->values['veliDetayLokasyon'],
                                            'SBVeliUlke' => $form->values['veliDetayUlke'],
                                            'SBVeliIl' => $form->values['veliDetayIl'],
                                            'SBVeliIlce' => $form->values['veliDetayIlce'],
                                            'SBVeliSemt' => $form->values['veliDetaySemt'],
                                            'SBVeliMahalle' => $form->values['veliDetayMahalle'],
                                            'SBVeliSokak' => $form->values['veliDetaySokak'],
                                            'SBVeliPostaKodu' => $form->values['veliDetayPostaKodu'],
                                            'SBVeliCaddeNo' => $form->values['veliDetayCaddeNo'],
                                            'SBVeliAdres' => $form->values['veliDetayAdres'],
                                            'SBVeliDetayAdres' => $form->values['detayAdres'],
                                            'SBVeliAciklama' => $form->values['veliDetayAciklama'],
                                            'Status' => $form->values['veliDetayDurum']
                                        );
                                    }
                                    $resultVeliUpdate = $Panel_Model->veliOzelliklerDuzenle($data, $veliID);
                                    if ($resultVeliUpdate) {
                                        if ($veliAd != $eskiAd || $veliSoyad != $eskiSoyad) {
                                            $dataDuzenle = array(
                                                'BSGonderenAdSoyad' => $veliAdSoyad
                                            );
                                            $updateduyuru = $Panel_Model->veliOzellikDuzenle($dataDuzenle, $veliID);
                                            $dataDuzenle1 = array(
                                                'BSEkleyenAdSoyad' => $veliAdSoyad
                                            );
                                            $updateduyurulog = $Panel_Model->veliOzellikDuzenle1($dataDuzenle1, $veliID);
                                            $dataDuzenle2 = array(
                                                'BSOdemeYapanAd' => $veliAdSoyad
                                            );
                                            $updateodeme = $Panel_Model->veliOzellikDuzenle2($dataDuzenle2, $veliID);
                                        }
                                        $veliOgrenciCount = count($veliOgrenciID);
                                        if ($veliOgrenciCount > 0) {
                                            $deleteVeliOgrenci = $Panel_Model->detailVeliOgrenciDelete($veliID);
                                            if ($deleteVeliOgrenci) {
                                                for ($d = 0; $d < $veliOgrenciCount; $d++) {
                                                    $ogrencidata[$d] = array(
                                                        'BSOgrenciID' => $veliOgrenciID[$d],
                                                        'BSOgrenciAd' => $veliOgrenciAd[$d],
                                                        'BSVeliID' => $veliID,
                                                        'BSVeliAd' => $veliAdSoyad
                                                    );
                                                }
                                                $resultOgrenciID = $Panel_Model->addNewVeliOgrenci($ogrencidata);
                                                if ($resultOgrenciID) {
                                                    $deleteresultt = $Panel_Model->detailVeliKurumDelete($veliID);
                                                    if ($deleteresultt) {
                                                        $veliKurumCount = count($veliKurumID);
                                                        for ($c = 0; $c < $veliKurumCount; $c++) {
                                                            $kurumdata[$c] = array(
                                                                'BSKurumID' => $veliKurumID[$c],
                                                                'BSKurumAd' => $veliKurumAd[$c],
                                                                'BSVeliID' => $veliID,
                                                                'BSVeliAd' => $veliAdSoyad
                                                            );
                                                        }
                                                        $resultKurumID = $Panel_Model->addNewVeliKurum($kurumdata);
                                                        if ($resultKurumID) {
                                                            $bolgeID = count($veliBolgeID);
                                                            $deleteresulttt = $Panel_Model->detailVeliBolgeDelete($veliID);
                                                            if ($deleteresulttt) {
                                                                for ($b = 0; $b < $bolgeID; $b++) {
                                                                    $bolgedata[$b] = array(
                                                                        'BSVeliID' => $veliID,
                                                                        'BSVeliAd' => $veliAdSoyad,
                                                                        'BSBolgeID' => $veliBolgeID[$b],
                                                                        'BSBolgeAd' => $veliBolgeAdi[$b]
                                                                    );
                                                                }
                                                                $resultBolgeID = $Panel_Model->addNewBolgeVeli($bolgedata);
                                                                if ($resultBolgeID) {
                                                                    $sonuc["newVeliID"] = $veliID;
                                                                    $sonuc["update"] = $languagedeger['VeliDuzenle'];
                                                                } else {
                                                                    $sonuc["hata"] = $languagedeger['Hata'];
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = $languagedeger['Hata'];
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = $languagedeger['Hata'];
                                                        }
                                                    }
                                                }
                                            }
                                        } else {
                                            $deleteresultt = $Panel_Model->detailVeliKurumDelete($veliID);
                                            if ($deleteresultt) {
                                                $veliKurumCount = count($veliKurumID);
                                                for ($c = 0; $c < $veliKurumCount; $c++) {
                                                    $kurumdata[$c] = array(
                                                        'BSKurumID' => $veliKurumID[$c],
                                                        'BSKurumAd' => $veliKurumAd[$c],
                                                        'BSVeliID' => $veliID,
                                                        'BSVeliAd' => $veliAdSoyad
                                                    );
                                                }
                                                $resultKurumID = $Panel_Model->addNewVeliKurum($kurumdata);
                                                if ($resultKurumID) {
                                                    $bolgeID = count($veliBolgeID);
                                                    $deleteresulttt = $Panel_Model->detailVeliBolgeDelete($veliID);
                                                    if ($deleteresulttt) {
                                                        for ($b = 0; $b < $bolgeID; $b++) {
                                                            $bolgedata[$b] = array(
                                                                'BSVeliID' => $veliID,
                                                                'BSVeliAd' => $veliAdSoyad,
                                                                'BSBolgeID' => $veliBolgeID[$b],
                                                                'BSBolgeAd' => $veliBolgeAdi[$b]
                                                            );
                                                        }
                                                        $resultBolgeID = $Panel_Model->addNewBolgeVeli($bolgedata);
                                                        if ($resultBolgeID) {
                                                            $sonuc["newVeliID"] = $veliID;
                                                            $sonuc["update"] = $languagedeger['VeliDuzenle'];
                                                        } else {
                                                            $sonuc["hata"] = $languagedeger['Hata'];
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = $languagedeger['Hata'];
                                                    }
                                                } else {
                                                    $sonuc["hata"] = $languagedeger['Hata'];
                                                }
                                            }
                                        }
                                    } else {
                                        $sonuc["hata"] = $languagedeger['Hata'];
                                    }
                                } else {
                                    $sonuc["hata"] = $languagedeger['KullanilmisEmail'];
                                }
                            } else {
                                $sonuc["hata"] = $languagedeger['BaskaEmail'];
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['GecerliEmail'];
                        }
                    }
                case "VeliDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $veliDetailBolgeID = $_REQUEST['veliDetailBolgeID'];
                        $form->post('veliID', true);
                        $veliID = $form->values['veliID'];

                        //Veliye ait kurumlar
                        $adminVeliKurum = $Panel_Model->veliDetailMultiSelectVeli($veliID);
                        if (count($adminVeliKurum) > 0) {
                            $velikurumId = [];
                            foreach ($adminVeliKurum as $adminVeliKurumm) {
                                $velikurumId[] = $adminVeliKurumm['BSKurumID'];
                            }
                            //veliye ait kurumlar
                            $velibolgekurum = implode(',', $velikurumId);
                            //seçilen bölgeler
                            $velibolgedizim = implode(',', $veliDetailBolgeID);
                            //seçilen bölgedeki kurumlar
                            $VeliBolgeKurum = $Panel_Model->adminSelectBolgeKurumm($velibolgedizim);
                            $veliDigerKurumId = [];
                            foreach ($VeliBolgeKurum as $VeliBolgeKurumm) {
                                $veliDigerKurumId[] = $VeliBolgeKurumm['SBKurumID'];
                            }
                            //gelen kurum ıdlerinde aynı olan idler, seçili kurumlardır.
                            $ortakIDler = array_intersect($velikurumId, $veliDigerKurumId);
                            //gelen idlerde ki farklı olanlar seçili olmayan kurumlardır yani diğer kurumlar
                            $kurum_fark = array_diff($veliDigerKurumId, $velikurumId);
                            $diger_kurum_fark = implode(',', $kurum_fark);
                            //ortak ıd ye sahip kurum varmı
                            if (count($ortakIDler) > 0) {
                                //seçili kurumlar
                                $secilenIdKurum = implode(',', $ortakIDler);
                                $selectBolgeKurum = $Panel_Model->veliNotSelectKurum($secilenIdKurum);
                                $c = 0;
                                foreach ($selectBolgeKurum as $selectBolgeKurumm) {
                                    $selectVeliKurum[$c]['SelectVeliKurumID'] = $selectBolgeKurumm['SBKurumID'];
                                    $selectVeliKurum[$c]['SelectVeliKurumAd'] = $selectBolgeKurumm['SBKurumAdi'];
                                    $c++;
                                }

                                //diğer kurumlar
                                $digerBolgeKurum = $Panel_Model->veliNotSelectKurum($diger_kurum_fark);

                                $d = 0;
                                foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                    $digerVeliKurum[$d]['DigerVeliKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                    $digerVeliKurum[$d]['DigerVeliKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili kurum yoktur
                                //diğer kurumlar
                                $digerBolgeKurum = $Panel_Model->veliNotSelectKurum($diger_kurum_fark);

                                $d = 0;
                                foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                    $digerVeliKurum[$d]['DigerVeliKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                    $digerVeliKurum[$d]['DigerVeliKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            }
                        } else {
                            $veliDetailBollgeID = implode(',', $veliDetailBolgeID);
                            //adamın seçili olab bölgedeki diğer kurumları
                            $digerBolgeKurum = $Panel_Model->adminSelectBolgeKurumm($veliDetailBollgeID);

                            $d = 0;
                            foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                $digerVeliKurum[$d]['DigerVeliKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                $digerVeliKurum[$d]['DigerVeliKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminVeliSelectKurum"] = $selectVeliKurum;
                        $sonuc["adminVeliKurum"] = $digerVeliKurum;
                    }
                    break;
                case "OgrenciDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $veliDetailKurumID = $_REQUEST['veliDetailKurumID'];
                        $form->post('veliID', true);
                        $veliID = $form->values['veliID'];

                        //Veliye ait öğrenciler
                        $adminVeliOgrencim = $Panel_Model->veliDetailMultiSelectOgrenci($veliID);
                        if (count($adminVeliOgrencim) > 0) {
                            $veliogrenciId = [];
                            foreach ($adminVeliOgrencim as $adminVeliOgrencimm) {
                                $veliogrenciId[] = $adminVeliOgrencimm['BSOgrenciID'];
                            }
                            //veliye ait öğrenciler
                            $velibolgeogrenci = implode(',', $veliogrenciId);
                            //seçilen kurumlar
                            $velikurumdizim = implode(',', $veliDetailKurumID);
                            //seçilen kurumdaki öğrenciler
                            $VeliKurumOgrenci = $Panel_Model->adminSelectBolgeKurumOgrenci($velikurumdizim);
                            $veliDigerOgrenciId = [];
                            foreach ($VeliKurumOgrenci as $VeliKurumOgrencii) {
                                $veliDigerOgrenciId[] = $VeliKurumOgrencii['BSOgrenciID'];
                            }
                            //gelen öğrenci ıdlerinde aynı olan idler, seçili öğrenciler.
                            $ortakIDler = array_intersect($veliogrenciId, $veliDigerOgrenciId);
                            //gelen idlerde ki farklı olanlar seçili olmayan öğrencilerdir yani diğer öğrenciler
                            $ogrenci_fark = array_diff($veliDigerOgrenciId, $veliogrenciId);
                            $diger_ogrenci_fark = implode(',', $ogrenci_fark);
                            //ortak ıd ye sahip öğrenci varmı
                            if (count($ortakIDler) > 0) {
                                //seçili öğrenciler
                                $secilenIdOgrenci = implode(',', $ortakIDler);
                                $selectKurumOgrenci = $Panel_Model->veliNotSelectOgrenci($secilenIdOgrenci);
                                $c = 0;
                                foreach ($selectKurumOgrenci as $selectKurumOgrencii) {
                                    $selectVeliOgrenci[$c]['SelectVeliOgrenciID'] = $selectKurumOgrencii['BSOgrenciID'];
                                    $selectVeliOgrenci[$c]['SelectVeliOgrenciAd'] = $selectKurumOgrencii['BSOgrenciAd'];
                                    $c++;
                                }

                                //diğer öğrenciler
                                $digerKurumOgrenci = $Panel_Model->veliNotSelectOgrenci($diger_ogrenci_fark);

                                $d = 0;
                                foreach ($digerKurumOgrenci as $digerKurumOgrencii) {
                                    $digerVeliOgrenci[$d]['DigerVeliOgrenciID'] = $digerKurumOgrencii['BSOgrenciID'];
                                    $digerVeliOgrenci[$d]['DigerVeliOgrenciAd'] = $digerKurumOgrencii['BSOgrenciAd'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili öğrenci yoktur
                                //diğer öğrenci
                                $digerKurumOgrenci = $Panel_Model->veliNotSelectOgrenci($diger_ogrenci_fark);

                                $d = 0;
                                foreach ($digerKurumOgrenci as $digerKurumOgrencii) {
                                    $digerVeliOgrenci[$d]['DigerVeliOgrenciID'] = $digerKurumOgrencii['BSOgrenciID'];
                                    $digerVeliOgrenci[$d]['DigerVeliOgrenciAd'] = $digerKurumOgrencii['BSOgrenciAd'];
                                    $d++;
                                }
                            }
                        } else {
                            $veliDetailKurummID = implode(',', $veliDetailKurumID);
                            //adamın seçili olab kurumdaki diğer öğrencileri
                            $digerKurumOgrenci = $Panel_Model->adminSelectBolgeKurumOgrenci($veliDetailKurummID);

                            $d = 0;
                            foreach ($digerKurumOgrenci as $digerKurumOgrencii) {
                                $digerVeliOgrenci[$d]['DigerVeliOgrenciID'] = $digerKurumOgrencii['BSOgrenciID'];
                                $digerVeliOgrenci[$d]['DigerVeliOgrenciAd'] = $digerKurumOgrencii['BSOgrenciAd'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminVeliSelectOgrenci"] = $selectVeliOgrenci;
                        $sonuc["adminVeliOgrenci"] = $digerVeliOgrenci;
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

