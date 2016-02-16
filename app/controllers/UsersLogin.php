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

        if (Session::get("BSShuttlelogin") == true && Session::get("sessionkey") == $sessionKey) {
            header("Location:" . SITE_URL_HOME . "/panel");
        } else {
            $this->runLogin($form);
        }
    }

    public function runLogin($form) {
        $form->post('usersloginkadi', true);
        $loginKadi = $form->values['usersloginkadi'];
        //yanlış bilgi-dil dosyası
        if (!Session::get("dil")) {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            Session::set("dil", $lang);
            $formLang = $this->load->frontmultilanguage($lang);
            $degerLang = $formLang->frontHFmultilanguage();
        } else {
            $formLang = $this->load->frontmultilanguage(Session::get("dil"));
            $degerLang = $formLang->frontHFmultilanguage();
        }

        if (isset($loginKadi) && $loginKadi != '') {
            $usersselect_model = $this->load->model("AdminSelectDb_Model");
            $form->post('usersloginkadi', true);
            $loginKadi = $form->values['usersloginkadi'];
            $form->post('usersloginsifre', true);
            $loginfirmaID = $form->substrEnd($loginKadi, 8);
            if ($loginfirmaID != "") {
                //return database results
                $UserSelectDb = $usersselect_model->kullaniciSelectDb($loginfirmaID);
                if ($UserSelectDb) {
                    $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                    $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                    $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                    $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];
                    $SelectdbFirmaKod = $UserSelectDb[0]['rootfirmaKodu'];
                    $SelectdbFirmaDurum = $UserSelectDb[0]['rootfirmaDurum'];
                    $ogrServis = $UserSelectDb[0]['rootfirmaOgrServis'];
                    $persServis = $UserSelectDb[0]['rootfirmaPersonelServis'];

                    if ($SelectdbFirmaDurum != 0) {
                        $loginTip = 1;
                        $loginSifre = $form->values['usersloginsifre'];
                        $sifresonuc = $form->userSifreOlustur($loginKadi, $loginSifre, $loginTip);
                        if ($loginTip == 1) {
                            $Kadi = 'BSAdminKadi';
                            $Sifre = 'BSAdminSifre';
                            $kullaniciID = 'BSAdminID';
                            $tableName = 'bsadmin';
                            $adminID = 'BSAdminID';
                        } else {
                            //$this->load->view("Entry/loginForm");
                        }
                        if ($form->submit()) {
                            $data = array(
                                ':loginKadi' => $loginKadi,
                                ':loginSifre' => $sifresonuc
                            );
                        }

                        //yeni db create
                        Session::set("selectDbName", $SelectdbName);
                        Session::set("selectDbIp", $SelectdbIp);
                        Session::set("selectDbUser", $SelectdbUser);
                        Session::set("selectDbPassword", $SelectdbPassword);
                        Session::set("selectFirmaDurum", $SelectdbFirmaDurum);
                        Session::set("selectDbEncryption", 'ShutteBSDb');
                        $Admin_Model = $this->load->model("Admin_Model");
                        $result = $Admin_Model->userControl($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                        if ($result) {
                            if ($result[0]['Status'] != 0) {
                                $sessionKey = $form->sessionKontrol();

                                //kullanıcı işlemleri başarılı
                                //login olarak session tanımlıyoruz admin panelini girerken login true ise diye
                                Session::set("BSShuttlelogin", "true");

                                //session güvenlik anahtarı
                                Session::set("sessionkey", $sessionKey);
                                Session::set("username", $result[0][$Kadi]);
                                Session::set("kullaniciad", $result[0]['BSAdminAd']);
                                Session::set("kullanicisoyad", $result[0]['BSAdminSoyad']);
                                Session::set("userId", $result[0][$adminID]);
                                Session::set("userTip", $loginTip);
                                Session::set("userRutbe", $result[0]["BSSuperAdmin"]);
                                Session::set("userFirmaKod", $SelectdbFirmaKod);
                                Session::set("FirmaId", $loginfirmaID);
                                Session::set("OgrServis", $ogrServis);
                                Session::set("PersServis", $persServis);

                                header("Location:" . SITE_URL_HOME . "/panel");
                            } else {
                                unset($_SESSION['selectDbEncryption']);
                                unset($_SESSION['selectDbName']);
                                unset($_SESSION['selectDbIp']);
                                unset($_SESSION['selectDbUser']);
                                unset($_SESSION['selectDbPassword']);
                                unset($_SESSION['selectFirmaDurum']);

                                $kullaniciStatus[0]['Result'] = $loginKadi . " " . $degerLang["LoginStatus"];
                                $this->load->view("Template_FrontEnd/header", $degerLang);
                                $this->load->view("Template_FrontEnd/log_in", $degerLang, $kullaniciStatus);
                                $this->load->view("Template_FrontEnd/footer", $degerLang);
                            }
                        } else {
                            unset($_SESSION['selectDbEncryption']);
                            unset($_SESSION['selectDbName']);
                            unset($_SESSION['selectDbIp']);
                            unset($_SESSION['selectDbUser']);
                            unset($_SESSION['selectDbPassword']);
                            unset($_SESSION['selectFirmaDurum']);

                            $kullaniciStatus[0]['Result'] = $degerLang["LoginFalse"];
                            $this->load->view("Template_FrontEnd/header", $degerLang);
                            $this->load->view("Template_FrontEnd/log_in", $degerLang, $kullaniciStatus);
                            $this->load->view("Template_FrontEnd/footer", $degerLang);
                        }
                    } else {
                        $kullaniciStatus[0]['Result'] = $degerLang["LoginFirmaFalse"];
                        $this->load->view("Template_FrontEnd/header", $degerLang);
                        $this->load->view("Template_FrontEnd/log_in", $degerLang, $kullaniciStatus);
                        $this->load->view("Template_FrontEnd/footer", $degerLang);
                    }
                } else {
                    $kullaniciStatus[0]['Result'] = $degerLang["LoginFalse"];
                    $this->load->view("Template_FrontEnd/header", $degerLang);
                    $this->load->view("Template_FrontEnd/log_in", $degerLang, $kullaniciStatus);
                    $this->load->view("Template_FrontEnd/footer", $degerLang);
                }
            } else {
                $kullaniciStatus[0]['Result'] = $degerLang["LoginFalse"];
                $this->load->view("Template_FrontEnd/header", $degerLang);
                $this->load->view("Template_FrontEnd/log_in", $degerLang, $kullaniciStatus);
                $this->load->view("Template_FrontEnd/footer", $degerLang);
            }
        } else {
            $kullaniciStatus[0]['Result'] = $degerLang["FalseKadi"];
            $this->load->view("Template_FrontEnd/header", $degerLang);
            $this->load->view("Template_FrontEnd/log_in", $degerLang, $kullaniciStatus);
            $this->load->view("Template_FrontEnd/footer", $degerLang);
        }
    }

}
?>


