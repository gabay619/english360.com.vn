var flag = 0;
var started = false;
var t = 200;
var thread;
function lookup(word, $obj) {
    console.log($obj);
    if(word=="") return false;
    var dict = (getCookie('tratu-lang') != '') ? getCookie('tratu-lang') : '1';
    $.ajax({
        //beforeSend: function() { $("#btn_clear").addClass('loading'); },
        //complete: function() { $("#btn_clear").removeClass('loading'); },
        url:"http://m.vdict.com/mobile/dictjson?fromapp=1&word=" + word + "&dict=" + dict,
        dataType: 'jsonp',
        success:function(json){
            console.log(json);
            if(json != null){
                $obj.find(".suggestions").hide();
                //$("#history").removeClass("not_found").hide();
                $(".tratu_result").html(json.result);
                //$("#content_result").trigger("create");
                $(".tratu_result").show();
                //$("#foo").removeCenter();
                //doSaveCookie(word, dict);
                if (json.type == 2){
                    $(".tratu_result").html('<div id="wordresult"><div><h1>'+word+'</h1><div><b>Không tìm thấy từ này.</b></div></div></div>');
                    $(".tratu_result").show();
                    //$("#history .hl span").html(json.result);
                    //$("#history .hl a").remove();
                    //$("#suggested-list").empty();
                    //$.each(json.items, function (i, thisitem) {
                    //    $('<li><a class="suggested" href="#">' + thisitem.wordname + '</a></li>').appendTo("#suggested-list");
                    //});
                    //$('<div class="clear"></div>').appendTo("#suggested-list");
                    //$(".tratu_result").html("").hide();
                    //$("#history").addClass("not_found").show();
                }
            }
            else{
                $(".tratu_result").html('<div id="wordresult"><div><h1>'+word+'</h1><div><b>Không tìm thấy từ này.</b></div></div></div>');
                $(".tratu_result").show();
            }

        },
        error:function(){
            alert("Error connecting to server");
        }
    });
}


function autocomplete(word, $obj) {
    //console.log($obj);
    if(word=="") return false;
    var dict = (getCookie('tratu-lang') != '') ? getCookie('tratu-lang') : '1';
    $.ajax({
        beforeSend: function() { $("#btn_clear").addClass('loading'); },
        complete: function() { $("#btn_clear").removeClass('loading'); },
        url:"http://vdjson.vd.xrel.com/"+ dict +"/"+ word +".jgz",
        dataType: 'jsonp',
        jsonpCallback: "vdjsoncb",
        success:function(json){
            $obj.parent().find(".suggestions").empty();
            $obj.parent().find(".suggestions").show();
            currentValue = json.query;
            console.log(json);
            if (json.suggestions){
                $i = 0;
                $.each(json.suggestions, function (i, thisitem) {
                    if ($i < 20)
                    {
                        htmlx = '<li><a class="suggested" href="javascript:void(0)"><strong>' + thisitem + '</strong></a></li>'
                        $obj.parent().find(".suggestions").append(htmlx);
                    }
                    $i++;
                });
                $('<div class="clear"></div>').appendTo("#suggestions");
                $("#suggestions").slideDown("fast");
                //$('<div class="clear"></div>').appendTo("#suggestions");
            }
        },
        error:function(){
        }
    });
}

function convertVietnamese(str) {
    str= str.toLowerCase();
    str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
    str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");
    str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
    str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o");
    str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");
    str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");
    str= str.replace(/đ/g,"d");
    str= str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g,"-");
    str= str.replace(/-+-/g,"-");
    str= str.replace(/^\-+|\-+$/g,"");

    return str;
}

function traTu(){
    var word = $('#txtTratu').val();
    if(word.length >= 2){
        lookup(word);
    }
}
jQuery.fn.center = function () {
    this.css("padding-top", (($(window).height() - this.outerHeight() - 84) / 2));
    return this;
}
jQuery.fn.bottom = function () {
    this.css("padding-top", ($(window).height() - this.outerHeight() - $("#main_content").height()));
    return this;
}
jQuery.fn.removeCenter = function () {
    this.css("padding-top", "0");
    return this;
}
jQuery(function ($) {
    var t = 200;
    var thread;
    $('li a.suggested').click(function (event) {
        event.preventDefault();
        //return;
        //lookup($(this).val(),1);
    });

    $("#history,#suggestions,#btn_clear").hide();
    $("#main_content").center();
    $("#main_content").removeCenter();
    $("#foo").bottom();

    //$(".btn-search").click(function(){
    //    var word = $('#word').val();
    //    if(word.length >= 2){
    //        lookup(word);
    //    }
    //});

    $(".txtTratu").focus(function () {
        if ($(this).val() != $(this).attr("placeholder") && $(this).val() != "") {
            $("#btn_clear").show();
        }
        $(this).val("");
        $(".suggestions").empty().hide();
    }).keyup(function (e) {
        var $obj = $(this);

        var word = $(this).val();
        if (word.length >= 1) {
            if(e.keyCode == 40){
                if ($obj.parent().find('.suggestions li.selected').length == 0) {
                    $obj.parent().find('.suggestions li:first').addClass('selected');
                } else {
                    if($obj.parent().find('.suggestions li').next().length > 0) {
                        $obj.parent().find('.suggestions li.selected').next().addClass('selected');
                        $obj.parent().find('.suggestions li.selected').prev().removeClass('selected');
                    }
                }
                $('.txtTratu').val($obj.parent().find('.suggestions li.selected').text());
            }else if(e.keyCode == 38 && flag == 1){
                $obj.parent().find('.suggestions li.selected').prev().addClass('selected');;
                $obj.parent().find('.suggestions li.selected').next().removeClass('selected')
            }else{
                clearTimeout(thread);
                thread = setTimeout(function () {

                    if (e.keyCode == 13) {
                        lookup(word);
                    } else {
                        autocomplete(word, $obj);

                        //$("#btn_clear").show();
                    }
                }, t);
            }

        }else{
            $obj.parent().find('.suggestions').hide();
        }
    });

    $("#btn_clear").click(function () {
        $(this).hide();
        $("#word").val("");
        $("#content_result").html("");
        // reset history, need history output here
        //$("#history").removeClass("not_found").html('<div class="hl"><span>History</span><a href="#" class="del"></a> </div><ul id="suggested-list"><div class="clear"></div></ul>').slideUp("fast");
        $("#suggestions").slideUp("fast");
        return false;
    });
    $('body').on('click', 'a.del', function () {
        //$("#history").slideUp("fast");
        //clearHistory();
        //updateHistory();
        return false;
    });
    // audio
    $('body').on('click', 'a#play', function () {
        document.getElementById('audio').play();
    });
    // look it up
    $("#frmlookup").submit(function () {
        $("#history,#suggestions").hide();
        lookup($("#word").val());
        return false;
    });
    $("#btn_submit").click(function () {
        $("#frmlookup").submit();
        return false;
    });
    $('body').on('click', 'a.suggested', function () {
        $obj = $(this).parent().parent().parent();
        $obj.find(".txtTratu").val($(this).text());
        lookup($(this).text(), $obj);
        return false;
    });
    $('.btn_tratu').click(function(){
        $obj = $(this).parent().find('.input-tratu');
        text = $obj.find(".txtTratu").val();
        //$obj.find(".txtTratu").val($(this).text());
        lookup(text, $obj);
        return false;
    })
});


function supports_html5_storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}