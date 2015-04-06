<?php

class LoginForm extends Controller {

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

}

?>