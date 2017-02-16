<?php if(!class_exists('raintpl')){exit;}?><div class="m_tsl_box" style="display:none;">
    <div class="m_tsl_content">
        <div class="m_tsl_top">
            <div class="content_tratu">
                <input type="text" class="tratu" placeholder="Tra từ nhanh" id="txtTratu">
                <button onclick="tratu('')">OK</button>
            </div>
            <div id="goiy_tratu" style="display: none">
                <ul>

                </ul>
            </div>
            <div class="show_tratu" style="display: none">
                abc
            </div>
        </div>
        <div id="m_tsl_info"></div>
    </div>
</div>
<script>
    function tratu(id){
        $('#goiy_tratu').hide();
        var searchword = $('#txtTratu').val();
        $.post('/incoming.php?act=tratu', {
            word: searchword, dict: 'av', id:id
        }, function (result){
            if(result.status == 200){
                showTratu(result.content);
            }else{
                showTratu('<h3>Không tìm thấy từ cần tra.</h3>')
            }
        });
    }

    function showTratu(content){
        $('.show_tratu').html(content).show();
    }

    function loadWord(word){
        $.post('/incoming.php?act=loadTratu', {
            word: word, dict: 'av'
        }, function(result){
            var data = result.data;
            for(i=0; i< data.length; i++){
                $('#goiy_tratu ul').append('<li><a href="javascript:void(0)" data-id="'+data[i].id+'">'+data[i].word+'</a></li>');
            }
        }, 'json');
        $('#goiy_tratu').show();
    }

    $(function(){
        $('#txtTratu').keyup(function(){
            $('.show_tratu').hide();
            word = $(this).val();
            if(word.length > 1){
                setTimeout(function(){
                    $('#goiy_tratu ul').html('');
                    loadWord(word);
                }, 200);
            }

        });

        $('#goiy_tratu').on('click', 'a', function(){
            word = $(this).html();
            id = $(this).attr('data-id');
            $('#txtTratu').val(word);
            console.log(word);
            tratu(id);
        });
    })
</script>
<style>
    #goiy_tratu li{
        height: 26px;
    }
    #goiy_tratu a{
        color: #fff;
        display: block;
        height: 100%;
    }
    .show_tratu{
        border-bottom: 1px solid #ccc;
    }
    .show_tratu span.type{
        font-weight: bold;
    }
</style>