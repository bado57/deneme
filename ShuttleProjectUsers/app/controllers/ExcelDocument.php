<?php

class ExcelDocument extends Controller {

    function __construct() {
        parent::__construct();
        $this->option();
    }

    function option() {
        error_reporting(E_ALL); //tüm hata gösterimleri açılıyor.
        set_time_limit(0); //max_execution_time değeri olabilecek en üst değere getirliyor
        ini_set('memory_limit', '-1'); //bu şekilde değer vermemiz istediğimiz kadar excel satırı çekmemizi sağlar
        //ini_set('max_execution_time', 40);//sayfa yüklemesi çok fazla sürerse iptal et anlamında
        date_default_timezone_set('Europe/Istanbul');
        include SITE_PLUGIN . '/excel/Classes/PHPExcel/IOFactory.php';
    }

    //$inputFileName = 'dosya.xls';
    function readExcel($fileName, $veritabaniAdi) {
        //  Read your Excel workbook
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
            $objReader->setLoadSheetsOnly(1);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                    . '": ' . $e->getMessage());
        }

        //  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        //  Loop through each row of the worksheet in turn
        for ($row = 1; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            foreach ($rowData[0] as $k => $v)
                echo "Row: " . $row . "- Col: " . ($k + 1) . " = " . $v . "<br />";
        }
    }

}

?>