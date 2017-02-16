var flag = 0;
var started = false;
function lookup(word, dict) {
    if (word == "") return false;
    $.ajax({
        beforeSend: function () { $("#btn_clear").addClass('loading'); },
        complete: function () { $("#btn_clear").removeClass('loading'); },
        url: "http://m.vdict.com/mobile/dictjson?fromapp=1&word=" + word + "&dict=" + dict,
        dataType: 'jsonp',
        success: function (json) {
            $("#suggestions").hide();
            $("#history").removeClass("not_found").hide();
            if(json != null){
                $("#content_result").html(json.result);
                $("#content_result").trigger("create");
                $("#content_result").show();
                $("#foo").removeCenter();
                if (json.type == 2) {
                    $("#suggested-list").empty();
                    $.each(json.items, function (i, thisitem) {
                        $('<li><a class="suggested" href="#">' + thisitem.wordname + '</a></li>').appendTo("#suggested-list");
                    });
                    $('<div class="clear"></div>').appendTo("#suggested-list");
                    $("#content_result").html("<p>Không tìm thấy từ cần tra!</p>");
                }
            }else{
                $("#content_result").html("<p>Có lỗi trong quá trình xử lý</p>");
            }
            $('#dialog-trans').dialog('open');
        },
        error: function () {
            alert("Error connecting to server");
        }
    });
}

function autocomplete(word, dict) {
    if (word == "") return false;
    $.ajax({
        beforeSend: function () { $("#suggestions").slideUp('fast');flag = 0; },
        complete: function () { $("#btn_clear").removeClass('loading'); },
        url: "http://vdjson.vd.xrel.com/" + dict + "/" + word + ".jgz",
        dataType: 'jsonp',
        jsonpCallback: "vdjsoncb",
        success: function (json) {
            $("#suggestions").empty();

            currentValue = json.query;
            if (json.suggestions) {
                $i = 0;
                $.each(json.suggestions, function (i, thisitem) {
                    if ($i < 100) {
                        var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
                        var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
                        label = thisitem.replace(new RegExp(pattern, 'gi'), "<strong class='autocomplete-word-hightline'>$1</strong>");
                        $('<li><a class="suggested" href="#">' + label + '</a></li>').appendTo("#suggestions");
                    }
                    $i++;
                });
                $('<div class="clear"></div>').appendTo("#suggestions");
                $("#suggestions").slideDown("fast");
                flag = 1;

            }
        },
        error: function () {
            
        }
    });
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

    $(".btn-search").click(function(){
        var word = $('#word').val();
        if(word.length >= 2){
            lookup(word, 1);
        }
    });

    $("#word").focus(function () {
        if ($(this).val() != $(this).attr("placeholder") && $(this).val() != "") {
            $("#btn_clear").show();
        }
        $("#word").val("");
        $("#suggestions").empty().hide();
    }).keyup(function (e) {
            var word = $(this).val();
            if (word.length > 2) {
                if(e.keyCode == 40 && flag == 1 ){
                    if ($('#suggestions li.selected').length == 0) {
                        $('#suggestions li:first').addClass('selected');
                    } else {
                        if($('#suggestions li').next().length > 0) {
                            $('#suggestions li.selected').next().addClass('selected');
                            $('#suggestions li.selected').prev().removeClass('selected');
                        }
                    }
                    $('#word').val($('#suggestions li.selected').text());
                }else if(e.keyCode == 38 && flag == 1){
                    $('#suggestions li.selected').prev().addClass('selected');;
                    $('#suggestions li.selected').next().removeClass('selected')
                }else{
                    clearTimeout(thread);
                    thread = setTimeout(function () {

                        if (e.keyCode == 13) {
                            lookup(word, 1);
                        } else {
                            autocomplete(word, 1);

                            $("#btn_clear").show();
                        }
                    }, t);
                }

            }else{
                $('#suggestions').hide();
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
        lookup($("#word").val(), 1);
        return false;
    });
    $("#btn_submit").click(function () {
        $("#frmlookup").submit();
        return false;
    });
    $('body').on('click', 'a.suggested', function () {
        $("#word").val($(this).text());
        lookup($(this).text(), 1);
        return false;
    });
});


function supports_html5_storage() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}
