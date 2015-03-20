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

    

    // Subview Kontrolü
    $(document).on("click", ".svToggle", function (event) {
        var effect = 'slide';
        var options = {direction: 'right'};
        var duration = 500;
        var sv = $(this).attr("data-type");
        var sc = $(this).attr("data-class");
        var h = $("."+sv).parent().height();
        var hh = $(document).find("header").height();
        switch(sv) {
    case "svAdd":
        $("#"+sc).height(h);
        $("#"+sc).css("top", hh);
        z++;
        $("#"+sc).css("z-index", z);
        $('#'+sc).toggle(effect, options, duration);
        break;
    case "svDetail":
        $("."+sv).height(h);
        $("."+sv).css("top", hh);
        z++;
        $("."+sv).css("z-index", z);
        $("."+sv).toggle(effect, options, duration);
        break;
    default:
        break;
}
        
        
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


function disabledForm() {
    $(document).find(".dsb").prop("disabled", true);
    $(document).find(".submit-group").css("display", "none");
    $(document).find(".edit-group").fadeIn();
    checkIt();
}