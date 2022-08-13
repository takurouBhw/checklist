チェックリスト - 仕様書

【目的】
日常業務を項目分けして作業完了をチェックし、各人の作業進捗度の把握と漏れミスを防ぐことが目的。


【参考URL】
チェックリストシステムアニー
※管理画面が意味不明。参考にすると時間が掛かり失敗する。


【営業から】
今回は予算的に、ログイン認証出来て、誰がチェックしたか分かり、項目追加して、チェック出来る、だけのシステムの予定です。
項目のカテゴリ分けとかも出来た方が良さそうかな。


【機能仕様】
本部管理画面(バックエンド)　※見越し機能。将来必要だと思われるので、余裕あれば実装。
登録クライアント管理：
アカウント管理：自身のアカウント編集。
Webサービス展開があるようなら、ニュースなどの編集機能追加が発生すると思われるが、その時点での対応とする。


各クライアント向け管理画面(バックエンド)　※本機能がシステムの主体。
チェックリスト：作成、編集、照会、削除。作成済みに対して複写機能あり。
※編集、削除は回答がない場合のみ可。編集を可能とした場合、過去チェック分を削除する処理とユーザーへの通知処理が必要になる。
※チェックリストには自動生成機能あり。曜日(選択後に曜日リストを表示)、毎月。
チェックリスト：一覧、ユーザー検索機能。
各チェックリストの達成度。
ユーザーマスター：作成、編集、照会、削除。
※削除は論理削除。退社扱いとし、情報も見える形にして残す。表示名はユーザー番号、氏名のみ。
※メールアドレス以外は暗号化。パスワードは管理画面で確認できるようにする。
会社マスター：作成、編集、照会、削除。※現時点で不要と思われるが用意しておく。
支社マスター：作成、編集、照会、削除。※現時点で不要と思われるが用意しておく。
部署マスター：作成、編集、照会、削除。※現時点で不要と思われるが用意しておく。
カテゴリーマスター：作成、編集、照会。※削除はなし。


操作画面(フロントエンド)　※API連携。
ログイン認証。
※ユーザーマスターでの登録のみ。ユーザー自身がユーザー登録はしない。
チェックリストの選択とチェック報告。
チェックリスト項目へのメモの追加。
リアルタイムによる他者操作状況の更新表示。


【本稼働サーバー】
カラフルボックス。※予算的な要求による。


【開発言語】
管理画面：Laravel8ないし9。PHP8　※フロントをReactで開発しない場合はLivewire
アプリ側：React ※現時点で安定してる最新版。

【構成】
下表の通り、URL中のセグメントでのルーティング分けとする。
RouteServiceProvider

分類
URL
ルーティング
本部管理画面
ドメイン/admin/
admin.php
クライアント管理画面
ドメイン/client/
client.php
ユーザー
ドメイン/
web.php
React
ドメイン/api/
api.php



実際のチェックリスト操作側はPWAを想定。場合によってはMonacaで開発する。※将来的にアプリ化するかもしれないため。


【本仕様書内での登場人物】
所有者・・・本部管理画面に唯一アクセスできる人。
管理者・・・チェックリストを作成、編集、閉鎖する人。
ユーザー・・チェックリストのチェック操作を実施する人。

【テーブル構造】
※ラベル名称はクライアント要望に合わせる。全テーブルcreated_at、updated_atを有する。

ユーザーマスター：users

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID




Laravel用に残す。認証、Eloquent用。
user_id
varchar
32
ユーザーID
UUID
name
varchar
50
ユーザー名


company_id　多対一
biginteger　符号なし


所属会社


branch_office_id　多対一
biginteger　符号なし


所属支店


duty_station_id　多対一
biginteger　符号なし


所属部署


email
varchar
255
メールアドレス


phone
varchar
15
電話番号


deleted_at
datetime
NULL


退社日。※論理削除用
role
tinyinteger　符号なし
1
権限
0=開発者
1=所有者
2=管理者
5=ユーザー
last_logined_at
datetime
NULL
最終ログイン日時


last_checklist_id
biginteger
NULL
最終チェック作業ID




会社マスター：companies

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






client_key
varchar
64
クライアントキー
UUID
name
varchar
100
会社名


