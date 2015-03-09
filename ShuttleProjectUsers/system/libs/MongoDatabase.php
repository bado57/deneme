<?php

class MongoDatabase {

    public $mongodb;

    //kurucu metod
    public function __construct($username, $password, $hostname, $port, $databaseName) {
        try {
            // Mongo Sunucusuna bağlanalım
            $connect = "mongodb://${username}:${password}@${hostname}:${port}";
            $mongo = new Mongo($connect);

            // Veritabanını Seçelim 
            $this->mongodb = $mongo->selectDB($databaseName);
        } catch (MongoConnectionException $e) {
            die('Baglanti Kurulamadi : ' . $e->getMessage());
        }
    }

    //select fonksiyonu
    public function select($collectionName, $limit, $skip, $sort) {
        #gelen $tableName isimli collectiona bağlantı gerçekleştirelim.
        $Collection = new MongoCollection($this->mongodb, $collectionName);

        //controllerdan limit diye birşey gelmiyorsa
        if ($limit != '') {
            $limit = $limit;
        } else {
            $limit = 0;
        }
        //skip yani limit 5 den 10 a gibi
        if ($skip != '') {
            $skip = $skip;
        } else {
            $skip = 0;
        }
        //controllerdan sort diye bir sıralama geliyorsa
        if ($sort != '') {
            try {
                $selectResult = $Collection->find()->skip($skip)->limit($limit)->sort($sort);
            } catch (MongoCursorException $e) {
                die('select yaparken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
            }
        } else {
            try {
                $selectResult = $Collection->find()->skip($skip)->limit($limit);
            } catch (MongoCursorException $e) {
                die('Select yaparken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
            }
        }


        return $selectResult;
    }

    //kayıt etme fonksiyonu
    public function insert($collectionName, $array) {
        #gelen $tableName isimli collectiona bağlantı gerçekleştirelim.
        $Collection = new MongoCollection($this->mongodb, '$collectionName');
        //yeni kayıt ekleme
        try {
            $Collection->insert($array);
            $result = 'Başarılı şekilde kayıt olunmuştur';
        } catch (MongoCursorException $e) {
            die('İnsert yaparken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
        }
        return $result;
    }

    //güvenli silme fonksiyonu
    public function delete($collectionName, $array) {
        #gelen $tableName isimli collectiona bağlantı gerçekleştirelim.
        $Collection = new MongoCollection($this->mongodb, $collectionName);
        //kayıt silme
        try {
            $Collection->remove($array, array('safe' => true));
            $result = 'Başarılı şekilde silme işlemi gerçekleştirilmişir.';
        } catch (MongoCursorException $e) {
            die('Silme işlemi yaparken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
        }
        return $result;
    }

    //güncelleme fonksiyonu
    public function update($collectionName, $oldarray, $newarray) {
        #gelen $tableName isimli collectiona bağlantı gerçekleştirelim.
        $Collection = new MongoCollection($this->mongodb, $collectionName);
        try {
            #içeriği güncelleyelim.
            $Collection->update($oldarray, $newarray);
            $result='Güncelleme işlemi başarılı şekilde gerçekleştirilmiştir.';
        } catch (MongoCursorException $e) {
            die('Güncelleme işlemi yaparken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
        }
        return $result;
    }

    //Collecion silme fonksiyonu
    public function deleteCollection($collectionName) {
        $Collection = new MongoCollection($this->mongodb, $collectionName);
        try {
            #içeriği güncelleyelim.
            $Collection->drop();
            $result='Collection Başarılı bir şekilde silinmiştir.';
        } catch (MongoCursorException $e) {
            die('Collecion Silme işlemi yaparken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
        }
        return $result;
    }

    //Database Silme Fonksiyonu
    public function deleteDatabase() {
        try {
            $this->mongodb->dropDatabase();
            $result='Database Başarılı bir şekilde silinmiştir.';
        } catch (MongoCursorException $e) {
            die('Database işlemi silinirken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
        }
        return $result;
    }

    //count bulma fonksiyonu
    public function count($collectionName) {
        #gelen $tableName isimli collectiona bağlantı gerçekleştirelim.
        $Collection = new MongoCollection($this->mongodb, $collectionName);
        //yeni kayıt ekleme
        try {
            $dataCount = $Collection->count();
        } catch (MongoCursorException $e) {
            die('İnsert yaparken teknik bir sorunla karşılaşıldı ' . $e->getMessage());
        }
        return $dataCount;
    }

}
?>

