$(document).ready(function() {


    $("#eth-copy").tooltip({
        placement: 'bottom',
        trigger: 'manual'
    });

    $("#btc-copy").tooltip({
        placement: 'bottom',
        trigger: 'manual'
    });


    $("#eth-copy").click(function () {
        copyToClipboard("#eth-address");
        showtooltip($( this ));
    });

    $("#btc-copy").click(function () {
        copyToClipboard("#btc-address");
        showtooltip($( this ));
    });

});

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).val()).select();
    document.execCommand("copy");
    $temp.remove();
}

function showtooltip(element) {
    element.tooltip('show');
    setTimeout(function() {
        element.tooltip('hide');
        }, 1000);
}
