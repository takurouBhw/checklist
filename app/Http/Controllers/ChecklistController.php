<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\User;
use Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $user = User::where('user_id', '=', $request->user_id)->first();
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
        $response = [
            "check_time" => $request->check_time,
            "error" => "",
            "check_users" => [
                [
                    "todo_ids" => 1,
                    "name" => "ユーザー１",
                    "check_time" => 1663633231,
                ],
            ],
            "progressA" => 80,
            "progressU" => 50,
        ];

        return response()->json($response, 200);

        $check_items = $request->all();
        $checklist_id = 0;
        foreach ($check_items as $check_item) {
            $checklist_id = $check_item['checklist_id'];
            break;
        }
        $checklist = Checklist::find($checklist_id);
        $encoded_check_items = json_encode($check_items, JSON_UNESCAPED_UNICODE);
        $checklist->check_items =  $encoded_check_items;
        $response = $checklist->save();

        return $response
            ? response()->json($check_items, 200)
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

        // 結果
        $checklist = Checklist::where('user_id', '=', $request->user_id)
        ->where('category1_id', '=', $request->category1_id)
        ->where('category2_id', '=', $request->category2_id)->get();

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
