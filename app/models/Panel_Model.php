<?php

class Panel_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function susersLogin($array = array(), $Kadi, $Sifre,$KullaniciID, $tableName) {
        $sql = "SELECT ".$Kadi.",".$KullaniciID." FROM " . $tableName . " WHERE " . $Kadi . " = :loginKadi && " . $Sifre . " = :loginSifre";
        return ($count = $this->db->select($sql, $array));
    }

    public function projeListeleSon() {
        $sql = "SELECT * FROM insaat_projeler ORDER BY insaat_proje_id DESC LIMIT 1";
        return $this->db->select($sql);
    }

    public function projeListele_Count() {
        $sql = "SELECT * FROM insaat_projeler WHERE insaat_proje_id=:1";
        return($this->db->affectedRows($sql, $array));
    }

    public function addNewProjectInsert($data) {
        return ($this->db->insert("insaat_projeler", $data));
    }

    public function updateNewProject($data, $gelenlabel) {
        return ($this->db->update("insaat_projeler", $data, "insaat_proje_id=$gelenlabel"));
    }

    public function gayri_benzersiz_deger_kodu($array = array()) {
        $sql = "SELECT * FROM insaat_projeler WHERE insaat_proje_kodu = :InputPkodu";
        return ($count = $this->db->affectedRows($sql, $array));
    }

    public function gayri_benzersiz_deger_adi($array = array()) {
        $sql = "SELECT * FROM insaat_projeler WHERE insaat_proje_adi = :InputPadi";
        return ($count = $this->db->affectedRows($sql, $array));
    }

    public function addNewProjectBuildingInsert($datam) {
        return ($this->db->insert("insaat_proje_yapi", $datam));
    }

    public function addBuildingDelete($gelenbloklabell) {
        return ($this->db->delete("insaat_proje_yapi_blok", "insaat_proje_yapi_id=$gelenbloklabell"));
    }

    public function updateNewBlokProject($datam, $gelenbloklabell) {
        return ($this->db->update("insaat_proje_yapi", $datam, "insaat_proje_yapi_id=$gelenbloklabell"));
    }

    public function addBuildingInsert($data) {
        return ($this->db->insert("insaat_proje_yapi_blok", $data));
    }

    public function addBuildingUpdateInsert($data, $gelenyapi_id) {
        return ($this->db->insert("insaat_proje_yapi_blok", $data, "insaat_proje_yapi_id=$gelenyapi_id"));
    }

    public function projeIlListele() {
        $sql = "SELECT * FROM insaat_proje_il";
        return $this->db->select($sql);
    }

    public function projeIlceListele($array = array()) {
        $sql = "Select * from insaat_proje_ilce WHERE il_id=:proje_il_id";
        return $this->db->select($sql, $array);
    }

    public function projeSemtListele($array = array()) {
        $sql = "Select * from insaat_proje_semt WHERE ilceID=:proje_ilce_id";
        return $this->db->select($sql, $array);
    }

    public function projeMahalleListele($array = array()) {
        $sql = "Select * from insaat_proje_mahalle WHERE semtID=:proje_semt_id";
        return $this->db->select($sql, $array);
    }

    public function projePostaKoduGoster($array = array()) {
        $sql = "Select * from insaat_proje_postakodu WHERE mahalleID=:proje_mahalle_id";
        return $this->db->select($sql, $array);
    }

    public function addNewProjectAdressInsert($data) {
        return ($this->db->insert("insaat_proje_yapi_adres", $data));
    }

    public function updateProjectAdressInsert($data, $gelenadres_id) {
        return ($this->db->insert("insaat_proje_yapi_adres", $data, "insaat_proje_yapi_adres_id=$gelenadres_id"));
    }

    public function projeModalDetayIcon($array = array()) {
        $sql = "SELECT * FROM insaat_projeler LEFT JOIN insaat_proje_yapi ON insaat_proje_yapi.insaat_yapi_proje=insaat_projeler.insaat_proje_id LEFT JOIN insaat_proje_yapi_blok ON insaat_proje_yapi_blok.insaat_proje_yapi_id=insaat_proje_yapi.insaat_proje_yapi_id LEFT JOIN insaat_proje_yapi_adres ON insaat_proje_yapi_adres.insaat_proje_yapi_id=insaat_proje_yapi.insaat_proje_yapi_id WHERE insaat_proje_id=:projeModalDtyID";
        return $this->db->select($sql, $array);
    }

    public function dataTableListCount() {
        $sql = "SELECT * FROM insaat_projeler";
        return($this->db->affectedRows($sql));
    }

    public function tableListele($data) {
        //ORDER BY insaat_proje_id ASC LIMIT 0,3
        $sql = "SELECT * FROM insaat_projeler " . $data . "";
        return ($this->db->select($sql));
    }

}

?>