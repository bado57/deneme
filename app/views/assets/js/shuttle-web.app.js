// Document Ready
        var z = 1;
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

    $(document).on("click", ".svToggle", function() {
        var dtype = $(this).attr("data-type");
        var dclass = $(this).attr("data-class");
        svControl(dtype,dclass);
    });

});
// End Document Ready
//data-type="svAdd" data-class="bolge"
// Subview Kontrolü
function svControl(dtype, dclass) {
    var effect = 'slide';
    var options = {direction: 'right'};
    var duration = 500;
    var h = $("." + dtype).parent().height();
    var hh = $(document).find("header").height();
    switch (dtype) {
        case "svAdd":
            $("#" + dclass).height(h);
            $("#" + dclass).css("top", hh);
            z++;
            $("#" + dclass).css("z-index", z);
            $('#' + dclass).toggle(effect, options, duration);
            break;
        case "svDetail":
            $("." + dtype).height(h);
            $("." + dtype).css("top", hh);
            z++;
            $("." + dtype).css("z-index", z);
            $("." + dtype).toggle(effect, options, duration);
            break;
        default:
            break;
    }
}
// End Subview Kontrolü

// CheckBox Kontrolü
function checkIt() {
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
}
// End CheckBox Kontrolü    


function disabledForm() {
    $(document).find(".dsb").prop("disabled", true);
    $(document).find(".submit-group").css("display", "none");
    $(document).find(".edit-group").fadeIn();
    checkIt();
}