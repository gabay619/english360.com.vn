@extends('layouts.private_not_aside', array(
    'breadcrumb'=>'Kiểm tra trình độ',
    'breadcrumbUrl' => '/test'
))
@section('content')
    <div class="content_tab_text">
        <input type="text" class="input_2 w150" id="txtInput" />
        <button onclick="startRecord();" type="button" id="recordBtn"><i class="fa fa-volume-up"></i></button>
        <span id="mss"></span>
    </div>
    <script>
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
        var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList
        var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent
        var recognition = new SpeechRecognition();
        var speechRecognitionList = new SpeechGrammarList();
        //    speechRecognitionList.addFromString(grammar, 1);
        //    recognition.grammars = speechRecognitionList;
        //recognition.continuous = false;
        recognition.lang = 'en-US';
        //    recognition.interimResults = false;
        //    recognition.maxAlternatives = 1;
        startRecord = function() {
            recognition.start();
            $('#recordBtn').prop('disabled',true);
            $('#mss').html('Nói vào micro...')
            console.log('Ready to receive a color command.');
        }
        recognition.onresult = function(event) {
            // The SpeechRecognitionEvent results property returns a SpeechRecognitionResultList object
            // The SpeechRecognitionResultList object contains SpeechRecognitionResult objects.
            // It has a getter so it can be accessed like an array
            // The [last] returns the SpeechRecognitionResult at the last position.
            // Each SpeechRecognitionResult object contains SpeechRecognitionAlternative objects that contain individual results.
            // These also have getters so they can be accessed like arrays.
            // The [0] returns the SpeechRecognitionAlternative at position 0.
            // We then return the transcript property of the SpeechRecognitionAlternative object
            var last = event.results.length - 1;
            $('#txtInput').val(event.results[last][0].transcript);
            $('#recordBtn').prop('disabled',false);
            $('#mss').html('')

//        var last = event.results.length - 1;
//        var color = event.results[last][0].transcript;
//
//        diagnostic.textContent = 'Result received: ' + color + '.';
//        bg.style.backgroundColor = color;
//        console.log('Confidence: ' + event.results[0][0].confidence);
        }

        recognition.onspeechend = function() {
            recognition.stop();
        }

        //    recognition.onnomatch = function(event) {
        //        diagnostic.textContent = "I didn't recognise that color.";
        //    }

        recognition.onerror = function(event) {
            alert(event.error);
        }
    </script>
@endsection