postal_code
varchar
8
郵便番号


address
varchar
255
住所


email
varchar
255
メールアドレス


phone
varchar
15
電話番号


representative


NULL
代表者名


responsible


NULL
担当者名


url


NULL
ホームページ




支社マスター：branch_offices

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






company_id　多対一
biginteger　符号なし


本社


name
varchar
100
支社社名


postal_code
varchar
8
郵便番号


address
varchar
255
住所


email
varchar
255
メールアドレス


phone
varchar
15
電話番号


representative


NULL
代表者名


responsible


NULL
担当者名


url


NULL
ホームページ




部署マスター：duty_stations

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






company_id　多対一
biginteger　符号なし


本社


branch_office_id　多対一
biginteger　符号なし
NULL
支社


name
varchar
100
部署名


postal_code
varchar
8
郵便番号


address
varchar
255
住所


email
varchar
255
メールアドレス


phone
varchar
15
電話番号


representative


NULL
代表者名


responsible


NULL
担当者名


url


NULL
ホームページ





カテゴリーマスター：categories

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






name
varchar
100
カテゴリー名


sort_num
integer
0
表示順





チェックリスト：checklists

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






category_id　多対一
biginteger　符号なし


カテゴリー


user_id
varchar
32
作成者


priority
tinyinteger
1　1
優先度
0=低い
1=通常
2=高い
title
varchar
100
タイトル


drafted_at
datetime
NULL
下書き日時


opened_at
datetime
NULL
公開日時


colsed_at
datetime
NULL
終了日時


progress
double　符号なし
0
達成率


locked_at
datetime
NULL
編集ロック日時


sort_num
integer
0
表示順





チェックリスト詳細：checklist_todos

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






category_id　多対一
biginteger　符号なし


カテゴリー


checklist_id　多対一
biginteger　符号なし


チェックリストID


headline
tinyinter
0
見出しフラグ
見出しにするとチェック項目から除外
attention
tinyinteger
1　0
注目項目


check_item
text
NULL
チェック内容


locked_at
datetime
NULL
編集ロック日時


sort_num
integer
0
表示順





チェックリスト参加者：checklist_participants

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






category_id　多対一
biginteger　符号なし


カテゴリー


checklist_id　多対一
biginteger　符号なし


チェックリストID


user_id
varchar
32
参加者





チェック作業：checklist_works

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






category_id　多対一
biginteger　符号なし


カテゴリー


checklist_id　多対一
biginteger　符号なし


チェックリストID


user_id　多対一
varchar
32
user_id


title
varchar
100
タイトル


started_at
datetime
NULL
作業開始日時


ended_at
datetime
NULL
作業終了日時




チェック作業回答：checklist_todo_works

カラム名
データ型
サイズ、初期値
ラベル
説明
id
LaravelID






category_id　多対一
biginteger　符号なし


カテゴリー


checklist_id　多対一
biginteger　符号なし


チェックリストID


user_id　多対一
varchar
32
user_id


headline
tinyinter
0
見出しフラグ
見出しにするとチェック項目から除外
attention
tinyinteger
1　0
注目項目


check_item
text
NULL
チェック内容


checked
tinyinter
1
チェック結果


memo
memo


メモ
チェック業務中のメモ。
second
integer


経過秒数




【機能仕様】
本部管理画面
クライアント管理画面
チェックリスト
ユーザーマスター
所属部署がない場合は、項目自体を非表示。
	
【コーディングルール】
変数名はスネークライン。HTMLタグ内のクラス名はキャメルライン。いずれも先頭文字は小文字。
インデントはタブ。


【チェックリストの業務フロー】
エントランス画面はログインフォームとする。
※ブックマーク等ログイン後のアクセスは、ログイン画面に強制遷移。


ログイン後のTOPページは、操作可能なチェックリストのカテゴリー一覧を表示。
※プルダウン式。
※チェックリストが下書き、または閉鎖されたものは除外。
※並び順は、未チェックを先頭に優先度＞新着順とする。
※チェック済でも新規に項目が追加される場合もあるため、通知機能を設ける。確認が必要なチェックリストに対してのアナウンスを表示。
※チェックが必要な数に対する達成度を円グラフと％(パーセント)で表示する。


