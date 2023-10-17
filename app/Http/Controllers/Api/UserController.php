<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Login api.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        try {
            $request->authenticate();

            $request->session()->regenerate();

            return $this->sendResponse('Ви успішно авторизувались.');
        } catch (\Exception $e) {
            return $this->sendError('Unauthorised.', ['error' => ($e->getMessage() ?? 'default')]);
        }
    }

    public function getUser()
    {
        $user = Auth::user();

        if (Auth::user()) {
            return $this->sendResponse('', $user);
        } else {
            return $this->sendError('Не авторизований.', ['error' => 'Не авторизований'], 401);
        }
    }

    public function getUsers()
    {
        if (Auth::user()) {
            return $this->sendResponse('', ['users' => $this->userRepository->getUsers()]);
        } else {
            return $this->sendError('Не авторизований.', ['error' => 'Не авторизований'], 401);
        }
    }

    public function deleteUser($userId)
    {
        if (Auth::user()) {
            $deleteResult = $this->userRepository->deleteUser($userId);

            if ($deleteResult) {
                return $this->sendResponse('успішно', ['message' => 'успішно']);
            }
            return $this->sendError('Не знайдено', ['message' => 'Користувача Не знайдено'], 404);
        } else {
            return $this->sendError('Не авторизований.', ['error' => 'Не авторизований.'], 401);
        }
    }

    public function updateUser(UpdateUserRequest $request, $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return $this->sendError('Не знайдено', ['error' => 'Користувача Не знайдено'], 404);
        }

        $user->name = $request->name;
        $user->login = $request->login;
        $user->email = $request->email;
        $password = $request->password;

        if (!empty($password)) {
            $user->password = Hash::make($password);
        }

        $user->save();

        return $this->sendResponse('успішно', ['message' => 'успішно']);
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            User::create([
                'name' => $request->name,
                'login' => $request->login,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return $this->sendResponse('успішно', ['message' => 'успішно']);
        } catch (\Exception $e) {
            return $this->sendError('помилка', ['error' => $e->getMessage()], 422);
        }
    }

    public function destroy(Request $request)
    {
        try {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return $this->sendResponse('успішно', ['message' => 'успішно']);
        } catch (\Exception $e) {
            return $this->sendError('помилка', ['error' => $e->getMessage()], 422);
        }
    }
}
