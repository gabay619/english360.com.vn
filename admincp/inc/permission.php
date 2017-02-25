<?php
$module[] = array("name"=>"Home","key"=>"home","controller"=>"controller/home/index.php","permission"=>
    array(
        array("name"=>"Đăng nhập hệ thống","key"=>"loginsystem")
    )
);
$module[] = array("name"=>"Category","key"=>"category","controller"=>"controller/category/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách chuyên mục","key"=>"category_view"),
        array("name"=>"Sửa chuyên mục","key"=>"category_update"),
        array("name"=>"Xóa chuyên mục","key"=>"category_delete"),
        array("name"=>"Thêm mới chuyên mục","key"=>"category_insert")
    )
);

$module[] = array("name"=>"Import","key"=>"import","controller"=>"controller/import/index.php","permission"=>
    array(
        array("name"=>"Import account event HSSV","key"=>"import_hssv"),
        array("name"=>"Xem account event HSSV","key"=>"import_hssv_view"),
        array("name"=>"Thêm account event HSSV","key"=>"import_hssv_insert"),
        array("name"=>"Gửi MT event HSSV","key"=>"import_hssv_mt"),
    )
);


$module[] = array("name"=>"Email","key"=>"email","controller"=>"controller/email/index.php","permission"=>
    array(
        array("name"=>"Xem lịch sử email","key"=>"email_view"),
        array("name"=>"Gửi email cho user","key"=>"email_new"),
    )
);


$module[] = array("name"=>"SMS","key"=>"sms","controller"=>"controller/sms/index.php","permission"=>
    array(
        array("name"=>"Gửi sms cho user","key"=>"sms_new"),
    )
);
$module[] = array("name"=>"Thanh toán","key"=>"txn","controller"=>"controller/txn/index.php","permission"=>
    array(
        array("name"=>"Quản lý thẻ cào","key"=>"txn_card"),
        array("name"=>"Quản lý giao dịch bank","key"=>"txn_bank"),
    )
);

$module[] = array("name"=>"Gói cước","key"=>"package","controller"=>"controller/package/index.php","permission"=>
    array(
        array("name"=>"Xem thông tin gói cước","key"=>"package_view"),
        array("name"=>"Thêm gói cước","key"=>"package_insert"),
        array("name"=>"Sửa gói cước","key"=>"package_update"),
        array("name"=>"Xóa gói cước","key"=>"package_delete"),
    )
);

