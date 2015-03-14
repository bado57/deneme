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
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');
        $sessionKey = $form->sessionKontrol();

        if (Session::get("login") == true && Session::get("sessionkey") == $sessionKey) {
            header("Location:" . SITE_URL_HOME . "/panel");
        } else {
            $this->runLogin($form);
        }
    }

    public function runLogin($form) {

        if ($_POST) {
            
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
                $Kadi = 'BSAdminKadi';
                $Sifre = 'BSAdminSifre';
                $kullaniciID = 'BSAdminID';
                $tableName = 'bsadmin';
                $adminID = 'BSAdminID';
            } elseif ($loginTip == 2) {
                $Kadi = 'BSSoforKadi';
                $Sifre = 'BSSoforSifre';
                $kullaniciID = 'BSSoforID';
                $tableName = 'bssofor';
                $adminID = 'BSSoforID';
            } elseif ($loginTip == 3) {
                $Kadi = 'SBVeliKadi';
                $Sifre = 'SBVeliSifre';
                $kullaniciID = 'SBVeliID';
                $tableName = 'sbveli';
                $adminID = 'SBVeliID';
            } elseif ($loginTip == 4) {
                $Kadi = 'BSOgrenciKadi';
                $Sifre = 'BSOgrenciSifre';
                $kullaniciID = 'BSOgrenciID';
                $tableName = 'bsogrenci';
                $adminID = 'BSOgrenciID';
            } else if ($loginTip == 5) {
                $Kadi = 'SBIsciKadi';
                $Sifre = 'SBIsciSifre';
                $kullaniciID = 'SBIsciID';
                $tableName = 'sbsisci';
                $adminID = 'SBIsciID';
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
            $firmaID = $result[0]["BSFirmaID"];
            //Kişinin bağlı olduğu firma kodu 
            $firmaKodu = $admin_model->firmaOzellikler($firmaID);
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
                $sessionKey =  $form->sessionKontrol();
                //kullanıcı işlemleri başarılı
                //login olarak session tanımlıyoruz admin panelini girerken login true ise diye
                Session::set("login", "true");
                
                //session güvenlik anahtarı
                Session::set("sessionkey", $sessionKey);
                Session::set("username", $result[0][$Kadi]);
                Session::set("userId", $result[0][$adminID]);
                Session::set("userTip", $loginTip);
                Session::set("userRutbe", $result[0]["BSSuperAdmin"]);
                Session::set("BSfirmaKodu", $firmaKodu[0]["BSFirmaKodu"]);

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


