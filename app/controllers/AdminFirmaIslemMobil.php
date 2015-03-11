<?php
 class AdminFirmaIslemMobil extends Controller{
     
     public function __construct() {
        parent::__construct();
        //oturum kontrolü
        //Session::checkSession();
    }
    
    public function index() {
        $this->home();
    }
    
    public function home() {
        $form = $this->load->otherClasses('Form');
        
        $form->post("language", true);
        $language = $form->values['language'];
        
        $form->post("rutbe", true);
        $rutbe = $form->values['rutbe'];
        
        $form = $this->load->multilanguage($language);
        $deger = $form->multilanguage();
        
        $this->load->view("Template_AdminBackEnd/MobileAdmin/adminfirmamobil",$deger,$rutbe);
    }
 }
?>

