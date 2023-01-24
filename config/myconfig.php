<?php
/*
|--------------------------------------------------------------------------
| Myコンフィグ
|--------------------------------------------------------------------------
*/
return [

	'client_id' => 1,
	'row_count' => 25,				// １ページに表示する件数
	'upload_max_filesize' => 3,		// 同時にアップロードできるファイル数
	'upload_max_file' => 1,			// アップロードできるファイルサイズ
	'resize' => 300,
	'cookie_time' => 60,			// 分指定
	'del_mode' => 1,				// 削除モード。0=物理削除、1=倫理削除
	'test_mode' => 1,				// テストモード。0=テストなし、1=テストあり

	'SESSION_LIFETIME' => env('SESSION_LIFETIME'),

	'gender_label' => [
		0 => '女性',
		1 => '男性',
	],
	'role_label' => [
		0 => '開発者',
		1 => '所有者',
		2 => '管理者',
		3 => '',
		4 => '',
		5 => '参加者',
	],

	'client_id' => '3900b7df-c9b2-4f7c-8391-4285b02d8a16',
];
