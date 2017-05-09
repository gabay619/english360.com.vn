<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 09/05/2017
 * Time: 8:06 AM
 */
$title = "Import bài học";
?>
<script src="/assets/lib/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.iframe-transport.js"></script>
<script src="/assets/lib/jquery-upload/js/jquery.fileupload.js"></script>
<link rel="stylesheet" href="/assets/lib/jquery-upload/css/jquery.fileupload.css">
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<?php include("component/message.php"); ?>
<div class="row">
    <div class="col-lg-12">
        <input type="hidden" id="linkExcel">
        <div class="form-group">
            <label class="col-sm-2 control-label">Upload Excel</label>
            <div class="col-sm-10">
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Chọn file...</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="Filedata" data-url="incoming.php?act=uploadLession" />
                </span>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#fileupload').fileupload({
            dataType: 'json',
            done: function (e, data) {
//                console.log(data.result);return false;
                obj = data.result;
                if (obj.status == 200) {
                    location.reload();
//                    max = obj.rs.length;
//                    for (i = 0; i <= obj.rs.length; i++) {
//                        stt = parseInt(i) + 1;
//                        htmlx = '<tr>' +
//                            '<td>' + stt + '</td>' +
//                            '<td class="ten-casi">' + obj.rs[i]['ca_si'] + '</td>' +
//                            '</tr>';
//                        $('#tableSong tbody').append(htmlx);
//                    }
                } else {
                    alert(obj.mss);
                }
//                $.each(data.result.files, function (index, file) {
//                    $('<p/>').text(file.name).appendTo(document.body);
//                });
            }
        });
    })
</script>