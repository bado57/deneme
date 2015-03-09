<?php

try {

    class DataTable_Classes extends Controller {

        function __construct() {
            parent::__construct();
        }

        function datatableGet() {

            if ($_GET && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
                $cevap = array();
                $form = $this->load->otherClasses('Form');
                $form->get("action", true);
                $action = $form->values['action'];
                $dataDizi = array();
                $jTableResult = array();
                switch ($action) {
                    case "list":

                        $form->get("veritabaniAdi", true);
                        $veritabaniAdi = $form->values['veritabaniAdi'];

                        $Plist_model = $this->load->model("DataTables_Model");
                        $data["ProjeCount"] = $Plist_model->dataTableListCount($veritabaniAdi);
                        $recordCount = $data["ProjeCount"];


                        $deger = "ORDER BY " . $_GET["jtSorting"] . " LIMIT " . $_GET["jtStartIndex"] . "," . $_GET["jtPageSize"] . "";
                        $dataDizi[] = $Plist_model->tableListele($veritabaniAdi, $deger);


                        $jTableResult = array();
                        $jTableResult['Result'] = "OK";
                        $jTableResult['TotalRecordCount'] = $recordCount;
                        $jTableResult['Records'] = $dataDizi[0];
                        print json_encode($jTableResult);

                        break;

                    //yeni satır oluşturma
                    case "create":

                        //Insert record into database
                        $result = mysql_query("INSERT INTO datatables_demo(Name, Age, RecordDate) VALUES('" . $_POST["Name"] . "', " . $_POST["Age"] . ",now());");

                        //Get last inserted record (to return to jTable)
                        $result = mysql_query("SELECT * FROM people WHERE PersonId = LAST_INSERT_ID();");
                        $row = mysql_fetch_array($result);


                        $jTableResult['Result'] = "OK";
                        $jTableResult['Record'] = $dataDizi[0];
                        print json_encode($jTableResult);
                        break;
                    case "list":

                        error_log("upadte");
                        break;

                    default:
                        break;
                }
            } else {
                die("Hacklemeye mi Çalışıyorsun pezevenk?");
            }
        }

    }

} catch (Exception $ex) {
    //tablo için hata mesajı
    $jTableResult = array();
    $jTableResult['Result'] = "ERROR";
    $jTableResult['Message'] = $ex->getMessage();
    print json_encode($jTableResult);
}
?>