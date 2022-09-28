<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistWork;
use App\Models\User;
use Attribute;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Node\Inline\Newline;
use PhpParser\Node\Stmt\Continue_;
use Respect\Validation\Rules\Length;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\returnSelf;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $checklist = Checklist::findAllForAllUsers()->get();
        return $checklist->toArray();
    }

    public function checkStart(Request $request)
    {



        // return response()->json($response, 200);
    }

    public function realtimeCheck(Request $request)
    {

        // リクエスト開始日時
        // $requested_begin_date = new Carbon();
        // // 認証チェック
        // $user = User::where('user_id', '=', $request->user_id)->first();
        // if (is_null($user)) {
        //     return response()->json([
        //         'error' => '権限エラー',
        //         'checklist_items' => [],
        //     ], 419);
        // }
        /*
        テーブルロックを使用しない、期待の大きい代案。
        同じチェックリストについてのみの疑似ロック処理。
        本処理に3秒もかからないと予測。前回操作から3秒経過分はそのまま続行。
        2秒以内の場合は1秒待機して続行。
        */

        // 疑似ロックファイル存在チェック
        // $lockfie_path = "public/works/{$request->checklist_id}.lock";
        // $is_lockedfile = Storage::exists($lockfile_path);

        // // ロック中の場合
        // $timestamp = 0;
        // if ($is_lockedfile) {
        //     $timestamp = Storage::get($lockfie_path);
        // }
        // // ロック中でなければファイル内容にタイムスタンプを記述
        // else {
        //     Storage::put($lockfie_path, ($timestamp = (new Carbon())->timestamp));
        // }

        // // ロック処理
        // $processing_time = 3;
        // if ($processing_time <= (new Carbon())->timestamp - $timestamp) {
        //     Storage::put($lockfie_path, ((new Carbon())->timestamp));
        // } else {
        //     sleep(2);
        // }

        // // チェックリスト抽出
        // $checklist = Checklist::find($request->checklist_id)
        //     ->select([['id', 'title']])
        //     ->where('opened_at', '<=', $requested_begin_date->format('Y-m-d 00:00:00'))
        //     ->Where('colsed_at', '>=', $requested_begin_date->format('Y-m-d 23:59:59'))->first();

        // // 存在チェック
        // if (is_null($checklist)) {
        //     return response()->json([
        //         'error' => '該当するチェックリストが存在しません。',
        //         'checklist_items' => [],
        //     ], 419);
        // }

        // // チェック時間更新処理
        // $check_items = $request->check_items;
        // $colmuns = [];
        // foreach ($check_items as $post) {
        //     $checkeds[$post['checklist_work_id']] = [
        //         'no' => $post['no'],
        //         'title' => $post['titile'],
        //         'headline' => $post['headline'],
        //         'memo' => $post['memo'],
        //         'checked' => $post['val'],
        //         'check_time' => (int)$post['val'] === 1 ? $post['check_time'] : 0,
        //     ];
        // }

        // // 保存処理
        // $checklist->items[$request->user_id] = [
        //     'user_name' => $user_name,
        //     'started_at' => $checklist->check_items[$user_id]['started_at'],
        //     'finished_at' => 0,
        //     'columns' =>  $columns,
        // ];

        // // 保存に失敗した場合
        // if (!$checklist->save()) {
        //     return [
        //         'error' => '更新に失敗しました。',
        //         'participants' => $checklist->participants,
        //         'user_id' => $request->user_id,
        //     ];
        // }

        // // 返却するときは自分以外の参加者のチェック情報を返却
        // $participants = $checklist->participants;
        // unset($participants[$request->user_id]);

        // return [
        //     'check_items' => $checklist->check_items,
        //     'user_id' => $user_id,
        //     'error' => '',
        // ];

        // 更新処理
        // $check_items = json_decode($checklist->check_items, JSON_UNESCAPED_UNICODE);
        // // チェックアイテムからclient keyに紐付いたアイテムを抽出
        // $new_check_items = null;
        // foreach ($check_items as $key => $val) {
        //     if ($val['key'] !== $request->key) continue;

        //     $val['check_time'] = $request->check_time;
        //     $val['val'] = $request->check_time > 0 ? 1 : 0;

        //     $check_items[$key] = $val;
        //     $new_check_items = $check_items;
        // }

        // // 保存処理
        // $encoded_check_items = json_encode($new_check_items, JSON_UNESCAPED_UNICODE);
        // $checklist->check_items =  $encoded_check_items;
        // $result = $checklist->save();

        // // 保存に失敗した場合
        // if (!$result) {
        //     return response()->json([
        //         'error' => '保存に失敗しました。',
        //         'checklist_items' => [],
        //     ], 500);
        // }

        // レスポンス生成
        // $response = [
        //     "check_time" => $request->check_time,
        //     "error" => "",
        //     "check_users" => [
        //         [
        //             "todo_ids" => 1,
        //             "name" => "ユーザー１",
        //             "check_time" => $request->check_time,
        //         ],
        //     ],
        //     "progressA" => 80,
        //     "progressU" => 50,
        // ];

        // return $response
        //     ? response()->json($response, 200)
        //     : response()->json([
        //         'error' => 'JSON構造が不正です。',
        //         'checklist_items' => [],
        //     ], 419);
    }

    public function realtime_save(Request $request)
    {

        $user_id = $request->user_id;
        $user_name = $request->user_name;

        // 認証チェック
        $user = User::where('user_id', '=', $request->user_id)->first();
        if (is_null($user)) {
            return response()->json([
                'error' => '権限エラー',
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
        // $lockfie_path = "public/works/{$request->checklist_id}.lock";
        // $is_lockedfile = Storage::exists($lockfie_path);

        // // ロック中の場合
        // $now = new Carbon();
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
        // $processing_time = 3;
        // if ($processing_time <= (new Carbon())->timestamp - $timestamp) {
        //     Storage::put($lockfie_path, ((new Carbon())->timestamp));
        // } else {
        //     sleep(2);
        // }

        //　チェックリスト取得
        $checlist = Checklist::find($request->checklist_id)
        ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
        ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
        ->first();

        // 作業中チェックリストが存在しない場合
        if(is_null($checlist)){
            return [
                'error' => "checklist_id: {$request->checklist_id}: チェックリスト取得できないエラー",
                'checklist_works' => [],
            ];
        }

        // check_items partipants抽出
        $check_items = isset($checlist->check_items) ? json_decode($checlist->check_items, true) : [];
        $participants = isset($checlist->participants) ? json_decode($checlist->participants, true) : [];

        // チェック作業に表示する項目が存在しない場合
        if(empty($check_items)) {
            return response()->json([
                'error' => '',
                'checklist_works' => $check_items,
            ]);
        }

        // partipants抽出
        // 自身の参加者情報が存在しない場合は権限がないとみなす
        $self_participant = isset($participants[$request->user_id]) ? $participants[$request->user_id] : null;
        if(is_null($self_participant)){
            return [
                'error' => 'チェック作業権限がありません。',
                'check_items' => [],
            ];
        }

        // 参加者が初チェック作業({})の場合はカラムcheck_itmesのJSON作業IDに紐付くカラムparticipant JSONの初期化をする
        if(empty($self_participant)) {
            foreach($check_items as $index => $item) {
                // check itmeのidが存在しない場合
                if(!isset($item['id'])) continue;
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
        foreach($request->check_items as $item) {
            $self_participant['checkeds'][$item['id']] = $item['checked'];
            $self_participant['inputs'][$item['id']] = $item['input'];
            $self_participant['checkeds_time'][$item['id']] = $item['check_time'];
        }

        // 保存処理
        $participants[$request->user_id] = $self_participant;
        $checlist->participants = json_encode($participants, true);
        try {
            DB::beginTransaction();
            $checlist->save();
            DB::commit();
        } catch(Exception $exception) {
            DB::rollBack();

            return response()->json([
                'error' => '',
                'started_at' => $request->started_at,
                'finished_at' => $request->finished_at,
                'checklist_works' => $request->checklist_works
            ], 200);
        }

        // レスポンスチェック作業リストの生成処理
        $tmp_check_items = $request->check_items;
        foreach($tmp_check_items as $index => $item) {
            $item['checked'] = $self_participant['checkeds'][$item['id']];
            $item['input'] = $self_participant['inputs'][$item['id']];

            // 自分以外の参加者情報のチェック時間と名前を追加
            $_index = 0;
            foreach($participants as $_user_id => $info) {
                if($_user_id === $request->user_id) continue;
                $item['participants'][$_index]['user_name'] = $info['user_name'];
                $item['participants'][$_index]['check_time'] = $info['checkeds_time'][$item['id']];
                $tmp_check_items[$index] = $item;
                $_index++;
            }
        }

        // ヘッダ設定
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'error' => '',
            'started_at' => isset($self_participant['started_at']) ? $self_participant['started_at'] : 0,
            'finished_at' => isset($self_participant['finished_at']) ? $self_participant['finished_at'] : 0,
            'checklist_works' => $tmp_check_items
        ], 200);
    }

    /**
     * チェックリスト取得
     *
     * @param Request $request
     * @return Json
     */
    public function getChecklist(Request $request)
    {
        // 権限チェック
        $user = User::where('user_id', '=', $request->user_id)->first();
        if (is_null($user)) {
            return response()->json([
                'checklists' => [],
                'error' => 'user_id: 権限エラー',
            ], 419);
        }

        // チェックリスト取得
        $checklist = Checklist::where('category1_id', '=', $request->category1_id)
            ->where('category2_id', '=', $request->category2_id)
            ->select('id', 'title')->get();

        // チェックリストが存在しない場合
        if (is_null($checklist)) {
            return response()->json([
                'checklists' => [],
                'error' => '',
            ]);
        }

        return response()->json([
            'checklists' => $checklist,
            'error' => '',
        ], 200);
    }

    public function get_checklist_works(Request $request) {

        //　チェックリスト取得
        $now = new Carbon();
        $checlist = Checklist::find($request->checklist_id)
        ->where('opened_at', '<=', $now->format('Y-m-d 00:00:00'))
        ->where('colsed_at', '>=', $now->format('Y-m-d 23:59:59'))
        ->first();

        // 存在チェック
        if(is_null($checlist)){
            return [
                'error' => '',
                'checklist_works' => [],
            ];
        }

        // check_items partipants抽出
        $check_items = isset($checlist->check_items) ? json_decode($checlist->check_items, true) : [];
        $participants = isset($checlist->participants) ? json_decode($checlist->participants, true) : [];

        // チェック作業に表示する項目が存在しない場合
        if(empty($check_items)) {
            return response()->json([
                'error' => '',
                'checklist_works' => $check_items,
            ]);
        }

        // partipants抽出
        // 自身の参加者情報が存在しない場合は権限がないとみなす
        $self_participant = isset($participants[$request->user_id]) ? $participants[$request->user_id] : null;
        if(is_null($self_participant)){
            return [
                'error' => 'チェック作業権限がありません。',
                'check_items' => [],
            ];
        }

        // 参加者が初チェック作業({})の場合はカラムcheck_itmesのJSON作業IDに紐付くカラムparticipant JSONの初期化をする
        if(empty($self_participant)) {
            foreach($check_items as $index => $item) {
                // check itmeのidが存在しない場合
                if(!isset($item['id'])) continue;
                $self_participant['checkeds'][$item['id']] = 0;
                $self_participant['checkeds_time'][$item['id']] = 0;
                $self_participant['inputs'][$item['id']] = '';
            }
            $self_participant['started_at'] = 0;
            $self_participant['finished_at'] = 0;
        }

        // レスポンスチェック作業リストの生成処理
        foreach($check_items as $index => $item) {
            $item['checked'] = $self_participant['checkeds'][$item['id']];
            $item['input'] = $self_participant['inputs'][$item['id']];

            // 自分以外の参加者情報のチェック時間と名前を取得処理
            $_index = 0;
            foreach($participants as $_user_id => $info) {
                if($_user_id === $request->user_id) continue;

                $item['participants'][$_index]['user_name'] = $info['user_name'];
                $item['participants'][$_index]['check_time'] = $info['checkeds_time'][$item['id']];
                //
                $check_items[$index] = $item;
                $_index++;
            }
        }

        // ヘッダ設定
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With");

        return response()->json([
            'error' => '',
            'started_at' => isset($self_participant['started_at']) ? $self_participant['started_at'] : 0,
            'finished_at' => isset($self_participant['finished_at']) ? $self_participant['finished_at'] : 0,
            'checklist_works' => $check_items,
        ], 200);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