$module[] = array("name"=>"Giao tiếp cơ bản","key"=>"gtcb","controller"=>"controller/gtcb/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài giảng","key"=>"gtcb_view"),
        array("name"=>"Sửa bài giảng","key"=>"gtcb_update"),
        array("name"=>"Xóa bài giảng","key"=>"gtcb_delete"),
        array("name"=>"Thêm bài giảng","key"=>"gtcb_insert"),
        array("name"=>"Cập nhật trạng thái bài giảng","key"=>"gtcb_status"),
        array("name"=>"Thêm bài tập","key"=>"gtcb_test_insert"),
        array("name"=>"Thêm bài tập sắp xếp","key"=>"gtcb_sx_insert"),
        array("name"=>"Thêm bài tập điền từ","key"=>"gtcb_dt_insert"),
        array("name"=>"Thêm bài tập ghép câu","key"=>"gtcb_gc_insert"),
        array("name"=>"Sửa bài tập","key"=>"gtcb_test_update"),
        array("name"=>"Xóa bài tập","key"=>"gtcb_test_del"),
        array("name"=>"Xem bài tập trắc nghiệm","key"=>"gtcb_test_view"),
        array("name"=>"Xem bài tập điền từ","key"=>"gtcb_điền từ_view"),
        array("name"=>"Xem bài tập sắp xếp câu","key"=>"gtcb_sx_view"),
        array("name"=>"Xem bài tập ghép câu","key"=>"gtcb_gc_view"),
        array("name"=>"Xem bài luyện nghe","key"=>"gtcb_listen_view"),
        array("name"=>"Thêm bài luyện nghe","key"=>"gtcb_listen_insert"),
        array("name"=>"Sửa bài luyện nghe","key"=>"gtcb_listen_update"),
        array("name"=>"Sửa bài ghép câu","key"=>"gtcb_gc_update"),
        array("name"=>"Xóa bài luyện nghe","key"=>"gtcb_listen_del")
    )
);
$module[] = array("name"=>"Thư viện","key"=>"thuvien","controller"=>"controller/thuvien/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"thuvien_view"),
        array("name"=>"Sửa bài viết","key"=>"thuvien_update"),
        array("name"=>"Xóa bài viết","key"=>"thuvien_delete"),
        array("name"=>"Thêm bài viết","key"=>"thuvien_insert"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"thuvien_status")
    )
);
$module[] = array("name"=>"Luyện ngữ âm","key"=>"luyennguam","controller"=>"controller/luyennguam/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"luyennguam_view"),
        array("name"=>"Sửa bài viết","key"=>"luyennguam_update"),
        array("name"=>"Xóa bài viết","key"=>"luyennguam_delete"),
        array("name"=>"Thêm bài viết","key"=>"luyennguam_insert"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"luyennguam_status"),
        array("name"=>"Xem bài tập","key"=>"luyennguam_test_view"),
        array("name"=>"Thêm bài tập","key"=>"luyennguam_test_insert"),
        array("name"=>"Sửa bài tập","key"=>"luyennguam_test_update"),
        array("name"=>"Xóa bài tập","key"=>"luyennguam_test_del")
    )
);
$module[] = array("name"=>"Ngữ pháp","key"=>"nguphap","controller"=>"controller/nguphap/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"nguphap_view"),
        array("name"=>"Sửa bài viết","key"=>"nguphap_update"),
        array("name"=>"Xóa bài viết","key"=>"nguphap_delete"),
        array("name"=>"Thêm bài viết","key"=>"nguphap_insert"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"nguphap_status"),
        array("name"=>"Xem bài tập","key"=>"nguphap_test_view"),
        array("name"=>"Thêm bài tập","key"=>"nguphap_test_insert"),
        array("name"=>"Sửa bài tập","key"=>"nguphap_test_update"),
        array("name"=>"Xóa bài tập","key"=>"nguphap_test_del")
    )
);
$module[] = array("name"=>"Từ điển","key"=>"tudien","controller"=>"controller/tudien/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"tudien_view"),
        array("name"=>"Sửa bài viết","key"=>"tudien_update"),
        array("name"=>"Xóa bài viết","key"=>"tudien_delete"),
        array("name"=>"Thêm bài viết","key"=>"tudien_insert"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"tudien_status")
    )
);
$module[] = array("name"=>"Bài hát tiếng anh","key"=>"hmcaudio","controller"=>"controller/hmc/hmcaudio/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"hmcaudio_view"),
        array("name"=>"Sửa bài viết","key"=>"hmcaudio_update"),
        array("name"=>"Xóa bài viết","key"=>"hmcaudio_delete"),
        array("name"=>"Thêm bài viết","key"=>"hmcaudio_insert"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"hmcaudio_status")
    )
);
$module[] = array("name"=>"Học mà chơi - Video","key"=>"hmcvideo","controller"=>"controller/hmc/hmcvideo/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"hmcvideo_view"),
        array("name"=>"Sửa bài viết","key"=>"hmcvideo_update"),
        array("name"=>"Xóa bài viết","key"=>"hmcvideo_delete"),
        array("name"=>"Thêm bài viết","key"=>"hmcvideo_insert"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"hmcvideo_status")
    )
);
$module[] = array("name"=>"Học mà chơi - Game","key"=>"hmcgame","controller"=>"controller/hmc/hmcgame/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"hmcgame_view"),
        array("name"=>"Sửa bài viết","key"=>"hmcgame_update"),
        array("name"=>"Xóa bài viết","key"=>"hmcgame_delete"),
        array("name"=>"Thêm bài viết","key"=>"hmcgame_insert"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"hmcgame_status")
    )
);

