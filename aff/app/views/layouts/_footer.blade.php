</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

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
        $("#start_time" ).datepicker({ dateFormat: 'yy-mm-dd' }).val();
        $("#end_time").datepicker({ dateFormat: 'yy-mm-dd' }).val();
        $('.selectpicker').selectpicker();
    });
</script>

<!-- Morris Charts JavaScript -->
<script src="/media/admin-theme/js/plugins/morris/raphael.min.js"></script>
<script src="/media/admin-theme/js/plugins/morris/morris.min.js"></script>
<script src="/media/admin-theme/js/plugins/morris/morris-data.js"></script>
</body>

</html>