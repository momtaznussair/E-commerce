<?php

namespace App\Http\Controllers\Api\Auth;

use App\Traits\Api\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Contracts\UserRepositoryInterface;

class LoginController extends Controller
{
    use ApiResponse;
    /**
     * Handle the incoming request.
     *
     * @param  App\Http\Requests\Api\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request, UserRepositoryInterface $userRepository)
    {
        if(! Auth::guard('web')->attempt($this->credentials($request))){
            return $this->apiResponse(null, 'Invalid Credentials', 401);
        }

        $user = $userRepository->getByEmailOrPhone($request->emailOrPhone);

        $token = $user->createToken('access-token');
        return $this->apiResponse(['access-token' => $token->plainTextToken], 'User Logged In Successfully');
    }

    protected function credentials($request) {
        $credentials = ['password' => $request->password];
        if(is_numeric($request->emailOrPhone)) {
            $credentials['phone'] = $request->emailOrPhone;
        }
        else {
            $credentials['email'] = $request->emailOrPhone;
        }
        return $credentials;
    }
}
