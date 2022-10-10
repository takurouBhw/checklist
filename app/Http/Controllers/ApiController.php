<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Models\User;
use App\Models\CheckList;
use App\Models\ChecklistWork;
use Exception;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $error = '';
        $client_key = '';
        $user_id = '';
        $user_name = '';

        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['bail', 'required', 'string', 'email', 'max:255'],
                'password' => ['bail', 'required', 'string', 'min:5'],
            ],
            [],
            [
                'email' => 'メールアドレス',
                'password' => 'パスワード',
            ]
        );

        if ($validator->fails()) {
            $error = $validator->messages();
            return response()->json([
                'error' => $error,
            ]);
        }

        $user = User::where('email', '=', $request->email)->first();
        if (!isset($user->id)) {
            $error = 'ログイン情報が登録されていません。';
            return response()->json([
                'error' => $error,
            ]);
        }
        if (!Hash::check($request->password, $user->password)) {
            $error = 'メールアドレスまたはパスワードが一致しません。';
            return response()->json([
                'error' => $error,
            ]);
        }

        $now = new Carbon();
        $client_key = $user->client_key;
        $user_id = $user->user_id;
        $user_name = $user->name;
        $user->last_logined_at = $now->format('Y-m-d H:i:s');
        $user->save();

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'error' => $error,
            'client_key' => $client_key,
            'user_id' => $user_id,
            'user_name' =>   Crypt::decryptString($user_name),
        ]);
    }

    public function logout(Request $request)
    {
        $user = User::where('email', '=', $request->user_id)->first();

        if (!isset($user->id)) {
        } else {
            $user->last_logined_at = null;
            $user->save();
        }
    }

    public function get_category1(Request $request)
    {
        $categories = [];

        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);

        // 権限チェック
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'status' => 403,
            ]);
        }

        $now = new Carbon();
        $categories = DB::select(
            "SELECT `category1s`.`id`, `category1s`.`category1_name`, COUNT(`checklist_works`.`id`) AS `cnt`
            FROM `category1s`
            LEFT JOIN `checklist_works` ON `category1s`.`id` = `checklist_works`.`category1_id`
            -- WHERE `checklist_works`.`opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL)
            WHERE `checklist_works`.`colsed_at`>=? OR (`checklist_works`.`colsed_at` IS NULL)
            GROUP BY `category1s`.`id`, `category1s`.`category1_name`",
            [$now->format('Y-m-d 23:59:59')]
        );

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function get_category2(Request $request)
    {
        $categories = [];

        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);

        // 権限チェック
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'status' => 403,
            ]);
        }

        $now = new Carbon();
        $categories = DB::select(
            "SELECT `category2s`.`id`, `category2s`.`category2_name`, COUNT(`checklist_works`.`id`) AS `cnt`
            FROM `category2s`
            LEFT JOIN `checklist_works` ON `category2s`.`id` = `checklist_works`.`category2_id`
            WHERE `checklist_works`.`category1_id`=?
            -- AND `checklist_works`.`opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL)
            AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL)
            GROUP BY `category2s`.`id`, `category2s`.`category2_name`",
            [$request->category1_id, $now->format('Y-m-d 23:59:59')]
        );

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function get_checklist(Request $request)
    {
        $checklists = [];
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        // 権限チェック
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'status' => 403,
            ]);
        }

        $now = new Carbon();
        $checklists = DB::table('checklist_works')
        ->select('id', 'checklist_title')
        ->where('category1_id', '=', $request->category1_id)
        ->where('category2_id', '=', $request->category2_id)
        ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
        ->orderBy('deadline_at', 'asc')
        ->get();
        // $checklists = DB::select(
        //     "SELECT `checklist_works`.`id`, `checklist_works`.`checklist_title`
        //     FROM `checklist`
        //     WHERE `category1_id`=? AND `category2_id`=?
        //     AND `opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL)
        //     ORDER BY `deadline_at` ASC",
        //     [$request->category1_id, $request->category2_id, $now->format('Y-m-d 00:00:00'), $now->format('Y-m-d 23:59:59')]
        // );

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'checklists' => is_null($checklists) ? [] : $checklists,
        ]);
    }

    public function get_checklist_works(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'checklist_id' => ['bail', 'required', 'integer', 'min:1'],
                'user_id' => ['bail', 'required', 'string', 'min:36', 'max:36'],
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'started_at' =>  0,
                'finished_at' => 0,
                'deadline_at' => 0,
                'elapsed_time' => 0,
                'checklist_works' => [],
                'status' => 400,
            ]);
        }

        $user_name = '';
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        // 権限チェック
        $now = new Carbon();
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'started_at' =>  0,
                'finished_at' => 0,
                'deadline_at' => 0,
                'elapsed_time' => 0,
                'checklist_works' => [],
                'status' => 403,
            ]);
        }

        //　チェックリスト取得
        $checklist = DB::table('checklist_works')->where('id', '=', $request->checklist_id)->first();
        // $checklist = DB::table('checklist_works')->find($request->checklist_id)->first();

        // チェックリスト存在チェック
        if (is_null($checklist)) {
            return response()->json([
                'error' => '',
                'started_at' =>  0,
                'finished_at' => 0,
                'deadline_at' => 0,
                'elapsed_time' => 0,
                'checklist_works' => [],
            ]);
        }

        /***************** check_items取得処理 *********************************************/
        // JSONファイル存在チェック
        $json_file_path = "public/works/{$request->checklist_id}_checkitem.dat";
        $is_json_file_path = Storage::exists($json_file_path);
        if(!$is_json_file_path) {
            return response()->json([
                'error' => [],
                'started_at' =>  0,
                'finished_at' => 0,
                'deadline_at' => 0,
                'elapsed_time' => 0,
                'checklist_works' => [],
            ]);
        }

        // 取得
        $json_content = Storage::get($json_file_path);
        $check_items = json_decode($json_content, true);
        // dd($check_items);
        /****************************************************************/

        // 変換
        // $check_items = isset($checklist->check_items) ? json_decode($checklist->check_items, true) : [];
        // $check_items = isset($checklist->check_items) ? json_decode($checklist->check_items, true) : [];
        $participants = isset($checklist->participants) ? json_decode($checklist->participants, true) : [];

        // チェック作業リストに表示する項目が存在しない場合
        if (empty($check_items)) {
            return response()->json([
                'error' => [],
                'started_at' =>  0,
                'finished_at' => 0,
                'deadline_at' => 0,
                'elapsed_time' => 0,
                'checklist_works' => [],
            ]);
        }

        // partipants抽出
        // 自身がチェック作業初参加の場合
        $is_first_participation = isset($participants[$request->user_id]) ? false : true;
        $self_participant = $participants[$request->user_id] ?? [];

        // 参加者が初チェック作業({})の場合はカラムcheck_itmesのJSON作業IDに紐付くカラムparticipant JSONの初期化をする
        // 初参加者判定
        if ($is_first_participation) {
            foreach ($check_items as $index => $item) {
                // check itmeのidが存在しない場合
                $self_participant['checkeds'][$index] = 0;
                $self_participant['checkeds_time'][$index] = 0;
                $self_participant['inputs'][$index] = '';
            }
            $self_participant['started_at'] = 0;
            $self_participant['finished_at'] = 0;
            $self_participant['elapsed_time'] = 0;
            $self_participant['user_name'] =  $user_name;
        }
        // 参加者が作業完了している場合は空で返却
        if ($self_participant['finished_at'] > 0) {
            return response()->json([
                'error' => '',
                'started_at' =>  0,
                'finished_at' => 0,
                'deadline_at' => 0,
                'elapsed_time' => 0,
                'checklist_works' => [],
            ], 200);
        }

        // 参加者が初参加の場合のみparticipanカラムが生成されているので保存
        if ($is_first_participation) {
            // 保存処理
            $participants[$request->user_id] = $self_participant;
            $checklist->participants = json_encode($participants, true);
            // 保存に失敗した場合
            // $checklist->update([
            //     'participants' => json_encode($participants, true),
            // ]);
            DB::table('checklist_works')->where('id', $request->checklist_id)->update([
                'participants' => json_encode($participants, true),
            ]);
            // if(!$checklist->save()) {
            //     return response()->json(
            //         [
            //             'error' => 'データの取得に失敗しました。',
            //             'started_at' =>  0,
            //             'finished_at' => 0,
            //             'deadline_at' => 0,
            //             'elapsed_time' => 0,
            //             'checklist_works' => [],
            //         ],500,
            //     );
            // }
        }

        // レスポンスチェック作業リストの生成処理
        $new_items = [];
        foreach ($check_items as $index => $item) {
            $item['id'] = $index;
            $item['no'] = $index;
            $item['checked'] = isset($self_participant['checkeds'][$index]) ? $self_participant['checkeds'][$index] : 0;
            $item['input'] = isset($self_participant['inputs'][$index]) ? $self_participant['inputs'][$index] : "";
            $item['check_time'] = isset($self_participant['checkeds_time'][$index]) ? $self_participant['checkeds_time'][$index] : 0;
            // array_push($new_items, $item);
            $check_items[$index] = $item;

            // 自分以外の参加者情報のチェック時間と名前を取得処理
            $_index = 0;
            foreach ($participants as $_user_id => $info) {
                if ($_user_id === $request->user_id) continue;

                $item['participants'][$_index]['user_name'] =  Crypt::decryptString($info['user_name']);
                $item['participants'][$_index]['check_time'] = $info['checkeds_time'][$index] ?? 0;
            // array_push($new_items, $item);
                $check_items[$index] = $item;
                $_index++;
            }
        }
        // dd($new_items);
        // ソート
        // id 昇順に並び替え
        // sort($check_items);
        // $ids = array_column($new_items, 'id');
        $ids = array_column($check_items, 'id');
        array_multisort($ids, SORT_ASC, $check_items);
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'error' => '',
            'started_at' => isset($self_participant['started_at']) ? $self_participant['started_at'] : 0,
            'finished_at' => isset($self_participant['finished_at']) ? $self_participant['finished_at'] : 0,
            'deadline_at' => isset($checklist->deadline_at) ? (new Carbon($checklist->deadline_at))->timestamp : 0,
            'elapsed_time' => isset($checklist->elapsed_time) ? $self_participant['elapsed_time'] : 0,
            'checklist_works' => $check_items,
            // 'checklist_works' => $new_items,
        ], 200);
    }

    public function check_start(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'key' => ['bail', 'required', 'string'],
                'checklist_id' => ['bail', 'required', 'integer', 'min:1'],
                'user_id' => ['bail', 'required', 'string'],
                'check_time' => ['bail', 'required', 'integer', 'min:1']
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400,
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ]);
        }

        // 権限チェック
        $user_name = '';
        $now = new Carbon();
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'status' => 403,
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ]);
        }

        /*
        テーブルロックを使用しない、期待の大きい代案。
        同じチェックリストについてのみの疑似ロック処理。
        本処理に3秒もかからないと予測。前回操作から3秒経過分はそのまま続行。
        2秒以内の場合は1秒待機して続行。
        */
        // 疑似ロックファイル存在チェック
        $lockfie_path = "public/works/{$request->checklist_id}.lock";
        $is_lockedfile = Storage::exists($lockfie_path);

        // ロック中の場合
        $timestamp = 0;
        if ($is_lockedfile) {
            $timestamp = Storage::get($lockfie_path);
        }
        // ロック中でなければファイル内容にタイムスタンプを記述
        else {
            $timestamp = $now->timestamp;
            Storage::put($lockfie_path, $timestamp);
        }

        // ロック待機処理
        $wate_time = 1;
        if ($wate_time <= (new Carbon())->timestamp - $timestamp) {
            Storage::put($lockfie_path, ((new Carbon())->timestamp));
        } else {
            sleep(1);
        }

        //　チェックリスト取得
        $checklist = ChecklistWork::find($request->checklist_id)
            ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
            ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
            ->first();
        // 作業中チェックリストが存在しない場合
        if (is_null($checklist)) {
            return [
                'error' => "checklist_id: {$request->checklist_id}: チェックリストが存在しません。",
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ];
        }

        // check_items partipants抽出
        $check_item_json_path = "public/templates/1_checkitem.dat";
        $is_check_item_json = Storage::exists($check_item_json_path);

        // ロック中の場合
        $timestamp = 0;
        $json_contents = [];
        if ($is_check_item_json) {
            $json_contents = Storage::get($check_item_json_path);
            $json_contents = mb_convert_encoding($json_contents, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
            dd($json_contents);
        }
        // ロック中でなければファイル内容にタイムスタンプを記述
        else {
            $timestamp = $now->timestamp;
            Storage::put($lockfie_path, $timestamp);
        }
        $check_items = isset($checklist->check_items) ? json_decode($checklist->check_items, true) : [];
        $participants = isset($checklist->participants) ? json_decode($checklist->participants, true) : [];

        // チェック作業に表示する項目自体が存在しない場合
        if (empty($check_items)) {
            return response()->json([
                'error' => '',
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ]);
        }

        // partipants抽出
        $self_participant = isset($participants[$request->user_id]) ? $participants[$request->user_id] : [];
        // []の場合は参加者は初チェック作業とみなしカラムcheck_itmes内の作業IDに紐付く,
        // カラムparticipantパラメータ生成と初期化処理を実施
        if (empty($self_participant)) {
            foreach ($check_items as $index => $item) {
                // check itmeのidが存在しない場合
                if (!isset($item['id'])) continue;

                $self_participant['checkeds'][$item['id']] = 0;
                $self_participant['checkeds_time'][$item['id']] = 0;
                $self_participant['inputs'][$item['id']] = '';
            }
            $self_participant['started_at'] = 0;
            $self_participant['finished_at'] = 0;
            $self_participant['elapsed_time'] = 0;
        }

        // 更新処理
        $self_participant['started_at'] = $request->check_time;
        // 保存処理
        $participants[$request->user_id] = $self_participant;
        $checklist->participants = json_encode($participants, true);
        try {
            DB::beginTransaction();
            $checklist->save();
            // 自分以外の参加者情報を抽出
            $_participants = [];
            // 全参加者のチェック数
            $chkA = 0;
            // 自身のチェック数
            $chkU = 0;

            // レスポンス生成処理
            foreach ($participants as $_user_id => $payload) {
                if (empty($payload)) continue;
                $index = 0;
                foreach ($payload['checkeds_time'] as $checklist_work_id => $check_time) {
                    // 自身のチェック数処理
                    if ($_user_id === $request->user_id) {
                        $chkU = $check_time > 0 ? $chkU + 1 : $chkU;
                        continue;
                    }

                    $chkA = $check_time > 0 ? $chkA + 1 : $chkA;
                    $item = [
                        'id' => $checklist_work_id,
                        'check_time' => $check_time,
                        'user_name' =>  $payload['user_name'],
                    ];
                    $_participant = [
                        'check_time' => $check_time,
                        'user_name' => $payload['user_name'],
                    ];
                    $_participants[$checklist_work_id] = [];
                    array_push($_participants[$checklist_work_id], $_participant);
                    $index++;
                }
            }

            // Progress作成処理
            // 総項目数
            $total_count = count(json_decode($checklist->check_items, true));
            // 参加人数
            $user_count = count(json_decode($checklist->participants, true));

            if ($total_count !== 0 || $user_count !== 0) {
                // progressA: 全体の進捗値。0～100を返す。※式 = (参加者の全チェック数) ／ (参加人数 ＊ 項目数)　小数点以下四捨五入。
                $progressA = round(($chkU + $chkA) / ($total_count * $user_count));
            }
            if ($total_count !== 0) {
                // progressU: 個人の進捗値。0～100を返す。※式 = (チェック数) ／ (項目数)　小数点以下四捨五入。
                $progressU = round($chkU / $total_count);
            }

            DB::commit();

            // header("Access-Control-Allow-Origin: *");
            // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

            return response()->json([
                "check_users" => $_participants,
                "error" => "",
                "progressA" => $progressA,
                "progressU" => $progressU,
            ], 200);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'error' => 'データの保存に失敗しました。',
                'check_users' => [],
                'progressA' =>  0,
                'progressU' => 0,
            ], 500);
        }
    }
    public function realtime_chk(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                // 'key' => ['bail', 'required', 'string'],
                'checklist_id' => ['bail', 'required', 'integer', 'min:1'],
                'user_id' => ['bail', 'required', 'string', 'min:36', 'max:36'],
            ],
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400,
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ]);
        }

        // 権限チェック
        $user_name = '';
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ], 403);
        }

        // チェックリスト抽出
        $now = new Carbon();
        $checklist = ChecklistWork::find($request->checklist_id)
            ->select('participants', 'check_items')
            ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
            ->Where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))->first();

        // 存在チェック
        if (is_null($checklist)) {
            return response()->json([
                'error' => 'チェックリストが存在しません。',
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ]);
        }

        // チェック作業中なのに自身を含める参加者が存在しない場合
        // サーバー側でデータ整合性エラーが発生している可能あり
        if (!isset($checklist->participants)) {
            return response()->json([
                'error' => 'チェック作業者のデータが存在しません。',
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ], 500);
        }

        // JSONデコードに失敗した場合
        // サーバー側のJSONデータ登録に問題が発生している可能性あり
        $participants = json_decode($checklist->participants, true);
        if (is_null($participants)) {
            return response()->json([
                'error' => '参加者のデータ取得に失敗しました。',
                'check_users' => [],
                'progressA' => 0,
                'progressU' => 0,
            ], 500);
        }

        // 自分以外の参加者情報を抽出
        $_participants = [];
        // 全参加者のチェック数
        $chkA = 0;
        // 自身のチェック数
        $chkU = 0;

        // レスポンス生成処理
        foreach ($participants as $_user_id => $payload) {
            if (empty($payload)) continue;

            $index = 0;
            foreach ($payload['checkeds_time'] as $checklist_work_id => $check_time) {
                // 自身のチェック数処理
                if ($_user_id === $request->user_id) {
                    $chkU = $check_time > 0 ? $chkU + 1 : $chkU;
                    continue;
                }

                // 参加者のチェック数処理
                $chkA = $check_time > 0 ? $chkA + 1 : $chkA;
                $_participan = [
                    'check_time' => $check_time,
                    'user_name' => Crypt::decryptString($payload['user_name']),
                ];
                $_participants[$checklist_work_id] = [];
                array_push($_participants[$checklist_work_id], $_participan);
                $index++;
            }
        }

        // Progress作成処理
        // 総項目数
        $progressA = 1;
        $progressU = 1;
        $total_count = count(json_decode($checklist->check_items, true));
        // 参加人数
        $user_count = count(json_decode($checklist->participants, true));

        if (($total_count * $user_count) !== 0) {
            $progressA = round(($chkU + $chkA) / ($total_count * $user_count));
        }
        if ($total_count !== 0 && $total_count !== 0) {
            $progressU = round($chkU / $total_count);
        }

        // レスポンス生成
        return response()->json([
            "check_users" => $_participants,
            "error" => "",
            "progressA" => $progressA,
            "progressU" => $progressU,
        ], 200);
    }

    // 保存キュー処理にも対応
    // チェックリストは配列でやってくる
    public function realtime_save(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                // 'key' => ['bail', 'required', 'string', 'min:36', 'max:36'],
                'checklist_id' => ['bail', 'required', 'integer', 'min:1'],
                'user_id' => ['bail', 'required', 'string', 'min:36', 'max:36'],
                'elapsed_time' =>  ['bail', 'required', 'integer', 'min:1'],
                'checklist_works' => ['bail', 'required', 'array'],
            ],
        );


        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => 400,
                'checklist_works' => [],
            ]);
        }

        // 権限チェック
        $user_name = '';
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'checklist_works' => [],
                'status' => 403,
            ]);
        }

        /*
        テーブルロックを使用しない、期待の大きい代案。
        同じチェックリストについてのみの疑似ロック処理。
        本処理に3秒もかからないと予測。前回操作から3秒経過分はそのまま続行。
        2秒以内の場合は1秒待機して続行。
        */
        // 疑似ロックファイル存在チェック
        $now = new Carbon();
        // $lockfie_path = "public/works/{$request->checklist_id}.lock";
        // $is_lockedfile = Storage::exists($lockfie_path);

        // // ロック中の場合
        // $timestamp = 0;
        // if ($is_lockedfile) {
        //     $timestamp = Storage::get($lockfie_path);
        // }
        // // ロック中でなければファイル内容にタイムスタンプを記述
        // else {
        //     $timestamp = $now->timestamp;
        //     Storage::put($lockfie_path, $timestamp);
        // }

        // // ロック待機処理
        // $wait_time = 1;
        // if ($wait_time <= (new Carbon())->timestamp - $timestamp) {
        //     Storage::put($lockfie_path, ((new Carbon())->timestamp));
        // } else {
        //     sleep(1);
        // }

        //　チェックリスト取得
        $checklist = DB::table('checklist_works')->where('id', '=', $request->checklist_id)
        ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
        ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
        ->first();
        //　チェックリスト取得
        // $checklist = ChecklistWork::find($request->checklist_id)
        //     ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
        //     ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
        //     ->first();
        // 作業中チェックリストが存在しない場合
        if (is_null($checklist)) {
            return [
                'error' => "checklist_id: {$request->checklist_id}: チェックリストが存在しません。",
                'checklist_works' => [],
            ];
        }

         /***************** check_items取得処理 *********************************************/
        // JSONファイル存在チェック
        $json_file_path = "public/works/{$request->checklist_id}_checkitem.dat";
        $is_json_file_path = Storage::exists($json_file_path);
        if(!$is_json_file_path) {
            return response()->json([
                'error' => [],
                'started_at' =>  0,
                'finished_at' => 0,
                'deadline_at' => 0,
                'elapsed_time' => 0,
                'checklist_works' => [],
            ]);
        }
        // 取得
        $json_content = Storage::get($json_file_path);
        $check_items = json_decode($json_content, true);
        // dd($check_items);
        /****************************************************************/

        // partipants抽出
        $participants = isset($checklist->participants) ? json_decode($checklist->participants, true) : [];

        // チェック作業に表示する項目自体が存在しない場合
        if (empty($check_items)) {
            return response()->json([
                'error' => '',
                'checklist_works' => $check_items,
            ]);
        }

        // partipants抽出
        $self_participant = isset($participants[$request->user_id]) ? $participants[$request->user_id] : [];
        // 参加者が初チェック作業({})の場合はカラムcheck_itmesのJSON作業IDに紐付くカラムparticipant JSONの初期化をする
        if (empty($self_participant)) {
            foreach ($check_items as $index => $item) {
                // check itmeのidが存在しない場合
                if (!isset($item['id'])) continue;
                $self_participant['checkeds'][$item['id']] = 0;
                $self_participant['checkeds_time'][$item['id']] = 0;
                $self_participant['inputs'][$item['id']] = '';
            }
            $self_participant['started_at'] = 0;
            $self_participant['finished_at'] = 0;
            $self_participant['elapsed_time'] = 0;
        } else {
            foreach ($check_items as $index => $item) {
                // item項目に対応するIDが存在しない場合は新規作成
                if (!isset($self_participant['checkeds'][$index])) {
                    $self_participant['checkeds'][$index] = 0;
                }
                if (!isset($self_participant['checkeds_time'][$index])) {
                    $self_participant['checkeds_time'][$index] = 0;
                }
                if (!isset($self_participant['inputs'][$index])) {
                    $self_participant['inputs'][$index] = '';
                }
            }
            if (isset($self_participant['started_at'])) {
                $self_participant['started_at'] = 0;
            }
            if (isset($self_participant['finished_at'])) {
                $self_participant['finished_at'] = 0;
            }
            if (isset($self_participant['elapsed_time'])) {
                $self_participant['elapsed_time'] = 0;
            }
        }

        // 更新処理
        $self_participant['user_name'] = $user_name;
        $self_participant['elapsed_time'] = $request->elapsed_time;
        foreach ($request->checklist_works as $item) {
            $cheked = $item['checked'] ?? 0;
            $id = $item['id'];
            $self_participant['checkeds'][$id] = $cheked;
            $self_participant['checkeds_time'][$id] =  $cheked == 1 ? $item['check_time'] : 0;
            $self_participant['inputs'][$id] = $item['input'] ?? '';
        }

        // 保存処理
        $participants[$request->user_id] = $self_participant;
        try {
            DB::beginTransaction();
            DB::table('checklist_works')->where('id', $request->checklist_id)->update([
                'participants' => json_encode($participants, true),
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'error' => $exception->getMessage(),
                'checklist_works' => [],
            ], 500);
        }

        // レスポンスチェック作業リストの生成処理
        $tmp_checklist_works = $check_items;
        // 自身のチェック数
        $chkA = 0;
        // 全参加者のチェック数
        $chkU = 0;
        $new_items = [];
        foreach ($tmp_checklist_works as $index => $item) {

            // チェック済み加算
            if ((int)$self_participant['checkeds'][$index] == 1) {
                $chkU++;
                $chkA++;
            }
            $item['id'] = $index;
            $item['no'] = $index;
            $item['checked'] = $self_participant['checkeds'][$index] ?? 0;
            $item['input'] = $self_participant['inputs'][$index] ?? '';
            $item['check_time'] = $self_participant['checkeds_time'][$index] ?? 0;

            // 自分以外の参加者情報のチェック時間と名前を追加
            $_index = 0;
            foreach ($participants as $_user_id => $info) {

                if ($_user_id === $request->user_id) continue;
                $item['participants'][$_index]['user_name'] = Crypt::decryptString($info['user_name']);
                $item['participants'][$_index]['check_time'] = $info['checkeds_time'][$_index] ?? 0;

                // チェックタイム0より上ならチェック済みなので全参加のチェック数を加算
                if ((int)$info['checkeds_time'][$index] > 0) {
                    $chkA++;
                }
                $_index++;
            }
            // array_push($new_items, $item);
            $tmp_checklist_works[$index] = $item;
        }

        // Progress作成処理
        // 総項目数
        $total_count = count(json_decode($checklist->check_items, true));
        $progressA = 1;
        $progressU = 1;
        // 参加人数
        $user_count = count($tmp_checklist_works[0]['participants'] ?? []) + 1;
        if (($total_count * $user_count) !== 0) {
            // progressA: 全体の進捗値。0～100を返す。※式 = (参加者の全チェック数) ／ (参加人数 ＊ 項目数)　小数点以下四捨五入。
            $progressA = round(($chkU + $chkA) / ($total_count * $user_count));
        }
        if ($total_count !== 0 && $$chkU !== 0) {
            // progressU: 個人の進捗値。0～100を返す。※式 = (チェック数) ／ (項目数)　小数点以下四捨五入。
            $progressU = round($chkU / $total_count);
        }
        // ソート
        // id 昇順に並び替え
        // $ids = array_column($new_items, 'id');
        // dd('aaa');
        // array_multisort($ids, SORT_ASC, $new_items);
        $ids = array_column($tmp_checklist_works, 'id');
        array_multisort($ids, SORT_ASC, $tmp_checklist_works);


        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");
        return response()->json([
            'error' => '',
            // 'checklist_works' => $new_items,
            'checklist_works' => $tmp_checklist_works,
            'elapsed_time' => $request->elapsed_time,
            'progressA' => $progressA,
            'progressU' => $progressU,
        ], 200);
    }


    public function check_finish(Request $request)
    {
        $error = '';
        $validator = Validator::make(
            $request->all(),
            [
                'key' => ['bail', 'required', 'string', 'min:36', 'max:36'],
                'checklist_id' => ['bail', 'required', 'integer', 'min:1'],
                'user_id' => ['bail', 'required', 'string', 'min:36', 'max:36'],
                'elapsed_time' => ['bail', 'required', 'integer', 'min:1'],
            ],
        );

        // 権限チェック
        $user_name = '';
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'status' => 403,
                'checklist_works' => [],
            ]);
        }

        $now = new Carbon();
        //　チェックリスト取得
        $checklist = ChecklistWork::find($request->checklist_id)
            ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
            ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
            ->first();
        // 作業中チェックリストが存在しない場合
        if (is_null($checklist)) {
            return [
                'error' => "checklist_id: {$request->checklist_id}: チェックリストが存在しません。",
            ];
        }


        // partipants抽出
        $participants = isset($checklist->participants) ? json_decode($checklist->participants, true) : [];
        $self_participant = isset($participants[$request->user_id]) ? $participants[$request->user_id] : [];

        // 自身のチェック項目が存在しない場合
        if (empty($self_participant)) {
            return response()->json([
                'error' =>  'チェック項目が存在しません。',
            ]);
        }

        // 全チェック済みか判定
        $is_check_complete = true;
        foreach ($self_participant['checkeds_time'] as $_id => $val) {
            if ($val < 1) {
                $is_check_complete = false;
                break;
            }
        }

        // 完了条件チェック
        if (!$is_check_complete) {
            return response()->json([
                'error' => '終了する条件が整っていません、'
            ], 406);
        }

        // $checklist = DB::select(
        //     "SELECT `checklist_works`.`id`, `checklist_works`.`title`
        //     FROM `checklist_works`
        //     WHERE `id`=?
        //     AND `opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL) ",
        //     [$request->checklist_id, $now->format('Y-m-d 00:00:00'), $now->format('Y-m-d 23:59:59')]
        // )->first();

        // 保存処理
        $self_participant['finished_at'] =  (new Carbon())->timestamp;
        $participants = [];
        $participants[$request->user_id] = $self_participant;
        $checklist->participants = json_encode($participants, true);

        try {
            DB::beginTransaction();
            $checklist->save();
            // header("Access-Control-Allow-Origin: *");
            // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

            DB::commit();

            return response()->json([
                'error' => '',
            ]);
        } catch (Exception $e) {
            return response()->json(([
                'error' => $e->getMessage(),
            ]));
        }
    }


    private static function isLogin($user_id)
    {
        $lifetime = config('myconfig.SESSION_LIFETIME');
        $user = User::where('user_id', '=', $user_id)->first();

        if (!isset($user->id)) {
            return false;
        } else {
            $target = new Carbon($user->last_logined_at);
            $now = new Carbon();
            $target->addMinutes($lifetime);

            if ($now->timestamp <= $target->timestamp) {
                $user->last_logined_at = $now->format('Y-m-d H:i:s');
                $user->save();

                $user_name = $user->name;
                return [$user->client_key, $user_name];
            } else {
                return false;
            }
        }
    }
}
