<?php

class Login extends Controller {

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
            header("Location:" . SITE_URL_HOME . "/Panel");
        } else {
            $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            if (!Session::get("dil")) {
                Session::set("dil", $lang);
                $formMulti = $this->load->frontmultilanguage($lang);
                $degerHF = $formMulti->frontHFmultilanguage();
            } else {
                $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
                $degerHF = $formMulti->frontHFmultilanguage();
            }
            $this->load->view("Template_FrontEnd/header", $degerHF);
            $this->load->view("Template_FrontEnd/log_in", $degerHF);
            $this->load->view("Template_FrontEnd/footer", $degerHF);
        }
    }

}

?>