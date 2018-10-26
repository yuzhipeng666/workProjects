$(function(){
    var icon_close = true;
    $(".icon-close").click(function () {
        if(icon_close) {
            var icon_first = $(this).children("span:first-child");
            var icon_last = $(this).children("span:last-child");
            icon_first.css("transform","rotate(-55deg)");
            icon_last.css({
                "transform":"rotate(55deg)",
                "margin-top": "-1px"
            });
            $(this).css("top", "32px");
            $(".menu-home-container").css("display", "block")
            icon_close = false;
        } else {
            var icon_first = $(this).children("span:first-child");
            var icon_last = $(this).children("span:last-child");
            icon_first.css("transform","rotate(0deg)");
            icon_last.css({
                "transform":"rotate(0deg)",
                "margin-top": "8px"
            });
            $(this).css("top", "30px");
            $(".menu-home-container").css("display", "none")
            icon_close = true;
        }

    });
});

