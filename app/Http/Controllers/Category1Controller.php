<?php

namespace App\Http\Controllers;

use App\Models\Category1;
use Illuminate\Http\Request;

class Category1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aa = Category1::all();
        return $aa->toArray();
    }

    public function getCategory(Request $request)
    {
        $request->user_id;
        $aa = Category1::all()->toArray();

        return $aa;
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
     * @param  \App\Http\Requests\StoreCategory1Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        dd($request);
        $user_id = $request->user_id;
        $aa = Category1::all();
        return $aa->toArray();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category1  $category1
     * @return \Illuminate\Http\Response
     */
    public function show(Category1 $category1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category1  $category1
     * @return \Illuminate\Http\Response
     */
    public function edit(Category1 $category1)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategory1Request  $request
     * @param  \App\Models\Category1  $category1
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategory1Request $request, Category1 $category1)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category1  $category1
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category1 $category1)
    {
        //
    }
}
