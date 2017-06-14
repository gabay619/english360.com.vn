$(document).ready(function(){
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
        $('#guideVoice').show();
        $('a.voice').each(function () {
            text = $(this).html();
            html = '<div style="display: inline-block;position: relative">' +
                '<span class="voice">' + text + '</span> ' +
                '<span class="result"></span>' +
                '<button class="ht btnMicro"><span class="fa fa-microphone"></span></button>' +
                '<div class="popover" style="display: none"></div>' +
                '</div>';
            $(this).after(html);
            $(this).remove();
        });
    }else{
        // alert('Tính năng Test Voice không hỗ trợ trình duyệt bạn đang sử dụng');
        if(getMobileOperatingSystem() == 'iOS'){
            $('body').append(
                '<a href="#requiredBrowser" id="fbRequiredBrowser" class="fancybox" style="display:none;">Open</a>' +
                '<div style="display: none" id="requiredBrowser">Hãy sử dụng trình duyệt Chrome trên máy tính hoặc điện thoại hệ điều hành android để luyện phát âm</div>'
            );
        }else{
            $('body').append(
                '<a href="#requiredBrowser" id="fbRequiredBrowser" class="fancybox" style="display:none;">Open</a>' +
                '<div style="display: none; text-align: center" id="requiredBrowser">' +
                '<p style="margin-bottom: 10px">Tính năng Test Voice không hỗ trợ trình duyệt bạn đang sử dụng. Vui lòng tải trình duyệt Chrome hoặc Cốc Cốc để sử dụng tính năng này.</p>' +
                '<a style="background-color: #4267b2" href="https://www.google.com/intl/vi/chrome/browser/desktop/index.html" target="_blank" class="ht"><i class="fa fa-chrome" aria-hidden="true"></i> Tải Chrome</a>'+
                '<a style="background-color: #5cb85c" style="margin-left: 10px" href="https://coccoc.com/" target="_blank" class="ht"><i class="fa fa-chrome" aria-hidden="true"></i> Tải Cốc Cốc</a>'+
                '</div>'
            );
            // $.featherlight($('#requireBrowser'),{})
        }
        $("#fbRequiredBrowser").trigger('click');

        $('a.voice').each(function () {
            text = $(this).html();
            html = '<span class="voice">' + text + '</span>';
            $(this).after(html);
            $(this).remove();
        });
    }
    $('.voice').click(function () {
        responsiveVoice.speak($(this).html().replace(/&nbsp;/gi,' '))
    });

    $(document).on('click', '.btnMicro',function () {
        recognition.start();
        currentAns = $(this).parent().find('.voice').html();
        $currentBtn = $(this);
    });
    $(document).on('click', function (e) {
        //did not click a popover toggle, or icon in popover toggle, or popover
        $('.popover').hide();
    });

    // $('#guideVoice').click(function () {
    //     $(this).find('.popover').toggle();
    // })
});

function showPopover(ele,mss) {
    ele.parent().find('.popover').show().html(mss);
}

var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList;
var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent;
var recognition = new SpeechRecognition();
var speechRecognitionList = new SpeechGrammarList();
//    speechRecognitionList.addFromString(grammar, 1);
//    recognition.grammars = speechRecognitionList;
//recognition.continuous = false;
recognition.lang = 'en-US';
var currentAns;
var $currentBtn;


function checkAns(ans) {
    if(checkPhrase(currentAns,ans)){
        $currentBtn.parent().find('.voice').removeClass('text-danger').addClass('text-success');
        $currentBtn.parent().find('span.result').addClass('kq_t');
        $currentBtn.remove();
    }else{
        $currentBtn.parent().find('.voice').addClass('text-danger');
//            $currentBtn.parent().find('span.result').addClass('kq_f');
        showPopover($currentBtn,'<span class="kq_f"></span> '+ans);
        console.log(ans.toLowerCase().replace(/[^a-zA-Z1-9]/g, "")+'-'+currentAns.toLowerCase().replace(/[^a-zA-Z1-9]/g, ""))
    }
}

recognition.onresult = function(event) {
    var last = event.results.length - 1;
    ans = event.results[last][0].transcript;
    console.log(ans)
    checkAns(ans);
}

recognition.onspeechend = function() {
    recognition.stop();
    $currentBtn.removeClass('btn-success').addClass('btn-primary');
}

recognition.onnomatch = function(event) {
//        $('#voiceMss').show().html('Không bắt được âm thanh');
    alert('Không bắt được âm thanh');
//        $currentBtn.removeClass('btn-success').addClass('btn-primary');
}

recognition.onerror = function(event) {
    alert('Không bắt được âm thanh!');
//        $('#voiceMss').show().html(event.error);
//        $currentBtn.removeClass('btn-success').addClass('btn-primary');
    //        alert(event.error);
}

//End voice

