<?php

class AdminOgrenciAjaxSorgu extends Controller {

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
                case "ogrenciEkleSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //super adminse tüm bölgeler çekilir
                        if ($adminRutbe != 0) {
                            //bölgeleri getirir
                            $bolgeListe = $Panel_Model->ogrenciNewBolgeListele();

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
                case "ogrenciKurumMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $ogrenciBolgeID = $_REQUEST['ogrenciBolgeID'];
                        $multiogrencidizi = implode(',', $ogrenciBolgeID);

                        $kurumListe = $Panel_Model->ogrenciKurumMultiSelect($multiogrencidizi);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $ogrenciKurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $ogrenciKurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $a++;
                        }
                        $sonuc["kurumMultiSelect"] = $ogrenciKurumSelect;
                    }
                    break;
                case "ogrenciVeliMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $kurumBolgeID = $_REQUEST['kurumBolgeID'];
                        $multiogrencivelidizi = implode(',', $kurumBolgeID);

                        $veliListe = $Panel_Model->ogrenciVeliMultiSelect($multiogrencivelidizi);

                        $a = 0;
                        foreach ($veliListe as $veliListee) {
                            $ogrenciKurumSelect['VeliSelectID'][$a] = $veliListee['BSVeliID'];
                            $ogrenciKurumSelect['VeliSelectAd'][$a] = $veliListee['BSVeliAd'];
                            $a++;
                        }
                        $sonuc["veliMultiSelect"] = $ogrenciKurumSelect;
                    }
                    break;
                case "ogrenciKaydet":
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
                                    $form->post('ogrenciAd', true);
                                    $form->post('ogrenciSoyad', true);
                                    $form->post('ogrenciEmail', true);
                                    $form->post('ogrenciDurum', true);
                                    $form->post('ogrenciLokasyon', true);
                                    $form->post('ogrenciTelefon', true);
                                    $form->post('ogrenciAdres', true);
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
                                    $form->post('gdsbildirim', true);
                                    $form->post('dnsbildirim', true);
                                    $form->post('odemeTutar', true);
                                    $form->post('odemeTip', true);

                                    $ogrenciAd = $form->values['ogrenciAd'];
                                    $ogrenciSoyad = $form->values['ogrenciSoyad'];
                                    $ogrenciAdSoyad = $ogrenciAd . ' ' . $ogrenciSoyad;
                                    $ogrenciEmail = $form->values['ogrenciEmail'];
                                    $odemeTutar = $form->values['odemeTutar'];

                                    $ogrenciBolgeID = $_REQUEST['ogrenciBolgeID'];
                                    $ogrenciBolgeAdi = $_REQUEST['ogrenciBolgeAdi'];
                                    $ogrenciKurumID = $_REQUEST['ogrenciKurumID'];
                                    $ogrenciKurumAd = $_REQUEST['ogrenciKurumAd'];
                                    $veliOgrenciID = $_REQUEST['ogrenciVeliID'];
                                    $veliOgrenciAd = $_REQUEST['ogrenciVeliAd'];

                                    if (!filter_var($ogrenciEmail, FILTER_VALIDATE_EMAIL) === false) {
                                        $emailValidate = $form->mailControl1($ogrenciEmail);
                                        if ($emailValidate == 1) {
                                            $kullaniciliste = $Panel_Model->ogrenciEmailDbKontrol($ogrenciEmail);
                                            if (count($kullaniciliste) <= 0) {
                                                //gelen para değerini virgülden temizleme
                                                $length = strlen($odemeTutar);
                                                for ($l = 0; $l < $length; $l++) {
                                                    if ($odemeTutar[$l] != ",") {
                                                        $odemeValue.=$odemeTutar[$l];
                                                    }
                                                }

                                                if ($form->submit()) {
                                                    $data = array(
                                                        'BSOgrenciAd' => $ogrenciAd,
                                                        'BSOgrenciSoyad' => $ogrenciSoyad,
                                                        'BSOgrenciKadi' => $userKadi,
                                                        'BSOgrenciSifre' => $adminSifre,
                                                        'BSOgrenciRSifre' => $realSifre,
                                                        'BSOgrenciPhone' => $form->values['ogrenciTelefon'],
                                                        'BSOgrenciEmail' => $ogrenciEmail,
                                                        'BSOgrenciLocation' => $form->values['ogrenciLokasyon'],
                                                        'BSOgrenciUlke' => $form->values['ulke'],
                                                        'BSOgrenciIl' => $form->values['il'],
                                                        'BSOgrenciIlce' => $form->values['ilce'],
                                                        'BSOgrenciSemt' => $form->values['semt'],
                                                        'BSOgrenciMahalle' => $form->values['mahalle'],
                                                        'BSOgrenciSokak' => $form->values['sokak'],
                                                        'BSOgrenciPostaKodu' => $form->values['postakodu'],
                                                        'BSOgrenciCaddeNo' => $form->values['caddeno'],
                                                        'BSOgrenciAdres' => $form->values['ogrenciAdres'],
                                                        'BSOgrenciDetayAdres' => $form->values['detayAdres'],
                                                        'Status' => $form->values['ogrenciDurum'],
                                                        'BSOgrenciAciklama' => $form->values['aciklama'],
                                                        'BildirimMesafeGidis' => $form->values['gdsbildirim'],
                                                        'BildirimMesafeDonus' => $form->values['dnsbildirim'],
                                                        'OdemeTutar' => $odemeValue,
                                                        'OdemeParaTip' => $form->values['odemeTip']
                                                    );
                                                }
                                                $resultOgrenciID = $Panel_Model->addNewOgrenci($data);
                                                if ($resultOgrenciID != 'unique') {
                                                    $bolgeID = count($ogrenciBolgeID);
                                                    if ($bolgeID > 0) {
                                                        for ($b = 0; $b < $bolgeID; $b++) {
                                                            $bolgedata[$b] = array(
                                                                'BSOgrenciID' => $resultOgrenciID,
                                                                'BSOgrenciAd' => $ogrenciAdSoyad,
                                                                'BSBolgeID' => $ogrenciBolgeID[$b],
                                                                'BSBolgeAd' => $ogrenciBolgeAdi[$b]
                                                            );
                                                        }
                                                        $resultBolgeID = $Panel_Model->addNewBolgeOgrenci($bolgedata);
                                                        if ($resultBolgeID) {
                                                            //öğrenciye kurum seçildi ise
                                                            $kurumID = count($ogrenciKurumID);
                                                            if ($kurumID > 0) {
                                                                for ($c = 0; $c < $kurumID; $c++) {
                                                                    $kurumdata[$c] = array(
                                                                        'BSKurumID' => $ogrenciKurumID[$c],
                                                                        'BSKurumAd' => $ogrenciKurumAd[$c],
                                                                        'BSOgrenciID' => $resultOgrenciID,
                                                                        'BSOgrenciAd' => $ogrenciAdSoyad
                                                                    );
                                                                }
                                                                $resultKurumID = $Panel_Model->addNewOgrenciKurum($kurumdata);
                                                                if ($resultKurumID) {
                                                                    //kullanıcıya gerekli giriş mail yazısı
                                                                    $setTitle = $languagedeger['UyelikBilgi'];
                                                                    $subject = $languagedeger['SHtrltMail'];
                                                                    $body = $languagedeger['Merhaba'] . ' ' . $ogrenciAdSoyad . '!<br/>' . $languagedeger['KullaniciAdi'] . ' = ' . $userKadi . '<br/>'
                                                                            . $languagedeger['KullaniciSifre'] . ' = ' . $realSifre . '<br/>'
                                                                            . $languagedeger['IyiGunler'];
                                                                    $ogrenciID = count($veliOgrenciID);
                                                                    if ($ogrenciID > 0) {
                                                                        for ($d = 0; $d < $ogrenciID; $d++) {
                                                                            $ogrencidata[$d] = array(
                                                                                'BSVeliID' => $veliOgrenciID[$d],
                                                                                'BSVeliAd' => $veliOgrenciAd[$d],
                                                                                'BSOgrenciID' => $resultOgrenciID,
                                                                                'BSOgrenciAd' => $ogrenciAdSoyad
                                                                            );
                                                                        }
                                                                        $resultOgrenciID = $Panel_Model->addNewVeliOgrenci($ogrencidata);
                                                                        //kullanıcıya gerekli giriş bilgileri gönderiliyor.
                                                                        $resultMail = $form->sifreHatirlatMail($ogrenciEmail, $setTitle, $ogrenciAdSoyad, $subject, $body);
                                                                        $sonuc["newOgrenciID"] = $resultOgrenciID;
                                                                        $sonuc["insert"] = $languagedeger['OgrenciEkle'];
                                                                    } else {
                                                                        //kullanıcıya gerekli giriş bilgileri gönderiliyor.
                                                                        $resultMail = $form->sifreHatirlatMail($ogrenciEmail, $setTitle, $ogrenciAdSoyad, $subject, $body);
                                                                        $sonuc["newOgrenciID"] = $resultOgrenciID;
                                                                        $sonuc["insert"] = $languagedeger['OgrenciEkle'];
                                                                    }
                                                                } else {
                                                                    //bölge kaydedilirken hata geldi ise
                                                                    $deleteresult = $Panel_Model->ogrenciDelete($resultOgrenciID);
                                                                    $deleteresultt = $Panel_Model->ogrenciBolgeDelete($resultOgrenciID);
                                                                    if ($deleteresultt) {
                                                                        $sonuc["hata"] = $languagedeger['KurumSec'];
                                                                    }
                                                                }
                                                            } else {
                                                                //bölge kaydedilirken hata geldi ise
                                                                $deleteresult = $Panel_Model->ogrenciDelete($resultOgrenciID);
                                                                $deleteresultt = $Panel_Model->ogrenciBolgeDelete($resultOgrenciID);

                                                                if ($deleteresultt) {
                                                                    $sonuc["hata"] = $languagedeger['KurumSec'];
                                                                }
                                                            }
                                                        } else {
                                                            //bölge kaydedilirken hata geldi ise
                                                            $deleteresult = $Panel_Model->ogrenciDelete($resultOgrenciID);
                                                            $deleteresultt = $Panel_Model->ogrenciBolgeDelete($resultOgrenciID);

                                                            if ($deleteresultt) {
                                                                $sonuc["hata"] = $languagedeger['Hata'];
                                                            }
                                                        }
                                                    } else {
                                                        //eğer öğrencinin bölgesi yoksa
                                                        $deleteresult = $Panel_Model->ogrenciDelete($resultOgrenciID);
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
                case "ogrenciDetail":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $adminRutbe = Session::get("userRutbe");
                        //superadminse
                        if ($adminRutbe != 0) {
                            $form->post('ogrenciRowid', true);
                            $ogrenciDetailID = $form->values['ogrenciRowid'];

                            $ogrenciBolge = $Panel_Model->ogrenciDetailBolge($ogrenciDetailID);
                            //öğrenci bölge idler
                            $a = 0;
                            foreach ($ogrenciBolge as $ogrenciBolgee) {
                                $selectOgrenciBolge[$a]['SelectOgrenciBolgeID'] = $ogrenciBolgee['BSBolgeID'];
                                $selectOgrenciBolge[$a]['SelectOgrenciBolgeAdi'] = $ogrenciBolgee['BSBolgeAd'];
                                $ogrencibolgeId[] = $ogrenciBolgee['BSBolgeID'];
                                $a++;
                            }

                            //öğrenciye ait bölge varmı(kesin oalcak veliye a bölge seçtirmeden ekletmiyoruz
                            $ogrenciCountBolge = count($ogrencibolgeId);
                            if ($ogrenciCountBolge > 0) {
                                $ogrencibolgedizi = implode(',', $ogrencibolgeId);
                                //öğrencinin bolgesi dışındakiler
                                $digerBolge = $Panel_Model->ogrenciDetailSBolge($ogrencibolgedizi);
                                //öğrenci diğer bölgeler
                                $b = 0;
                                foreach ($digerBolge as $digerBolgee) {
                                    $digerOgrenciBolge[$b]['DigerOgrenciBolgeID'] = $digerBolgee['SBBolgeID'];
                                    $digerOgrenciBolge[$b]['DigerOgrenciBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                    $b++;
                                }
                            }

                            // öğrenci seçili kurum
                            $adminOgrenciKurum = $Panel_Model->adminDetailOgrenciKurum($ogrenciDetailID);
                            $ogrenciKurumCount = count($adminOgrenciKurum);
                            //eğer öğrencinin seçili kurumu varsa burası gelecek
                            if ($ogrenciKurumCount > 0) {
                                //kurum Veli idler
                                $c = 0;
                                foreach ($adminOgrenciKurum as $adminOgrenciKurumm) {
                                    $selectOgrenciKurum[$c]['SelectOgrenciKurumID'] = $adminOgrenciKurumm['BSKurumID'];
                                    $selectOgrenciKurum[$c]['SelectOgrenciKurumAd'] = $adminOgrenciKurumm['BSKurumAd'];
                                    $ogrencikurumId[] = $adminOgrenciKurumm['BSKurumID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $ogrencibolgedizim = implode(',', $ogrencibolgeId);
                                //seçili olan kurum
                                $ogrencibolgekurum = implode(',', $ogrencikurumId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminOgrenciBolgeKurum = $Panel_Model->adminSelectIsciBolge($ogrencibolgedizim, $ogrencibolgekurum);

                                if (count($adminOgrenciBolgeKurum) > 0) {
                                    $d = 0;
                                    foreach ($adminOgrenciBolgeKurum as $adminOgrenciBolgeKurumm) {
                                        $digerOgrenciKurum[$d]['DigerOgrenciKurumID'] = $adminOgrenciBolgeKurumm['SBKurumID'];
                                        $digerOgrenciKurum[$d]['DigerOgrenciKurumAd'] = $adminOgrenciBolgeKurumm['SBKurumAdi'];
                                        $d++;
                                    }
                                }
                            }

                            // öğrenci seçili veli
                            $adminOgrenciVeli = $Panel_Model->adminDetailOgrenciVeli($ogrenciDetailID);
                            $ogrenciVeliCount = count($adminOgrenciVeli);
                            //eğer  öğrencinin seçili velisi varsa burası gelecek
                            if ($ogrenciVeliCount > 0) {
                                //öğrenci Veli idler
                                $f = 0;
                                foreach ($adminOgrenciVeli as $adminOgrenciVelii) {
                                    $selectOgrenciVeli[$f]['SelectOgrenciVeliID'] = $adminOgrenciVelii['BSVeliID'];
                                    $selectOgrenciVeli[$f]['SelectOgrenciVeliAd'] = $adminOgrenciVelii['BSVeliAd'];
                                    $ogrenciveliId[] = $adminOgrenciVelii['BSVeliID'];
                                    $f++;
                                }
                                //seçili olan kurum
                                $ogrencikurumdizim = implode(',', $ogrencikurumId);
                                //seçili olan kurum
                                $ogrencibolgeveli = implode(',', $ogrenciveliId);
                                //adamın seçili olab kurumdaki diğer öğrenciler
                                $adminOgrenciKurumVeli = $Panel_Model->adminSelectOgrenciKurum($ogrencikurumdizim, $ogrencibolgeveli);

                                if (count($adminOgrenciKurumVeli) > 0) {
                                    $g = 0;
                                    foreach ($adminOgrenciKurumVeli as $adminOgrenciKurumVelii) {
                                        $digerOgrenciVeli[$g]['DigerOgrenciVeliID'] = $adminOgrenciKurumVelii['BSVeliID'];
                                        $digerOgrenciVeli[$g]['DigerOgrenciVeliAd'] = $adminOgrenciKurumVelii['BSVeliAd'];
                                        $g++;
                                    }
                                }
                            } else {
                                //seçili olan kurum
                                $ogrencikurumdizim = implode(',', $ogrencikurumId);
                                //adamın seçili olab kurumdaki diğer velileri
                                $adminOgrenciKurumVeli = $Panel_Model->adminSelectKurumVeli($ogrencikurumdizim);

                                $g = 0;
                                foreach ($adminOgrenciKurumVeli as $adminOgrenciKurumVelii) {
                                    $digerOgrenciVeli[$g]['DigerOgrenciVeliID'] = $adminOgrenciKurumVelii['BSVeliID'];
                                    $digerOgrenciVeli[$g]['DigerOgrenciVeliAd'] = $adminOgrenciKurumVelii['BSVeliAd'];
                                    $g++;
                                }
                            }


                            //Öğrenci Özellikleri
                            $ogrenciOzellik = $Panel_Model->ogrenciDetail($ogrenciDetailID);
                            foreach ($ogrenciOzellik as $ogrenciOzellikk) {
                                $ogrenciList[0]['OgrenciListID'] = $ogrenciOzellikk['BSOgrenciID'];
                                $ogrenciList[0]['OgrenciListAd'] = $ogrenciOzellikk['BSOgrenciAd'];
                                $ogrenciList[0]['OgrenciListSoyad'] = $ogrenciOzellikk['BSOgrenciSoyad'];
                                $ogrenciList[0]['OgrenciListTelefon'] = $ogrenciOzellikk['BSOgrenciPhone'];
                                $ogrenciList[0]['OgrenciListMail'] = $ogrenciOzellikk['BSOgrenciEmail'];
                                $ogrenciList[0]['OgrenciListLokasyon'] = $ogrenciOzellikk['BSOgrenciLocation'];
                                $ogrenciList[0]['OgrenciListUlke'] = $ogrenciOzellikk['BSOgrenciUlke'];
                                $ogrenciList[0]['OgrenciListIl'] = $ogrenciOzellikk['BSOgrenciIl'];
                                $ogrenciList[0]['OgrenciListIlce'] = $ogrenciOzellikk['BSOgrenciIlce'];
                                $ogrenciList[0]['OgrenciListSemt'] = $ogrenciOzellikk['BSOgrenciSemt'];
                                $ogrenciList[0]['OgrenciListMahalle'] = $ogrenciOzellikk['BSOgrenciMahalle'];
                                $ogrenciList[0]['OgrenciListSokak'] = $ogrenciOzellikk['BSOgrenciSokak'];
                                $ogrenciList[0]['OgrenciListPostaKodu'] = $ogrenciOzellikk['BSOgrenciPostaKodu'];
                                $ogrenciList[0]['OgrenciListCaddeNo'] = $ogrenciOzellikk['BSOgrenciCaddeNo'];
                                $ogrenciList[0]['OgrenciListAdres'] = $ogrenciOzellikk['BSOgrenciAdres'];
                                $ogrenciList[0]['OgrenciListDetayAdres'] = $ogrenciOzellikk['BSOgrenciDetayAdres'];
                                $ogrenciList[0]['OgrenciListDurum'] = $ogrenciOzellikk['Status'];
                                $ogrenciList[0]['OgrenciListAciklama'] = $ogrenciOzellikk['BSOgrenciAciklama'];
                                $ogrenciList[0]['OgrenciGBild'] = $ogrenciOzellikk['BildirimMesafeGidis'];
                                $ogrenciList[0]['OgrenciDBild'] = $ogrenciOzellikk['BildirimMesafeDonus'];
                                //tutarı virgülle ayırma
                                $ogrenciList[0]['OgrenciOTutar'] = $form->convertDecimal($ogrenciOzellikk['OdemeTutar']);
                                $ogrenciList[0]['OgrenciParaTip'] = $ogrenciOzellikk['OdemeParaTip'];
                            }
                        } else {
                            $adminID = Session::get("userId");
                            //normal adminse
                            $form->post('ogrenciRowid', true);
                            $ogrenciDetailID = $form->values['ogrenciRowid'];

                            //küçük adminin olan bölgeleri
                            $bolgeListeRutbe = $Panel_Model->AdminbolgeListele($adminID);

                            //bölge idler
                            $bolgerutbeId = [];
                            foreach ($bolgeListeRutbe as $bolgeListeRutbee) {
                                $bolgerutbeId[] = $bolgeListeRutbee['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            $ogrenciBolge = $Panel_Model->ogrenciDetailBolge($ogrenciDetailID);
                            //öğrenci bölge idler
                            $ogrencibolgeId = [];
                            $a = 0;
                            foreach ($ogrenciBolge as $ogrenciBolgee) {
                                $selectOgrenciBolge[$a]['SelectOgrenciBolgeID'] = $ogrenciBolgee['BSBolgeID'];
                                $selectOgrenciBolge[$a]['SelectOgrenciBolgeAdi'] = $ogrenciBolgee['BSBolgeAd'];
                                $ogrencibolgeId[] = $ogrenciBolgee['BSBolgeID'];
                                $a++;
                            }

                            //küçük admine göre farkını alıp, select olmayan bölgeleri çıkarıyoruz
                            $bolgefark = array_diff($bolgerutbeId, $ogrencibolgeId);
                            $bolgefarkk = implode(',', $bolgefark);

                            //öğrencinin bolgesi dışındakiler
                            $digerBolge = $Panel_Model->ogrenciDetailSBolge($bolgefarkk);
                            //öğrenci diğer bölgeler
                            $b = 0;
                            foreach ($digerBolge as $digerBolgee) {
                                $digerOgrenciBolge[$b]['DigerOgrenciBolgeID'] = $digerBolgee['SBBolgeID'];
                                $digerOgrenciBolge[$b]['DigerOgrenciBolgeAdi'] = $digerBolgee['SBBolgeAdi'];
                                $b++;
                            }

                            // öğrenci seçili kurum
                            $adminOgrenciKurum = $Panel_Model->adminDetailOgrenciKurum($ogrenciDetailID);
                            $ogrenciKurumCount = count($adminOgrenciKurum);
                            //eğer öğrencinin seçili kurumu varsa burası gelecek
                            if ($ogrenciKurumCount > 0) {
                                //kurum Veli idler
                                $c = 0;
                                foreach ($adminOgrenciKurum as $adminOgrenciKurumm) {
                                    $selectOgrenciKurum[$c]['SelectOgrenciKurumID'] = $adminOgrenciKurumm['BSKurumID'];
                                    $selectOgrenciKurum[$c]['SelectOgrenciKurumAd'] = $adminOgrenciKurumm['BSKurumAd'];
                                    $ogrencikurumId[] = $adminOgrenciKurumm['BSKurumID'];
                                    $c++;
                                }
                                //seçili olan bölge
                                $ogrencibolgedizim = implode(',', $ogrencibolgeId);
                                //seçili olan kurum
                                $ogrencibolgekurum = implode(',', $ogrencikurumId);
                                //adamın seçili olab bölgedeki diğer kurumları
                                $adminOgrenciBolgeKurum = $Panel_Model->adminSelectIsciBolge($ogrencibolgedizim, $ogrencibolgekurum);

                                if (count($adminOgrenciBolgeKurum) > 0) {
                                    $d = 0;
                                    foreach ($adminOgrenciBolgeKurum as $adminOgrenciBolgeKurumm) {
                                        $digerOgrenciKurum[$d]['DigerOgrenciKurumID'] = $adminOgrenciBolgeKurumm['SBKurumID'];
                                        $digerOgrenciKurum[$d]['DigerOgrenciKurumAd'] = $adminOgrenciBolgeKurumm['SBKurumAdi'];
                                        $d++;
                                    }
                                }
                            }

                            // öğrenci seçili veli
                            $adminOgrenciVeli = $Panel_Model->adminDetailOgrenciVeli($ogrenciDetailID);
                            $ogrenciVeliCount = count($adminOgrenciVeli);
                            //eğer  öğrencinin seçili velisi varsa burası gelecek
                            if ($ogrenciVeliCount > 0) {
                                //öğrenci Veli idler
                                $f = 0;
                                foreach ($adminOgrenciVeli as $adminOgrenciVelii) {
                                    $selectOgrenciVeli[$f]['SelectOgrenciVeliID'] = $adminOgrenciVelii['BSVeliID'];
                                    $selectOgrenciVeli[$f]['SelectOgrenciVeliAd'] = $adminOgrenciVelii['BSVeliAd'];
                                    $ogrenciveliId[] = $adminOgrenciVelii['BSVeliID'];
                                    $f++;
                                }
                                //seçili olan kurum
                                $ogrencikurumdizim = implode(',', $ogrencikurumId);
                                //seçili olan kurum
                                $ogrencibolgeveli = implode(',', $ogrenciveliId);
                                //adamın seçili olab kurumdaki diğer öğrenciler
                                $adminOgrenciKurumVeli = $Panel_Model->adminSelectOgrenciKurum($ogrencikurumdizim, $ogrencibolgeveli);

                                if (count($adminOgrenciKurumVeli) > 0) {
                                    $g = 0;
                                    foreach ($adminOgrenciKurumVeli as $adminOgrenciKurumVelii) {
                                        $digerOgrenciVeli[$g]['DigerOgrenciVeliID'] = $adminOgrenciKurumVelii['BSVeliID'];
                                        $digerOgrenciVeli[$g]['DigerOgrenciVeliAd'] = $adminOgrenciKurumVelii['BSVeliAd'];
                                        $g++;
                                    }
                                }
                            } else {
                                //seçili olan kurum
                                $ogrencikurumdizim = implode(',', $ogrencikurumId);
                                //adamın seçili olab kurumdaki diğer velileri
                                $adminOgrenciKurumVeli = $Panel_Model->adminSelectKurumVeli($ogrencikurumdizim);

                                $g = 0;
                                foreach ($adminOgrenciKurumVeli as $adminOgrenciKurumVelii) {
                                    $digerOgrenciVeli[$g]['DigerOgrenciVeliID'] = $adminOgrenciKurumVelii['BSVeliID'];
                                    $digerOgrenciVeli[$g]['DigerOgrenciVeliAd'] = $adminOgrenciKurumVelii['BSVeliAd'];
                                    $g++;
                                }
                            }


                            //Öğrenci Özellikleri
                            $ogrenciOzellik = $Panel_Model->ogrenciDetail($ogrenciDetailID);
                            foreach ($ogrenciOzellik as $ogrenciOzellikk) {
                                $ogrenciList[0]['OgrenciListID'] = $ogrenciOzellikk['BSOgrenciID'];
                                $ogrenciList[0]['OgrenciListAd'] = $ogrenciOzellikk['BSOgrenciAd'];
                                $ogrenciList[0]['OgrenciListSoyad'] = $ogrenciOzellikk['BSOgrenciSoyad'];
                                $ogrenciList[0]['OgrenciListTelefon'] = $ogrenciOzellikk['BSOgrenciPhone'];
                                $ogrenciList[0]['OgrenciListMail'] = $ogrenciOzellikk['BSOgrenciEmail'];
                                $ogrenciList[0]['OgrenciListLokasyon'] = $ogrenciOzellikk['BSOgrenciLocation'];
                                $ogrenciList[0]['OgrenciListUlke'] = $ogrenciOzellikk['BSOgrenciUlke'];
                                $ogrenciList[0]['OgrenciListIl'] = $ogrenciOzellikk['BSOgrenciIl'];
                                $ogrenciList[0]['OgrenciListIlce'] = $ogrenciOzellikk['BSOgrenciIlce'];
                                $ogrenciList[0]['OgrenciListSemt'] = $ogrenciOzellikk['BSOgrenciSemt'];
                                $ogrenciList[0]['OgrenciListMahalle'] = $ogrenciOzellikk['BSOgrenciMahalle'];
                                $ogrenciList[0]['OgrenciListSokak'] = $ogrenciOzellikk['BSOgrenciSokak'];
                                $ogrenciList[0]['OgrenciListPostaKodu'] = $ogrenciOzellikk['BSOgrenciPostaKodu'];
                                $ogrenciList[0]['OgrenciListCaddeNo'] = $ogrenciOzellikk['BSOgrenciCaddeNo'];
                                $ogrenciList[0]['OgrenciListAdres'] = $ogrenciOzellikk['BSOgrenciAdres'];
                                $ogrenciList[0]['OgrenciListDetayAdres'] = $ogrenciOzellikk['BSOgrenciDetayAdres'];
                                $ogrenciList[0]['OgrenciListDurum'] = $ogrenciOzellikk['Status'];
                                $ogrenciList[0]['OgrenciListAciklama'] = $ogrenciOzellikk['BSOgrenciAciklama'];
                                $ogrenciList[0]['OgrenciGBild'] = $ogrenciOzellikk['BildirimMesafeGidis'];
                                $ogrenciList[0]['OgrenciDBild'] = $ogrenciOzellikk['BildirimMesafeDonus'];
                                //tutarı virgülle ayırma
                                $ogrenciList[0]['OgrenciOTutar'] = $form->convertDecimal($ogrenciOzellikk['OdemeTutar']);
                                $ogrenciList[0]['OgrenciParaTip'] = $ogrenciOzellikk['OdemeParaTip'];
                            }
                        }
                        //sonuçlar
                        $sonuc["ogrenciSelectBolge"] = $selectOgrenciBolge;
                        $sonuc["ogrenciBolge"] = $digerOgrenciBolge;
                        $sonuc["ogrenciSelectKurum"] = $selectOgrenciKurum;
                        $sonuc["ogrenciKurum"] = $digerOgrenciKurum;
                        $sonuc["ogrenciSelectVeli"] = $selectOgrenciVeli;
                        $sonuc["ogrenciVeli"] = $digerOgrenciVeli;
                        $sonuc["ogrenciDetail"] = $ogrenciList;
                    }

                    break;
                case "ogrenciDetailDelete":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('ogrencidetail_id', true);
                        $ogrenciDetailID = $form->values['ogrencidetail_id'];

                        $deleteresult = $Panel_Model->detailOgrenciDelete($ogrenciDetailID);
                        if ($deleteresult) {
                            $deleteresultt = $Panel_Model->detailOgrenciBolgeDelete($ogrenciDetailID);
                            if ($deleteresultt) {
                                $deleteresulttt = $Panel_Model->detailOgrenciKurumDelete($ogrenciDetailID);
                                if ($deleteresulttt) {
                                    $deleteresultttt = $Panel_Model->detailOgrenciVeliDelete($ogrenciDetailID);
                                    if ($deleteresultttt) {
                                        $sonuc["delete"] = $languagedeger['OgrenciSil'];
                                    }
                                }
                            }
                        } else {
                            $sonuc["hata"] = $languagedeger['Hata'];
                        }
                    }

                    $sonuc["ogrenciDetail"] = $data["ogrenciDetail"];

                    break;
                case "ogrenciDetailKaydet":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('ogrencidetail_id', true);
                        $ogrenciID = $form->values['ogrencidetail_id'];
                        $form->post('ogrenciDetayAd', true);
                        $form->post('ogrenciDetaySoyad', true);
                        $form->post('ogrenciDetayEmail', true);
                        $form->post('ogrenciDetayDurum', true);
                        $form->post('ogrenciDetayLokasyon', true);
                        $form->post('ogrenciDetayTelefon', true);
                        $form->post('ogrenciDetayAdres', true);
                        $form->post('ogrenciDetayAciklama', true);
                        $form->post('ogrenciDetayUlke', true);
                        $form->post('ogrenciDetayIl', true);
                        $form->post('ogrenciDetayIlce', true);
                        $form->post('ogrenciDetaySemt', true);
                        $form->post('ogrenciDetayMahalle', true);
                        $form->post('ogrenciDetaySokak', true);
                        $form->post('ogrenciDetayPostaKodu', true);
                        $form->post('ogrenciDetayCaddeNo', true);
                        $form->post('detayAdres', true);
                        $form->post('gdsbildirim', true);
                        $form->post('dnsbildirim', true);
                        $form->post('odemeTutar', true);
                        $form->post('odemeTip', true);
                        $form->post('eskiAd', true);
                        $form->post('eskiSoyad', true);
                        $eskiAd = $form->values['eskiAd'];
                        $eskiSoyad = $form->values['eskiSoyad'];

                        $ogrenciAd = $form->values['ogrenciDetayAd'];
                        $ogrenciSoyad = $form->values['ogrenciDetaySoyad'];
                        $ogrenciAdSoyad = $ogrenciAd . ' ' . $ogrenciSoyad;
                        $ogrenciEmail = $form->values['ogrenciDetayEmail'];
                        $odemeTutar = $form->values['odemeTutar'];

                        $ogrenciBolgeID = $_REQUEST['ogrenciBolgeID'];
                        $ogrenciBolgeAdi = $_REQUEST['ogrenciBolgeAd'];
                        $ogrenciKurumID = $_REQUEST['ogrenciKurumID'];
                        $ogrenciKurumAd = $_REQUEST['ogrenciKurumAd'];
                        $ogrenciVeliID = $_REQUEST['ogrenciVeliID'];
                        $ogrenciVeliAd = $_REQUEST['ogrenciVeliAd'];

                        if (!filter_var($ogrenciEmail, FILTER_VALIDATE_EMAIL) === false) {
                            $emailValidate = $form->mailControl1($ogrenciEmail);
                            if ($emailValidate == 1) {
                                $kullaniciliste = $Panel_Model->ogrenciEmailDbKontrol($ogrenciEmail);
                                if (count($kullaniciliste) <= 0) {
                                    //gelen para değerini virgülden temizleme
                                    $length = strlen($odemeTutar);
                                    for ($l = 0; $l < $length; $l++) {
                                        if ($odemeTutar[$l] != ",") {
                                            $odemeValue.=$odemeTutar[$l];
                                        }
                                    }
                                    if ($form->submit()) {
                                        $data = array(
                                            'BSOgrenciAd' => $ogrenciAd,
                                            'BSOgrenciSoyad' => $ogrenciSoyad,
                                            'BSOgrenciPhone' => $form->values['ogrenciDetayTelefon'],
                                            'BSOgrenciEmail' => $ogrenciEmail,
                                            'BSOgrenciLocation' => $form->values['ogrenciDetayLokasyon'],
                                            'BSOgrenciUlke' => $form->values['ogrenciDetayUlke'],
                                            'BSOgrenciIl' => $form->values['ogrenciDetayIl'],
                                            'BSOgrenciIlce' => $form->values['ogrenciDetayIlce'],
                                            'BSOgrenciSemt' => $form->values['ogrenciDetaySemt'],
                                            'BSOgrenciMahalle' => $form->values['ogrenciDetayMahalle'],
                                            'BSOgrenciSokak' => $form->values['ogrenciDetaySokak'],
                                            'BSOgrenciPostaKodu' => $form->values['ogrenciDetayPostaKodu'],
                                            'BSOgrenciCaddeNo' => $form->values['ogrenciDetayCaddeNo'],
                                            'BSOgrenciAdres' => $form->values['ogrenciDetayAdres'],
                                            'BSOgrenciDetayAdres' => $form->values['detayAdres'],
                                            'BSOgrenciAciklama' => $form->values['ogrenciDetayAciklama'],
                                            'Status' => $form->values['ogrenciDetayDurum'],
                                            'BildirimMesafeGidis' => $form->values['gdsbildirim'],
                                            'BildirimMesafeDonus' => $form->values['dnsbildirim'],
                                            'OdemeTutar' => $odemeValue,
                                            'OdemeParaTip' => $form->values['odemeTip']
                                        );
                                    }
                                    $resultOgrenciUpdate = $Panel_Model->ogrenciOzelliklerDuzenle($data, $ogrenciID);
                                    if ($resultOgrenciUpdate) {
                                        if ($ogrenciAd != $eskiAd || $ogrenciSoyad != $eskiSoyad) {
                                            $dataDuzenle = array(
                                                'BSGonderenAdSoyad' => $ogrenciAdSoyad
                                            );
                                            $updateduyuru = $Panel_Model->ogrOzellikDuzenle($dataDuzenle, $ogrenciID);
                                            //duyurulogları
                                            $dataDuzenle1 = array(
                                                'BSEkleyenAdSoyad' => $ogrenciAdSoyad
                                            );
                                            $updateduyurulog = $Panel_Model->ogrOzellikDuzenle1($dataDuzenle1, $ogrenciID);
                                            $dataDuzenle2 = array(
                                                'BSOdemeYapanAd' => $ogrenciAdSoyad
                                            );
                                            $updateodeme = $Panel_Model->ogrOzellikDuzenle2($dataDuzenle2, $ogrenciID);
                                            $dataDuzenle3 = array(
                                                'BSOgrenciAd' => $ogrenciAdSoyad
                                            );
                                            $updateogrtur = $Panel_Model->ogrOzellikDuzenle3($dataDuzenle3, $ogrenciID);
                                            $dataDuzenle4 = array(
                                                'BSOgrenciIsciAd' => $ogrenciAdSoyad
                                            );
                                            $updateogriscitur = $Panel_Model->ogrOzellikDuzenle4($dataDuzenle4, $ogrenciID);
                                        }
                                        $veliOgrenciCount = count($ogrenciVeliID);
                                        if ($veliOgrenciCount > 0) {
                                            $deleteVeliOgrenci = $Panel_Model->detailOgrenciVeliDelete($ogrenciID);
                                            if ($deleteVeliOgrenci) {
                                                for ($d = 0; $d < $veliOgrenciCount; $d++) {
                                                    $ogrencidata[$d] = array(
                                                        'BSOgrenciID' => $ogrenciID,
                                                        'BSOgrenciAd' => $ogrenciAdSoyad,
                                                        'BSVeliID' => $ogrenciVeliID[$d],
                                                        'BSVeliAd' => $ogrenciVeliAd[$d]
                                                    );
                                                }
                                                $resultOgrenciID = $Panel_Model->addNewVeliOgrenci($ogrencidata);
                                                if ($resultOgrenciID) {
                                                    $deleteresultt = $Panel_Model->detailOgrenciKurumDelete($ogrenciID);
                                                    if ($deleteresultt) {
                                                        $ogrenciKurumCount = count($ogrenciKurumID);
                                                        for ($c = 0; $c < $ogrenciKurumCount; $c++) {
                                                            $kurumdata[$c] = array(
                                                                'BSKurumID' => $ogrenciKurumID[$c],
                                                                'BSKurumAd' => $ogrenciKurumAd[$c],
                                                                'BSOgrenciID' => $ogrenciID,
                                                                'BSOgrenciAd' => $ogrenciAdSoyad
                                                            );
                                                        }
                                                        $resultKurumID = $Panel_Model->addNewOgrenciKurum($kurumdata);
                                                        if ($resultKurumID) {
                                                            $bolgeID = count($ogrenciBolgeID);
                                                            $deleteresulttt = $Panel_Model->detailOgrenciBolgeDelete($ogrenciID);
                                                            if ($deleteresulttt) {
                                                                for ($b = 0; $b < $bolgeID; $b++) {
                                                                    $bolgedata[$b] = array(
                                                                        'BSOgrenciID' => $ogrenciID,
                                                                        'BSOgrenciAd' => $ogrenciAdSoyad,
                                                                        'BSBolgeID' => $ogrenciBolgeID[$b],
                                                                        'BSBolgeAd' => $ogrenciBolgeAdi[$b]
                                                                    );
                                                                }
                                                                $resultBolgeID = $Panel_Model->addNewBolgeOgrenci($bolgedata);
                                                                if ($resultBolgeID) {
                                                                    $sonuc["newOgrenciID"] = $ogrenciID;
                                                                    $sonuc["update"] = $languagedeger['OgrenciDuzenle'];
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
                                            $deleteresultt = $Panel_Model->detailOgrenciKurumDelete($ogrenciID);
                                            if ($deleteresultt) {
                                                $ogrenciKurumCount = count($ogrenciKurumID);
                                                for ($c = 0; $c < $ogrenciKurumCount; $c++) {
                                                    $kurumdata[$c] = array(
                                                        'BSKurumID' => $ogrenciKurumID[$c],
                                                        'BSKurumAd' => $ogrenciKurumAd[$c],
                                                        'BSOgrenciID' => $ogrenciID,
                                                        'BSOgrenciAd' => $ogrenciAdSoyad
                                                    );
                                                }
                                                $resultKurumID = $Panel_Model->addNewOgrenciKurum($kurumdata);
                                                if ($resultKurumID) {
                                                    $bolgeID = count($ogrenciBolgeID);
                                                    $deleteresulttt = $Panel_Model->detailOgrenciBolgeDelete($ogrenciID);
                                                    if ($deleteresulttt) {
                                                        for ($b = 0; $b < $bolgeID; $b++) {
                                                            $bolgedata[$b] = array(
                                                                'BSOgrenciID' => $ogrenciID,
                                                                'BSOgrenciAd' => $ogrenciAdSoyad,
                                                                'BSBolgeID' => $ogrenciBolgeID[$b],
                                                                'BSBolgeAd' => $ogrenciBolgeAdi[$b]
                                                            );
                                                        }
                                                        $resultBolgeID = $Panel_Model->addNewBolgeOgrenci($bolgedata);
                                                        if ($resultBolgeID) {
                                                            $sonuc["newOgrenciID"] = $ogrenciID;
                                                            $sonuc["update"] = $languagedeger['OgrenciDuzenle'];
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
                case "adminOgrenciDetailTur":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $form->post('ogrenciID', true);
                        $adminOgrDetailID = $form->values['ogrenciID'];
                        //öğrenci tur tablosu için
                        $ogrTurDetail = $Panel_Model->adminOgrenciTurDetail($adminOgrDetailID);
                        $ogrturId = array();
                        $a = 0;
                        foreach ($ogrTurDetail as $ogrTurDetaill) {
                            $ogrturId[] = $ogrTurDetaill['BSTurID'];
                            $a++;
                        }
                        //öğrenciişçi tur tablosu için
                        $ogrTurDetailler = $Panel_Model->adminOgrenciTurDetail2($adminOgrDetailID);
                        $ogrisciturId = array();
                        $a = 0;
                        foreach ($ogrTurDetailler as $ogrTurDetaillerr) {
                            $ogrisciturId[] = $ogrTurDetaillerr['BSTurID'];
                            $a++;
                        }
                        $yeni_dizi = array_merge($ogrturId, $ogrisciturId);
                        $turId = implode(',', $yeni_dizi);

                        $ogrTur = $Panel_Model->ogrenciDetailTur($turId);
                        $b = 0;
                        foreach ($ogrTur as $ogrTurr) {
                            $ogrenciDetailTur[$b]['TurID'] = $ogrTurr['SBTurID'];
                            $ogrenciDetailTur[$b]['TurAd'] = $ogrTurr['SBTurAd'];
                            $ogrenciDetailTur[$b]['TurAciklama'] = $ogrTurr['SBTurAciklama'];
                            $ogrenciDetailTur[$b]['TurAktiflik'] = $ogrTurr['SBTurAktiflik'];
                            $ogrenciDetailTur[$b]['TurKurum'] = $ogrTurr['SBKurumAd'];
                            $ogrenciDetailTur[$b]['TurTip'] = $ogrTurr['SBTurTip'];
                            $ogrenciDetailTur[$b]['TurBolge'] = $ogrTurr['SBBolgeAd'];
                            $b++;
                        }
                        $sonuc["ogrenciDetailTur"] = $ogrenciDetailTur;
                    }
                    break;
                case "OgrenciBolgeDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $ogrenciDetailBolgeID = $_REQUEST['ogrenciDetailBolgeID'];
                        $form->post('ogrenciID', true);
                        $ogrenciID = $form->values['ogrenciID'];

                        //Öğrenciye ait kurumlar
                        $adminOgrenciKurum = $Panel_Model->ogrenciDetailMultiSelectVeli($ogrenciID);
                        if (count($adminOgrenciKurum) > 0) {
                            $ogrencikurumId = [];
                            foreach ($adminOgrenciKurum as $adminOgrenciKurumm) {
                                $ogrencikurumId[] = $adminOgrenciKurumm['BSKurumID'];
                            }
                            //öğrenciye ait kurumlar
                            $ogrencibolgekurum = implode(',', $ogrencikurumId);
                            //seçilen bölgeler
                            $ogrencibolgedizim = implode(',', $ogrenciDetailBolgeID);
                            //seçilen bölgedeki kurumlar
                            $ogrenciBolgeKurum = $Panel_Model->adminSelectBolgeKurumm($ogrencibolgedizim);
                            $ogrenciDigerKurumId = [];
                            foreach ($ogrenciBolgeKurum as $ogrenciBolgeKurumm) {
                                $ogrenciDigerKurumId[] = $ogrenciBolgeKurumm['SBKurumID'];
                            }
                            //gelen kurum ıdlerinde aynı olan idler, seçili kurumlardır.
                            $ortakIDler = array_intersect($ogrencikurumId, $ogrenciDigerKurumId);
                            //gelen idlerde ki farklı olanlar seçili olmayan kurumlardır yani diğer kurumlar
                            $kurum_fark = array_diff($ogrenciDigerKurumId, $ogrencikurumId);
                            $diger_kurum_fark = implode(',', $kurum_fark);
                            //ortak ıd ye sahip kurum varmı
                            if (count($ortakIDler) > 0) {
                                //seçili kurumlar
                                $secilenIdKurum = implode(',', $ortakIDler);
                                $selectBolgeKurum = $Panel_Model->ogrenciNotSelectKurum($secilenIdKurum);
                                $c = 0;
                                foreach ($selectBolgeKurum as $selectBolgeKurumm) {
                                    $selectOgrenciKurum[$c]['SelectOgrenciKurumID'] = $selectBolgeKurumm['SBKurumID'];
                                    $selectOgrenciKurum[$c]['SelectOgrenciKurumAd'] = $selectBolgeKurumm['SBKurumAdi'];
                                    $c++;
                                }

                                //diğer kurumlar
                                $digerBolgeKurum = $Panel_Model->ogrenciNotSelectKurum($diger_kurum_fark);

                                $d = 0;
                                foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                    $digerOgrenciKurum[$d]['DigerOgrenciKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                    $digerOgrenciKurum[$d]['DigerOgrenciKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili kurum yoktur
                                //diğer kurumlar
                                $digerBolgeKurum = $Panel_Model->ogrenciNotSelectKurum($diger_kurum_fark);

                                $d = 0;
                                foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                    $digerOgrenciKurum[$d]['DigerOgrenciKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                    $digerOgrenciKurum[$d]['DigerOgrenciKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                    $d++;
                                }
                            }
                        } else {
                            $ogrenciDetailBollgeID = implode(',', $ogrenciDetailBolgeID);
                            //adamın seçili olab bölgedeki diğer kurumları
                            $digerBolgeKurum = $Panel_Model->adminSelectBolgeKurumm($ogrenciDetailBollgeID);

                            $d = 0;
                            foreach ($digerBolgeKurum as $digerBolgeKurumm) {
                                $digerOgrenciKurum[$d]['DigerOgrenciKurumID'] = $digerBolgeKurumm['SBKurumID'];
                                $digerOgrenciKurum[$d]['DigerOgrenciKurumAd'] = $digerBolgeKurumm['SBKurumAdi'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminOgrenciSelectKurum"] = $selectOgrenciKurum;
                        $sonuc["adminOgrenciKurum"] = $digerOgrenciKurum;
                    }
                    break;
                case "OgrenciVeliDetailMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $ogrenciDetailKurumID = $_REQUEST['veliDetailKurumID'];
                        $form->post('ogrenciID', true);
                        $ogrenciID = $form->values['ogrenciID'];

                        //Öğrenciye ait veliler
                        $adminOgrenciVelim = $Panel_Model->ogrenciDetailMultiSelect($ogrenciID);
                        if (count($adminOgrenciVelim) > 0) {
                            $ogrenciveliId = [];
                            foreach ($adminOgrenciVelim as $adminOgrenciVelimm) {
                                $ogrenciveliId[] = $adminOgrenciVelimm['BSVeliID'];
                            }
                            //öğrenciler ait veliler
                            $ogrencibolgeveli = implode(',', $ogrenciveliId);
                            //seçilen kurumlar
                            $ogrencikurumdizim = implode(',', $ogrenciDetailKurumID);
                            //seçilen kurumdaki öğrenciler
                            $ogrenciKurumVeli = $Panel_Model->adminSelectBolgeKurumVeli($ogrencikurumdizim);
                            $OgrenciDigerveliId = [];
                            foreach ($ogrenciKurumVeli as $OgrenciKurumVelii) {
                                $OgrenciDigerveliId[] = $OgrenciKurumVelii['BSVeliID'];
                            }
                            //gelen veli ıdlerinde aynı olan idler, seçili veliler.
                            $ortakIDler = array_intersect($ogrenciveliId, $OgrenciDigerveliId);
                            //gelen idlerde ki farklı olanlar seçili olmayan velilerdir yani diğer veliler
                            $veli_fark = array_diff($OgrenciDigerveliId, $ogrenciveliId);
                            $diger_veli_fark = implode(',', $veli_fark);
                            //ortak ıd ye sahip veli varmı
                            if (count($ortakIDler) > 0) {
                                //seçili veliler
                                $secilenIdVeli = implode(',', $ortakIDler);
                                $selectKurumVeli = $Panel_Model->ogrenciNotSelectVeli($secilenIdVeli);
                                $c = 0;
                                foreach ($selectKurumVeli as $selectKurumVelii) {
                                    $selectOgrenciVeli[$c]['SelectOgrenciVeliID'] = $selectKurumVelii['SBVeliID'];
                                    $selectOgrenciVeli[$c]['SelectOgrenciVeliAd'] = $selectKurumVelii['SBVeliAd'];
                                    $c++;
                                }

                                //diğer veliler
                                $digerKurumVeli = $Panel_Model->ogrenciNotSelectVeli($diger_veli_fark);

                                $d = 0;
                                foreach ($digerKurumVeli as $digerKurumVelii) {
                                    $digerOgrenciVeli[$d]['DigerVeliOgrenciID'] = $digerKurumVelii['SBVeliID'];
                                    $digerOgrenciVeli[$d]['DigerVeliOgrenciAd'] = $digerKurumVelii['SBVeliAd'];
                                    $d++;
                                }
                            } else {
                                //ortak id yoksa seçili veli yoktur
                                //diğer veli
                                $digerKurumVeli = $Panel_Model->ogrenciNotSelectVeli($diger_veli_fark);

                                $d = 0;
                                foreach ($digerKurumVeli as $digerKurumVelii) {
                                    $digerOgrenciVeli[$d]['DigerVeliOgrenciID'] = $digerKurumVelii['SBVeliID'];
                                    $digerOgrenciVeli[$d]['DigerVeliOgrenciAd'] = $digerKurumVelii['SBVeliAd'];
                                    $d++;
                                }
                            }
                        } else {
                            $ogrenciDetailKurummID = implode(',', $ogrenciDetailKurumID);
                            //adamın seçili olan kurumdaki diğer velileri
                            $digerKurumVeli = $Panel_Model->adminSelectBolgeKurumVeli($ogrenciDetailKurummID);

                            $d = 0;
                            foreach ($digerKurumVeli as $digerKurumVelii) {
                                $digerOgrenciVeli[$d]['DigerVeliOgrenciID'] = $digerKurumVelii['SBVeliID'];
                                $digerOgrenciVeli[$d]['DigerVeliOgrenciAd'] = $digerKurumVelii['SBVeliAd'];
                                $d++;
                            }
                        }

                        //sonuçlar
                        $sonuc["adminOgrenciSelectVeli"] = $selectOgrenciVeli;
                        $sonuc["adminOgrenciVeli"] = $digerOgrenciVeli;
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

