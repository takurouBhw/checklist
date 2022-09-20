<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\User;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Continue_;

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
        // 権限チェック
        $user = User::where('user_id', '=', $request->user_id)->first();
        if(is_null($user)) {
        }

        $checklist = Checklist::find($request->checklist_id);
        $participants = json_decode($checklist->participants, JSON_UNESCAPED_UNICODE);
        $param = $participants[$request->user_id];
        $param['started_at'] = $request->check_time;
        $participants[$request->user_id] = $param;
        $encoded = json_encode($participants, JSON_UNESCAPED_UNICODE);
        $checklist->participants = $encoded;
        $checklist->save();


        $response = [
            "check_time" => $request->check_time,
            "error" => "",
            "check_users" => [
                [
                    "todo_ids" => 1,
                    "name" => "ユーザー１",
                    "check_time" => $request->check_time,
                ],
            ],
            "progressA" => 80,
            "progressU" => 50,
        ];

        return response()->json($response, 200);
    }

    public function realTimeCheck(Request $request)
    {

        // 権限チェック
        $user = User::where('user_id', '=', $request->user_id)->first();
        if(is_null($user)) {
            return response()->json([
                'error' => '権限エラー',
                'checklist_items' => [],
            ], 419);
        }

        // チェックアイテム抽出と存在チェック
        $checklist = Checklist::find($request->checklist_id);
        if(is_null($checklist)) {
            return response()->json([
                'error' => 'チェックリストが存在しません。',
                'checklist_items' => [],
            ], 419);
        }
        $check_items = json_decode($checklist->check_items, JSON_UNESCAPED_UNICODE);

        // チェックアイテムからclient keyに紐付いたアイテムを抽出
        $new_check_items = null;
        foreach($check_items as $key => $val) {
            if($val['key'] !== $request->key) continue;

            $val['check_time'] = $request->check_time;
            $check_items[$key] = $val;
            $new_check_items = $check_items;
            break;
        }

        // 保存処理
        $encoded_check_items = json_encode($new_check_items, JSON_UNESCAPED_UNICODE);
        $checklist->check_items =  $encoded_check_items;
        $result = $checklist->save();

        // 保存に失敗した場合
        if(!$result) {
            return response()->json([
                'error' => '保存に失敗しました。',
                'checklist_items' => [],
            ], 500);
        }

        // レスポンス生成
        $response = [
            "check_time" => $request->check_time,
            "error" => "",
            "check_users" => [
                [
                    "todo_ids" => 1,
                    "name" => "ユーザー１",
                    "check_time" => $request->check_time,
                ],
            ],
            "progressA" => 80,
            "progressU" => 50,
        ];

        return $response
            ? response()->json($response, 200)
            : response()->json([
                'error' => 'JSON構造が不正です。',
                'checklist_items' => [],
            ], 419);
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
        if(is_null($user)) {
            return response()->json([
                'checklists' => [],
                'error' => 'client_key: 権限エラー',
            ], 419);
        }

        // チェックリスト取得
        $checklist = Checklist::where('user_id', '=', $request->user_id)
        ->where('category1_id', '=', $request->category1_id)
        ->where('category2_id', '=', $request->category2_id)->get();

        // 結果
        return $checklist
            ? response()->json([
                'checklists' => $checklist
            ], 200)
            : response()->json([], 500);
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
