<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Http\JsonResponse;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return Company::all()->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompanyRequest $request
     * @param Company $company
     * @return JsonResponse
     */
    public function store(StoreCompanyRequest $request, Company $company): JsonResponse
    {
        // 作成
        $company = Company::create($request->companyAttributes());
        return $company
            ? response()->json($company, 201)
            : response()->json([], 500);
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
     * @param UpdateCompanyRequest $request
     * @param [type] $id
     * @return JsonResponse
     */
    public function update(UpdateCompanyRequest $request, $id): JsonResponse
    {
        $company = Company::find($id);
        $company->update($request->companyAttributes());
        // 更新
        return $company->update($request->companyAttributes())
            ? response()->json($company, 200)
            : response()->json([], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        // 論理削除
        $company = Company::findOrFail($id)->delete();

        return $company
        ? response()->json($company)
        : response()->json([], 500);

    }
}
