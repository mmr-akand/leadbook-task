<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\FavouriteUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\CompanyCollection;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        $users = User::all();

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return UserResource
     */
    public function store(StoreRequest $request)
    {
        return new UserResource(
            app()->user->store($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Display the Company resource.
     *
     * @param User $user
     * @return CompanyCollection
     */
    public function favourite(User $user)
    {
        return new CompanyCollection($user->favourite);
    }

    /**
     * Display a listing of the company resource.
     * @param User $user
     * @param FavouriteUpdateRequest $request
     * @return CompanyCollection
     */    
    public function updateFavourite(User $user, FavouriteUpdateRequest $request)
    {
        $user->favourite()->sync($request->company_ids);

        return new CompanyCollection($user->favourite);
    }
}
