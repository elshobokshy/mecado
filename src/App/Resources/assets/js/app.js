
$(function () {
    $('.message .close').on('click', function () {
        $(this).closest('.message').transition('fade');
    });
});

$(document).ready(function() {
    $("input[name$='choice']").click(function() {
        var value = $(this).val();

        $("div.recipient").hide();
        $("#" + value).show();
    });
});