<?php

namespace App\Components;

use App\Http\Requests\Company\SearchRequest;
use App\Company;

class CompanyComponent
{
    public function search(SearchRequest $request)
    {
        $companies = Company::where('name', 'LIKE', '%'.$request->name.'%')->get();

        return $companies;
    }
}