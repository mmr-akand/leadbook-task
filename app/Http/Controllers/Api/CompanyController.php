<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Company\SearchRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Controllers\Controller;
use App\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CompanyCollection
     */
    public function index()
    {
        $companies = Company::all();

        return new CompanyCollection($companies);
    }

    /**
     * Display a listing of the company resource.
     * @param SearchRequest $request
     * @return CompanyCollection
     */    
    public function search(SearchRequest $request)
    {
        $companies = app()->company->search($request);

        return new CompanyCollection($companies);
    }
}
