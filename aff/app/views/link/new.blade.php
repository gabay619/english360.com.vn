@extends('layouts.main')

@section('content')
    <script src="/js/clipboard.min.js?v=22"></script>
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Tạo link phân phối
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <form role="form" class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="redirectLink">Link đích:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="redirectLink" placeholder="VD: http://english360.com.vn/giao-tiep-co-ban.html">
                            <p class="help-block"><i>Người dùng sẽ được chuyển đến đây sau khi lưu cookie</i></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="subId">Nguồn:</label>
                        <div class="col-sm-9">
                            <input class="form-control" id="subId" placeholder="VD: facebook, google,...">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button type="button" class="btn btn-primary" onclick="generateLink()" id="btnGetLink">Lấy link</button>
                        </div>
                    </div>
                    <div id="linkArea" style="display: none">
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="shortUrl">Link rút gọn:</label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="Link rút gọn" readonly id="shortUrl">
                            </div>
                            <button class="col-sm-1 btn btn-success clb-btn" type="button" data-clipboard-target="#shortUrl"><i class="fa fa-files-o"></i></button>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="longUrl">Link đẩy đủ:</label>
                            <div class="col-sm-8">
                                <input class="form-control" placeholder="Link đầy đủ" readonly id="longUrl">
                            </div>
                            <button class="col-sm-1 btn btn-success clb-btn" type="button" data-clipboard-target="#longUrl"><i class="fa fa-files-o"></i></button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        function generateLink() {
            $('#btnGetLink').prop('disabled',true);
            link = $('#redirectLink').val();
            sub_id = $('#subId').val();
            $.post('/link/generate-link',{
                link:link, sub_id:sub_id, _token: '{{csrf_token()}}'
            }, function (re) {
                if(re.success){
                    $('#shortUrl').val(re.shortUrl)
                    $('#longUrl').val(re.longUrl)
                    $('#linkArea').show()
                }else{
                    alert(re.message)
                }
                $('#btnGetLink').prop('disabled',false);
            })
        }

        new Clipboard('.clb-btn');
    </script>
@endsection