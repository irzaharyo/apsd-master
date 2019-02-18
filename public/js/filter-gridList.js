var downloadGrid = (function () {
    "use strict";

    var $cardContainer = $('.download-cards');
    var $downloadCard = $('.download-card__content-box');
    var $viewTrigger = $('button:not(#btn_filter)').attr('data', 'trigger');

    function swapTriggerActiveClass(e) {
        $viewTrigger.removeClass('active');
        $(e.target).addClass('active');
    }

    function swapView(e) {
        var $currentView = $(e.target).attr('data-trigger');
        $cardContainer.attr('data-view', $currentView);
    }

    $(document).ready(function () {
        $viewTrigger.click(function (e) {
            swapTriggerActiveClass(e);
            swapView(e);
        });
    });

})();
$("#radio-salary").click(function () {
    $("#highest").prop('disabled', function (i, v) {
        return !v;
    });
});
$("#btn_filter").on("click", function () {
    $("#sidebar").toggle(300);
    $(this).toggleClass('active');
    $("#vacancy-list").toggleClass('col-lg-9 col-lg-12');
});

function filterFunction() {
    var input, a, i;
    input = $("#txt_filter").val().toUpperCase();
    a = $("#list-lokasi a");
    $("#list-lokasi .dropdown-header, #list-lokasi .divider").hide();
    for (i = 0; i < a.length; i++) {
        if (a.eq(i).text().toUpperCase().indexOf(input) > -1) {
            a.eq(i).parents("li").show();
            $('.province' + a.eq(i).parents("li").data('id')).show();
            $('#divider').show();
        } else {
            a.eq(i).parents("li").hide();
            $('.not_found').show();
        }
    }
}

$("#btn_reset").on("click", function () {
    $(this).hide();
    $("#lokasi").html('Filter&nbsp;<span class="fa fa-caret-down">' + '</span>');
    $("#txt_keyword").removeAttr('value');
    $(".search-form input:not(#txt_sort)").val('');
    filterFunction();
});

function showResetBtn(keyword) {
    if (keyword && keyword.length <= 0) {
        $("#btn_reset").hide();
    } else {
        $("#btn_reset").show();
    }
}