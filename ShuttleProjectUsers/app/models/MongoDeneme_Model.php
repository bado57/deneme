<?php

class MongoDeneme_Model extends ModelMongo {
    
     public function __construct() {
        //başka bir veritabanına bağlanmak istersek bu construc ın içine yazarız
        parent::__construct();
    }
    
    //select işlemi
    public function select($collectionName,$limit,$skip,$sort) {
        return $this->dbmongo->select($collectionName,$limit,$skip,$sort);
    }
    
    //kayıt ekleme
    public function insert($collectionName,$array) {
        return $this->dbmongo->insert($collectionName,$array);
    }
    //silme
    public function delete($collectionName,$array) {
        return $this->dbmongo->delete($collectionName,$array);
    }
    //güncelleme işlemei
    public function update($collectionName,$oldarray,$newarray) {
        return $this->dbmongo->update($collectionName,$oldarray,$newarray);
    }
    
    //deleteCollection işlemei
    public function deleteCollection($collectionName) {
        return $this->dbmongo->deleteCollection($collectionName);
    }
    
    //deleteDatabase işlemei
    public function deleteDatabase() {
        return $this->dbmongo->deleteDatabase();
    }
    
    //count bulma işlemi
    public function count($collectionName) {
        return $this->dbmongo->count($collectionName);
    }
    
}
?>

