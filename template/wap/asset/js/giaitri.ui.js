//Hide Top
window.addEventListener("load", function () {
    // Set a timeout...
    setTimeout(function () {
        // Hide the address bar!
        window.scrollTo(0, 1);
    }, 0);
});
// Side Bar
$(document).ready(function () {
    var is_expand = false;
    $('#sib_btn').click(function () {
        if(is_expand==false){
            $('wrapper').css('position','absolute');
            $('body,.carea').height($('#scrollbar_sidebar').height());
            $('.my_sidebar').css('left',"0");
            $('.carea').css('left',"250px");
            $('.carea').css('overflow-x', 'hidden');
            $('.carea').css('min-height', '100vh');
            $('body').css('overflow-x', 'hidden');
            $('body').css('min-height', '100vh');
            $('.carea').css("position","fixed");
            is_expand=true;
        }
        else{
            $('.my_sidebar').css('left',"-250px");
            $('.carea,.header').css('left',"0");
            $('body,.carea').height('auto');
            $('body,.carea').css("position","relative");
            is_expand=false;
        }
        return false;
    });

});
function focusHeader()
{
    $(document).ready(function () {
        $("html, body").animate({ scrollTop: $('.header').offset().top }, 10);
    });
}

function isPropertySupported(property) {
    return property in document.body.style;
}

// Toogle Search
$(".btn_search, .btn_close_search").click(function(){
    $(".search_type").toggle();
});

// Toogle Btn_more_cate
$(".btn_more_cate").click(function(){
    $(this).parent().find(".content_more_cate").toggle();
});














