</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
<div class="footer" style="text-align: center; padding: 20px; color: #fff">
    <p>Cơ quan chủ quản: Công ty TNHH Truyền thông IQ Việt Nam</p>
    <p>Địa chỉ: Tầng 2 tòa nhà Dinhle, 123B Trần Đăng Ninh, Dịch Vọng, Cầu Giấy, Hà Nội</p>
    <p>Email: <a href="mailto:cskh@english360.com.vn">cskh@english360.com.vn</a> - CSKH: (024) 32474175</p>
</div>

</div>
<!-- /#wrapper -->
@chatbox()

<script src="{{ asset('lib/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('js/redactor.min.js') }}"></script>
<script src="{{ asset('js/bootbox.js') }}"></script>
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/blockUI.js') }}"></script>
<script src="{{ asset('lib/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('lib/ckfinder/ckfinder.js') }}"></script>

<script>
    $(function() {
//        $("#start_time" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
//        $("#end_time").datepicker({ dateFormat: 'yy-mm-dd' }).val();
        $('.selectpicker').selectpicker();
        $('.datepicker').datepicker({ dateFormat: 'dd/mm/yy' });
    });
</script>

<!-- Morris Charts JavaScript -->
{{--<script src="/media/admin-theme/js/plugins/morris/raphael.min.js"></script>--}}
{{--<script src="/media/admin-theme/js/plugins/morris/morris.min.js"></script>--}}
{{--<script src="/media/admin-theme/js/plugins/morris/morris-data.js"></script>--}}

<!-- Flot Charts JavaScript -->
<!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
<script src="/media/admin-theme/js/plugins/flot/jquery.flot.js"></script>
<script src="/media/admin-theme/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/media/admin-theme/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/media/admin-theme/js/plugins/flot/jquery.flot.pie.js"></script>
{{--<script src="/media/admin-theme/js/plugins/flot/flot-data.js"></script>--}}
</body>

</html>