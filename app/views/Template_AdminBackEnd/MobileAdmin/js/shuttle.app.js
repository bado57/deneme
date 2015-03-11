$(document).ready(function () {

    // Form Enable / Disable
    $(document).on("click", "#editForm", function () {
        $(document).find(".navbar-toggle").click();
        $(document).find(".dsb").prop("disabled", false);
        $(document).find(".submit-group").fadeIn();
         checkIt();
    });

    $(document).on("click", ".vzg", function () {
        $(document).find(".dsb").prop("disabled", true);
        $(document).find(".submit-group").fadeOut();
         checkIt();
    });

});


function checkIt() {
        $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });
    }