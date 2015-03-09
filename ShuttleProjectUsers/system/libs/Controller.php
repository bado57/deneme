<?php
/*bu da load ta ilk index.php de include halde yani birbirini görebilmekterler
 * tabi ana controller yani burası üstte ve sistem altındakileri
 * include ettikçe görebilecek.sonrada ana bi değişken tanımladık load diye artık bununla 
 * ilgili sayfadaki Load klasörü altındaki tüm metodlara ulaşabiliriz.
*/
//ana çatı kontrolü en tepedeki yer
class Controller {
    protected $load=array();
            
    function __construct() {
        //echo "ana kontroller";
        $this->load=new Load();
        
    } 
}
 
?>

