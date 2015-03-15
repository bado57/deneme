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
    public function view($fileName, $data = false , $model=false) {
        if ($data == true) {
            extract($data);
        }
        if ($model == true) {
            extract($model);
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
    
    //form sayfaları kullanımlar için
    public function form($fileName) {
        include "app/form/" . $fileName . ".php";
        return new $fileName;
    }
    
    //language
    public function multilanguage($fileName) {
        include "app/language/" . $fileName . ".php";
        return new $fileName;
    }
}
?>

