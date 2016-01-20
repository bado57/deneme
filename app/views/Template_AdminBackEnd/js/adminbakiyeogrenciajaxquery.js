$.ajaxSetup({
    type: "post",
    url: SITE_URL + "AdminBakiyeOgrenciAjax",
    //timeout:3000,
    dataType: "json",
    error: function (a, b) {
        if (b == "timeout")
            reset();
        alertify.alert(jsDil.InternetBaglanti);
        return false;
    },
    statusCode: {
        404: function () {
            reset();
            alertify.alert(jsDil.InternetBaglanti);
            return false;
        }
    }
});
var gidisBildAyar = new Array();
var donusBildAyar = new Array();
$(document).ready(function () {
    OgrenciTable = $('#bakiyeOgrenciTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    OgrenciBakiyeTable = $('#odemeDetay').dataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "bFilter": false
    });
    //Öğrenci İşlemleri 'table#adminKurumTurTable > tbody > tr > td > a'
    $(document).on('click', 'tbody#ogrenciRow > tr > td > a', function (e) {
        OgrenciBakiyeTable.DataTable().clear().draw();
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var id = $(this).attr('value');
        $.ajax({
            data: {"id": id, "tip": "ogrenciDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    $("input[name=ogrenciDetayID]").val(cevap.ogrenciDetail[0][0].OgrenciListID);
                    $("input[name=odemeDovizTip]").val(cevap.ogrenciDetail[0][0].OdemeParaTip);
                    $("#ogrAdSoyad").text(cevap.ogrenciDetail[0][0].OgrenciListAd + " " + cevap.ogrenciDetail[0][0].OgrenciListSoyad);
                    $("#totalMoney").text(cevap.ogrenciDetail[0][0].OdemeTutar + " " + cevap.ogrenciDetail[0][0].OdemeParaTip);
                    $("#odenenMoney").text(cevap.ogrenciDetail[0][0].OdenenTutar + " " + cevap.ogrenciDetail[0][0].OdemeParaTip);
                    $("#kalanMoney").text(cevap.ogrenciDetail[0][0].KalanTutar + " " + cevap.ogrenciDetail[0][0].OdemeParaTip);
                    if (cevap.ogrenciDetail[1]) {
                        var length = cevap.ogrenciDetail[1].length;
                        for (var b = 0; b < length; b++) {
                            var addRow = "<tr value='" + cevap.ogrenciDetail[1][b].ID + "'>"
                                    + "<td>" + cevap.ogrenciDetail[1][b].OdemeAlanAd + " (" + cevap.ogrenciDetail[1][b].OdemeAlanTip + ")" + "</td>"
                                    + "<td value='" + cevap.ogrenciDetail[1][b].OdemeYapanTp + "'>" + cevap.ogrenciDetail[1][b].OdemeYapanAd + " (" + cevap.ogrenciDetail[1][b].OdemeYapanTip + ")" + "</td>"
                                    + "<td>" + cevap.ogrenciDetail[1][b].OdemeTutar + " (" + cevap.ogrenciDetail[0][0].OdemeParaTip + ")" + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.ogrenciDetail[1][b].OdemeTip + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.ogrenciDetail[1][b].OdemeAciklama + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.ogrenciDetail[1][b].OdemeTarih + "</td>"
                                    + "<td class='hidden-xs'>"
                                    + "<a data-islem='0' data-toggle='tooltip' data-placement='top' title='Düzenle' value='' style='margin-left:10px;margin-right:10px;font-size:16px'><i class='fa fa-edit'></i></a>"
                                    + "<a data-islem='1' data-toggle='tooltip' data-placement='top' title='Yazdır' value='' style='margin-left:10px;margin-right:10px;font-size:16px'><i class='fa fa-print'></i></a>"
                                    + "</td>"
                                    + "</tr>";
                            OgrenciBakiyeTable.DataTable().row.add($(addRow)).draw();
                        }
                    }
                    svControl('svAdd', 'OgrenciDetay', '');
                    i.removeClass("fa fa-spinner");
                    i.addClass("glyphicon glyphicon-user");
                }
            }
        });
    });
    $(document).on('click', 'table#odemeDetay > tbody > tr > td > a', function (e) {
        var islemTipi = $(this).attr("data-islem");
        if (islemTipi == 0) {//Düzenleme
            var i = $(this).find("i");
            i.removeClass("fa fa-edit");
            i.addClass("fa fa-spinner");
            var rowID = $(this).parent().parent().attr("value");
            var odemeYapan = $(this).parent().parent().find('td:eq(1)').text();
            var odemeYapanTip = $(this).parent().parent().find('td:eq(1)').attr("value");
            var tutar = $(this).parent().parent().find('td:eq(2)').text();
            var odemeSekli = $(this).parent().parent().find('td:eq(3)').text();
            var aciklama = $(this).parent().parent().find('td:eq(4)').text();
            var ogrAdSSoyad = $("#ogrAdSoyad").text();
            var ogrID = $("input[name=ogrenciDetayID]").val();
            $('#odemeDYapan').empty().append('<option selected="selected" value="0">' + jsDil.Seciniz + '</option>');
            var odemeYapann = odemeYapan.split('(');
            $.ajax({
                data: {"ogrID": ogrID, "tip": "ogrenciYeniOdeme"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(jsDil.Hata);
                        return false;
                    } else {
                        var length = cevap.veliler.length;
                        if (length != 0) {
                            for (var v = 0; v < length; v++) {
                                if ($.trim(odemeYapann[0]) == cevap.veliler[v].Ad) {
                                    $("#odemeDYapan").append('<option id="1" value="1" selected>' + cevap.veliler[v].Ad + ' (' + jsDil.Veli + ')' + '</option>');
                                } else {
                                    $("#odemeDYapan").append('<option id="1" value="1">' + cevap.veliler[v].Ad + ' (' + jsDil.Veli + ')' + '</option>');
                                }
                            }
                        }
                        if (odemeYapanTip == 0) {
                            $("#odemeDYapan").append('<option id="0" value="' + ogrID + '" selected>' + ogrAdSSoyad + ' (' + jsDil.Ogrenci + ')' + '</option>');
                        } else {
                            $("#odemeDYapan").append('<option id="0" value="' + ogrID + '">' + ogrAdSSoyad + ' (' + jsDil.Ogrenci + ')' + '</option>');
                        }
                    }
                }
            });
            $("input[name=rowID]").val(rowID);
            $("#ogrDOdemeAdSoyad").text(ogrAdSSoyad);
            var oTutar = tutar.split('(');
            $("input[name=odemeDTutar]").val($.trim(oTutar[0]));
            var dovizTip = $("input[name=odemeDovizTip]").val();
            $("#dovizDTip").val(dovizTip);
            $('#odemeDSekil').val(odemeSekli);
            $("textarea[name=bakiyeDAciklama]").val(aciklama);
            svControl('svAdd', 'ogrenciOdemeDuzenle', '');
            i.removeClass("fa fa-spinner");
            i.addClass("fa fa-edit");
        } else {//Print
            var odemeAlan = $(this).parent().parent().find('td:eq(0)').text();
            var odemeYapan = $(this).parent().parent().find('td:eq(1)').text();
            var odemeTutar = $(this).parent().parent().find('td:eq(2)').text();
            var odemeSekil = $(this).parent().parent().find('td:eq(3)').text();
            var odemeAciklama = $(this).parent().parent().find('td:eq(4)').text();
            var odemeTarih = $(this).parent().parent().find('td:eq(5)').text();
            $("#prOdemeAlan").text(odemeAlan);
            $("#prOdemeYapan").text(odemeYapan);
            $("#prOdemeTutar").text(odemeTutar);
            $("#prOdemeSekli").text(odemeSekil);
            $("#prOdemeAciklama").text(odemeAciklama);
            $("#prOdemeTarih").text(odemeTarih);
            printMe = window.open();
            printMe.document.write($('#odemeprint').html());
            printMe.print();
            printMe.close();
        }
    });
});
var BakiyeDetailVazgec = [];
$.AdminIslemler = {
    odemeYeni: function () {
        var ogrAdSSoyad = $("#ogrAdSoyad").text();
        var ogrID = $("input[name=ogrenciDetayID]").val();
        var dovizTip = $("input[name=odemeDovizTip]").val();
        $('#odemeYapan').empty().append('<option selected="selected" value="0">' + jsDil.Seciniz + '</option>');
        $("#ogrOdemeAdSoyad").text(ogrAdSSoyad);
        $("#dovizTip").val(dovizTip);
        $("textarea[name=bakiyeAciklama]").val('');
        $("input[name=odemeTutar]").val('');
        $.ajax({
            data: {"ogrID": ogrID, "tip": "ogrenciYeniOdeme"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    var length = cevap.veliler.length;
                    if (length != 0) {
                        for (var v = 0; v < length; v++) {
                            $("#odemeYapan").append('<option id="1" value="' + cevap.veliler[v].ID + '">' + cevap.veliler[v].Ad + ' (' + jsDil.Veli + ')' + ' </option>');
                        }
                    }
                    $("#odemeYapan").append('<option id="0" value="' + ogrID + '">' + ogrAdSSoyad + ' (' + jsDil.Ogrenci + ')' + '</option>');
                }
            }
        });
        return true;
    },
    ogrenciOdemeCancel: function () {
        return true;
    },
    odemeKaydet: function () {
        var odemeYapanText = $("#odemeYapan option:selected").text();
        var odemeYapanVal = $("#odemeYapan option:selected").val();
        var odemeYapanTip = $('#odemeYapan option:selected').attr("id");
        var odemeTutar = $("#odemeTutar").val();
        var dovizTip = $("#dovizTip").val();
        var odemeSekil = $("#odemeSekil").val();
        var aciklama = $("textarea[name=bakiyeAciklama]").val();
        var odenenID = $("input[name=ogrenciDetayID]").val();
        var odenenAdSyd = $("#ogrAdSoyad").text();
        if (odemeYapanVal != 0) {
            if (odemeTutar != "") {
                $.ajax({
                    data: {"odemeYapanText": odemeYapanText, "odemeYapanVal": odemeYapanVal,
                        "odemeYapanTip": odemeYapanTip, "odemeTutar": odemeTutar, "dovizTip": dovizTip,
                        "odemeSekil": odemeSekil, "aciklama": aciklama,
                        "odenenID": odenenID, "odenenAdSyd": odenenAdSyd, "tip": "ogrenciOdemeKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            reset();
                            alertify.success(cevap.result[0].Insert);
                            $("#odenenMoney").text(cevap.result[0].OdenenTutar + " " + cevap.result[0].OdemeParaTip);
                            $("#kalanMoney").text(cevap.result[0].KalanTutar + " " + cevap.result[0].OdemeParaTip);
                            var addRow = "<tr value='" + cevap.result[0].ID + "' style='background-color:#F2F2F2'>"
                                    + "<td>" + cevap.result[0].OdemeAlanAd + " (" + cevap.result[0].OdemeAlanTip + ")" + "</td>"
                                    + "<td value='" + cevap.result[0].OdemeYapanTp + "'>" + cevap.result[0].OdemeYapanAd + " (" + cevap.result[0].OdemeYapanTip + ")" + "</td>"
                                    + "<td>" + cevap.result[0].OdemeTutar + " (" + cevap.result[0].OdemeParaTip + ")" + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.result[0].OdemeTip + "</td>"
                                    + "<td class='hidden-xs'>" + aciklama + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.result[0].OdemeTarih + "</td>"
                                    + "<td class='hidden-xs'>"
                                    + "<a data-islem='0' data-toggle='tooltip' data-placement='top' title='Düzenle' value='' style='margin-left:10px;margin-right:10px;font-size:16px'><i class='fa fa-edit'></i></a>"
                                    + "<a data-islem='1' data-toggle='tooltip' data-placement='top' title='Yazdır' value='' style='margin-left:10px;margin-right:10px;font-size:16px'><i class='fa fa-print'></i></a>"
                                    + "</td>"
                                    + "</tr>";
                            OgrenciBakiyeTable.DataTable().row.add($(addRow)).draw();
                        }
                    }
                });
                return true;
            } else {
                reset();
                alertify.alert(jsDil.OdemeTutarGir);
                return false;
            }
        } else {
            reset();
            alertify.alert(jsDil.OdemeYapanSec);
            return false;
        }
    },
    ogrenciOdemeDCancel: function () {
        return true;
    },
    adminBakiyeDetailEdit: function () {
        //Bakiye İşlemleri Değerleri
        var odemeYapan = $("#odemeDYapan option:selected").text();
        var odemeTutar = $("input[name=odemeDTutar]").val();
        var dovizTip = $("#dovizDTip").val();
        var odemeSekli = $('#odemeDSekil option:selected').val();
        var odemeAciklama = $("textarea[name=bakiyeDAciklama]").val();
        BakiyeDetailVazgec = [];
        BakiyeDetailVazgec.push(odemeYapan, odemeTutar, dovizTip, odemeSekli, odemeAciklama);
    },
    adminBakiyeDetailVazgec: function () {
        var optionlength = $("#odemeDYapan >option").length;
        for (var o = 0; o < optionlength; o++) {
            if (BakiyeDetailVazgec[0] == $("#odemeDYapan > option:eq('" + o + "')").text()) {
                $("#odemeDYapan > option:eq('" + o + "')").prop('selected', true);
            }
        }
        $("input[name=odemeDTutar]").val(BakiyeDetailVazgec[1]);
        $("#dovizDTip").val(BakiyeDetailVazgec[2]);
        $('#odemeDSekil').val(BakiyeDetailVazgec[3]);
        $("textarea[name=bakiyeDAciklama]").val(BakiyeDetailVazgec[4]);
    },
    adminBakiyeDetailSil: function () {
        reset();
        alertify.confirm(jsDil.SilOnay, function (e) {
            if (e) {
                var rowID = $("input[name=rowID]").val();
                var ogrID = $("input[name=ogrenciDetayID]").val();
                var tutar = $("input[name=odemeDTutar]").val();
                var dovizTip = $("#dovizDTip").val();
                $.ajax({
                    data: {"rowID": rowID, "ogrID": ogrID, "tutar": tutar,
                        "tip": "bakiyeDetailDelete"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(jsDil.Hata);
                            return false;
                        } else {
                            disabledForm();
                            var length = $('table#odemeDetay > tbody > tr').length;
                            for (var t = 0; t < length; t++) {
                                var attrValueId = $("table#odemeDetay > tbody > tr").eq(t).attr('value');
                                if (attrValueId == rowID) {
                                    var deleteRow = $('table#odemeDetay > tbody > tr:eq(' + t + ')');
                                    OgrenciBakiyeTable.DataTable().row($(deleteRow)).remove().draw();
                                }
                            }
                            $("#odenenMoney").text(cevap.result[0].OdenenTutar + " " + dovizTip);
                            $("#kalanMoney").text(cevap.result[0].KalanTutar + " " + dovizTip);
                            //altta bulunan seçim pencerisini kapatma
                            reset();
                            alertify.success(cevap.result[0].Delete);
                            svControl('svClose', 'ogrenciOdemeDuzenle', '');
                        }
                    }
                });
            } else {
                alertify.error(jsDil.SilRed);
            }
        });
    },
    adminBakiyeDetailKaydet: function () {
        var odemeYapanText = $("#odemeDYapan option:selected").text();
        var odemeYapanVal = $("#odemeDYapan option:selected").val();
        var odemeYapanTip = $('#odemeDYapan option:selected').attr("id");
        var odemeTutar = $("#odemeDTutar").val();
        var oncekiTutar = BakiyeDetailVazgec[1];
        var dovizTip = $("#dovizDTip").val();
        var odemeSekil = $("#odemeDSekil").val();
        var aciklama = $("textarea[name=bakiyeDAciklama]").val();
        var odenenID = $("input[name=ogrenciDetayID]").val();
        var odenenAdSyd = $("#ogrAdSoyad").text();
        var rowID = $("input[name=rowID]").val();
        if (BakiyeDetailVazgec[0] == odemeYapanText && BakiyeDetailVazgec[1] == odemeTutar && BakiyeDetailVazgec[2] == dovizTip &&
                BakiyeDetailVazgec[3] == odemeSekil && BakiyeDetailVazgec[4] == aciklama) {
            reset();
            alertify.alert(jsDil.Degisiklik);
            return false;
        } else {
            if (odemeYapanVal != 0) {
                if (odemeTutar != "") {
                    $.ajax({
                        data: {"odemeYapanText": odemeYapanText, "odemeYapanVal": odemeYapanVal,
                            "odemeYapanTip": odemeYapanTip, "odemeTutar": odemeTutar, "dovizTip": dovizTip,
                            "odemeSekil": odemeSekil, "aciklama": aciklama,
                            "odenenID": odenenID, "odenenAdSyd": odenenAdSyd,
                            "rowID": rowID, "oncekiTutar": oncekiTutar, "tip": "ogrenciOdemeDetailKaydet"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                reset();
                                alertify.alert(jsDil.Hata);
                                return false;
                            } else {
                                disabledForm();
                                var length = $('table#odemeDetay > tbody > tr').length;
                                for (var t = 0; t < length; t++) {
                                    var attrValueId = $("table#odemeDetay > tbody > tr").eq(t).attr('value');
                                    if (attrValueId == rowID) {
                                        $("table#odemeDetay > tbody > tr").eq(t).find('td:eq(1)').text(cevap.result[0].OdemeYapanAd + " (" + cevap.result[0].OdemeYapanTip + ")");
                                        $("table#odemeDetay > tbody > tr").eq(t).find('td:eq(1)').attr("value", cevap.result[0].OdemeYapanTp);
                                        $("table#odemeDetay > tbody > tr").eq(t).find('td:eq(2)').text(cevap.result[0].OdemeTutar + " (" + cevap.result[0].OdemeParaTip + ")");
                                        $("table#odemeDetay > tbody > tr").eq(t).find('td:eq(3)').text(cevap.result[0].OdemeTip);
                                        $("table#odemeDetay > tbody > tr").eq(t).find('td:eq(4)').text(aciklama);
                                    }
                                }
                                $("#odenenMoney").text(cevap.result[0].OdenenTutar + " " + cevap.result[0].OdemeParaTip);
                                $("#kalanMoney").text(cevap.result[0].KalanTutar + " " + cevap.result[0].OdemeParaTip);
                                reset();
                                alertify.success(cevap.result[0].update);
                            }
                        }
                    });
                    return true;
                } else {
                    reset();
                    alertify.alert(jsDil.OdemeTutarGir);
                    return false;
                }
            } else {
                reset();
                alertify.alert(jsDil.OdemeYapanSec);
                return false;
            }
        }

    },
}


