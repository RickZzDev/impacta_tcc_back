<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserCollection(User::get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use($request) {
            $user = User::create([
                'name' => $request->get('name'),
                'password' => Hash::make($request->get('password')),
                'email' => $request->get('email')
            ]);
        });

        return response()->json(status: JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::transaction(function() use($request, $user) {
            $name = $request->get('name', $user->name);
            $email = $request->get('email', $user->email);
            $password = $request->get('password', $user->password);

            $user->update([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password)
            ]);
        });

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
