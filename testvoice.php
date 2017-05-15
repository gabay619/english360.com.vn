<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="vi_VN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <link href="/assets/web/css/normalize.css" type="text/css" rel="stylesheet" media="all" />
    <link href="/assets/web/css/style.css" type="text/css" rel="stylesheet" media="all" />
    <link href="/assets/web/css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all" />
    <link href="/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/lib/jquery-ui/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/assets/lib/jwplayer-7.4.2/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key="sP/q5QP+35gezFLCM/h47ykgSjaKjE0jUjCEfQ==";</script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/lib/jquery-ui/jquery-ui.min.js"></script>
</head>
<body>
<div class="container">
    <div class="detail_default">
        <div class="url_video_area center row">
            <div id="myElement">Loading the player...</div>
        </div>
    </div>
    <div style="clear: both"></div>
    <div class="text-center">
        <span class="alert alert-danger" id="voiceMss" style="display: none; margin-top: 5px"></span>
    </div>
    <div class="table_detail row" style="margin-top: 25px; margin-bottom: 30px">
        <p>Waitress: May I help you, sir?</p>
        <p>Customer: I'm Patrick Allen, <span class="result">I made a reservation yesterday</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Let me check the reservation list. Mr.Allen, your table is in the middle. Follow me.</p>
        <p>Customer: OK.</p>
        <p>Waitress: Would you like to have a drink before you order, sir?</p>
        <p>Customer: <span class="result">Yes, one beer please</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Yes, sir. What would you like to eat?</p>
        <p>Customer: Well, let me see. <span class="result">What are today’s specials</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>?</p>
        <p>Waitress: We have plain saute shrimps, fried boneless pork with sweet and sour sauce, and shredded beef, etc.</p>
        <p>Customer: I'll have the fried boneless pork.</p>
        <p>Waitress: Yes sir, anything else you would like to order?</p>
        <p>Customer: <span class="result">No, thank you</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Here's your beer, sir, and your fried boneless pork. I hope you enjoy your meal.</p>
        <p>(Later...)</p>
        <p>Customer: Waitress, <span class="result">May I have the check</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>?</p>
        <p>Waitress: Yeah, sure, here it is.</p>
        <p>Customer: <span class="result">Alright, here is my credit card</span> <i></i><button class="btn btn-sm btn-primary btnMicro"><i class="fa fa-microphone"></i></button>.</p>
        <p>Waitress: Thank you, sir.</p>
    </div>
</div>


<script type="text/javascript">
    jwplayer("myElement").setup({
        file: "http://english360.com.vn/uploads/15-12-2016/1481770765.mp4",
        image: "",
        width: "100%",
        aspectratio: "16:9",
        skin: 'bekle',
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
            currentAns = $(this).parent().find('span').html();
            $('#voiceMss').hide();
//            $(this).parent().find('>i').remove();
            $currentBtn = $(this);
            $(this).removeClass('btn-primary').addClass('btn-success')
        })
    })

    function checkAns(ans) {
        if(checkPhrase(currentAns,ans)){
            $currentBtn.parent().find('span').removeClass('false').addClass('true');
            $currentBtn.parent().find('>i').removeClass('i_anw_false').addClass('i_anw_true');
            $currentBtn.remove();
        }else{
            $currentBtn.parent().find('span').addClass('false');
            $currentBtn.parent().find('>i').addClass('i_anw_false');
            $('#voiceMss').show().html(ans);
//            $currentBtn.parent().find('input').val(ans);
//            textWidth = ans.length * 7;
//            if(textWidth > 150){
//                $currentBtn.parent().find('input').width(textWidth)
//            }
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
        $('#voiceMss').show().html('Không bắt được âm thanh');
//        alert('Không bắt được âm thanh');
        $currentBtn.removeClass('btn-success').addClass('btn-primary');
//            diagnostic.textContent = "I didn't recognise that color.";
    }

    recognition.onerror = function(event) {
//        alert(event.error);
        $('#voiceMss').show().html(event.error);
        $currentBtn.removeClass('btn-success').addClass('btn-primary');
//        alert(event.error);
    }
</script>
</body>
</html>
