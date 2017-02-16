<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Bạn phải đồng ý với :attribute.",
	"active_url"           => ":attribute không phải URL hợp lệ.",
	"after"                => ":attribute phải là một ngày sau :date.",
	"alpha"                => ":attribute chỉ được nhập chữ cái",
	"alpha_dash"           => ":attribute chỉ được nhập chữ, số hoặc dấu gạch ngang.",
	"alpha_num"            => ":attribute chỉ được nhập chữ hoặc số.",
	"array"                => ":attribute phải là một mảng.",
	"before"               => ":attribute phải là một ngày sau :date.",
	"between"              => array(
		"numeric" => ":attribute có giá trị từ :min đến :max.",
		"file"    => ":attribute có dung lượng từ :min đến :max kilobytes.",
		"string"  => ":attribute có độ dài từ :min đến :max ký tự.",
		"array"   => ":attribute có giới hạn từ :min đến :max mục.",
	),
	"confirmed"            => ":attribute nhập lại không chính xác.",
	"date"                 => ":attribute không phải ngày hợp lệ.",
	"date_format"          => ":attribute không đúng định dạng :format.",
	"different"            => ":attribute và :other phải khác nhau.",
	"digits"               => ":attribute phải là :digits chữ số.",
	"digits_between"       => ":attribute có từ :min đến :max chữ số.",
	"email"                => ":attribute không hợp lệ.",
	"exists"               => ":attribute được chọn không hợp lệ.",
	"image"                => ":attribute phải là hình ảnh.",
	"in"                   => ":attribute được chọn không hợp lệ.",
	"integer"              => ":attribute phải là số.",
	"ip"                   => ":attribute không phải là địa chỉ IP hợp lệ.",
	"max"                  => array(
		"numeric" => ":attribute không được lớn hơn :max.",
		"file"    => ":attribute không được lớn hơn :max kilobytes.",
		"string"  => ":attribute không được quá :max ký tự.",
		"array"   => ":attribute không được quá :max mục.",
	),
	"mimes"                => ":attribute phải là file loại: :values.",
	"min"                  => array(
		"numeric" => ":attribute phải lớn hơn :min.",
		"file"    => ":attribute phải lớn hơn :min kilobytes.",
		"string"  => ":attribute có ít nhất :min ký tự.",
		"array"   => ":attribute có ít nhất :min mục.",
	),
	"not_in"               => ":attribute được chọn không hợp lệ.",
	"numeric"              => ":attribute phải là số.",
	"regex"                => ":attribute có định dạng không hợp lệ.",
	"required"             => "Bạn chưa nhập :attribute.",
	"required_if"          => "Bạn cần nhập :attribute khi :other là :value.",
    "required_with"        => "The :attribute field is required when :values is present.",
    "required_with_all"    => "The :attribute field is required when :values is present.",
    "required_without"     => "The :attribute field is required when :values is not present.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => ":attribute và :other phải trùng khớp.",
	"size"                 => array(
		"numeric" => ":attribute có kích thước :size.",
		"file"    => ":attribute có kích thước :size kilobytes.",
		"string"  => ":attribute có kích thước :size ký tự.",
		"array"   => ":attribute có kích thước :size mục.",
	),
	"unique"               => ":attribute đã được sử dụng.",
	"url"                  => ":attribute định dạng không hợp lệ.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message'
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
        'username'=>'Tên đăng nhập',
        'email' => 'Địa chỉ email',
        'phone' => 'Số điện thoại',
        'password' => 'Mật khẩu',
        'password_confirmation' => 'Xác nhận mật khẩu',
        'cmnd' => 'Số CMND',
        'fullname' => 'Họ tên đầy đủ'
    ),

);