$module[] = array("name"=>"Hỏi đáp","key"=>"hoidap","controller"=>"controller/hoidap/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách bài viết","key"=>"hoidap_view"),
        array("name"=>"Sửa bài viết","key"=>"hoidap_update"),
        array("name"=>"Xóa bài viết","key"=>"hoidap_delete"),
        array("name"=>"Thêm bài viết","key"=>"hoidap_insert"),
        array("name"=>"Trả lời bài viết","key"=>"hoidap_reply"),
        array("name"=>"Xem Trả lời bài viết","key"=>"hoidap_reply_view"),
        array("name"=>"Cập nhật trạng thái bài viết","key"=>"hoidap_status")
    )
);
$module[] = array("name"=>"Tin tức","key"=>"news","controller"=>"controller/news/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách tin","key"=>"news_view"),
        array("name"=>"Sửa tin","key"=>"news_update"),
        array("name"=>"Xóa tin","key"=>"news_delete"),
        array("name"=>"Thêm mới tin","key"=>"news_insert"),
        array("name"=>"Cập nhật trạng thái tin","key"=>"news_status")
    )
);
$module[] = array("name"=>"Event","key"=>"event","controller"=>"controller/event/index.php","permission"=>
        array(
            array("name"=>"Xem danh sách event","key"=>"event_view"),
            array("name"=>"Xóa event","key"=>"event_delete"),
            array("name"=>"Thêm mới event","key"=>"event_insert"),
            array("name"=>"Xem user event","key"=>"event_user"),
        )
);

$module[] = array("name"=>"Log","key"=>"log","controller"=>"controller/log/index.php","permission"=>
        array(
                array("name"=>"Xem lịch sử sử dụng","key"=>"log_history"),
        )
);


$module[] = array("name"=>"Người dùng","key"=>"user_manage","controller"=>"controller/user/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách người dùng","key"=>"user_view"),
        array("name"=>"Sửa người dùng","key"=>"user_update"),
        array("name"=>"Xóa người dùng","key"=>"user_delete"),
        array("name"=>"Thêm người dùng","key"=>"user_insert"),
        array("name"=>"Lựa chọn nhóm quyền","key"=>"user_rolegroup_insert"),
        array("name"=>"Cài đặt quyền riêng","key"=>"user_rolegroup_permission"),
        array("name"=>"Gửi thông báo","key"=>"user_sendnotify"),
        array("name"=>"Gửi thư","key"=>"user_sendmail"),
    )
);

$module[] = array("name"=>"Comment","key"=>"comment","controller"=>"controller/comment/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách comment","key"=>"comment_view"),
        array("name"=>"Sửa commment","key"=>"comment_update"),
        array("name"=>"Xóa commment","key"=>"comment_delete"),
        array("name"=>"Thêm comment","key"=>"comment_insert"),
        array("name"=>"Cập nhật trạng thái comment","key"=>"comment_status")
    )
);

$module[] = array("name"=>"Upload Audio","key"=>"upload_audio","controller"=>"controller/hmc/hmcaudio/index.php","permission"=>
        array(
                array("name"=>"Xem danh sách audio upload","key"=>"audio_upload_view"),
                array("name"=>"Xóa audio upload","key"=>"audio_upload_delete"),
        )
);

$module[] = array("name"=>"Chat","key"=>"chat","controller"=>"controller/chat/index.php","permission"=>
        array(
                array("name"=>"Xem danh sách chat","key"=>"chat_view"),
                array("name"=>"Trả lời chat","key"=>"chat_update"),
                array("name"=>"Xóa chat","key"=>"chat_delete"),
        )
);

