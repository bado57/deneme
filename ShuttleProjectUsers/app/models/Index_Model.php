<?php
    class Index_Model extends Model{
        public function __construct() {
            //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
            parent::__construct();
        }
       //select i çalıştıracak database.php deki database classındaki
       //id şeklinde gönderilecekse başarılı
        /*
        public function isimListele($id){
            $sql="Select * from test WHERE id=:id";
            $params=array(":id"=>$id);
            return $this->db->select($sql,$params);
        }*/
        
        //id şeklinde olmayacaksa yani koşul yoksa
        //yada 3 ü binValue şeklinde üstteki gibi olcak
        public function isimListele(){
            $sql="Select * from test where id>3";
         
            //print_r($this->db->select($sql));
            return $this->db->select($sql);
        }
        
           public function makaleKaydet($data){
               //insert
             return $this->db->insert("makaleler",$data);
        }
        
         public function guncelle() {
             $data=array(
                  "baslik"=>"Yeni güncellenmiş başlık",
                  "icerik"=>"Yeni güncellenmiş içerik",
                  "baslik"=>"Yeni güncellenmiş etiket"
             );
             $this->db->update("makaleler",$data,"id=3");
        }
        
        public function makaleListele() {
            $sql="Select * from makaleler";
            return $this->db->select($sql);
        }   
    }
?>