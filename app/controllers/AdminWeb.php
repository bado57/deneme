<?php
class AdminWeb extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->firmislem();
    }

    //daha önce login oldu ise
    function firmislem() {
        if (Session::get("login") == true) {
            $language=Session::get("dil");
            $form = $this->load->multilanguage($language);
            $deger = $form->multilanguage();
            
            $this->load->view("Template_AdminBackEnd/header",$deger);
            $this->load->view("Template_AdminBackEnd/left",$deger);
            $this->load->view("Template_AdminBackEnd/firmaislem",$deger);
            $this->load->view("Template_AdminBackEnd/footer",$deger);
        } else {
            header("Location:" . SITE_URL);
        }
    }
    
    function aracliste() {
        if (Session::get("login") == true) {
            $language=Session::get("dil");
            $form = $this->load->multilanguage($language);
            $deger = $form->multilanguage();
            
            $this->load->view("Template_AdminBackEnd/header",$deger);
            $this->load->view("Template_AdminBackEnd/left",$deger);
            $this->load->view("Template_AdminBackEnd/aracliste",$deger);
            $this->load->view("Template_AdminBackEnd/footer",$deger);
        } else {
            header("Location:" . SITE_URL);
        }
    }
    
    function bolgeliste() {
        if (Session::get("login") == true) {
            $language=Session::get("dil");
            $form = $this->load->multilanguage($language);
            $deger = $form->multilanguage();
            
            $this->load->view("Template_AdminBackEnd/header",$deger);
            $this->load->view("Template_AdminBackEnd/left",$deger);
            $this->load->view("Template_AdminBackEnd/bolgeliste",$deger);
            $this->load->view("Template_AdminBackEnd/footer",$deger);
        } else {
            header("Location:" . SITE_URL);
        }
    }
    
}
?>