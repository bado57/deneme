<?php

//veri tabanaı bağlantısını yaptık, PDO şu anki veritabanı bağlanma dili
class Database extends PDO {

    //kurucu metod
    public function __construct($dsn, $user, $password) {
        parent::__construct($dsn, $user, $password);
        $this->query("SET NAMES 'utf8'");
        $this->query("SET CHARACTER SET utf8");
    }

    //select fonksiyonu
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC) {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue($key, $value);
        }
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    //etkilenen satırları görme fonksiyonu
    public function affectedRows($sql, $array = array()) {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue($key, $value);
        }
        $sth->execute();
        return $sth->rowCount();
    }

    //kayıt etme fonksiyonu
    public function insert($tableName, $data) {
        $fieldKeys = implode(",", array_keys($data));
        $fieldValues = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $tableName($fieldKeys) VALUES($fieldValues)";
        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        if ($sth->execute()) {
            return $this->lastInsertId();
        } else {
            //unique için hata kodu
            if ($sth->errorCode() == 23000 || $sth->errorCode() == 1062) {
                return 'unique';
            } else {
                return false;
            }
        }
    }

    //çoklu kayıt etme
    function multiInsert($tableName, $data) {
        $rowsSQL = array();

        $toBind = array();

        $columnNames = array_keys($data[0]);

        foreach ($data as $arrayIndex => $row) {
            $params = array();
            foreach ($row as $columnName => $columnValue) {
                $param = ":" . $columnName . $arrayIndex;
                $params[] = $param;
                $toBind[$param] = $columnValue;
            }
            $rowsSQL[] = "(" . implode(", ", $params) . ")";
        }
        $sql = "INSERT INTO `$tableName` (" . implode(", ", $columnNames) . ") VALUES " . implode(", ", $rowsSQL);
        $sth = $this->prepare($sql);
        foreach ($toBind as $param => $val) {
            $sth->bindValue($param, $val);
        }
        if ($sth->execute()) {
            return $this->lastInsertId();
        } else {
            //unique için hata kodu
            if ($sth->errorCode() == 23000 || $sth->errorCode() == 1062) {
                return 'unique';
            } else {
                return false;
            }
        }
    }

    //güncelleme fonksiyonu
    public function update($tableName, $data, $where) {
        $updateKeys = null;
        foreach ($data as $key => $value) {
            $updateKeys .= "$key=:$key,";
        }
        $updateKeys = rtrim($updateKeys, ",");
        $sql = "UPDATE $tableName SET $updateKeys WHERE  $where";

        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        if ($sth->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //silme işlemi
    public function delete($tableName, $where) {
        return($this->exec("DELETE FROM $tableName WHERE $where"));
    }

    //limite göre silme işlemi
    public function deleteLimit($tableName, $where, $limit = 1) {
        $this->exec("DELETE FROM $tableName WHERE $where LIMIT $limit");
    }

    //count işlemi
    public function Count($sql) {
        $result = $this->prepare($sql);
        $result->execute();
        $number_of_rows = $result->fetchColumn();
        return $number_of_rows;
    }

}
?>