カテゴリーを選択後に、チェックリストを構成して表示する。こちらはリスト一覧表示。
※並び順は、未チェックを先頭に優先度＞新着順とする。
※チェック完了したチェックリストも表示、再チェック操作も可能とする。このために「すべてのチェックを外す」機能を用意する。
　ただし「すべてチェックする」機能はアプリの性質上なし。


チェックリスト操作画面
※参加しているメンバーを表示。オンラインであるかはここでは見ない。
※全チェック完了で「すべてのチェックが終わりました。」のアラートを表示し、「確認」ボタンでカテゴリー選択時の前画面に戻る。
※チェックリスト操作は中断可能とする。
※見出し項目はチェック対象外。これ以外はチェックが必要な項目。またこれにはテキストインプットが必要な項目もある。
　見出しの次の項目が１件しかない場合は「一括チェック」なし。行背景色A
　見出しの次の項目が１件以上ある場合は「一括チェック」あり。行背景色B
　attentionの値が1の項目は赤文字にする。

　

※本画面を開いたタイミングで、ユーザーごとにチェックリスト回答用データ(checklist_works_anser)が先に生成される。


チェックリスト内の文言の修正、追加提案機能。
※チェック作業中に発見した語弊、誤字脱字等の修正依頼の報告機能。

管理画面側のロック機能。
チェックしたチェックリストの内容が改ざん出来ないように以下の機能を用意。
ユーザーがチェックした時点で、そのチェック項目については編集ロックする。
すべてのチェックがされたら、親データについても編集ロックする。


【API仕様】
要求、受信：React
応答、処理：Laravel　※Livewire選択時でも、APIはコントローラーを使用する。


初期化API　※条件：ユーザーIDが端末内に保存されていること。
URL：			ドメイン/api/login以外の全ページ
通信：			POST
パラメータ：
　user_id		ユーザーID　※端末のcookieかstorageに保存された値を使用。
レスポンス：		json形式　{“error!”:””}
　error			認証結果。空文字=認証OK。それ以外はエラーメッセージ。セッション切れ、または退社時。
			セッション切れ：「セッションが切れました。ログインし直してください。」アラート、ログイン画面へ。
			退社時：「このユーザーでは現在使用することが出来ません。」アラート、ログイン画面へ。ボタンは使用不可。
※セッション内の場合は、チェックリストカテゴリー一覧画面に遷移。保存されたチェックリストNoがある場合は、そのチェックリストへ遷移。


ログインAPI
URL：			ドメイン/api/login
通信：			POST
パラメータ：
　email		ログインID(メールアドレス)
　password		パスワード
レスポンス：		json形式　{“error”:””,”user_id”,””}
　error			認証結果。空文字=認証OK。それ以外はエラーメッセージ。
　user_id		ユーザーID。認証以降ログアウトまで保持すること。
※認証成功の場合は、チェックリストカテゴリー一覧画面に遷移。保存されたチェックリストNoがある場合は、そのチェックリストへ遷移。


ログアウトAPI
URL：			ドメイン/api/logout
通信：			POST
パラメータ：		
　user_id		ユーザーID
レスポンス：		なし。

※全項目のチェックが未完了でもログアウトを可とする。その際は未チェックが残っていることを示すアラートを出す。
　「すべてのチェックが終っていません。このままログアウトしますか？」
※端末内のユーザーID、チェックリストNoを破棄してログイン画面へ遷移。画面上部に「ログアウトしました。」を表示。


カテゴリーリスト画面
目的：			カテゴリーリストの構成。
イベント：		画面表示時。
URL：			ドメイン/api/get_category
通信：			POST
パラメータ：		
　user_id		ユーザーID
レスポンス：		json形式　{"categories":[{"id":"","name":""},{“id”:””,”name”:””}]}
　categories		開いたチェックリストの項目。作業再開は回答データ付き。


チェックリスト表示時
目的：			カテゴリーからチェックリストの構成。
イベント：		画面表示時。
URL：			ドメイン/api/get_checklist
通信：			POST
パラメータ：		
　user_id		ユーザーID
　category_id		カテゴリーID
レスポンス：		json形式　{"checklists":[{"id":"","title":""},{“id”:””,”title”:””}]}
　checklists		開いたチェックリストの項目。作業再開は回答データ付き。


