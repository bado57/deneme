<?php 
//githup
//oturum başlatma
ob_start();
Session::init();
//hata mesajlarını gösterme
error_reporting(0);
//Türkçe Karekter kullanımı
header('Content-Type: text/html; charset=utf-8');
//System dosyalarımı include ediyoruz
/*
 * bu function ile include etmediğimiz classları bu fonksiyonda belittiğimiz
 * adres dizinini de ayırıyor ve kendi include ediyor.
 * yani otomatik olarak bu adrestekileri include edecek kendisi.
 */
function  __autoload($className){
    include_once 'system/libs/'.$className.'.php';
    
}
//config dosyasını include ediyorum
include_once 'app/config/config.php';


//bootstarp classı bunu bölüp controller a yönlendirecek.
$boot =new Bootstrap();
?>
