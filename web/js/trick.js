$(function () {
    $("#see-medias").click(function() {
        $(this).removeClass('visible-xs').fadeOut('slow');
        $(this).next('div.row').removeClass('hidden-xs').hide().slideDown();
    });

    $("div.comments").slice(0, 4).show();
    if ($("div.comments").length > 4) {
        $("#loadMore").on('click', function (e) {
            $("div.comments:hidden").slice(0, 4).slideDown();
            if ($("div.comments:hidden").length == 0) {
                $("#loadMore").fadeOut('slow');
            }
            $('html,body').animate({
                scrollTop: $(this).offset().top
            }, 1500);
        });
    } else {
        $("#loadMore").hide();
    }
});