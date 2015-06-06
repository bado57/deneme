<?php

class AdminDuyuruAjaxSorgu extends Controller {

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
            //dil yapılandırılması
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (!Session::get("dil")) {
                Session::set("dil", $lang);
                $formm = $this->load->multilanguage($lang);
                $deger = $formm->multilanguage();
            } else {
                $formm = $this->load->multilanguage(Session::get("dil"));
                $deger = $formm->multilanguage();
            }
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            //form class bağlanısı
            $MemcacheModel = $this->load->model("adminmemcache_model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            $adSoyad = Session::get("kullaniciad") . ' ' . Session::get("kullanicisoyad");
            $bolgeIcon = 'fa fa-th';
            $bolgeUrl = 'bolgeliste';
            Switch ($tip) {

                case "duyuruBolgeSelect":
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
                        } else {//değilse admin ıd ye göre bölge görür
                            $bolgeListeRutbe = $Panel_Model->adminAracBolgeListele($adminID);

                            foreach ($bolgeListeRutbe as $rutbe) {
                                $bolgerutbeId[] = $rutbe['BSBolgeID'];
                            }
                            $rutbebolgedizi = implode(',', $bolgerutbeId);

                            //rütbeye göre bölge listele
                            $bolgeListe = $Panel_Model->adminRutbeAracBolgeListele($rutbebolgedizi);

                            $a = 0;
                            foreach ($bolgeListe as $bolgelist) {
                                $adminBolge['AdminBolge'][$a] = $bolgelist['SBBolgeAdi'];
                                $adminBolge['AdminBolgeID'][$a] = $bolgelist['SBBolgeID'];
                                $a++;
                            }
                        }

                        $sonuc["adminDuyuruBolge"] = $adminBolge;
                    }
                    break;

                case "duyuruBolgeAdminMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multiadmindizi = implode(',', $duyuruBolgeID);

                        $adminBolgeListe = $Panel_Model->duyuruBolgeMultiAdmin($multiadmindizi);
                        foreach ($adminBolgeListe as $adminBolgeListee) {
                            $bolgeAdminId[] = $adminBolgeListee['BSAdminID'];
                        }
                        $bolgeAdminIdler = implode(',', $bolgeAdminId);
                        //adminleri getirir
                        $adminListe = $Panel_Model->duyuruAdmin($bolgeAdminIdler);

                        $a = 0;
                        foreach ($adminListe as $adminListee) {
                            $duyuruAdmin['AdminID'][$a] = $adminListee['BSAdminID'];
                            $duyuruAdmin['AdminAd'][$a] = $adminListee['BSAdminAd'];
                            $duyuruAdmin['AdminSoyad'][$a] = $adminListee['BSAdminSoyad'];
                            $a++;
                        }

