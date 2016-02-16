$.ajaxSetup({
    type: "post",
    url: SITE_URL + "AdminBakiyeIsciAjax",
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
    IsciTable = $('#bakiyeIsciTable').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    IsciBakiyeTable = $('#odemeDetay').dataTable({
        "paging": false,
        "ordering": false,
        "info": false,
        "bFilter": false
    });
    $(document).on('click', 'tbody#isciRow > tr > td > a', function (e) {
        IsciBakiyeTable.DataTable().clear().draw();
        var i = $(this).find("i");
        i.removeClass("glyphicon glyphicon-user");
        i.addClass("fa fa-spinner");
        var id = $(this).attr('value');
        $.ajax({
            data: {"id": id, "tip": "isciDetail"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(jsDil.Hata);
                    return false;
                } else {
                    $("input[name=isciDetayID]").val(cevap.isciDetail[0][0].IsciListID);
                    $("input[name=odemeDovizTip]").val(cevap.isciDetail[0][0].OdemeParaTip);
                    $("#isciAdSoyad").text(cevap.isciDetail[0][0].IsciListAd + " " + cevap.isciDetail[0][0].IsciListSoyad);
                    $("#totalMoney").text(cevap.isciDetail[0][0].OdemeTutar + " " + cevap.isciDetail[0][0].OdemeParaTip);
                    $("#odenenMoney").text(cevap.isciDetail[0][0].OdenenTutar + " " + cevap.isciDetail[0][0].OdemeParaTip);
                    $("#kalanMoney").text(cevap.isciDetail[0][0].KalanTutar + " " + cevap.isciDetail[0][0].OdemeParaTip);
                    if (cevap.isciDetail[1]) {
                        var length = cevap.isciDetail[1].length;
                        for (var b = 0; b < length; b++) {
                            var addRow = "<tr value='" + cevap.isciDetail[1][b].ID + "'>"
                                    + "<td>" + cevap.isciDetail[1][b].OdemeAlanAd + " (" + cevap.isciDetail[1][b].OdemeAlanTip + ")" + "</td>"
                                    + "<td value='" + cevap.isciDetail[1][b].OdemeYapanTp + "'>" + cevap.isciDetail[1][b].OdemeYapanAd + " (" + cevap.isciDetail[1][b].OdemeYapanTip + ")" + "</td>"
                                    + "<td>" + cevap.isciDetail[1][b].OdemeTutar + " (" + cevap.isciDetail[0][0].OdemeParaTip + ")" + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.isciDetail[1][b].OdemeTip + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.isciDetail[1][b].OdemeAciklama + "</td>"
                                    + "<td class='hidden-xs'>" + cevap.isciDetail[1][b].OdemeTarih + "</td>"
                                    + "<td class='hidden-xs'>"
                                    + "<a data-islem='0' data-toggle='tooltip' data-placement='top' title='Düzenle' value='' style='margin-left:10px;margin-right:10px;font-size:16px'><i class='fa fa-edit'></i></a>"
                                    + "<a data-islem='1' data-toggle='tooltip' data-placement='top' title='Yazdır' value='' style='margin-left:10px;margin-right:10px;font-size:16px'><i class='fa fa-print'></i></a>"
                                    + "</td>"
                                    + "</tr>";
                            IsciBakiyeTable.DataTable().row.add($(addRow)).draw();
                        }
                    }
                    svControl('svAdd', 'IsciDetay', '');
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
            var isciAdSSoyad = $("#isciAdSoyad").text();
            var isciID = $("input[name=isciDetayID]").val();
            $('#odemeDYapan').empty().append('<option value="0">' + jsDil.Seciniz + '</option>');
            var odemeYapann = odemeYapan.split('(');
            $("#odemeDYapan").append('<option id="0" value="' + isciID + '"  selected="selected">' + isciAdSSoyad + ' (' + jsDil.Personel + ')' + '</option>');
            $("input[name=rowID]").val(rowID);
            $("#isciDOdemeAdSoyad").text(isciAdSSoyad);
            var oTutar = tutar.split('(');
            $("input[name=odemeDTutar]").val($.trim(oTutar[0]));
            var dovizTip = $("input[name=odemeDovizTip]").val();
            $("#dovizDTip").val(dovizTip);
            $('#odemeDSekil').val(odemeSekli);
            $("textarea[name=bakiyeDAciklama]").val(aciklama);
            svControl('svAdd', 'isciOdemeDuzenle', '');
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
        var isciAdSSoyad = $("#isciAdSoyad").text();
        var isciID = $("input[name=isciDetayID]").val();
        var dovizTip = $("input[name=odemeDovizTip]").val();
        $('#odemeYapan').empty().append('<option selected="selected" value="0">' + jsDil.Seciniz + '</option>');
        $("#isciOdemeAdSoyad").text(isciAdSSoyad);
        $("#dovizTip").val(dovizTip);
        $("textarea[name=bakiyeAciklama]").val('');
        $("input[name=odemeTutar]").val('');
        $("#odemeYapan").append('<option id="0" value="' + isciID + '">' + isciAdSSoyad + ' (' + jsDil.Personel + ')' + '</option>');
        return true;
    },
    isciOdemeCancel: function () {
        return true;
    },
    odemeKaydet: function () {
        var odemeYapanText = $("#odemeYapan option:selected").text();
        var odemeYapanVal = $("#odemeYapan option:selected").val();
        var odemeTutar = $("#odemeTutar").val();
        var dovizTip = $("#dovizTip").val();
        var odemeSekil = $("#odemeSekil").val();
        var aciklama = $("textarea[name=bakiyeAciklama]").val();
        var odenenID = $("input[name=isciDetayID]").val();
        var odenenAdSyd = $("#isciAdSoyad").text();
        if (odemeYapanVal != 0) {
            if (odemeTutar != "") {
                $.ajax({
                    data: {"odemeYapanText": odemeYapanText, "odemeYapanVal": odemeYapanVal,
                        "odemeTutar": odemeTutar, "dovizTip": dovizTip,
                        "odemeSekil": odemeSekil, "aciklama": aciklama,
                        "odenenID": odenenID, "odenenAdSyd": odenenAdSyd, "tip": "isciOdemeKaydet"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
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
                            IsciBakiyeTable.DataTable().row.add($(addRow)).draw();
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
    isciOdemeDCancel: function () {
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
                var isciID = $("input[name=isciDetayID]").val();
                var tutar = $("input[name=odemeDTutar]").val();
                var dovizTip = $("#dovizDTip").val();
                $.ajax({
                    data: {"rowID": rowID, "isciID": isciID, "tutar": tutar,
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
                                    IsciBakiyeTable.DataTable().row($(deleteRow)).remove().draw();
                                }
                            }
                            $("#odenenMoney").text(cevap.result[0].OdenenTutar + " " + dovizTip);
                            $("#kalanMoney").text(cevap.result[0].KalanTutar + " " + dovizTip);
                            //altta bulunan seçim pencerisini kapatma
                            reset();
                            alertify.success(cevap.result[0].Delete);
                            svControl('svClose', 'isciOdemeDuzenle', '');
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
        var odemeTutar = $("#odemeDTutar").val();
        var oncekiTutar = BakiyeDetailVazgec[1];
        var dovizTip = $("#dovizDTip").val();
        var odemeSekil = $("#odemeDSekil").val();
        var aciklama = $("textarea[name=bakiyeDAciklama]").val();
        var odenenID = $("input[name=isciDetayID]").val();
        var odenenAdSyd = $("#isciAdSoyad").text();
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
                            "odemeTutar": odemeTutar, "dovizTip": dovizTip,
                            "odemeSekil": odemeSekil, "aciklama": aciklama,
                            "odenenID": odenenID, "odenenAdSyd": odenenAdSyd,
                            "rowID": rowID, "oncekiTutar": oncekiTutar, "tip": "isciOdemeDetailKaydet"},
                        success: function (cevap) {
                            if (cevap.hata) {
                                reset();
                                alertify.alert(cevap.hata);
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


