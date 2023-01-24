<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChecklistTodoWork;
use App\Models\ChecklistWork;

class ChecklistWorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ChecklistWork::all()->toArray();
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

    public function updateDone(ChecklistWork $checklistWork, Request $request)
    {
        $checklistWork->user_id == $request->user_id;

        return $checklistWork->update()
            ? response()->json()
            : response()->json([], 500);
    }

    public function getChecklist(Request $request) {

        // dd($request->category1_id);
        $checklists = ChecklistWork::
        // where('category1_id', '=', $request->cagegory1_id)
        // ->where('category2_id', '=', $request->cagegory2_id)
        // ->where('category3_id', '=', $request->cagegory3_id)
        where('category1_id', '=', 1)
        ->where('category2_id', '=', 1)
        ->where('category3_id', '=', 1)
         ->get();

        return $checklists->toArray();
    }
}
