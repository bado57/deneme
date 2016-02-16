<?php

/*
 * Bu servis sadece haftada bir defa pazar günü öğlen saat 12:00 da çalışacak ve üm db yedeklerini alacak
 */

class OurServisBackup extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model_Our");

        $rootDbFirma = $Panel_Model->rootFirmaConnectBackup();

        $a = 0;
        $firmtable = array();
        foreach ($rootDbFirma as $rootDbFirmaa) {
            $firmtable[$a]['Name'] = $rootDbFirmaa['rootFirmaDbName'];
            $firmtable[$a]['Sifre'] = $rootDbFirmaa['rootFirmaDbSifre'];
            $firmtable[$a]['Ip'] = $rootDbFirmaa['rootFirmaDbIp'];
            $firmtable[$a]['User'] = $rootDbFirmaa['rootFirmaDbUser'];
            $firmtable[$a]['Kod'] = $rootDbFirmaa['rootfirmaKodu'];
            $firmtable[$a]['FirmAd'] = $rootDbFirmaa['rootfirmaAdi'];
            $a++;
        }
        $size = count($firmtable);
        for ($f = 0; $f < $size; $f++) {
            $result = $this->backup($firmtable[$f]["Ip"], $firmtable[$f]['User'], $firmtable[$f]['Sifre'], $firmtable[$f]["Name"], $firmtable[$f]["Kod"], $firmtable[$f]["FirmAd"]);
            if ($result) {
                
            } else {
                $f--;
            }
        }
    }

    public function backup($host, $user, $pass, $name, $kod, $backup_name, $tables = false) {
        $form = $this->load->otherClasses('Form');
        //db bağlantısı sağlanıyor ve yedek dosyamız alınıyor
        $mysqli = new mysqli($host, $user, $pass, $name);
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");
        $queryTables = $mysqli->query('SHOW TABLES');
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        } if ($tables !== false) {
            $target_tables = array_intersect($target_tables, $tables);
        }
        foreach ($target_tables as $table) {
            $result = $mysqli->query('SELECT * FROM ' . $table);
            $fields_amount = $result->field_count;
            $rows_num = $mysqli->affected_rows;
            $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $TableMLine = $res->fetch_row();
            $content = (!isset($content) ? '' : $content) . "\n\n" . $TableMLine[1] . ";\n\n";
            for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
                while ($row = $result->fetch_row()) {
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\nINSERT INTO " . $table . " VALUES";
                    }
                    $content .= "\n(";
                    for ($j = 0; $j < $fields_amount; $j++) {
                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                        if (isset($row[$j])) {
                            $content .= '"' . $row[$j] . '"';
                        } else {
                            $content .= '""';
                        } if ($j < ($fields_amount - 1)) {
                            $content.= ',';
                        }
                    }
                    $content .=")";
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                        $content .= ";";
                    } else {
                        $content .= ",";
                    } $st_counter = $st_counter + 1;
                }
            } $content .="\n\n\n";
        }
        date_default_timezone_set('Europe/Istanbul');
        $backup_name = $backup_name ? $backup_name : $name . "___(" . date('H-i-s') . "_" . date('d-m-Y') . ")__rand" . rand(1, 11111111) . ".sql";
        try {
            //backup klasörü içerisine yenisql dosyamız oluşturuluyor
            $handle = fopen('backup/' . $backup_name, 'w+');
            fwrite($handle, $content);
            fclose($handle);
            //yeni zip dosyamızı oluşturyoruz
            $zip = new ZipArchive;
            $zipname = 'backup/' . date('H-i-s') . "_" . date('d-m-Y') . ".zip";
            $res = $zip->open($zipname, ZipArchive::CREATE);
            if ($res === TRUE) {
                //zip içerisine az önce oluşturduğumuz sql dosyasını atıyoruz
                $zip->addFile("backup/" . $backup_name);
                $zip->close();
                $klasor_adi = "backup/" . $backup_name;
                if (!file_exists($klasor_adi)) {
                    echo "Silinecek klasör yok!";
                    exit(); //İşlemi durdur
                }
                //işlem bittikten sonra sql dosyasını siliyoruz ve sadece rar kalmakta
                $klasor_sil = unlink($klasor_adi);
                if ($klasor_sil) {
                    if (file_exists($zipname)) {
                        //oluşturulan rar dosyasını mail ile gönderiyoruz
                        $result = $form->backupDatabase($zipname);
                        if ($result == 1) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        echo 'Dosyamız yok';
                    }
                }
            } else {
                
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    protected function saveFile(&$sql) {
        if (!$sql)
            return false;

        try {
            date_default_timezone_set('Europe/Istanbul');
            $handle = fopen('backup/db-backup-' . $this->dbName . '-' . date("Ymd-His", time()) . '.sql', 'w+');
            fwrite($handle, $sql);
            fclose($handle);
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }

        return true;
    }

}

?>