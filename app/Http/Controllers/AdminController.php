<?php

namespace App\Http\Controllers;

use App\Exceptions\Err;
use App\Http\Controllers\CustomBaseController;
use App\Models\Marketings;
use App\Models\Settings;
use App\Models\User;
use App\Models\Users;
use App\Traits\ControllerTrait;
use Exception;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends CustomBaseController
{

    use ControllerTrait;
    public function admin_panel()
    {
        return view('admin.adminpanel');
    }
    public function users()
    {
        return view('admin.users');
    }

    public function payments()
    {
        return view('admin.payments');
    }

    public function settings()
    {
        return view('admin.settings');
    }

    public function getSetting(Request $request): mixed
    {
        $user = $this->getUser();
        if ($user->user_type != 1) {
            Err::throw('You are not alllowed to get server setting');
        }

        $params = $request->validate([
            'key' => 'required|string'
        ]);
        return Settings::where('key', $params['key'])
            ->first();
    }

    public function saveSetting(Request $request): mixed
    {
        $user = $this->getUser();
        if ($user->user_type != 1) {
            Err::throw('You are not alllowed to set server setting');
        }
        $params = $request->validate([
            'key' => 'required|string',
            'value' => 'required|json'
        ]);
        Settings::updateOrCreate([
            'key' => $params['key']
        ], [
            'value' => $params['value']
        ]);
        return [
            'code' => 0,
            'result' => 'success'
        ];
    }
}
