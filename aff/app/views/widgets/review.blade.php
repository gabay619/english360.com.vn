<div id="reviewSide">
    Bài học này có hữu ích với bạn?<br>
    <button class="btn btn-success btnReviewYes" onclick="reviewYes('{{$id}}','{{$type}}')"><i class="glyphicon glyphicon-thumbs-up"></i> Có <span></span></button>
    <button class="btn btn-danger btnReviewNo" onclick="reviewNo('{{$id}}','{{$type}}')"><i class="glyphicon glyphicon-thumbs-down"></i> Không <span></span></button>
</div>
<script>
    loadReview();
    function reviewYes(id,type){
        $.post('/ajax/review', {
            id:id, type:type, ok:1
        }, function(result){
            if(result.success){
                loadReview();
            }else{
                alert(result.message)
            }
//            $('#reviewSide').hide();
//            openReviewPopup();
        })
    }
    
    function loadReview() {
        id= '{{$id}}';
        type = '{{$type}}';
        $.post('/ajax/load-review', {
            id:id, type:type
        }, function(result){
            $('.btnReviewYes span').html('('+result.yes+')');
            $('.btnReviewNo span').html('('+result.no+')');
//            openReviewPopup();
        })
    }

    function reviewNo(id, type){
        $.post('/ajax/review', {
            id:id, type:type, ok:0
        }, function(result){
            if(result.success){
                loadReview();
            }else{
                alert(result.message)
            }
        })
    }
</script>