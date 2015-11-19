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

                    $loginfirmaID = $form->substrEnd($loginKadi, 8);
                    //return database results
                    $UserSelectDb = $usersselect_model->MkullaniciSelectDb($loginfirmaID);
                    $firmaDurum = $UserSelectDb[0]['rootfirmaDurum'];
                    if ($firmaDurum != 0) {
                        $SelectdbName = $UserSelectDb[0]['rootFirmaDbName'];
                        $SelectdbIp = $UserSelectDb[0]['rootFirmaDbIp'];
                        $SelectdbUser = $UserSelectDb[0]['rootFirmaDbUser'];
                        $SelectdbPassword = $UserSelectDb[0]['rootFirmaDbSifre'];
                        $SelectdbFirmaKod = $UserSelectDb[0]['rootfirmaKodu'];

                        $formDbConfig->configDb($SelectdbName, $SelectdbIp, $SelectdbUser, $SelectdbPassword);


                        $loginTip = $form->values['loginTip'];
                        $loginSifre = $form->values['loginSifre'];


                        $cihazID = $form->values['cihazID'];
                        $language = $form->values['language'];


                        //mobile select o dan başlama durumu
                        $loginTipp = $loginTip + 1;

                        $sifresonuc = $form->userSifreOlustur($loginKadi, $loginSifre, $loginTipp);
                        if ($form->submit()) {
                            $data = array(
                                ':loginKadi' => $loginKadi,
                                ':loginSifre' => $sifresonuc
                            );
                        }
                        $ShuttleGiris = $this->load->model("panel_model_mobile");

                        if ($loginTipp == 1) {
                            $Kadi = 'BSAdminKadi';
                            $Sifre = 'BSAdminSifre';
                            $kullaniciID = 'BSAdminID';
                            $tableName = 'bsadmin';

                            if ($cihazID) {
                                $resultDeviceID = $ShuttleGiris->shuttleAdminCihaz($cihazID);
                                if ($resultDeviceID) {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSAdminID'];
                                        $result['Kadi'] = $resultKullanicii['BSAdminKadi'];
                                        $result['SAdmin'] = $resultKullanicii['BSSuperAdmin'];
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSAdminID'];
                                        $result['Kadi'] = $resultKullanicii['BSAdminKadi'];
                                        $result['SAdmin'] = $resultKullanicii['BSSuperAdmin'];
                                    }
                                    $id = $resultKullanici[0]['BSAdminID'];
                                    $insertdata = array(
                                        'bsadmincihazRecID' => $cihazID,
                                        'bsadminID' => $id
                                    );

                                    $resultDeviceInsert = $ShuttleGiris->shuttleAdminCihazInsert($insertdata);
                                }
                            } else {
                                $resultKullanici = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                foreach ($resultKullanici as $resultKullanicii) {
                                    $result['ID'] = $resultKullanicii['BSAdminID'];
                                    $result['Kadi'] = $resultKullanicii['BSAdminKadi'];
                                    $result['SAdmin'] = $resultKullanicii['BSSuperAdmin'];
                                }
                            }
                        } elseif ($loginTipp == 2) {
                            $Kadi = 'BSSoforKadi';
                            $Sifre = 'BSSoforSifre';
                            $kullaniciID = 'BSSoforID';
                            $tableName = 'bssofor';
                            if ($cihazID) {
                                $resultDeviceID = $ShuttleGiris->shuttleSoforCihaz($cihazID);
                                if ($resultDeviceID) {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSSoforID'];
                                        $result['Kadi'] = $resultKullanicii['BSSoforKadi'];
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSSoforID'];
                                        $result['Kadi'] = $resultKullanicii['BSSoforKadi'];
                                    }
                                    $id = $resultKullanici['BSSoforID'];

                                    $insertdata = array(
                                        'sbsoforcihazRecID' => $cihazID,
                                        'sbsoforID' => $id
                                    );

                                    $resultDeviceInsert = $ShuttleGiris->shuttleSoforCihazInsert($insertdata);
                                }
                            } else {
                                $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                foreach ($resultKullanici as $resultKullanicii) {
                                    $result['ID'] = $resultKullanicii['BSSoforID'];
                                    $result['Kadi'] = $resultKullanicii['BSSoforKadi'];
                                }
                            }
                        } elseif ($loginTipp == 3) {
                            $Kadi = 'SBVeliKadi';
                            $Sifre = 'SBBVeliSifre';
                            $kullaniciID = 'SBVeliID';
                            $tableName = 'sbveli';

                            if ($cihazID) {
                                $resultDeviceID = $ShuttleGiris->shuttleVeliCihaz($cihazID);
                                if ($resultDeviceID) {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['SBVeliID'];
                                        $result['Kadi'] = $resultKullanicii['SBVeliKadi'];
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['SBVeliID'];
                                        $result['Kadi'] = $resultKullanicii['SBVeliKadi'];
                                    }
                                    $id = $resultKullanici['SBVeliID'];

                                    $insertdata = array(
                                        'bsvelicihazRecID' => $cihazID,
                                        'bsveliID' => $id
                                    );

                                    $resultDeviceInsert = $ShuttleGiris->shuttleVeliCihazInsert($insertdata);
                                }
                            } else {
                                $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                foreach ($resultKullanici as $resultKullanicii) {
                                    $result['ID'] = $resultKullanicii['SBVeliID'];
                                    $result['Kadi'] = $resultKullanicii['SBVeliKadi'];
                                }
                            }
                        } elseif ($loginTipp == 4) {
                            $Kadi = 'BSOgrenciKadi';
                            $Sifre = 'BSOgrenciSifre';
                            $kullaniciID = 'BSOgrenciID';
                            $tableName = 'bsogrenci';
                            if ($cihazID) {
                                $resultDeviceID = $ShuttleGiris->shuttleOgrenciCihaz($cihazID);
                                if ($resultDeviceID) {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSOgrenciID'];
                                        $result['Kadi'] = $resultKullanicii['BSOgrenciKadi'];
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSOgrenciID'];
                                        $result['Kadi'] = $resultKullanicii['BSOgrenciKadi'];
                                    }
                                    $id = $resultKullanici['BSOgrenciID'];

                                    $insertdata = array(
                                        'bsogrencicihazRecID' => $cihazID,
                                        'bsogrenciID' => $id
                                    );

                                    $resultDeviceInsert = $ShuttleGiris->shuttleOgrenciCihazInsert($insertdata);
                                }
                            } else {
                                $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                foreach ($resultKullanici as $resultKullanicii) {
                                    $result['ID'] = $resultKullanicii['BSOgrenciID'];
                                    $result['Kadi'] = $resultKullanicii['BSOgrenciKadi'];
                                }
                            }
                        } elseif ($loginTipp == 5) {
                            $Kadi = 'SBIsciKadi';
                            $Sifre = 'SBIsciSifre';
                            $kullaniciID = 'SBIsciID';
                            $tableName = 'sbisci';
                            if ($cihazID) {
                                $resultDeviceID = $ShuttleGiris->shuttleIsciCihaz($cihazID);
                                if ($resultDeviceID) {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['SBIsciID'];
                                        $result['Kadi'] = $resultKullanicii['SBIsciKadi'];
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['SBIsciID'];
                                        $result['Kadi'] = $resultKullanicii['SBIsciKadi'];
                                    }
                                    $id = $resultKullanici['SBIsciID'];

                                    $insertdata = array(
                                        'sbiscicihazRecID' => $cihazID,
                                        'sbisciID' => $id
                                    );

                                    $resultDeviceInsert = $ShuttleGiris->shuttleIsciCihazInsert($insertdata);
                                }
                            } else {
                                $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                foreach ($resultKullanici as $resultKullanicii) {
                                    $result['ID'] = $resultKullanicii['SBIsciID'];
                                    $result['Kadi'] = $resultKullanicii['SBIsciKadi'];
                                }
                            }
                        } else {
                            $Kadi = 'BSHostesKadi';
                            $Sifre = 'BSHostesSifre';
                            $kullaniciID = 'BSHostesID';
                            $tableName = 'bshostes';
                            if ($cihazID) {
                                $resultDeviceID = $ShuttleGiris->shuttleIsciCihaz($cihazID);
                                if ($resultDeviceID) {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSHostesID'];
                                        $result['Kadi'] = $resultKullanicii['BSHostesKadi'];
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    foreach ($resultKullanici as $resultKullanicii) {
                                        $result['ID'] = $resultKullanicii['BSHostesID'];
                                        $result['Kadi'] = $resultKullanicii['BSHostesKadi'];
                                    }
                                    $id = $resultKullanici['BSHostesID'];

                                    $insertdata = array(
                                        'bshostescihazRecID' => $cihazID,
                                        'bshostesID' => $id
                                    );

                                    $resultDeviceInsert = $ShuttleGiris->shuttleHostesCihazInsert($insertdata);
                                }
                            } else {
                                $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                foreach ($resultKullanici as $resultKullanicii) {
                                    $result['ID'] = $resultKullanicii['BSHostesID'];
                                    $result['Kadi'] = $resultKullanicii['BSHostesKadi'];
                                }
                            }
                        }

                        if ($result) {
                            if ($cihazID) {
                                $formLanguage = $this->load->multilanguage($language);
                                $languagedeger = $formLanguage->multilanguage();
                                $cihazarray = array($cihazID);
                                $form->shuttleNotification($cihazarray, $languagedeger['LoginNotification'], $languagedeger['LoginTitle']);
                            }
                            $sonuc["tip"] = $loginTipp;
                            $sonuc["userinfo"] = $result;
                        } else {
                            $sonuc["true"] = 6;
                        }
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

