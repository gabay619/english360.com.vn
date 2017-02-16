<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>UploadiFive Test</title>
    <script src="/template/wap/asset/js/jquery-1.10.1.min.js"></script>


    <script type="text/javascript" src="/plugin/uploadify/jquery.uploadify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/plugin/uploadify/uploadify.css" />
        <style type="text/css">
        body {
            font: 13px Arial, Helvetica, Sans-serif;
        }
    </style>
</head>

<body>
<h1>Công cụ hỗ trợ Upload - </h1>
<form>
    <div id="queue"></div>
    <input id="file_upload" name="file_upload" type="file" multiple="true"/>
</form>

<script type="text/javascript">
    <?php $timestamp = time();?>
    $(function() {
        $('#file_upload').uploadify({
            'formData'     : {
                'timestamp' : '<?php echo $timestamp;?>',
                'ssid': '<?php echo session_id() ?>',
                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
            },
            'swf'      : '/plugin/uploadify/uploadify.swf',
            'uploader' : '/plugin/uploadify/uploadify.php',
            'multi'          : true,
            'auto'           : true,
            'removeCompleted': false,
            'fileExt'        : '*.jpg; *.jpeg; *.png; *.gif; *.avi; *.mp4; *.flv; *.mov; *.3gp; *.txt; *.zip; *.rar;*.mp3;*.wav;',
            'fileDesc'       : 'JPG Image Files (*.jpg); JPEG Image Files (*.jpeg); PNG Image Files (*.png), GIF (*.gif)',
            'onUploadError'  : function(file, errorCode, errorMsg, errorString) {
                //alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
            },
            'onUploadSuccess': function(file, data, response) {
                //alert('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
            }
        });
    });
</script>
</body>
</html>