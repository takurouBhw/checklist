<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistWork;
use App\Models\User;
use Attribute;
use Carbon\Carbon;
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

        // // 権限チェック
        // $user = User::where('user_id', '=', $request->user_id)->first();
        // if (is_null($user)) {
        //     return response()->json([
        //         'error' => '権限エラー',
        //         'checklist_items' => [],
        //     ], 400);
        // }

        // // チェックリスト取得
        // $checklist = Checklist::find($request->checklist_id);

        // // 存在チェック
        // if (is_null($checklist)) {
        //     return response()->json([
        //         'error' => '未登録です。',
        //         'checklist_items' => [],
        //     ], 200);
        // }

        // // participantsからユーザー情報抽出
        // $participants = json_decode($checklist->participants, JSON_UNESCAPED_UNICODE);
        // $param = $participants[$request->user_id];

        // // 更新処理
        // $param['started_at'] = $request->check_time;
        // $participants[$request->user_id] = $param;

        // // 保存処理
        // $encoded = json_encode($participants, JSON_UNESCAPED_UNICODE);
        // $checklist->participants = $encoded;
        // $result = $checklist->save();

        // // 更新・保存に失敗した場合
        // if (!$result) {
        //     return response()->json([
        //         'error' => '更新に失敗しました。',
        //         'checklist_items' => [],
        //     ], 500);
        // }

        // // レスポンス生成
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

        // リクエスト開始日時
        $requested_begin_date = new Carbon();
        // 認証チェック
        $user = User::where('user_id', '=', $request->user_id)->first();
        if (is_null($user)) {
            return response()->json([
                'error' => '権限エラー',
                'checklist_items' => [],
            ], 419);
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
            Storage::put($lockfie_path, ($timestamp = (new Carbon())->timestamp));
        }

        // ロック待機処理
        $processing_time = 3;
        if ($processing_time <= (new Carbon())->timestamp - $timestamp) {
            Storage::put($lockfie_path, ((new Carbon())->timestamp));
        } else {
            sleep(2);
        }

        // チェックリスト抽出
        $checklist = ChecklistWork::find($request->checklist_id)
            ->select('id', 'checklist_title', 'check_items', 'participants')
            ->where('opened_at', '<=', $requested_begin_date->format('Y-m-d 00:00:00'))
            ->Where('colsed_at', '>=', $requested_begin_date->format('Y-m-d 23:59:59'))->first();

        // チェックリスト存在チェック
        if (is_null($checklist)) {
            return response()->json([
                'error' => "opened_at {$requested_begin_date->format('Y-m-d 00:00:00')}
                {$requested_begin_date->format('Y-m-d 23:59:59')}: エラー",
                'checklist_items' => [],
            ], 419);
        }

        $tmp_participants = [];
        $tmp_participants = json_decode($checklist->participants, JSON_UNESCAPED_UNICODE);
        // JSONデコードに失敗した場合
        if(is_null($tmp_participants)) {
            return [
                'error' => 'JSONデコードエラー',
                'check_items' => $request->check_items,
            ];
        }

        // JSONオブジェクト内にユーザー情報が存在しない場合は作業権限がない
        if(!isset($tmp_participants[$user_id])) {
            return [
                'error' => 'participants',
                'check_items' => $request->check_items,
            ];
        }

        $self_participant = $tmp_participants[$user_id];

        // participants更新処理
        $check_items = $request->check_items;
        $self_participant['started_at'] = $request->started_at;
        $self_participant['finished_at'] = $request->finished_at;
        $self_participant['user_name'] = $user_name;

        // リクエストパラメータのcheck_itmes抽出とparticipants更新
        foreach($check_items as $work_id => $val) {
            $self_participant['inputs'][$work_id] = isset($check_items[$work_id]['input']) ? $check_items[$work_id]['input'] : '';
            $cheked = isset($check_items[$work_id]['checked']) ? $check_items[$work_id]['checked'] : 0;
            $self_participant['checkeds'][$work_id] = $cheked;
            if($cheked > 0) {
                $self_participant['checkeds_time'][$work_id] =  isset($check_items[$work_id]['check_time']) ? $check_items[$work_id]['check_time'] : 0;
            }
            else {
                $self_participant['checkeds_time'][$work_id] = 0;
            }
        }

        // participants保存処理
        $tmp_participants[$user_id] = $self_participant;
        $checklist->participants = json_encode($tmp_participants, JSON_UNESCAPED_UNICODE);
        // 保存に失敗した場合
        if (!$checklist->save()) {
            return response()->json([
                'error' => 'participants保存できませんでした。',
                'check_items' => $check_items,
            ], 500);
        }

        /***** 自分以外の参加者の名前とチェック時間抽出処理 **********/
        unset($tmp_participants[$request->user_id]);
        // 参加者のパラメータ抽出用変数
        $other_participant = [];
        $participant_name = '';
        foreach ($tmp_participants as $_ => $_other_participant) {
            // 自分以外の参加者情報を取得
            $participant_name = $_other_participant['user_name'];
            $other_participant = $_other_participant;
        }
        /******************************************************/

        /************ レスポンスパラメータ生成処理 *****************/
        $_check_items = $checklist->check_items;
        dd($_check_items);
        foreach($check_items as $work_id => $_) {
            $check_items[$work_id]['participant_check_time'] =
                isset($other_participant['checkeds_time'][$work_id]) ? $other_participant['checkeds_time'][$work_id] : 0;
            $check_items[$work_id]['participant_name'] = $participant_name;
        }
        /*****************************************************/

        return response()->json([
            'user_id' => $user_id,
            'started_at' => $request->started_at,
            'finished_at' => $request->finished_at,
            'error' => '',
            'check_items' => $check_items,
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
        $checklist = Checklist::where('user_id', '=', $request->user_id)
            ->where('category1_id', '=', $request->category1_id)
            ->where('category2_id', '=', $request->category2_id)->get();

        // 存在チェック
        if (is_null($checklist)) {
            return response()->json([
                'checklists' => [],
                'error' => '取得できませんでした。',
            ], 414);
        }

        return response()->json([
            'checklists' => $checklist,
            'error' => '',
        ], 200);
    }

    public function get_checklist_works(Request $request) {

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
