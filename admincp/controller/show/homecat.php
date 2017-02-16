<?php
$location_page[] = array('name' => 'Trang chủ', 'type' => 'home', 'categoryType' => "home");
//$location_page[] = array('name' => 'Trang Movie', 'type' => 'movie', 'categoryType' => "movie");
//$location_page[] = array('name' => 'Trang Sport', 'type' => 'sport', 'categoryType' => "sport");
//$location_page[] = array('name' => 'Sidebar Trang chủ', 'type' => 'home-sidebar', 'categoryType' => "home");
//$location_page[] = array('name' => 'Sidebar Movie', 'type' => 'movie-sidebar', 'categoryType' => "movie");
//$location_page[] = array('name' => 'Sidebar Video', 'type' => 'video-sidebar', 'categoryType' => "video");

$title = "Danh sách chuyên mục hiển thị trên trang chủ (Client)";
$showcl = $dbmg->showcl;
$categorycl = $dbmg->category;
$current_url = cpagerparm("status");
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<?php include("component/message.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
    <?php foreach ($location_page as $key => $lpage) { ?>
        <li <?php echo $key == 0 ? 'class="active"' : ''; ?>>
            <a href="#<?php echo $lpage['type']; ?>" role="tab" data-toggle="tab"><?php echo $lpage['name']; ?></a></li>
    <?php } ?>
</ul>
<input type="hidden" id="currentUrl" value="<?php echo $current_url;?>">
<div class="tab-content">
    <?php foreach ($location_page as $key => $lpage) {
        $cursor = (array)$showcl->findOne(array("type" => strval($lpage['type'])));
        $_POST = $cursor;
        ?>

        <div class="tab-pane <?php echo $key == '0' ? 'active' : ''; ?>" id="<?php echo $lpage['type']; ?>">
            <p>&nbsp;</p>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-search"></span>
                    </div>
                    <input class="form-control" type="text" value="" onkeyup="getcategory(this);" data-type="<?php echo $cat['_id']; ?>" data-suggest-id="<?php echo $lpage['type']; ?>" placeholder="Tiêu đề hoặc mã danh mục">

                </div>
                <div class="suggestion" id="sgcategory_<?php echo $lpage['type']; ?>">
                    <div class="closebtn" onclick="$(this).parent().hide()"><i class="fa fa-times"></i></div>
                    <ul id="sugges_data_<?php echo $lpage['type']; ?>">
                    </ul>
                </div>
            </div>
            <div class="row">

                <ul class="listcat" id="listcat_<?php echo $lpage['type']; ?>">
                    <?php
                    $listid = !empty($_POST['category']) ? $_POST['category'] : array();
                    $list_cat = $categorycl->find(array("_id" => array('$in' => $listid)));
                    $listcategory = resortarray($list_cat, $listid, "_id");

                    foreach ($listcategory as $item) {
                        ?>
                        <li>
                            <label><input type="checkbox" checked value="<?php echo $item['_id']; ?>" class="cat_<?php echo $lpage['type']; ?>"/>&nbsp;<?php echo $item['name']; ?>
                            </label></li>
                    <?php } ?>
                </ul>

            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" onclick="saveData('<?php echo $lpage['type']; ?>');" class="btn btn-default">
                        Lưu
                    </button>
                </div>
            </div>
        </div>

    <?php } ?>

</div>
<script>
    $(function () {
        $(".listcat").sortable();
        $(".listcat").disableSelection();
    });

    var t = 400;
    var thread;
    function getcategory(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var q = $(obj).val();
            var type = $(obj).attr('data-type');
            var suggestId = $(obj).attr('data-suggest-id');
            $('#sugges_data_' + suggestId).html('');

            $.get("incoming.php", { act: 'getcategory', q: q, t: type }, function (re) {
                var data = re.data;
                if (data.length > 0) {
                    data.forEach(function (entry) {
                        var htmlx = '<li onclick="returncategory(this)" data-id="' + entry._id + '" data-type="' + suggestId + '" data-name="' + entry.name + '"><span class="muted">[' + entry.suffix + ']</span>'+ entry._id + ' - ' + entry.name + '</li>';
                        $('#sugges_data_' + suggestId).append(htmlx);
                    });
                    $('#sgcategory_' + type).show();
                } else $('#sgcategory_' + type).hide();
            });
        }, t);
    }
    function returncategory(obj) {
        var cat_id = $(obj).attr('data-id');
        var cat_name = $(obj).attr('data-name');
        var type = $(obj).attr('data-type');
        var htmlx = '<li><label><input type="checkbox" checked value="' + cat_id + '" class="cat_' + type + '" />&nbsp;' + cat_name + '</label></li>';
        console.log('#listcat_' + type);
        $('#listcat_' + type).append(htmlx);
        $(obj).parent().html('');
    }

    function saveData(type) {
        var list_cat = '';
        $('.cat_'+type).each(function(e){
            if($(this).is(':checked')){
                list_cat += $(this).val()+',';
            }
        });
        if(list_cat.length > 0){
            $.post("incoming.php", { act: 'saveCatShow', type: type, category:list_cat}, function (re) {
                if(re.status == 200){
                    window.location = $('#currentUrl').val() + 'status=success';
                }else{
                    alert(re.mss);
                }
            });
        }else{
            alert('Bạn chưa chọn danh mục nào.');
        }
    }
</script>



