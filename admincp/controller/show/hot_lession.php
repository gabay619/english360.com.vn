<?php
$location_page = array('name' => 'Bài học nổi bật', 'type' => 'hot_lession');
/*$location_page[] = array('name' => 'Trang Music', 'type' => 'music');
$location_page[] = array('name' => 'Trang Movie', 'type' => 'movie');
$location_page[] = array('name' => 'Trang Sport', 'type' => 'sport_news');
$location_page[] = array('name' => 'Trang Game', 'type' => 'game_list');
$title = "Danh sách slideshow hiển thị trên trang chủ (Client)";*/

$showCl = $dbmg->showcl;
$categorycl = $dbmg->category;
$current_url = cpagerparm("status");
?>
<title><?php echo $title ?></title>
<h5 class="text-center"><?php echo $title ?></h5>
<link rel="stylesheet" href="asset/css/jquery-ui.css">
<script src="asset/js/jquery-ui.js"></script>
<?php include("component/message.php"); ?>
<ul class="nav nav-tabs" role="tablist" id="myTab">
        <li class="active">
            <a href="#<?php echo $location_page['type']; ?>" role="tab" data-toggle="tab"><?php echo $location_page['name']; ?></a>
        </li>
</ul>

<input type="hidden" id="currentUrl" value="<?php echo $current_url;?>">
<div class="tab-content">
    <?php
        /* $cursor = (array)$showcl->findOne(array("type" => strval($lpage['type'])));
         $_POST = $cursor;*/
        ?>

        <div class="tab-pane active" id="<?php echo $location_page['type']; ?>">
            <p>&nbsp;</p>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-search"></span>
                    </div>
                    <input class="form-control input-to-suggest" type="text" value="" onkeyup="getMediaSuggest(this);" data-pagetype="<?php echo $location_page['type']; ?>" placeholder="Tiêu đề hoặc mã bài học">

                </div>
                <div class="suggestion" id="sgcategory_<?php echo $location_page['type']; ?>">
                    <div class="closebtn" onclick="$(this).parent().hide()"><i class="fa fa-times"></i></div>
                    <ul id="sugges_data_<?php echo $location_page['type']; ?>">
                    </ul>
                </div>
            </div>
            <div class="row">

                <ul class="listcat" id="list_lession">
                    <?php
                    //$listid = !empty($_POST['category']) ? $_POST['category'] : array();
                    $hot_lessions = $showCl->findOne(array('type' => $location_page['type']));
                    $list = $hot_lessions['lession'];
//                    print_r($list);die;
//                    $slideshowCr = $hotLessionshowCl->findOne(array('pagetype'=>$lpage['type']));
                    //foreach($slideshowCr as $elem) $listMediaId[] = $elem['media'];
//                    $listMediaId = $slideshowCr['media'];
                    if (!isset($list)) $list = array();
//                    $listMediaCr = $mediaCollection->find(array("_id" => array('$in' => $listMediaId)));
//                    $listMediaCr = resortarray($listMediaCr, $listMediaId, "_id");

                    foreach ($list as $item) {
                        $cate = Common::getcategorytype($item['type']);
                        $itemCl = Common::getClFromType($item['type']);
                        $itemCl = $dbmg->$itemCl;
                        $name = $itemCl->findOne(array('_id'=>$item['id']))['name'];
//                        print_r($name);die;
                        ?>
                        <li>
                            <label><input type="checkbox" checked value="<?php echo $item['id']; ?>" data-type="<?php echo $item['type']?>"/>[<?php echo $cate['name'] ?>] <?php echo $name; ?>
                            </label></li>
                    <?php } ?>
                </ul>

            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" onclick="saveData();" class="btn btn-default">
                        Lưu
                    </button>
                </div>
            </div>
        </div>


</div>
<style>
    .autocomplete{
        cursor: pointer;
    }
    .autocomplete:hover{
        background: blue;
        color: #fff;
    }
</style>
<script>
    $(function () {
        $(".listcat").sortable();
        $(".listcat").disableSelection();
    });

    var t = 400;
    var thread;
    function getMediaSuggest(obj) {
        clearTimeout(thread);
        thread = setTimeout(function () {
            var q = $(obj).val();
            var type = $(obj).attr('data-pagetype');
            $('#sugges_data_' + type).html('');

            $.get("incoming.php", { act: 'getlession', keyword: q, pageType: type }, function (re) {
                var data = re.data;
                if (data.length > 0) {
                    data.forEach(function (entry) {
                        var htmlx = '<li class="autocomplete" onclick="returnlession(this)" data-id="' + entry._id + '" data-type="' + entry.type + '" data-name="' + entry.name + '" data-cate="'+entry.catename+'"><span class="muted">[' + entry.catename + ']</span> ' + entry.name + '</li>';
                        $('#sugges_data_' + type).append(htmlx);
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
        $('#listcat_' + type).append(htmlx);
        $(obj).parent().html('');
        $(".input-to-suggest").val('');
    }

    function returnlession(obj) {
        var lession_id  = $(obj).attr('data-id');
        var lession_name = $(obj).attr('data-name');
        var cate_name = $(obj).attr('data-cate');
        var type = $(obj).attr('data-type');
        var htmlx = '<li><label><input type="checkbox" checked value="' + lession_id + '" data-type="'+type+'"/>['+cate_name+'] ' + lession_name + '</label></li>';
        console.log(htmlx);
        $('#list_lession').prepend(htmlx);
        $(obj).parent().html('');
        $(".input-to-suggest").val('');
    }

    function saveData() {
        var list_lession = '';
        $('#list_lession input').each(function(e){
            if($(this).is(':checked')){
                list_lession += $(this).attr('data-type')+'-'+$(this).val()+',';
            }
        });
        if(list_lession.length > 0){
            $.post("incoming.php", { act: 'savetohotlession', lession:list_lession}, function (re) {
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



