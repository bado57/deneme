<?php

class DataTables_Model extends Model{

     public function __construct() {
        parent::__construct();
    }
    
    /*List durumu için geçerli kullanım*/
    
    //list fonksiyonu
    public function dataTableListCount($veritabaniAdi) {
        $sql = "SELECT * FROM $veritabaniAdi";
        return($this->db->affectedRows($sql));
    }
    //list fonksiyonu
    public function tableListele($veritabaniAdi,$data) {
        //ORDER BY insaat_proje_id ASC LIMIT 0,3
        $sql = "SELECT * FROM $veritabaniAdi " . $data . "";
        return ($this->db->select($sql));
    }
    
    
    /*Create durumu için geçerli kullanım*/
    
    

}