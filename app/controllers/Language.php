<?php

class Language extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->selectlanguage();
    }

    function selectlanguage() {
        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
            $sonuc = array();
            
            $form = $this->load->otherClasses('Form');
            Session::init();

            $form->post("lang", true);
            $dil = $form->values['lang'];

            if ($dil == "tr" || $dil == "en" ||$dil == "fr" || $dil == "ar" || $dil == "de" || $dil =="zh") {
                Session::set("dil", $dil);
            } else {
                //eğer dil yoksa
                $dil='en';
                Session::set("dil", $dil);
            }
            $sonuc["lang"] =$dil;

            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

