<?php

class ShuttleWebServisLogin extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->shuttleWebServisLogin();
    }

    public function shuttleWebServisLogin() {

        if ($_POST) {
            $sonuc = array();
            $form = $this->load->otherClasses('Form');
            $form->post("tip", true);
            $tip = $form->values['tip'];
            Switch ($tip) {
                case "shuttleLogin":

                    $formDbConfig = $this->load->otherClasses('DatabaseConfig');
                    $usersselect_model = $this->load->model("adminselectdb_mobil");

                    $form->post('loginKadi', true);
                    $form->post('loginSifre', true);
                    $form->post('loginTip', true);
                    $form->post('cihazID', true);
                    $form->post('language', true);

                    $loginKadi = $form->values['loginKadi'];

                    $loginfirmaID = $form->substrEnd($loginKadi, 6);
                    //return database results
                    $UserSelectDb = $usersselect_model->MkullaniciSelectDb($loginfirmaID);

                    $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                    $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                    $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                    $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];
                    $SelectdbFirmaKod = $UserSelectDb[0]['rootfirmaKodu'];

                    $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);


                    $loginTip = $form->values['loginTip'];
                    $loginSifre = $form->values['loginSifre'];
                    $loginDeger = "bs";


                    $cihazID = $form->values['cihazID'];
                    $language = $form->values['language'];


                    //mobile select o dan başlama durumu
                    $loginTip = $loginTip + 1;
                    $sifreilkeleman = $loginDeger . $loginKadi . $loginTip;
                    $sifreilkeleman1 = md5($sifreilkeleman);
                    $sifreikincieleman = md5($loginSifre);
                    $sifresonuc = $sifreilkeleman1 . $sifreikincieleman;

                    if ($form->submit()) {
                        $data = array(
                            ':loginKadi' => $loginKadi,
                            ':loginSifre' => $sifresonuc
                        );
                    }

                    $ShuttleGiris = $this->load->model("panel_model_mobile");

                    if ($loginTip == 1) {
                        $Kadi = 'BSAdminKadi';
                        $Sifre = 'BSAdminSifre';
                        $kullaniciID = 'BSAdminID';
                        $tableName = 'bsadmin';

                        if ($cihazID) {
                            $resultDeviceID = $ShuttleGiris->shuttleAdminCihaz($cihazID);
                            if ($resultDeviceID) {
                                $result = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                            } else {
                                $result = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                $id = $result[0]['BSAdminID'];
                                $insertdata = array(
                                    'bsadmincihazRecID' => $cihazID,
                                    'bsadminID' => $id
                                );

                                $resultDeviceInsert = $ShuttleGiris->shuttleAdminCihazInsert($insertdata);
                            }
                        } else {
                            $result = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                        }
                    } elseif ($loginTip == 2) {
                        $Kadi = 'BSSoforKadi';
                        $Sifre = 'BSSoforSifre';
                        $kullaniciID = 'BSSoforID';
                        $tableName = 'bssofor';
                        if ($cihazID) {
                            $resultDeviceID = $ShuttleGiris->shuttleSoforCihaz($cihazID);
                            if ($resultDeviceID) {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                            } else {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                $id = $result['BSSoforID'];

                                $insertdata = array(
                                    'sbsoforcihazRecID' => $cihazID,
                                    'sbsoforID' => $id
                                );

                                $resultDeviceInsert = $ShuttleGiris->shuttleSoforCihazInsert($insertdata);
                            }
                        } else {
                            $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                        }
                    } elseif ($loginTip == 3) {
                        $Kadi = 'SBVeliKadi';
                        $Sifre = 'SBBVeliSifre';
                        $kullaniciID = 'SBVeliID';
                        $tableName = 'sbveli';

                        if ($cihazID) {
                            $resultDeviceID = $ShuttleGiris->shuttleVeliCihaz($cihazID);
                            if ($resultDeviceID) {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                            } else {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                $id = $result['SBVeliID'];

                                $insertdata = array(
                                    'bsvelicihazRecID' => $cihazID,
                                    'bsveliID' => $id
                                );

                                $resultDeviceInsert = $ShuttleGiris->shuttleVeliCihazInsert($insertdata);
                            }
                        } else {
                            $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                        }
                    } elseif ($loginTip == 4) {
                        $Kadi = 'BSOgrenciKadi';
                        $Sifre = 'BSOgrenciSifre';
                        $kullaniciID = 'BSOgrenciID';
                        $tableName = 'bsogrenci';
                        if ($cihazID) {
                            $resultDeviceID = $ShuttleGiris->shuttleOgrenciCihaz($cihazID);
                            if ($resultDeviceID) {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                            } else {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                $id = $result['BSOgrenciID'];

                                $insertdata = array(
                                    'bsogrencicihazRecID' => $cihazID,
                                    'bsogrenciID' => $id
                                );

                                $resultDeviceInsert = $ShuttleGiris->shuttleOgrenciCihazInsert($insertdata);
                            }
                        } else {
                            $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                        }
                    } else {
                        $Kadi = 'SBIsciKadi';
                        $Sifre = 'SBIsciSifre';
                        $kullaniciID = 'SBIsciID';
                        $tableName = 'sbisci';
                        if ($cihazID) {
                            $resultDeviceID = $ShuttleGiris->shuttleIsciCihaz($cihazID);
                            if ($resultDeviceID) {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                            } else {
                                $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                $id = $result['SBIsciID'];

                                $insertdata = array(
                                    'sbiscicihazRecID' => $cihazID,
                                    'sbisciID' => $id
                                );

                                $resultDeviceInsert = $ShuttleGiris->shuttleIsciCihazInsert($insertdata);
                            }
                        } else {
                            $result = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                        }
                    }

                    if ($result) {
                        if ($cihazID) {
                            $formLanguage = $this->load->multilanguage($language);
                            $languagedeger = $formLanguage->multilanguage();
                            $cihazarray = array($cihazID);
                            $form->shuttleNotification($cihazarray, $languagedeger['LoginNotification'], $languagedeger['LoginTitle']);
                        }
                        $sonuc["tip"] = $loginTip;
                        $sonuc["userinfo"] = $result;
                    } else {
                        $sonuc["true"] = 5;
                    }

                    break;
            }
            echo json_encode($sonuc);
        } else {
            die("Hacklemeye mi Çalışıyorsun pezevenk?");
        }
    }

}
?>

