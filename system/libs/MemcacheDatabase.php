<?php

/*
 * Dikkat Edilmesi Gerekenler:
 * Memcache bir cache sistemidir. Verilerinizin kaybolabilir!
 * Memcache’de key (anahtar kelime) en fazla 250 karakter olabilir.
 * Cache’lenen veri en fazla 1MB olabilir. 1MB üzerinde veri saklayacaksanız sıkıştırma parametresini “true” yapın. Sıkıştırılan veri önbellekten okununduğunda açılması gerekir ve bu sıkıştırma/açma işlemi CPU maliyeti oluşturur, unutmayın.
 * Memcache’de cache için ayrılan alan hiçbir zaman dolmaz. Eğer sürekli veri set ediyorsanız ve yer kalmadı ise otomatik olarak en eski verinin üzerine yazılacaktır (LRU).
 * x86 ve x86_64 farkı:  x86 mimaride cache için ram’de en fazla 4GB ayırabilirsiniz.  x86_64 mimaride 16.8 milyon terabyte’a kadar desteklemektedir.
 */

class MemcacheDatabase {

    public $bellek;

    //kurucu metod
    public function __construct($hostname, $port) {
        try {
            // Memcache bağlanısını gerçekleştirelim.
            $this->bellek = new Memcache;
            $this->bellek->connect($hostname, $port);
        } catch (MongoConnectionException $e) {
            die('Baglanti Kurulamadi : ' . $e->getMessage());
        }
    }

    //get fonksiyonu yani memecache getirme
    public function get($key) {
        $Mresult = $this->bellek->get($key);
        //$this->bellek->close();
        return $Mresult;
    }

    //set fonksiyonu yani memecache kaydetme
    public function set($key, $data, $statu, $time) {
        /*
         * anahtar->içerik->bayrak->süre
         * Bayrak işaretçisi veriniz sıkıştırılmış olarak saklayıp saklamayacağına bakıyor.
         * “true” olarak ayarlanırsa veriyi sıkıştırılmış olarak saklıyor
         */
        $Mresult = $this->bellek->set($key, $data, $statu, $time);
        //$this->bellek->close();
        return $Mresult;
    }

    //replace onksiyonu yani ke deki dataları değiştirme
    public function replace($key, $data, $statu, $time) {
        /*
         * anahtar->içerik->bayrak->süre
         * belirli kee sahip değerin içindekileri değiştirmeye yaramaktadır 
         */
        $Mresult = $this->bellek->replace($key, $data, $statu, $time);
        $this->bellek->close();
        return $Mresult;
    }

    //istenilen keyi silmeye yaramaktadır
    public function deleteKey($key) {
        $Mresult = $this->bellek->delete($key);
        //$this->bellek->close();
        return $Mresult;
    }

    //bellekteki tüm keyleri siler
    public function deleteAllKey() {
        $Mresult = $this->bellek->flush();
        $this->bellek->close();
        return $Mresult;
    }

    //server status server açık yada kapalımı.1->açık null->kapalı
    public function serverStatus() {
        $Mresult = $this->bellek->getServerStatus('127.0.0.1', 11211);
        $this->bellek->close();
        return $Mresult;
    }

}

?>
