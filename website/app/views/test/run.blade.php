@extends('layouts.private_not_aside', array(
    'breadcrumb'=>'Kiểm tra trình độ',
    'breadcrumbUrl' => '/test'
))
@section('content')
    <script src="/assets/js/jquery.simple.timer.js"></script>
    <div class="test-content">
        <h4 class="title_1" id="loadTitle">{{$firstTest->name}}</h4>
        <div id="loadContent" style="padding-bottom: 30px">
           {{urldecode($firstTest->content)}}
        </div>
        <div class="clock">
            <div class="timer" data-minutes-left=24></div>
        </div>
        <div class="text-center">
            <button type="button" class="btn_x btn_blue btn_padding bold" onclick="toNext()" id="nextBtn">Tiếp theo</button>
        </div>
    </div>
    <div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="completeModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center"></h4>
                </div>
                <div class="modal-body" style="overflow: hidden">
                    <div class="text-center">
                        <button type="button" class="btn btn-danger" onclick="getResult()">Xem kết quả</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .test-content{
            padding: 15px;
            border: 1px solid #ccc;
            position: relative;
        }
        .clock{
            position: absolute;
            right:0;
            top:0;
            background: red;
            color: #fff;
            padding: 5px;
        }
        .jst-hours {
            float: left;
        }
        .jst-minutes {
            float: left;
        }
        .jst-seconds {
            float: left;
        }
        .jst-clearDiv {
            clear: both;
        }

        /*.checkbox label:after,*/
        /*.radio label:after {*/
            /*content: '';*/
            /*display: table;*/
            /*clear: both;*/
        /*}*/

        .tracnghiem .cr{
            position: relative;
            display: inline-block;
            border: 1px solid #a9a9a9;
            border-radius: .25em;
            width: 1.3em;
            height: 1.3em;
            float: left;
            margin-right: .5em;
        }

        .tracnghiem .cr .cr-icon {
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .tracnghiem label{
            margin-bottom: -2px;
        }

        .tracnghiem label input[type="checkbox"],
        .radio label input[type="radio"] {
            display: none;
        }

        .tracnghiem label input[type="checkbox"] + .cr > .cr-icon,
        .radio label input[type="radio"] + .cr > .cr-icon {
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .tracnghiem label input[type="checkbox"]:checked + .cr > .cr-icon,
        .radio label input[type="radio"]:checked + .cr > .cr-icon {
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .tracnghiem label input[type="checkbox"]:disabled + .cr,
        .radio label input[type="radio"]:disabled + .cr {
            opacity: .5;
        }
    </style>
    <script>
        var currentLvl = 1;
        var currentPoint = 0;
        var currentNumberQuestion = 1;
        var currentQuestionId = '{{$firstTest->_id}}';
        var numQuestion = 0;

        $(function () {
//            complete('Test message');
            $('.timer').startTimer({
                onComplete: function(element){
                    complete('Thời gian làm bài của bạn đã hết.');
                }
            });

            $(document).on('keyup','#loadContent .input_2',function(){
                textWidth = $(this).val().length * 7;
                if(textWidth > $(this).width()){
                    $(this).width(textWidth)
                }
                console.log(textWidth)
            });
            replaceResource();
        });

        function getResult() {
            $.post('/test/result', {
                point:currentPoint, num: numQuestion
            }, function (re) {
                if(re.success){
                    window.location.href = re.url;
                }
            })
        }

        function replaceResource() {
            $('#loadContent .Loa').each(function(){
                var src = $(this).attr('alt');
                html = '<a class="aSpeaker" href="javascript:playAudio(\''+src+'\')" data-audio="'+src+'">'+
                        '<i class="fa fa-volume-up fa-2x"></i>'+
                        '</a>';
                $(this).after(html);
                $(this).remove();
            });

            $('#loadContent img.InputQuestion').each(function () {
                var kq = $(this).attr('alt');
                $(this).after('<span><input style="text-align: left" class="input_2 w150" data-aw="' + kq + '" data-full="' + kq + '" type="text"><i></i></span>');
                $(this).hide();
            });

            $('#loadContent img.CheckBox').each(function () {
                var kq = $(this).attr('alt');
                html = '<label><input type="checkbox" value="'+kq+'" class="">' +
                        '<span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>'+
                        '</label>';
                $(this).after(html);
                $(this).hide();
            });
        }

        function complete(message) {
            $('#completeModal h4').html(message);

            $('#completeModal').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }

        function resultTracnghiem() {
            $('#loadContent .tracnghiem').each(function(){
                rs = true;
                $(this).find('input[type=checkbox]').each(function(){
                    if((!$(this).is(':checked') && $(this).val()==1) || ($(this).is(':checked') && $(this).val()!=1)){
                        rs = false;
                    }
                });
                if(rs){
                    currentPoint++;
                    increaseLevel();
                }
                else decreaseLevel();
                numQuestion++;
            });
        }

        function resultDientu() {
            $('#loadContent input[type=text]').each(function(){
                ans = $(this).val().toLowerCase();
                trueans = $(this).attr('data-aw');
                trueansArr = trueans.split('|');
                rs = false;
                for(i=0;i<trueansArr.length;i++){
                    if(checkPhrase(ans,trueansArr[i])){
                        rs = true;
                    }
                }
                if(rs){
                    currentPoint++;
                    increaseLevel();
                }
                else decreaseLevel();
                numQuestion++;
            })
        }

        function checkPhrase(ph1,ph2){
            return ph1.toLowerCase().replace(/[^a-zA-Z]/g, "") == ph2.toLowerCase().replace(/[^a-zA-Z]/g, "");
        }

        function increaseLevel() {
//           if(currentLvl < 6)
               currentLvl++;
        }

        function decreaseLevel() {
//            if(currentLvl > 1)
                currentLvl--;
        }

        function toNext() {
            resultTracnghiem();
            resultDientu();
            currentNumberQuestion++;

            if(currentLvl < 1) currentLvl = 1;
            else if(currentLvl > 6) currentLvl = 6;

            $.post('/test/question', {
                number:currentNumberQuestion, level:currentLvl, id: currentQuestionId
            }, function (re) {
                if(re.success){
                    $('#loadContent').html(re.content);
                    $('#loadTitle').html(re.title);
                    currentQuestionId = re.id
                    replaceResource();
//                    if(currentNumberQuestion==9){
//                    }
                }else{
                    complete(re.message);
//                    $('#nextBtn').attr('onclick','complete()').html('Hoàn thành');
//                    alert(re.message);
                }
            });
            console.log('point:'+currentPoint+'- level:'+currentLvl)
        }

    </script>
@endsection