$module[] = array("name"=>"Trang","key"=>"page","controller"=>"controller/page/index.php","permission"=>
        array(
                array("name"=>"Xem danh sách trang","key"=>"page_view"),
                array("name"=>"Sửa trang","key"=>"page_update"),
                array("name"=>"Xóa trang","key"=>"page_delete"),
                array("name"=>"Thêm trang","key"=>"page_insert")
        )
);

$module[] = array("name"=>"Báo cáo","key"=>"report","controller"=>"controller/report/index.php","permission"=>
        array(
                array("name"=>"Xem danh sách báo cáo","key"=>"report_view"),
                array("name"=>"Xóa báo cáo","key"=>"report_delete"),
                array("name"=>"Bỏ qua báo cáo","key"=>"report_dismiss"),
        )
);


$module[] = array("name"=>"Cấu hình","key"=>"config","controller"=>"controller/config/index.php","permission"=>
        array(
            array("name"=>"Cấu hình blacklist","key"=>"config_bl"),
            array("name"=>"Cấu hình 1 chạm","key"=>"config_1t"),
            array("name"=>"Cấu hình 1.5 chạm","key"=>"config_1t5"),
            array("name"=>"Xem log 3G","key"=>"config_3g"),
            array("name"=>"Xem log quảng cáo","key"=>"config_ads"),
            array("name"=>"Xem danh sách cấu hình","key"=>"config_view"),
        )
);

$module[] = array("name"=>"Pop up","key"=>"popup","controller"=>"controller/popup/index.php","permission"=>
        array(
                array("name"=>"Xem danh sách popup","key"=>"popup_view"),
                array("name"=>"Thêm popup","key"=>"popup_insert"),
                array("name"=>"Sửa popup","key"=>"popup_update"),
                array("name"=>"Xóa popup","key"=>"popup_delete"),
                array("name"=>"Cấu hình popup đăng ký","key"=>"popup_reg"),
        )
);

$module[] = array("name"=>"Banner","key"=>"banner","controller"=>"controller/banner/index.php","permission"=>
    array(
        array("name"=>"Xem danh sách banner","key"=>"banner_view"),
        array("name"=>"Thêm banner","key"=>"banner_insert"),
        array("name"=>"Sửa banner","key"=>"banner_update"),
        array("name"=>"Xóa banner","key"=>"banner_delete"),
    )
);

$module[] = array("name"=>"Phân quyền","key"=>"role_manage","controller"=>"controller/role/index.php","permission"=>
    array(
        array("name"=>"Xem nhóm quyền","key"=>"rolegroup_view"),
        array("name"=>"Sửa nhóm quyền","key"=>"rolegroup_update"),
        array("name"=>"Xóa nhóm quyền","key"=>"rolegroup_delete"),
        array("name"=>"Thêm nhóm quyền","key"=>"rolegroup_insert"),
        array("name"=>"Chỉnh sửa permission","key"=>"rolegroup_permission"),
    )
);
$module[] = array("name"=>"Hiển thị bài viết nổi bật trên slideshow","key"=>"show_slideshow","controller"=>"controller/show/slideshow.php");
$module[] = array("name"=>"Hiển thị chuyên mục trên trang chủ","key"=>"show_homecat","controller"=>"controller/show/homecat.php");
$module[] = array("name"=>"Quản lý file","key"=>"filemanager","controller"=>"");
$module[] = array("name" => "Bài học nổi bật", "key"=>"hot_lession", "controller"=>"controller/show/hot_lession.php");
$module[] = array("name" => "Bài học miễn phí", "key"=>"free_lession", "controller"=>"controller/show/free_lession.php");
function getpermissionbykey($key,$val){
    global $module;
    foreach($module as $k=>$v) if($v[$key]==$val) return $v;
    return $module[0];
}
function acceptpermiss($key){
    $permiss = $_SESSION['permission'];
    if(!isset($permiss)) return false;
    if(in_array($key,$permiss)) return true;
    else return false;
}
?>