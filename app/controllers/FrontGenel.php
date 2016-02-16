<?php

class FrontGenel extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->ajaxCall();
    }

    public function ajaxCall() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
            //dil yapılandırılması
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (!Session::get("dil")) {
                Session::set("dil", $lang);
                $formMulti = $this->load->frontmultilanguage($lang);
                $degerHF = $formMulti->frontAjaxmultilanguage();
            } else {
                $lang = Session::get("dil");
                $formMulti = $this->load->frontajaxmultilanguage($lang);
                $degerHF = $formMulti->ajaxlanguage();
            }
            $sonuc = array();
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model_Our");
            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {
                case "iletisim":
                    $form->post("adsoyad", true);
                    $form->post("email", true);
                    $form->post("mesaj", true);
                    $adsoyad = $form->values['adsoyad'];
                    $email = $form->values['email'];
                    $mesaj = $form->values['mesaj'];
                    if ($adsoyad != "") {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                            $emailValidate = $form->mailControl1($email);
                            if ($emailValidate == 1) {
                                if ($mesaj != "") {
                                    if ($form->submit()) {
                                        $data = array(
                                            'iletisim_AdSoyad' => $adsoyad,
                                            'iletisim_email' => $email,
                                            'iletisim_mesaj' => $mesaj,
                                            'iletisim_Okundu' => 0
                                        );
                                    }
                                    $resultIletisim = $Panel_Model->insertIletisim($data);
                                    if ($resultIletisim) {
                                        $resultMail = $form->frontIletisimMail($adsoyad, $email, $mesaj);
                                        $sonuc["result"] = $degerHF["MesajSonuc"];
                                    } else {
                                        $sonuc["hata"] = $degerHF["Hata"];
                                    }
                                } else {
                                    $sonuc["hata"] = $degerHF["MesajGir"];
                                }
                            } else {
                                $sonuc["hata"] = $degerHF["KullanilirEmail"];
                            }
                        } else {
                            $sonuc["hata"] = $degerHF["GecerliEmail"];
                        }
                    } else {
                        $sonuc["hata"] = $degerHF["IsimGir"];
                    }
                    break;
                case "signupKayit":
                    $sonuc["result"] = $degerHF["TestSurec"];
                    break;
                default :
                    header("Location:" . SITE_URL);
                    break;
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL);
        }
    }

}
?>