                        $sonuc["duyuruAdmin"] = $duyuruAdmin;
                    }
                    break;

                case "duyuruBolgeSoforMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multisofordizi = implode(',', $duyuruBolgeID);

                        $soforBolgeListe = $Panel_Model->duyuruBolgeMultiSofor($multisofordizi);
                        $a = 0;
                        foreach ($soforBolgeListe as $soforBolgeListee) {
                            $duyuruSofor['SoforID'][$a] = $soforBolgeListee['BSSoforID'];
                            $duyuruSofor['SoforAd'][$a] = $soforBolgeListee['BSSoforAd'];
                            $a++;
                        }

                        $sonuc["duyuruSofor"] = $duyuruSofor;
                    }
                    break;

                case "duyuruBolgeHostesMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multihostesdizi = implode(',', $duyuruBolgeID);

                        $hostesBolgeListe = $Panel_Model->duyuruBolgeMultiHostes($multihostesdizi);
                        $a = 0;
                        foreach ($hostesBolgeListe as $hostesBolgeListee) {
                            $duyuruHostes['HostesID'][$a] = $hostesBolgeListee['BSHostesID'];
                            $duyuruHostes['HostesAd'][$a] = $hostesBolgeListee['BSHostesAd'];
                            $a++;
                        }

                        $sonuc["duyuruHostes"] = $duyuruHostes;
                    }
                    break;

                case "duyuruBolgeVeliMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multivelidizi = implode(',', $duyuruBolgeID);

                        $veliBolgeListe = $Panel_Model->duyuruBolgeMultiVeli($multivelidizi);
                        $a = 0;
                        foreach ($veliBolgeListe as $veliBolgeListee) {
                            $duyuruVeli['VeliID'][$a] = $veliBolgeListee['BSVeliID'];
                            $duyuruVeli['VeliAd'][$a] = $veliBolgeListee['BSVeliAd'];
                            $a++;
                        }

                        $sonuc["duyuruVeli"] = $duyuruVeli;
                    }
                    break;

                case "duyuruBolgeOgrenciMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multiogrencidizi = implode(',', $duyuruBolgeID);

                        $ogrenciBolgeListe = $Panel_Model->duyuruBolgeMultiOgrenci($multiogrencidizi);
                        $a = 0;
                        foreach ($ogrenciBolgeListe as $ogrenciBolgeListee) {
                            $duyuruOgrenci['OgrenciID'][$a] = $ogrenciBolgeListee['BSOgrenciID'];
                            $duyuruOgrenci['OgrenciAd'][$a] = $ogrenciBolgeListee['BSOgrenciAd'];
                            $a++;
                        }

                        $sonuc["duyuruOgrenci"] = $duyuruOgrenci;
                    }
                    break;

                case "duyuruBolgePersonelMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multiiscidizi = implode(',', $duyuruBolgeID);

                        $isciBolgeListe = $Panel_Model->duyuruBolgeMultiIsci($multiiscidizi);
                        $a = 0;
                        foreach ($isciBolgeListe as $isciBolgeListee) {
                            $duyuruIsci['PersonelID'][$a] = $isciBolgeListee['SBIsciID'];
                            $duyuruIsci['PersonelAd'][$a] = $isciBolgeListee['SBIsciAd'];
                            $a++;
                        }

                        $sonuc["duyuruPersonel"] = $duyuruIsci;
                    }
                    break;

                case "duyuruKurumMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruBolgeID = $_REQUEST['duyuruBolgeID'];
                        $multikurumdizi = implode(',', $duyuruBolgeID);

                        $kurumListe = $Panel_Model->duyuruKurumMultiSelect($multikurumdizi);

                        $a = 0;
                        foreach ($kurumListe as $kurumListee) {
                            $kurumSelect['KurumSelectID'][$a] = $kurumListee['SBKurumID'];
                            $kurumSelect['KurumSelectAd'][$a] = $kurumListee['SBKurumAdi'];
                            $a++;
                        }
                        $sonuc["kurumMultiSelect"] = $kurumSelect;
                    }
                    break;

                case "duyuruKurumVeli":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $duyuruKurum = implode(',', $duyuruKurumID);

                        $veliListe = $Panel_Model->duyuruKurumVeli($duyuruKurum);

                        $a = 0;
                        foreach ($veliListe as $veliListee) {
                            $duyuruKurumVeli['VeliID'][$a] = $veliListee['BSVeliID'];
                            $duyuruKurumVeli['VeliAd'][$a] = $veliListee['BSVeliAd'];
                            $a++;
                        }
                        $sonuc["duyuruVeli"] = $duyuruKurumVeli;
                    }
                    break;

                case "duyuruKurumOgrenci":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $kurumOgrenciDizi = implode(',', $duyuruKurumID);

                        $ogrenciListe = $Panel_Model->duyuruKurumOgrenci($kurumOgrenciDizi);

                        $a = 0;
                        foreach ($ogrenciListe as $ogrenciListee) {
                            $duyuruKurumOgrenci['OgrenciID'][$a] = $ogrenciListee['BSOgrenciID'];
                            $duyuruKurumOgrenci['OgrenciAd'][$a] = $ogrenciListee['BSOgrenciAd'];
                            $a++;
                        }
                        $sonuc["duyuruOgrenci"] = $duyuruKurumOgrenci;
                    }
                    break;

                case "duyuruKurumIsci":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $kurumIsciDizi = implode(',', $duyuruKurumID);

                        $isciListe = $Panel_Model->duyuruKurumIsci($kurumIsciDizi);

                        $a = 0;
                        foreach ($isciListe as $isciListee) {
                            $duyuruPersonel['PersonelID'][$a] = $isciListee['SBIsciID'];
                            $duyuruPersonel['PersonelAd'][$a] = $isciListee['SBIsciAd'];
                            $a++;
                        }
                        $sonuc["duyuruPersonel"] = $duyuruPersonel;
                    }
                    break;

                case "duyuruTurMultiSelect":
                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        header("Location:" . SITE_URL_LOGOUT);
                    } else {
                        $duyuruKurumID = $_REQUEST['duyuruKurumID'];
                        $multiturdizi = implode(',', $duyuruKurumID);
                        
                        $turListe = $Panel_Model->duyuruTurMultiSelect($multiturdizi);

                        $a = 0;
                        foreach ($turListe as $turListee) {
                            $turSelect['TurSelectID'][$a] = $turListee['SBTurID'];
                            $turSelect['TurSelectAd'][$a] = $turListee['SBTurAd'];
                            $a++;
                        }
                        $sonuc["turMultiSelect"] = $turSelect;
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

