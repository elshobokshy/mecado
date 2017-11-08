
$(function () {
    $('.message').on('click', function () {
        $(this).remove();
    });
});

$(document).ready(function() {
    $("input[name$='choice']").click(function() {
        var value = $(this).val();

        $("div.recipient").hide();
        $("#" + value).show();
    });
});