<?php

class UsersLogin extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->login();
    }

    //daha önce login oldu ise
    function login() {
        if (Session::get("login") == true) {
            header("Location:" . SITE_URL_HOME . "/panel");
        } else {
            $this->runLogin();
        }
    }

    public function runLogin() {

        if ($_POST) {

            $form = $this->load->otherClasses('Form');

            $form->post('usersloginkadi', true);
            $form->post('usersloginsifre', true);
            $form->post('loginselected', true);

            $loginTip = $form->values['loginselected'];
            $loginKadi = $form->values['usersloginkadi'];
            $loginSifre = $form->values['usersloginsifre'];
            $loginDeger = "bs";

            $sifreilkeleman = $loginDeger . $loginKadi . $loginTip;
            $sifreilkeleman1 = md5($sifreilkeleman);
            $sifreikincieleman = md5($loginSifre);
            $sifresonuc = $sifreilkeleman1 . $sifreikincieleman;


            if ($loginTip == 1) {
                $Kadi = 'AdminKadi';
                $Sifre = 'AdminSifre';
                $kullaniciID = 'AdminID';
                $tableName = 'admin';
                $adminID = 'AdminID';
            } elseif ($loginTip == 2) {
                $Kadi = 'SoforKadi';
                $Sifre = 'SoforSifre';
                $kullaniciID = 'SoforID';
                $tableName = 'sofor';
                $adminID = 'SoforID';
            } elseif ($loginTip == 3) {
                $Kadi = 'VeliKadi';
                $Sifre = 'VeliSifre';
                $kullaniciID = 'VeliID';
                $tableName = 'veli';
                $adminID = 'VeliID';
            } elseif ($loginTip == 4) {
                $Kadi = 'OgrenciKadi';
                $Sifre = 'OgrenciSifre';
                $kullaniciID = 'OgrenciID';
                $tableName = 'ogrenci';
                $adminID = 'OgrenciID';
            } else if ($loginTip == 5) {
                $Kadi = 'IsciKadi';
                $Sifre = 'IsciSifre';
                $kullaniciID = 'IsciID';
                $tableName = 'isci';
                $adminID = 'IsciID';
            } else {
                //$this->load->view("Entry/loginForm");
            }


            if ($form->submit()) {
                $data = array(
                    ':loginKadi' => $form->values['usersloginkadi'],
                    ':loginSifre' => $sifresonuc
                );
            }

            $admin_model = $this->load->model("admin_model");
            $result = $admin_model->userControl($data, $Kadi, $Sifre, $kullaniciID, $tableName);


            if ($result == false) {
                //yanlış bilgi
                $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
                if (!Session::get("dil")) {
                    Session::set("dil", $lang);
                    $form = $this->load->multilanguage($lang);
                    $deger = $form->multilanguage();
                } else {
                    $form = $this->load->multilanguage(Session::get("dil"));
                    $deger = $form->multilanguage();
                }
                $this->load->view("Entry/loginForm", $deger);
            } else {
                //kullanıcı işlemleri başarılı
                //login olarak session tanımlıyoruz admin panelini girerken login true ise diye
                Session::set("login", "true");
                Session::set("username", $result[0][$Kadi]);
                Session::set("userId", $result[0][$adminID]);
                Session::set("userTip", $loginTip);

                header("Location:" . SITE_URL_HOME . "/panel");
            }
        } else {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (!Session::get("dil")) {
                Session::set("dil", $lang);
                $form = $this->load->multilanguage($lang);
                $deger = $form->multilanguage();
            } else {
                $form = $this->load->multilanguage(Session::get("dil"));
                $deger = $form->multilanguage();
            }
            $this->load->view("Entry/loginForm", $deger);
        }
    }

    //Çıkış Yap
    public function logout() {
        Session::destroy();
        header("Location:" . SITE_URL);
    }

}
?>


