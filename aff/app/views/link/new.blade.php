@extends('layouts.main')

@section('content')
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
            <form role="form">
                <div class="form-group">
                    <label>Link đích</label>
                    <input class="form-control" id="redirectLink">
                    <p class="help-block">Nhập link đích và click "Lấy link" để tạo link phân phối.</p>
                </div>
                <button type="button" class="btn btn-primary" onclick="generateLink()" id="btnGetLink">Lấy link</button>
                <div class="form-group" style="margin-top: 10px">
                    <label>Link phân phối</label>
                    <input class="form-control" placeholder="Link rút gọn" readonly id="shortUrl">
                    <input class="form-control" placeholder="Link đầy đủ" readonly id="longUrl">
                </div>
            </form>
        </div>
    </div>
    <script>
        function generateLink() {
            $('#btnGetLink').prop('disabled',true);
            link = $('#redirectLink').val();
            $.post('/link/generate-link',{
                link:link,  _token: '{{csrf_token()}}'
            }, function (re) {
                if(re.success){
                    $('#shortUrl').val(re.shortUrl)
                    $('#longUrl').val(re.longUrl)
                }else{
                    alert(re.message)
                }
                $('#btnGetLink').prop('disabled',false);
            })
        }
    </script>
@endsection