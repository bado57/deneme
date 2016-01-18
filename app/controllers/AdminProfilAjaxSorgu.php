<?php

class AdminProfilAjaxSorgu extends Controller {

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
            //language 
            $lang = Session::get("dil");
            $formlanguage = $this->load->ajaxlanguage($lang);
            $deger = $formlanguage->ajaxlanguage();
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");

            $form->post("tip", true);
            $tip = $form->values['tip'];
            Switch ($tip) {

                case "profilDuzenle":

                    $adminID = Session::get("userId");
                    if (!$adminID) {
                        $form->yonlendir("Location:" . SITE_URL_LOGOUT);
                    } else {

                        $form->post('ad', true);
                        $ad = $form->values['ad'];
                        $form->post('soyad', true);
                        $soyad = $form->values['soyad'];
                        $form->post('sifre', true);
                        $form->post('aciklama', true);
                        $form->post('telefon', true);
                        $form->post('email', true);
                        $form->post('lokasyon', true);
                        $form->post('ulke', true);
                        $form->post('il', true);
                        $form->post('ilce', true);
                        $form->post('semt', true);
                        $form->post('mahalle', true);
                        $form->post('sokak', true);
                        $form->post('postakodu', true);
                        $form->post('caddeno', true);
                        $form->post('adres', true);

                        if ($form->submit()) {
                            $data = array(
                                'BSAdminAd' => $ad,
                                'BSAdminSoyad' => $soyad,
                                'BSAdminPhone' => $form->values['telefon'],
                                'BSAdminEmail' => $form->values['email'],
                                'BSAdminLocation' => $form->values['lokasyon'],
                                'BSAdminUlke' => $form->values['ulke'],
                                'BSAdminIl' => $form->values['il'],
                                'BSAdminIlce' => $form->values['ilce'],
                                'BSAdminSemt' => $form->values['semt'],
                                'BSAdminMahalle' => $form->values['mahalle'],
                                'BSAdminSokak' => $form->values['sokak'],
                                'BSAdminPostaKodu' => $form->values['postakodu'],
                                'BSAdminCaddeNo' => $form->values['caddeno'],
                                'BSAdminAdres' => $form->values['adres'],
                                'BSAdminAciklama' => $form->values['aciklama']
                            );
                        }

                        $resultupdate = $Panel_Model->adminProfilDuzenle($data, $adminID);

                        if ($resultupdate) {
                            unset($_SESSION['kullaniciad']);
                            unset($_SESSION['kullanicisoyad']);
                            Session::set("kullaniciad", $ad);
                            Session::set("kullanicisoyad", $soyad);
                            $sonuc["update"] = $deger["ProfilDuzenle"];
                        } else {
                            $sonuc["hata"] = $deger["Hata"];
                        }
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

