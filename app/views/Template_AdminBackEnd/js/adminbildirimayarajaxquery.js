$.ajaxSetup({
    type: "post",
    url: SITE_URL + "AdminBildirimAyarAjaxSorgu",
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
$.AdminIslemler = {
    bildirimKaydet: function () {
        var notTickArray = new Array();
        var tbodytrr = $("tbody#bildirim>tr").length;
        var tbodytdd = $("tbody#bildirim>tr:eq(0)>td").length;
        for (var trr = 0; trr < tbodytrr; trr++) {
            for (var tdd = 1; tdd < tbodytdd; tdd++) {
                var tdler = $("tbody#bildirim>tr:eq(" + trr + ")>td:eq(" + tdd + ")>div>input").prop("checked");
                if (tdler != true) {
                    var dataislem = $("tbody#bildirim>tr:eq(" + trr + ")>td:eq(" + tdd + ")>div>input").attr("data-islem");
                    notTickArray.push(dataislem);
                }
            }
        }
        $.ajax({
            data: {"notTickArray[]": notTickArray, "tip": "bildirimTick"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    reset();
                    alertify.success(cevap.update);
                    $("#bildirim").val(cevap.ayarDuzen[0]);
                }
            }
        });
        return true;
    }
}


