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
                    $usersselect_model = $this->load->model("AdminSelectDb_Mobil");


                    $form->post('loginKadi', true);
                    $form->post('loginSifre', true);
                    $form->post('loginTip', true);
                    $form->post('cihazID', true);
                    $form->post('language', true);

                    $loginKadi = $form->values['loginKadi'];
                    $language = $form->values['language'];
                    $formLanguage = $this->load->mobillanguage($language);
                    $languagedeger = $formLanguage->mobillanguage();
                    $loginfirmaID = $form->substrEnd($loginKadi, 8);
                    if ($loginfirmaID != "") {
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
                            //mobile select 0 dan başlama durumu
                            $loginTipp = $loginTip + 1;
                            $sifresonuc = $form->userSifreOlustur($loginKadi, $loginSifre, $loginTipp);
                            if ($form->submit()) {
                                $data = array(
                                    ':loginKadi' => $loginKadi,
                                    ':loginSifre' => $sifresonuc
                                );
                            }
                            $ShuttleGiris = $this->load->model("Panel_Model_Mobile");

                            if ($loginTipp == 1) {
                                $Kadi = 'BSAdminKadi';
                                $Sifre = 'BSAdminSifre';
                                $kullaniciID = 'BSAdminID';
                                $tableName = 'bsadmin';
                                if ($cihazID != "") {
                                    $resultDeviceID = $ShuttleGiris->shuttleAdminCihaz($cihazID);
                                    if ($resultDeviceID) {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSAdminID'];
                                                    $result['Kadi'] = $resultKullanicii['BSAdminKadi'];
                                                    $result['SAdmin'] = $resultKullanicii['BSSuperAdmin'];
                                                }
                                                $sonuc["login"] = "";
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    } else {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSAdminID'];
                                                    $result['Kadi'] = $resultKullanicii['BSAdminKadi'];
                                                    $result['SAdmin'] = $resultKullanicii['BSSuperAdmin'];
                                                    $id = $resultKullanicii['BSAdminID'];
                                                }

                                                $insertdata = array(
                                                    'bsadmincihazRecID' => $cihazID,
                                                    'bsadminID' => $id
                                                );

                                                $resultDeviceInsert = $ShuttleGiris->shuttleAdminCihazInsert($insertdata);
                                                if ($resultDeviceInsert != 0) {
                                                    $sonuc["login"] = "";
                                                } else {
                                                    $sonuc["login"] = $languagedeger['Hata'];
                                                }
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLoginA($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    if ($resultKullanici) {
                                        if ($resultKullanici[0]["Status"] != 0) {
                                            foreach ($resultKullanici as $resultKullanicii) {
                                                $result['ID'] = $resultKullanicii['BSAdminID'];
                                                $result['Kadi'] = $resultKullanicii['BSAdminKadi'];
                                                $result['SAdmin'] = $resultKullanicii['BSSuperAdmin'];
                                            }
                                            $sonuc["login"] = "";
                                        } else {
                                            $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                        }
                                    } else {
                                        $sonuc["login"] = $languagedeger['LoginFalse'];
                                    }
                                }
                            } elseif ($loginTipp == 2) {
                                $Kadi = 'BSSoforKadi';
                                $Sifre = 'BSSoforSifre';
                                $kullaniciID = 'BSSoforID';
                                $tableName = 'bssofor';
                                if ($cihazID != "") {
                                    $resultDeviceID = $ShuttleGiris->shuttleSoforCihaz($cihazID);
                                    if ($resultDeviceID) {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSSoforID'];
                                                    $result['Kadi'] = $resultKullanicii['BSSoforKadi'];
                                                }
                                                $sonuc["login"] = "";
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    } else {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSSoforID'];
                                                    $result['Kadi'] = $resultKullanicii['BSSoforKadi'];
                                                    $id = $resultKullanicii['BSSoforID'];
                                                }
                                                $insertdata = array(
                                                    'sbsoforcihazRecID' => $cihazID,
                                                    'sbsoforID' => $id
                                                );

                                                $resultDeviceInsert = $ShuttleGiris->shuttleSoforCihazInsert($insertdata);
                                                if ($resultDeviceInsert != 0) {
                                                    $sonuc["login"] = "";
                                                } else {
                                                    $sonuc["login"] = $languagedeger['Hata'];
                                                }
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    if ($resultKullanici) {
                                        if ($resultKullanici[0]["Status"] != 0) {
                                            foreach ($resultKullanici as $resultKullanicii) {
                                                $result['ID'] = $resultKullanicii['BSSoforID'];
                                                $result['Kadi'] = $resultKullanicii['BSSoforKadi'];
                                            }
                                            $sonuc["login"] = "";
                                        } else {
                                            $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                        }
                                    } else {
                                        $sonuc["login"] = $languagedeger['LoginFalse'];
                                    }
                                }
                            } elseif ($loginTipp == 3) {
                                $Kadi = 'BSHostesKadi';
                                $Sifre = 'BSHostesSifre';
                                $kullaniciID = 'BSHostesID';
                                $tableName = 'bshostes';
                                if ($cihazID != "") {
                                    $resultDeviceID = $ShuttleGiris->shuttleIsciCihaz($cihazID);
                                    if ($resultDeviceID) {
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSHostesID'];
                                                    $result['Kadi'] = $resultKullanicii['BSHostesKadi'];
                                                }
                                                $sonuc["login"] = "";
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    } else {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSHostesID'];
                                                    $result['Kadi'] = $resultKullanicii['BSHostesKadi'];
                                                    $id = $resultKullanicii['BSHostesID'];
                                                }

                                                $insertdata = array(
                                                    'bshostescihazRecID' => $cihazID,
                                                    'bshostesID' => $id
                                                );

                                                $resultDeviceInsert = $ShuttleGiris->shuttleHostesCihazInsert($insertdata);
                                                if ($resultDeviceInsert != 0) {
                                                    $sonuc["login"] = "";
                                                } else {
                                                    $sonuc["login"] = $languagedeger['Hata'];
                                                }
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    if ($resultKullanici) {
                                        if ($resultKullanici[0]["Status"] != 0) {
                                            foreach ($resultKullanici as $resultKullanicii) {
                                                $result['ID'] = $resultKullanicii['BSHostesID'];
                                                $result['Kadi'] = $resultKullanicii['BSHostesKadi'];
                                            }
                                            $sonuc["login"] = "";
                                        } else {
                                            $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                        }
                                    } else {
                                        $sonuc["login"] = $languagedeger['LoginFalse'];
                                    }
                                }
                            } elseif ($loginTipp == 4) {
                                $Kadi = 'SBVeliKadi';
                                $Sifre = 'SBVeliSifre';
                                $kullaniciID = 'SBVeliID';
                                $tableName = 'sbveli';

                                if ($cihazID != "") {
                                    $resultDeviceID = $ShuttleGiris->shuttleVeliCihaz($cihazID);
                                    if ($resultDeviceID) {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['SBVeliID'];
                                                    $result['Kadi'] = $resultKullanicii['SBVeliKadi'];
                                                }
                                                $sonuc["login"] = "";
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    } else {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['SBVeliID'];
                                                    $result['Kadi'] = $resultKullanicii['SBVeliKadi'];
                                                    $id = $resultKullanicii['SBVeliID'];
                                                }

                                                $insertdata = array(
                                                    'bsvelicihazRecID' => $cihazID,
                                                    'bsveliID' => $id,
                                                    'GidisTurBasladi' => 1,
                                                    'DonusTurBasladi' => 1,
                                                    'GidisAracYaklasti' => 1,
                                                    'DonusAracYaklasti' => 1,
                                                    'GidisAracBindi' => 1,
                                                    'DonusAracIndi' => 1,
                                                    'GidisKurumVardi' => 1,
                                                    'DonusTurBitti' => 1,
                                                    'duyuruStatu' => 1
                                                );

                                                $resultDeviceInsert = $ShuttleGiris->shuttleVeliCihazInsert($insertdata);
                                                if ($resultDeviceInsert != 0) {
                                                    $sonuc["login"] = "";
                                                } else {
                                                    $sonuc["login"] = $languagedeger['Hata'];
                                                }
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    if ($resultKullanici) {
                                        if ($resultKullanici[0]["Status"] != 0) {
                                            foreach ($resultKullanici as $resultKullanicii) {
                                                $result['ID'] = $resultKullanicii['SBVeliID'];
                                                $result['Kadi'] = $resultKullanicii['SBVeliKadi'];
                                            }
                                            $sonuc["login"] = "";
                                        } else {
                                            $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                        }
                                    } else {
                                        $sonuc["login"] = $languagedeger['LoginFalse'];
                                    }
                                }
                            } elseif ($loginTipp == 5) {
                                $Kadi = 'BSOgrenciKadi';
                                $Sifre = 'BSOgrenciSifre';
                                $kullaniciID = 'BSOgrenciID';
                                $tableName = 'bsogrenci';
                                if ($cihazID != "") {
                                    $resultDeviceID = $ShuttleGiris->shuttleOgrenciCihaz($cihazID);
                                    if ($resultDeviceID) {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSOgrenciID'];
                                                    $result['Kadi'] = $resultKullanicii['BSOgrenciKadi'];
                                                }
                                                $sonuc["login"] = "";
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    } else {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['BSOgrenciID'];
                                                    $result['Kadi'] = $resultKullanicii['BSOgrenciKadi'];
                                                    $id = $resultKullanicii['BSOgrenciID'];
                                                }

                                                $insertdata = array(
                                                    'bsogrencicihazRecID' => $cihazID,
                                                    'bsogrenciID' => $id,
                                                    'GidisTurBasladi' => 1,
                                                    'DonusTurBasladi' => 1,
                                                    'GidisAracYaklasti' => 1,
                                                    'DonusAracYaklasti' => 1,
                                                    'GidisAracBindi' => 1,
                                                    'DonusAracIndi' => 1,
                                                    'GidisKurumVardi' => 1,
                                                    'DonusTurBitti' => 1,
                                                    'duyuruStatu' => 1
                                                );

                                                $resultDeviceInsert = $ShuttleGiris->shuttleOgrenciCihazInsert($insertdata);
                                                if ($resultDeviceInsert != 0) {
                                                    $sonuc["login"] = "";
                                                } else {
                                                    $sonuc["login"] = $languagedeger['Hata'];
                                                }
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    if ($resultKullanici) {
                                        if ($resultKullanici[0]["Status"] != 0) {
                                            foreach ($resultKullanici as $resultKullanicii) {
                                                $result['ID'] = $resultKullanicii['BSOgrenciID'];
                                                $result['Kadi'] = $resultKullanicii['BSOgrenciKadi'];
                                            }
                                            $sonuc["login"] = "";
                                        } else {
                                            $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                        }
                                    } else {
                                        $sonuc["login"] = $languagedeger['LoginFalse'];
                                    }
                                }
                            } elseif ($loginTipp == 6) {
                                $Kadi = 'SBIsciKadi';
                                $Sifre = 'SBIsciSifre';
                                $kullaniciID = 'SBIsciID';
                                $tableName = 'sbisci';
                                if ($cihazID != "") {
                                    $resultDeviceID = $ShuttleGiris->shuttleIsciCihaz($cihazID);
                                    if ($resultDeviceID) {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['SBIsciID'];
                                                    $result['Kadi'] = $resultKullanicii['SBIsciKadi'];
                                                }
                                                $sonuc["login"] = "";
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    } else {
                                        $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                        if ($resultKullanici) {
                                            if ($resultKullanici[0]["Status"] != 0) {
                                                foreach ($resultKullanici as $resultKullanicii) {
                                                    $result['ID'] = $resultKullanicii['SBIsciID'];
                                                    $result['Kadi'] = $resultKullanicii['SBIsciKadi'];
                                                    $id = $resultKullanicii['SBIsciID'];
                                                }

                                                $insertdata = array(
                                                    'sbiscicihazRecID' => $cihazID,
                                                    'sbisciID' => $id,
                                                    'GidisTurBasladi' => 1,
                                                    'DonusTurBasladi' => 1,
                                                    'GidisAracYaklasti' => 1,
                                                    'DonusAracYaklasti' => 1,
                                                    'GidisAracBindi' => 1,
                                                    'DonusAracIndi' => 1,
                                                    'GidisKurumVardi' => 1,
                                                    'DonusTurBitti' => 1,
                                                    'duyuruStatu' => 1
                                                );

                                                $resultDeviceInsert = $ShuttleGiris->shuttleIsciCihazInsert($insertdata);
                                                if ($resultDeviceInsert != 0) {
                                                    $sonuc["login"] = "";
                                                } else {
                                                    $sonuc["login"] = $languagedeger['Hata'];
                                                }
                                            } else {
                                                $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                            }
                                        } else {
                                            $sonuc["login"] = $languagedeger['LoginFalse'];
                                        }
                                    }
                                } else {
                                    $resultKullanici = $ShuttleGiris->shuttleKullaniciLogin($data, $Kadi, $Sifre, $kullaniciID, $tableName);
                                    if ($resultKullanici) {
                                        if ($resultKullanici[0]["Status"] != 0) {
                                            foreach ($resultKullanici as $resultKullanicii) {
                                                $result['ID'] = $resultKullanicii['SBIsciID'];
                                                $result['Kadi'] = $resultKullanicii['SBIsciKadi'];
                                            }
                                            $sonuc["login"] = "";
                                        } else {
                                            $sonuc["login"] = $loginKadi . " " . $languagedeger['LoginStatus'];
                                        }
                                    } else {
                                        $sonuc["login"] = $languagedeger['LoginFalse'];
                                    }
                                }
                            } else {
                                $sonuc["login"] = $languagedeger['Hata'];
                            }

                            if ($result) {
                                if ($cihazID) {
                                    $cihazarray = array($cihazID);
                                    $form->shuttleNotification($cihazarray, $languagedeger['LoginNotification'], $languagedeger['LoginTitle']);
                                }
                                $sonuc["tip"] = $loginTipp;
                                $sonuc["userinfo"] = $result;
                            } else {
                                //$sonuc["true"] = 6;
                            }
                        } else {
                            $sonuc["login"] = $languagedeger['LoginFirmaFalse'];
                        }
                    } else {
                        $sonuc["login"] = $languagedeger['FalseKadi'];
                    }
                    break;
            }
            echo json_encode($sonuc);
        } else {
            die($languagedeger['Hack']);
        }
    }

}
?>

