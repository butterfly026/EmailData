<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ControllerTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends CustomBaseController
{
    //
    use ControllerTrait;
    public function users_search(Request $request): mixed
    {
        $user = $this->getUser();
        if ($user->user_type != 1) {
            return [
                'code' => 999
            ];
        }
        $params = $request->validate([
            'email' => 'nullable|string',
            'perPage' => 'nullable',
            'curPage' => 'nullable',
        ]);
        return User::ifWhereLike($params, 'email')
            ->where('user_type', 0)
            ->paginate($this->perPage());
    }

    public function update(Request $request): mixed
    {
        $user = $this->getUser();
        if ($user->user_type != 1) {
            return [
                'code' => 999
            ];
        }
        $params = $request->validate([
            'email' => 'required|string',
            'password' => 'nullable|string',
            'full_access' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);
        User::where('email', $params['email'])
        ->update([
            'password' => (key_exists('password', $params) && $params['password']) ? bcrypt($params['password']) : DB::raw("password"),
            'is_paid' => (key_exists('full_access', $params) && $params['full_access'] == true) ? 1 : 0,
            'email_verified_at' => (key_exists('full_access', $params) && $params['full_access'] == true) ? now() : null,
            'is_email_verified' => (key_exists('full_access', $params) && $params['full_access'] == true) ? 1 : 0,
            'last_paid_at' => (key_exists('full_access', $params) && $params['full_access'] == true) ? now() : null,
            'is_active' => (key_exists('is_active', $params) && $params['is_active'] == true) ? 1: 0,
        ]);
        return [
            'code' => 0
        ];
    }

    public function delete(Request $request): mixed
    {
        $user = $this->getUser();
        if ($user->user_type != 1) {
            return [
                'code' => 999
            ];
        }
        $params = $request->validate([
            'email' => 'nullable|string'
        ]);
        User::where('email', $params['email'])->delete();
        return [
            'code' => 0
        ];
    }

    public function create(Request $request): mixed
    {
        $user = $this->getUser();
        if ($user->user_type != 1) {
            return [
                'code' => 999
            ];
        }
        $params = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'full_access' => 'nullable|boolean',
            'is_active' => 'nullable|boolean'
        ]);
        $user = User::where('email', $params['email'])->first();
        if($user){
            return [
                'code' => 998,
                'message' => 'Email already exist',
            ];
        }
        User::create([
            'email' => $params['email'],
            'password' => bcrypt($params['password']),
            'is_paid' => (key_exists('full_access', $params) && $params['full_access'] == true) ? 1 : 0,
            'last_paid_at' => (key_exists('full_access', $params) && $params['full_access'] == true) ? now() : null,
            'is_active' => (key_exists('is_active', $params) && $params['is_active'] == true) ? 1: 0,
        ]);
        return [
            'code' => 0
        ];
    }
}
