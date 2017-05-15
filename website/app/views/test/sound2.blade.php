@extends('layouts.private_not_aside', array(
    'breadcrumb'=>'Kiểm tra trình độ',
    'breadcrumbUrl' => '/test'
))
@section('content')
    <div class="detail_default">
        <div class="url_video_area center row">
            <div id="myElement">Loading the player...</div>
        </div>
    </div>
    <div class="table_detail row" style="margin-top: 25px">
        <p>Waitress: May I help you, sir?</p>
        <p>Customer: I'm Patrick Allen, <input readonly type="text" class="input_2 w_150" data-aw="I made a reservation yesterday" /><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Let me check the reservation list. Mr.Allen, your table is in the middle. Follow me.</p>
        <p>Customer: OK.</p>
        <p>Waitress: Would you like to have a drink before you order, sir?</p>
        <p>Customer: <input readonly type="text" class="input_2 w_150" data-aw="Yes, one beer please" /><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Yes, sir. What would you like to eat?</p>
        <p>Customer: Well, let me see. <input readonly type="text" class="input_2 w_150" data-aw="What are today specials" /><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>?</p>
        <p>Waitress: We have plain saute shrimps, fried boneless pork with sweet and sour sauce, and shredded beef, etc.</p>
        <p>Customer: <input readonly type="text" class="input_2 w_150" data-aw="I'll have the fried boneless pork" /><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Yes sir, anything else you would like to order?</p>
        <p>Customer: <input readonly type="text" class="input_2 w_150" data-aw="No, thank you" /><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Here's your beer, sir, and your fried boneless pork. I hope you enjoy your meal.</p>
        <p>(Later...)</p>
        <p>Customer: <input readonly type="text" class="input_2 w_150" data-aw="Waitress, May I have the check" /><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>?</p>
        <p>Waitress: Yeah, sure, here it is.</p>
        <p>Customer: <input readonly type="text" class="input_2 w_150" data-aw="Alright, here is my credit card" /><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Thank you, sir.</p>
    </div>

    <script type="text/javascript">
        jwplayer("myElement").setup({
            file: "http://english360.com.vn/uploads/15-12-2016/1481770765.mp4",
            image: "",
            skin: '{{Constant::PLAYER_SKIN}}',
            width: 650,
            height: 366,
            autostart: true,
            tracks: [],
            captions: {

            }
        });

        function checkPhrase(ph1,ph2){
            return ph1.toLowerCase().replace(/[^a-zA-Z1-9]/g, "") == ph2.toLowerCase().replace(/[^a-zA-Z1-9]/g, "");
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
        
        $(function () {
            $('.btnMicro').click(function () {
                recognition.start();
                currentAns = $(this).parent().find('input').attr('data-aw');
                $(this).parent().find('>i').remove();
                $currentBtn = $(this);
                $(this).removeClass('btn-primary').addClass('btn-success')
            })
        })

        function checkAns(ans) {
            if(checkPhrase(currentAns,ans)){
                $currentBtn.parent().find('input').remove();
                $currentBtn.parent().append('<span class="result true">'+
                        currentAns+ '</span>');
                $currentBtn.remove();
            }else{
                $currentBtn.parent().append('<i class="i_anw_false"></i>');
                $currentBtn.parent().find('input').val(ans);
                textWidth = ans.length * 7;
                if(textWidth > 150){
                    $currentBtn.parent().find('input').width(textWidth)
                }
            }
        }

        recognition.onresult = function(event) {
            var last = event.results.length - 1;
            ans = event.results[last][0].transcript;
            checkAns(ans);
        }

        recognition.onspeechend = function() {
            recognition.stop();
            $currentBtn.removeClass('btn-success').addClass('btn-primary');
        }

        recognition.onnomatch = function(event) {
            alert('Không bắt được âm thanh');
            $currentBtn.removeClass('btn-success').addClass('btn-primary');
//            diagnostic.textContent = "I didn't recognise that color.";
        }

        recognition.onerror = function(event) {
            alert(event.error);
            $currentBtn.removeClass('btn-success').addClass('btn-primary');
//        alert(event.error);
        }
    </script>
    <style>
        .input_2{
            color: red
        }
    </style>
@endsection