チェックリスト作業表示時
目的：			チェックリストから作業用チェックリストの構成。
イベント：		画面表示時。
URL：			ドメイン/api/get_checklist_works
通信：			POST
パラメータ：		
　user_id		ユーザーID
　checklist_id		チェックリストID
レスポンス：		json形式　{"checklist_works":[{"id":"","headline":"","attention”:"0”.”check_item”:””},{"id":"","headline":"","attention”:"0”.”check_item”:””}]}
　checklist_works	開いたチェックリストの項目。作業再開時は回答データ付き。


リアルタイム更新チェック
目的：			他者の操作をチェックし反映するための問い合わせ。10秒おきの処理。
イベント：		初回表示時。以降10秒(※暫定)おき。
URL：			ドメイン/api/realtime_chk
通信：			POST
パラメータ：		json形式
　key			クライアントキー
　checklist_id		チェックリストID
　user_id		ユーザーID（ログイン時に受け取った値）
　check_time		この画面を開いてセットされたタイムスタンプ。初回は「0」固定。

レスポンス：		json形式　{“check_time”:””,”check_users”:[{}],”progressA”:”10”,”progressU”:”30”,”error”:””}
　check_time		今回のリクエスト処理されたタイムスタンプ。　＞JS変数「check_time」を次回問い合わせ用に更新。
　check_users	今回のリクエストで見つかった他者の操作情報。
　　　　　　		[]・・・空配列＝更新情報なし
　　　　　　		[{"todo_ids":124,"name":"ユーザー１"},{"todo_ids":125,"name":"ユーザー２"}]
　			※No.124にユーザー１がチェックした。No.125にユーザー２がチェックした。
　progressA		全体の進捗値。0～100を返す。※式 = (参加者の全チェック数) ／ (参加人数 ＊ 項目数)　小数点以下四捨五入。
　progressU		個人の進捗値。0～100を返す。※式 = (チェック数) ／ (項目数)　小数点以下四捨五入。
　error			エラーメッセージ。問題なければ空文字。

※初回のみ全チェックリストを生成する必要がある。
問題点、もし管理側で新規項目が追加または変更、削除された場合、データ整合性が失われるため、一人でもユーザーがチェックリストを開いている場合は、管理画面で該当のチェックリストに対する操作をロックする。


リアルタイム保存
目的：			ユーザーがチェック操作した時点(changeイベント)で、APIを叩いてチェック情報等を送信する。
イベント：		チェックボックスへのチェック時。
URL：			ドメイン/api/realtime_save
通信：			POST
パラメータ：		json形式
　key			クライアントキー
　checklist_works_id	チェック作業ID
　user_id		ユーザーID
　memo		その項目のテキスト入力値
　check_time		開始ボタンを押してからチェックするまでの経過秒数。

レスポンス		※リアルタイム更新チェックと同じ。


メモ機能
目的：操作中に発見した語弊、誤字脱字等の修正依頼の報告やメモ書き機能。
イベント：メモ書きフォーカスアウト時。
URL：			ドメイン/api/requests
通信：			POST
パラメータ：		json形式
　key			クライアントキー
　checksheet		チェックリストID
　user_id		ユーザーID
　memo		操作中のチェックリスト項目についてのテキスト入力。チェック内容の不備やその他気づいた点。

レスポンス：		json形式
　error			エラーメッセージ。問題なければ空文字。
　response		成功時は「送信が成功しました。」失敗時は空文字。


ログアウト時の振る舞い。
ログアウト操作時に、書きかけのメモがあれば処理した後ログアウトする。同時に開いているチェックリストのNoを保存。次回ログイン時に再表示する。
もし保存したチェックリスト(やりかけであっても)が閉鎖された場合は、ログイン直後のカテゴリー一覧画面を表示しつつ、「保存したチェックリスト『タイトル』は閉鎖されました。」のメッセージを表示。


明示的にログアウトせずに、ブラウザの閉じる操作をした後のエントランス画面リクエスト時の振る舞い。セッション保持期間中は自動ログインを有効にする。遷移先はカテゴリー一覧。保持期間が過ぎたアクセス時はログイン画面を表示。





アプリ操作画面
