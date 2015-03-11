<?php
/*
 * Load sınıfı ile istenilen dosyalara daha rahat ulaşabilmeyi sağlamaktadır.Yani gelen filename adı ile istenilen
 * klasör altındaki istenilen sınıfa $this->load->$filename('') şeklinde ulaşabileceğiz
*/

class Load {

    public function __construct() {
        
    }
    //controllers classları için
    public function controllers($fileName) {
        include "app/controllers/" . $fileName . ".php";
        return new $fileName;
    }
    
    //view classları için
    public function view($fileName, $data = false , $rutbe=false) {
        if ($data == true) {
            extract($data);
        }
        if ($rutbe == true) {
            extract($rutbe);
        }
        include "app/views/" . $fileName . "_view.php";
    }
    
    //model classları için
    public function model($fileName) {
        include "app/models/" . $fileName . ".php";
        return new $fileName;
    }

    //other class lar için

    public function otherClasses($fileName) {
        include "app/otherClasses/" . $fileName . ".php";
        return new $fileName;
    }
    
    //language
    public function multilanguage($fileName) {
        include "app/language/" . $fileName . ".php";
        return new $fileName;
    }
}
?>

