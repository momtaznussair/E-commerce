<?php

namespace App\Http\Controllers\Api\Auth;

use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRegisterRequest;
use App\Http\Resources\UserResourse;
use App\Repositories\Contracts\UserRepositoryInterface;

class RegisterController extends Controller
{
    use ApiResponse;

    /**
     * Handle the incoming request.
     *
     * @param  App\Http\Requests\Api\UserRegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UserRegisterRequest $request, UserRepositoryInterface $userRepository)
    {
        if($request->hasFile('avatar')) {
            $request['avatar'] = $request->avatar->store('users');
        }
        
        $user = $userRepository->add($request->all());
        return $this->apiResponse (
        [
            'user' => new UserResourse($user),
            'access-token' => $user->createToken('access-token')->plainTextToken
        ],
        'User Created Successfully', 201);
    }
}
