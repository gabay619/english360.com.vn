//voice
var start_timestamp;
$(document).ready(function(){
    if (window.hasOwnProperty('webkitSpeechRecognition')) {
        $('#guideVoice').show();
        $('#guideVoice a').popover({
            title: 'Hướng dẫn sử dụng Test Voice',
            content: '<p><strong>B1:</strong> Bạn xem và nghe video mẫu.</p>' +
                        '<p><strong>B2:</strong> Khi bạn muốn luyện nói 1 câu/từ nào trong bài, bạn nhấn biểu tượng micro ở vị trí ngay bên phải của câu/từ đó -> chọn Allow (Cho phép) -> Bắt đầu đọc (bước chọn Allow chỉ hiển thị với lần đầu tiên bạn sử dụng, với những lần sau bạn chỉ cần nhấn biểu tượng micro là có thể đọc ngay).</p>' +
                        '<p>- Nếu bạn đọc chính xác: hệ thống sẽ báo đúng thể hiện bằng dấu <i class="i_anw_true"></i>.</p>' +
                        '<p>- Nếu bạn đọc sai: hệ thống sẽ báo sai thể hiện bằng dấu <i class="i_anw_false"></i>, đồng thời sẽ hiển thị câu mà bạn đã đọc sai, giúp bạn biết bạn đã đọc như thế nào, và sai ở đâu.</p>' +
                        '<p><i>Lưu ý: Sử dụng tai nghe có micro trên máy tính và sử dụng hệ điều hành Android trên điện thoại.</i></p>',
            placement: 'right',
            trigger: 'focus',
            html: true
        });
        $('a.voice').each(function () {
            text = $(this).html();
            html = '<div style="display: inline-block"><span class="voice result">' + text + '</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button></div>';
            $(this).after(html);
            $(this).remove();
        });
    }else{
        if(getMobileOperatingSystem() == 'iOS'){
            showMss('Hãy sử dụng trình duyệt Chrome trên máy tính hoặc điện thoại hệ điều hành android để luyện phát âm.')
        }else{
            bootbox.dialog({
                message:  '<div style="font-size: 14px; text-align: center"><p>Tính năng Test Voice không hỗ trợ trình duyệt bạn đang sử dụng. Vui lòng tải trình duyệt Chrome hoặc Cốc Cốc để sử dụng tính năng này.</p></div>'+
                '<div class="text-center">'+
                '<a href="https://www.google.com/intl/vi/chrome/browser/desktop/index.html" target="_blank" class="btn btn-primary"><i class="fa fa-chrome" aria-hidden="true"></i> Tải Chrome</a>'+
                '<a style="margin-left: 10px" href="https://coccoc.com/" target="_blank" class="btn btn-success"><i class="fa fa-chrome" aria-hidden="true"></i> Tải Cốc Cốc</a>'+
                '</div>'
            }
            );
            // setTimeout(function(){
            //     $('.modal').modal('hide');
            // }, 5000);
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
        start_timestamp = event.timeStamp;
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
        soundCorrect();
    }else{
        $currentBtn.parent().find('.voice').addClass('false');
        showPopover($currentBtn,'<i class="i_anw_false"></i> '+ans);
        soundInCorrect();
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
    alert('Không thể nhận diện phát âm của bạn.');
    $currentBtn.removeClass('btn-success').addClass('btn-primary');
}

recognition.onerror = function(event) {
    console.log(event.error)
    console.log(event.timeStamp - start_timestamp)
    if(event.error == 'no-speech'){
        alert('Không bắt được âm thanh. Hãy thử điều chỉnh các xác lập microphone trên máy tính của bạn.');
    }
    if (event.error == 'audio-capture') {
        alert('Yêu cầu nhận diện microphone đã bị từ chối. Hãy đảm bảo microphone đã được cài đặt và xác lập thành công trên máy tính của bạn.');
    }
    if(event.error == 'not-allowed'){
        if(event.timeStamp - start_timestamp < 100){
            alert('Chưa nhận diện được microphone. Hãy đảm bảo microphone đã được cài đặt và xác lập thành công trên máy tính của bạn.')
        }else{
            alert('Yêu cầu nhận diện microphone đã bị từ chối. Hãy đảm bảo microphone đã được cài đặt và xác lập thành công trên máy tính của bạn.')
        }
    }else{
        alert('Không bắt được âm thanh');
    }
    // alert(event.error);
//        $('#voiceMss').show().html(event.error);
    $currentBtn.removeClass('btn-success').addClass('btn-primary');
    //        alert(event.error);
}

