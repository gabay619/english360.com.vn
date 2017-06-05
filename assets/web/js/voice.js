//voice
$(document).ready(function(){
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
        $('a.voice').each(function () {
            text = $(this).html();
            html = '<div style="display: inline-block"><span class="voice result">' + text + '</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button></div>';
            $(this).after(html);
            $(this).remove();
        });
    }else{
        if(getMobileOperatingSystem() == 'iOS'){
            showMss('Tính năng Test Voice không hỗ trợ trình duyệt bạn đang sử dụng. Vui lòng tải trình duyệt Chrome hoặc Cốc Cốc để sử dụng tính năng này.')
        }else{
            bootbox.alert(
                '<div style="font-size: 14px; text-align: center"><p>Tính năng Test Voice không hỗ trợ trình duyệt bạn đang sử dụng. Vui lòng tải trình duyệt Chrome hoặc Cốc Cốc để sử dụng tính năng này.</p></div>'+
                    '<a href="https://www.google.com/intl/vi/chrome/browser/desktop/index.html" target="_blank" class="btn btn-primary">Tải Chrome</a>'+
                    '<a href="https://coccoc.com/" target="_blank" class="btn btn-primary">Tải Cốc Cốc</a>'
                , function(){
                    $('.modal').modal('hide');
                });
            setTimeout(function(){
                $('.modal').modal('hide');
            }, 5000);
        }
        $('a.voice').each(function () {
            text = $(this).html();
            html = '<span class="voice result">' + text + '</span>';
            $(this).after(html);
            $(this).remove();
        });
    }
    $('.voice').click(function () {
        responsiveVoice.speak($(this).html().replace(/&nbsp;/gi,' '))
    })

    $(document).on('click', '.btnMicro',function () {
        recognition.start();
        currentAns = $(this).parent().find('.voice').html();
//            alert(currentAns);return false;
        $('.btnMicro').popover('destroy');
        //            $(this).parent().find('>i').remove();
        $currentBtn = $(this);
        $(this).removeClass('btn-primary').addClass('btn-success')
    });
    $(document).on('click', function (e) {
        //did not click a popover toggle, or icon in popover toggle, or popover
        $('.btnMicro').popover('destroy');
    });
});
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

function showPopover(ele,mss) {
    ele.popover({
        content: '<strong style="color:red">'+mss+'</strong>',
        placement: 'bottom',
        html: true
    }).popover('show');
}

function checkAns(ans) {
    if(checkPhrase(currentAns,ans)){
        $currentBtn.parent().find('.voice').removeClass('false').addClass('true');
        $currentBtn.parent().find('>i').removeClass('i_anw_false').addClass('i_anw_true');
        $currentBtn.remove();
    }else{
        $currentBtn.parent().find('.voice').addClass('false');
        showPopover($currentBtn,'<i class="i_anw_false"></i> '+ans);
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
    $currentBtn.removeClass('btn-success').addClass('btn-primary');
}

recognition.onerror = function(event) {
    alert('Không bắt được âm thanh!');
//        $('#voiceMss').show().html(event.error);
    $currentBtn.removeClass('btn-success').addClass('btn-primary');
    //        alert(event.error);
}

