<?php

class UserIndex extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->home();
    }

    //daha önce login oldu ise
    function home() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerHome = $formMulti->frontHomemultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerHome = $formMulti->frontHomemultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/home", $degerHome);
        $this->load->view("Template_FrontEnd/footer", $degerHF);
    }

    //Hakkında
    function about() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerAbout = $formMulti->frontAboutmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerAbout = $formMulti->frontAboutmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/about", $degerAbout);
        $this->load->view("Template_FrontEnd/footer", $degerHF);
    }

    //Özellikler
    function features() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerFeatures = $formMulti->frontFeatmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerFeatures = $formMulti->frontFeatmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/features", $degerFeatures);
        $this->load->view("Template_FrontEnd/footer", $degerHF);
    }

    // Nasıl Çalışır
    function how_it_works() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerWork = $formMulti->frontWorksmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerWork = $formMulti->frontWorksmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/how_it_works", $degerWork);
        $this->load->view("Template_FrontEnd/footer", $degerHF);
    }

    // Nasıl Çalışır
    function faq() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerFaq = $formMulti->frontFaqmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerFaq = $formMulti->frontFaqmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/faq", $degerFaq);
        $this->load->view("Template_FrontEnd/footer", $degerHF);
    }

    // Kayıt Ol
    function sign_up() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerSignUp = $formMulti->frontSignmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerSignUp = $formMulti->frontSignmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/sign_up", $degerSignUp);
        //$this->load->view("Template_FrontEnd/footer", $deger);
    }

    // Ödeme
    function payment() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerPayment = $formMulti->frontPaymentmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerPayment = $formMulti->frontPaymentmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/payment", $degerPayment);
        //$this->load->view("Template_FrontEnd/footer", $deger);
    }

    // Ödeme Sonucu
    function payment_result() {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        if (!Session::get("dil")) {
            Session::set("dil", $lang);
            $formMulti = $this->load->frontmultilanguage($lang);
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerPayment = $formMulti->frontPaymentmultilanguage();
        } else {
            $formMulti = $this->load->frontmultilanguage(Session::get("dil"));
            $degerHF = $formMulti->frontHFmultilanguage();
            $degerPayment = $formMulti->frontPaymentmultilanguage();
        }

        $this->load->view("Template_FrontEnd/header", $degerHF);
        $this->load->view("Template_FrontEnd/payment_result", $degerPayment);
        //$this->load->view("Template_FrontEnd/footer", $deger);
    }

    // 404 hata sayfası
    function fail() {
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
        $this->load->view("Template_FrontEnd/404", $degerHF);
        //$this->load->view("Template_FrontEnd/footer", $deger);
    }

}

?>