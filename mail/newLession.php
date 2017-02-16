<?php
$dstin = '<div class="danhsachtin" style="float:left; width:100%; margin:50px 0;">';
if(isset($related[0]))
    $dstin .= '<div class="tin_list" style="float:left; width:20%; padding:20px 10px; border-top:4px double #ccc; border-bottom:4px double #ccc;">
            <a href="'.$related[0]['url'].'" style="float:left; width:100%;">
                	<span style="width:100%; margin-right:10px; float:left;">
                        <img style="width:100%;" src="'.$related[0]['avatar'].'"/>
                    </span>
            </a>
            <span style="float:left; width:100%; margin-top:10px; font-size:12px; cursor:pointer;">'.$related[0]['name'].'</span>
        </div>';

if(isset($related[1]))
    $dstin .= '<div class="tin_list" style="float:left; width:20%; padding:20px 10px; border-top:4px double #ccc; border-bottom:4px double #ccc;">
            <a href="'.$related[1]['url'].'" style="float:left; width:100%;">
                	<span style="width:100%; margin-right:10px; float:left;">
                        <img style="width:100%;" src="'.$related[1]['avatar'].'"/>
                    </span>
            </a>
            <span style="float:left; width:100%; margin-top:10px; font-size:12px; cursor:pointer;">'.$related[1]['name'].'</span>
        </div>';

if(isset($related[2]))
    $dstin .= '<div class="tin_list" style="float:left; width:20%; padding:20px 10px; border-top:4px double #ccc; border-bottom:4px double #ccc;">
            <a href="'.$related[2]['url'].'" style="float:left; width:100%;">
                	<span style="width:100%; margin-right:10px; float:left;">
                        <img style="width:100%;" src="'.$related[2]['avatar'].'"/>
                    </span>
            </a>
            <span style="float:left; width:100%; margin-top:10px; font-size:12px; cursor:pointer;">'.$related[2]['name'].'</span>
        </div>';
if(isset($related[3]))
    $dstin .= '<div class="tin_list" style="float:left; width:20%; padding:20px 10px; border-top:4px double #ccc; border-bottom:4px double #ccc;">
            <a href="'.$related[3]['url'].'" style="float:left; width:100%;">
                	<span style="width:100%; margin-right:10px; float:left;">
                        <img style="width:100%;" src="'.$related[3]['avatar'].'"/>
                    </span>
            </a>
            <span style="float:left; width:100%; margin-top:10px; font-size:12px; cursor:pointer;">'.$related[3]['name'].'</span>
        </div>';
$dstin .= '</div>';
$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Email Format</title>
    <style>
        html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
            border: 0;
            font-family:Arial, Helvetica, sans-serif;
            vertical-align: top;
            margin: 0;
            padding: 0;
        }
        a {
            color:#DB2727;
            text-decoration:none;
            transition:all ease-in-out 0.25s;
        }
        a:hover {
            text-decoration:underline;
            cursor:pointer;
        }
    </style>
</head>
<body>
<div class="email" style="float:left; max-width:100%; box-sizing:border-box;">
    <h2><a href="">'.$title.'</a></h2>
    <br></br>
    <p>Xin chào,</p>
    <p>Chuyên mục <b>'.$cate_name.'</b> vừa được cập nhật bài học mới</p>
    <div class="tin" style="float:left; width:100%; margin:20px 0;">
        <a href="'.$detailUrl.'" style="float:left; width:100%; text-decoration:none !important;">
        	<span style="width:189px; height:125px; margin-right:10px; float:left;">
            	<img style="width:100%;" src="'.$avatar.'" alt="'.$title.'"/>
            </span>
            <label style="color:#999; font-size:12px; display:block; text-decoration:none !important;">'.$time.'</label>
            <label style="font-weight:bold; color:#2291D0; display:block;" >'.$title.'</label>
            <label style="color:#333;">'.$description.'</label>
            
        </a>
    </div>
    <p>Click vào đây để <a href="'.$detailUrl.'">xem chi tiết</a></p>
    <br></br>
    <p><b>Trân trọng!</b></p>
    <p>English360</p>
    '.$dstin.'
    <br></br>
    <br></br>
    <br></br>
    <p style="color:#999; font-size:12px;"><i>Bạn nhận được tin nhắn này là do bạn đã đăng ký nhận thông báo qua e-mail từ English360. Để dừng nhận tin nhắn qua e-mail, vui lòng <a href="'.$disable_url.'">click vào đây</a>
</div>
</body>
</html>';
?>
