// Document Ready
        $(document).ready(function () {
    // Form Enable / Disable Kontrolleri
    $(document).on("click", "#editForm", function () {
        $(document).find(".dsb").prop("disabled", false);
        $(document).find(".edit-group").css("display", "none");
        $(document).find(".submit-group").fadeIn();
        checkIt();
    });

    $(document).on("click", ".vzg", function () {
        $(document).find(".dsb").prop("disabled", true);
        $(document).find(".submit-group").css("display", "none");
        $(document).find(".edit-group").fadeIn();
        checkIt();
    });
    // End Form Enable / Dissable Kontrolleri


    // Sol Menu Navigasyon Kontrolü   
    $(".sidebar-menu").find(".active").removeClass("active");
    $("#" + activeMenu).find("a").click();
    $(".sidebar-menu").find(".activeli").removeClass("activeli");
    $("#" + activeMenu).find("#" + activeLink).addClass("activeli");

    // End Sol Menu Navigasyon Kontrolü

    // Subview Kontrolü
    $(document).on("click", ".svToggle", function (event) {
        var effect = 'slide';
        var options = {direction: 'right'};
        var duration = 500;
        var h = $(".svAdd").parent().height();
        $(".svAdd").height(h);
        $('.svAdd').toggle(effect, options, duration);
    });
    // End Subview Kontrolü
    

});
// End Document Ready

// CheckBox Kontrolü
function checkIt() {
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
}
// End CheckBox Kontrolü    

// SubView Generator
/*
 * @param {type} headerText --> SubView Başlık Metni
 * @param {type} partialView --> Getirilecek PartialView
 * @param {type} type --> İçerik Türü (Yeni Kayıt, Düzenleme vs.) / Create, Edit, Delete şeklinde gönderilebilir.
 * @param {type} table --> Sorgu Çekilecek Tablo
 * @param {type} id --> Düzenlenecek Kayıt ID
 */
function addSubView(headerText, partialView, type, table, id) {

    var wrapper = $(document).find("aside.right-side").parent();

    var temp = '<div class="svAdd col-lg-12 col-md-12 col-sm-12 col-xs-12">'
            + '<div class="row">'
            + '<div class="svContent col-lg-12 col-md-12 col-sm-12 col-xs-12">'
            + '<h3>' + headerText + ' <span class="pull-right"><button class="svToggle btn btn-danger"><i class="fa fa-times-circle"></i></button></span></h3>'
            + '<hr/>'
            + '<div class="row" id="getPartialView">'
            // Ajax sayfası geledek
            + '</div>'
            + '</div>'
            + '</div>'
            + '</div>';

    wrapper.append(temp);

}
// End SubView Generator


function disabledForm() {
    $(document).find(".dsb").prop("disabled", true);
    $(document).find(".submit-group").css("display", "none");
    $(document).find(".edit-group").fadeIn();
    checkIt();
}