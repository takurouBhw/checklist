<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Carbon\Carbon;
use App\Models\User;
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

        // バリデーション
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
        } else {
            $user = User::where('email', '=', $request->email)->first();

            if (!isset($user->id)) {
                $error = 'ログイン情報が登録されていません。';
            } else {
                if (!Hash::check($request->password, $user->password)) {
                    $error = 'メールアドレスまたはパスワードが一致しません。';
                } else {
                    $now = new Carbon();
                    $client_key = $user->client_key;
                    $user_id = $user->user_id;
                    $user_name = $user->name;
                    $user->last_logined_at = $now->format('Y-m-d H:i:s');
                    // $user->save();
                }
            }
        }

        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");
        // dd('aaa');

        return response()->json([
            'error' => $error,
            'client_key' => $client_key,
            'user_id' => $user_id,
            'user_name' => $user_name,
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

        if ($user_name != '') {
            $now = new Carbon();

            $categories = DB::select(
                "SELECT `category1s`.`id`, `category1s`.`category1_name`, COUNT(`checklist_works`.`id`) AS `cnt`
				FROM `category1s`
				LEFT JOIN `checklist_works` ON `category1s`.`id` = `checklist_works`.`category1_id`
				WHERE `checklist_works`.`opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL)
				GROUP BY `category1s`.`id`, `category1s`.`category1_name`",
                [$nw->format('Y-m-d 00:00:00'), $nw->format('Y-m-d 23:59:59')]
            );
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function get_category2(Request $request)
    {
        $categories = [];

        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);

        if ($user_name != '') {
            $now = new Carbon();

            $categories = DB::select(
                "SELECT `category2s`.`id`, `category2s`.`category2_name`, COUNT(`checklist_works`.`id`) AS `cnt`
				FROM `category2s`
				LEFT JOIN `checklist_works` ON `category2s`.`id` = `checklist_works`.`category2_id`
				WHERE `checklist_works`.`category1_id`=?
				ANS `checklist_works`.`opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL)
				GROUP BY `category2s`.`id`, `category2s`.`category2_name`",
                [$request->category1_id, $nw->format('Y-m-d 00:00:00'), $nw->format('Y-m-d 23:59:59')]
            );
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'categories' => $categories,
        ]);
    }

    public function get_checklist(Request $request)
    {
        $checklists = [];

        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);

        if ($user_name != '') {
            $now = new Carbon();

            $checklists = DB::select(
                "SELECT `checklist_works`.`id`, `checklist_works`.`title`
				FROM `checklist_works`
				WHERE `category1_id`=? AND `category2_id`=?
				ANS `opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL)
				ORDER BY `deadline_at` ASC",
                [$request->category1_id, $request->category1_id, $nw->format('Y-m-d 00:00:00'), $nw->format('Y-m-d 23:59:59')]
            );
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'checklists' => $checklists,
        ]);
    }

    public function get_checklist_works(Request $request)
    {
        list($client_key, $user_name) = Self::isLogin($request->user_id ?? '');

        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック作業閲覧の権限がありません。',
                'started_at' => $request->started_at,
                'finished_at' => $request->finished_at,
                'checklist_works' => [],
            ], 200);
        }

        //　チェックリスト取得
        $now = new Carbon();
        $checklist = ChecklistWork::find($request->checklist_id)
            ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
            ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
            ->first();

        // チェックリスト存在チェック
        if (is_null($checklist)) {
            return response()->json([
                'error' => '',
                'checklist_works' => [],
            ]);
        }

        // check_items partipants抽出
        $check_items = isset($checklist->check_items) ? json_decode($checklist->check_items, true) : [];
        $participants = isset($checklist->participants) ? json_decode($checklist->participants, true) : [];

        // チェック作業リストに表示する項目が存在しない場合
        if (empty($check_items)) {
            return response()->json([
                'error' => '',
                'checklist_works' => [],
            ]);
        }

        // partipants抽出
        // 自身の参加者情報が存在しない場合は権限がないとみなす
        $self_participant = isset($participants[$request->user_id]) ? $participants[$request->user_id] : null;
        if (is_null($self_participant)) {
            response()->json([
                'error' => 'チェック作業権限がありません。',
                'checklist_works' => [],
            ]);
        }

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
        }

        // レスポンスチェック作業リストの生成処理
        foreach ($check_items as $index => $item) {
            $item['checked'] = isset($self_participant['checkeds'][$item['id']]) ? $self_participant['checkeds'][$item['id']] : 0;
            $item['input'] = isset($self_participant['inputs'][$item['id']]) ? $self_participant['inputs'][$item['id']] : "";
            $item['check_time'] = isset($self_participant['checkeds_time'][$item['id']]) ? $self_participant['checkeds_time'][$item['id']] : 0;

            // 自分以外の参加者情報のチェック時間と名前を取得処理
            $_index = 0;
            foreach ($participants as $_user_id => $info) {
                if ($_user_id === $request->user_id) continue;

                $item['participants'][$_index]['user_name'] = $info['user_name'];
                $item['participants'][$_index]['check_time'] = $info['checkeds_time'][$item['id']];
                //
                $check_items[$index] = $item;
                $_index++;
            }
        }

        // ヘッダ設定
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'error' => '',
            'started_at' => isset($self_participant['started_at']) ? $self_participant['started_at'] : 0,
            'finished_at' => isset($self_participant['finished_at']) ? $self_participant['finished_at'] : 0,
            'checklist_works' => $check_items,
        ], 200);
    }

    public function check_start(Request $request)
    {

        // 権限チェック
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id ?? '');
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'checklist_items' => [],
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
        $processing_time = 3;
        if ($processing_time <= (new Carbon())->timestamp - $timestamp) {
            Storage::put($lockfie_path, ((new Carbon())->timestamp));
        } else {
            sleep(2);
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
                'checklist_works' => [],
            ];
        }

        // check_items partipants抽出
        $check_items = isset($checklist->check_items) ? json_decode($checklist->check_items, true) : [];
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
        }

        // 更新処理
        $self_participant['started_at'] = $request->started_at;
        $self_participant['finished_at'] = $request->finished_at;
        $self_participant['user_name'] = $user_name;
        foreach ($request->checklist_works as $item) {
            $self_participant['checkeds'][$item['id']] = $item['checked'];
            $self_participant['inputs'][$item['id']] = $item['input'];
            $self_participant['checkeds_time'][$item['id']] = $item['check_time'];
        }

        // 保存処理
        $participants[$request->user_id] = $self_participant;
        $checklist->participants = json_encode($participants, true);
        try {
            DB::beginTransaction();
            $checklist->save();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => '保存に失敗しました。',
                'started_at' => $request->started_at,
                'finished_at' => $request->finished_at,
                'checklist_works' => $request->checklist_works
            ]);
        }

        // レスポンスチェック作業リストの生成処理
        $tmp_checklist_works = $request->checklist_works;
        // 自身のチェック数
        $chkA = 0;
        // 全参加者のチェック数
        $chkU = 0;
        foreach ($tmp_checklist_works as $index => $item) {

            // チェック済み加算
            if ((int)$self_participant['checkeds'][$item['id']] == 1) {
                $chkU++;
                $chkA++;
            }
            $item['checked'] = $self_participant['checkeds'][$item['id']];
            $item['input'] = $self_participant['inputs'][$item['id']];

            // 自分以外の参加者情報のチェック時間と名前を追加
            $_index = 0;
            foreach ($participants as $_user_id => $info) {
                if ($_user_id === $request->user_id) continue;
                $item['participants'][$_index]['user_name'] = $info['user_name'];
                $item['participants'][$_index]['check_time'] = $info['checkeds_time'][$item['id']];

                // チェックタイム0より上ならチェック済みなので全参加のチェック数を加算
                if ((int)$info['checkeds_time'][$item['id']] > 0) {
                    $chkA++;
                }
                $tmp_checklist_works[$index] = $item;
                $_index++;
            }
        }

        // Progress作成処理
        // 総項目数
        $total_count = count(json_decode($checklist->check_items, true));
        // 参加人数
        $user_count = count($tmp_checklist_works[0]['participants'] ?? []) + 1;
        if ($total_count !== 0 || $user_count !== 0) {
            // progressA: 全体の進捗値。0～100を返す。※式 = (参加者の全チェック数) ／ (参加人数 ＊ 項目数)　小数点以下四捨五入。
            $progressA = round(($chkU + $chkA) / ($total_count * $user_count));
        }
        if ($total_count !== 0) {
            // progressU: 個人の進捗値。0～100を返す。※式 = (チェック数) ／ (項目数)　小数点以下四捨五入。
            $progressU = round($chkU / $total_count);
        }

        // ヘッダ設定
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        // dd($tmp_checklist_works);
        return response()->json([
            'error' => '',
            'started_at' => isset($self_participant['started_at']) ? $self_participant['started_at'] : 0,
            'finished_at' => isset($self_participant['finished_at']) ? $self_participant['finished_at'] : 0,
            'checklist_works' => $tmp_checklist_works,
            'progressA' => $progressA,
            'progressU' => $progressU,
        ]);
    }

    public function realtime_chk(Request $request)
    {
        $checklists = [];

        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);
        $check_time = 0;
        $check_users = [];
        $progressA = 0;
        $progressU = 0;
        $chkA = 0;
        $chkU = 0;

        if ($user_name != '') {
            $now = new Carbon();

            $checklists = DB::select(
                "SELECT `checklist_works`.`id`, `checklist_works`.`title`
				FROM `checklist_works`
				WHERE `id`=?
				ANS `opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL) ",
                [$request->checklist_id, $nw->format('Y-m-d 00:00:00'), $nw->format('Y-m-d 23:59:59')]
            )->first();

            if (isset($checklist->participants)) {
                $checklist->participants = json_decode($checklist->participants, true);

                if (!isset($checklist->participants[$request->user_id])) {
                    foreach ($checklist->participants as $loop_user_id => $items) {
                        if ($loop_user_id == $request->user_id) {
                            $check_time = $items['timestamp'];

                            foreach ($items['checkeds'] as $key => $val) {
                                if ($val == 1) $chkU++;
                            }
                        } else {
                            $check_users[] = $loop_user_id;

                            foreach ($items['checkeds'] as $key => $val) {
                                if ($val == 1) $chkA++;
                            }
                        }
                    }
                }
            }

            $checklist->check_items = json_decode($checklist->check_items, true);

            // 総項目数
            $total_count = count($checklist->check_items);

            // 参加人数
            $user_count = count($check_users) + 1;

            if ($total_count === 0 || $user_count === 0) {
            } else {
                $progressA = round(($chkU + $chkA) / ($total_count * $user_count));
            }

            if ($total_count === 0) {
            } else {
                $progressU = round($chkU / $total_count);
            }
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'error' => $error,
            'check_time' => $check_time,
            'check_users' => $check_users,
            'progressA' => $progressA,
            'progressU' => $progressU,
        ]);
    }

    // 保存キュー処理にも対応
    // チェックリストは配列でやってくる
    public function realtime_save(Request $request)
    {
        // バリデーション
        // $validated = $request->validate([
        //     'user_id' => 'required|string|max:32',
        //     'checklist_id' =>'required|integer',
        //     'checklist_works' => 'required|array',
        // ]);

        $checklists = [];
        $error = 0;
        $user_id = '';
        $user_name = '';
        $now = new Carbon();

        // 権限チェック
        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id ?? '');
        if (is_null($user_name)) {
            return response()->json([
                'error' => 'チェック操作する権限がありません。',
                'checklist_items' => [],
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
        $processing_time = 2;
        if ($processing_time <= (new Carbon())->timestamp - $timestamp) {
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
                'checklist_works' => [],
            ];
        }

        // check_items partipants抽出
        $check_items = isset($checklist->check_items) ? json_decode($checklist->check_items, true) : [];
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
        }

        // 更新処理
        $self_participant['started_at'] = $request->started_at;
        $self_participant['finished_at'] = $request->finished_at;
        $self_participant['user_name'] = $user_name;
        foreach ($request->checklist_works as $item) {
            $cheked = $item['checked'];
            $self_participant['checkeds'][$item['id']] = $cheked;
            $self_participant['checkeds_time'][$item['id']] =  $cheked == 1 ? $item['check_time'] : 0;
            $self_participant['inputs'][$item['id']] = $item['input'];
        }

        // 保存処理
        $participants[$request->user_id] = $self_participant;
        $checklist->participants = json_encode($participants, true);
        try {
            DB::beginTransaction();
            $checklist->save();
            // レスポンスチェック作業リストの生成処理
            $tmp_checklist_works = $check_items;
            // 自身のチェック数
            $chkA = 0;
            // 全参加者のチェック数
            $chkU = 0;
            foreach ($tmp_checklist_works as $index => $item) {

                // チェック済み加算
                if ((int)$self_participant['checkeds'][$item['id']] == 1) {
                    $chkU++;
                    $chkA++;
                }
                $item['checked'] = $self_participant['checkeds'][$item['id']];
                $item['input'] = $self_participant['inputs'][$item['id']];
                $item['check_time'] = $self_participant['checkeds_time'][$item['id']];

                // 自分以外の参加者情報のチェック時間と名前を追加
                $_index = 0;
                foreach ($participants as $_user_id => $info) {
                    if ($_user_id === $request->user_id) continue;
                    $item['participants'][$_index]['user_name'] = $info['user_name'];
                    $item['participants'][$_index]['check_time'] = $info['checkeds_time'][$item['id']];
                    // dd($item);

                    // チェックタイム0より上ならチェック済みなので全参加のチェック数を加算
                    if ((int)$info['checkeds_time'][$item['id']] > 0) {
                        $chkA++;
                    }
                    $tmp_checklist_works[$index] = $item;
                    $_index++;
                }
            }

            // Progress作成処理
            // 総項目数
            $total_count = count(json_decode($checklist->check_items, true));
            // 参加人数
            $user_count = count($tmp_checklist_works[0]['participants'] ?? []) + 1;
            if ($total_count !== 0 || $user_count !== 0) {
                // progressA: 全体の進捗値。0～100を返す。※式 = (参加者の全チェック数) ／ (参加人数 ＊ 項目数)　小数点以下四捨五入。
                $progressA = round(($chkU + $chkA) / ($total_count * $user_count));
            }
            if ($total_count !== 0) {
                // progressU: 個人の進捗値。0～100を返す。※式 = (チェック数) ／ (項目数)　小数点以下四捨五入。
                $progressU = round($chkU / $total_count);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => '保存に失敗しました。',
                'started_at' => $request->started_at,
                'finished_at' => $request->finished_at,
                'checklist_works' => $request->checklist_works
            ]);
        }
        // ヘッダ設定
        // header("Access-Control-Allow-Origin: *");
        // header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        // dd($tmp_checklist_works);
        return response()->json([
            'error' => '',
            'started_at' => isset($self_participant['started_at']) ? $self_participant['started_at'] : 0,
            'finished_at' => isset($self_participant['finished_at']) ? $self_participant['finished_at'] : 0,
            'checklist_works' => $tmp_checklist_works,
            'progressA' => $progressA,
            'progressU' => $progressU,
        ]);
    }


    public function check_finish(Request $request)
    {
        $error = '';

        list($client_key, $user_name) = $user_name = Self::isLogin($request->user_id);

        if ($user_name != '') {
            $now = new Carbon();

            $checklists = DB::select(
                "SELECT `checklist_works`.`id`, `checklist_works`.`title`
				FROM `checklist_works`
				WHERE `id`=?
				ANS `opened_at`<=? AND (`checklist_works`.`colsed_at`>=? OR `checklist_works`.`colsed_at` IS NULL) ",
                [$request->checklist_id, $nw->format('Y-m-d 00:00:00'), $nw->format('Y-m-d 23:59:59')]
            )->first();

            if (isset($checklist->participants)) {
                $checklist->participants = json_decode($checklist->participants, true);

                if (!isset($checklist->participants[$request->user_id])) {
                    $error = '終了する条件が整っていません、';
                } else {
                    $checklist->participants[$request->user_id]['finished_at'] = $now->format('Y-m-d- H:i:s');
                }

                DB::update("UPDATE `checklist_works` SET `participants`=? WHERE `id`=?", [$checklist->participants, $request->checklist_id]);
            }
        }

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'error' => $error,
        ]);
    }

    private static function isLogin($user_id)
    {
        $lifetime = is_null(config('myconfig.SESSION_LIFETIME')) ? 100000 : 1000000;
        $user = User::where('user_id', '=', $user_id)->first();

        if (!isset($user->id)) {
            return false;
        } else {
            $target = new Carbon($user->last_logined_at);
            $now = new Carbon();
            $target->addMinutes($lifetime);

            if ($now->timestamp <= $target->timestamp) {
                // $user->last_logined_at = $now->format('Y-m-d H:i:s');
                // $user->save();

                $user_name = $user->name;
                return [$user->client_key, $user_name];
            } else {
                return false;
            }
        }
    }
}
