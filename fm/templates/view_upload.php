<?php 
session_start();
?>
<link rel="stylesheet" href="plugin/uploadify/uploadify.css" />
<script src="plugin/uploadify/jquery.uploadify.min.js"></script>
<div class="jumbotron">
    <form>
        <div id="queue"></div>
        <input id="file_upload" name="file_upload" type="file" multiple="true">
    </form>

    <script type="text/javascript">
	    <?php 
        $timestamp = time();?>
        $(function () {
            $('#file_upload').uploadify({
                'formData': {
                    'timestamp': '<?php echo $timestamp;?>',
                    'token': '<?php echo md5('unique_salt' . $timestamp);?>',
                    '<?php echo session_name();?>' : '<?php echo session_id();?>'
                },
                'sizeLimit': 1000000,
                'width': 120,
                'height': 30,
                'swf': 'plugin/uploadify/uploadify.swf',
                'uploader': 'plugin/uploadify/uploadify.php',
                'onUploadError' : function(file, errorCode, errorMsg, errorString) {
                    alert('The file ' + file.name + ' could not be uploaded: ' + errorString);
                    console.log(errorMsg);
                }
		    });
		});
	</script>
</div>
