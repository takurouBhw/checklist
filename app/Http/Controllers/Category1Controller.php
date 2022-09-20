<?php

namespace App\Http\Controllers;

use App\Models\Category1;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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


        return $aa;
    }

    public function getCategory(Request $request): JsonResponse
    {
        $user = User::where('user_id', '=', $request->user_id)->first();
        if(is_null($user)){
            return response()->json([
                'error' => '権限エラー',
                'categories' => [],
            ], 419);
        }
        $categories = Category1::all()->toArray();
        // dd($categories);
        $res = [
            'categories' => $categories,
            'client_key' => $user->client_key,
            'error' => '',
        ];

        return response()->json($res, 200);
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
        $client_key = $request->client_key;
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