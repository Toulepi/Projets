$(document).ready(function () {
    $("button[type='reset']").click(function () {
        $("#message").fadeOut(1000);
    });

    $("#message").dblclick(function () {
        $(this).fadeOut(1000);
    });
});