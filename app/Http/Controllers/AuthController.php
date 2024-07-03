<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * Register a user
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        // $data['password'] = Hash::make($data['password']);
        $data['password'] = $data['password'];
        $data['username'] = $data['username'];
        $data['name'] = $data['username'];
        $data['outlet_id'] = 1;

        $user = User::create($data);

        $token = $user->createToken(User::USER_TOKEN);

        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 'User has been register successfully');
    }


    /**
     * Login a user
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $isValid = $this->isValidCredential($request);

        if (!$isValid['success']) {
            return $this->error($isValid['message'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $isValid['user'];
        $token = $user->createToken(User::USER_TOKEN);

        return $this->success([
            'user' => $user,
            'token' => $token->plainTextToken,
        ], 'Login successfully');
    }


    /**
     * Validate user credential
     *
     * @param LoginRequest $request
     * @return array
     */
    private function isValidCredential(LoginRequest $request): array
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();

        if ($user == null) {
            return [
                'success' => false,
                'message' => 'Invalid Credential',
            ];
        }

        if (Hash::check($data['password'], $user->password)) {
            return [
                'success' => true,
                'user' => $user,
            ];
        }

        return [
            'success' => false,
            'message' => 'Password is not matches',
        ];
    }


    /**
     * Login user with token
     *
     * @return JsonResponse
     */
    public function loginWithToken(): JsonResponse
    {
        return $this->success(auth()->user(), 'Login Successfully');
    }


    /**
     * Logout user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logout Successfully!');
    }
}
