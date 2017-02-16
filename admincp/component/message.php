<?php
if (!isset($status))
 $status = $_GET['status'];
if ($status == "success") {
    ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Success!</strong> Xử lý thành công
    </div>
<?php }
else if ($status == "error") { ?>
    <?php if (!isset($errorMessage)) $errorMesssage = "Không thể xử lý được. Vui lòng thử lại sau!";?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> <?php echo $errorMesssage; ?>
    </div>
<?php } ?>

