<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Mood;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends CustomBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getExpiredDays(): int
    {
        $user = $this->getUser();
        $expired_days = 0;
        if($user && $user->is_paid == 1 && $user->last_paid_at) {
            $expiredAt = Carbon::parse($user->expired_at);
            if($expiredAt < now()) {
                $user->is_paid = 0;
                $user->save();
            } else {
                $expired_days = $expiredAt->diffInDays(now()) + 1;
            }
        }
        return $expired_days;
    }

    public function getPolicyTermContent(string $key): string
    {
        $setting = Settings::where('key', $key)->first();
        if(!$setting) {
            return '';
        }
        $config = json_decode($setting->value, true);
        return $config['content'];
    }
    public function home()
    {
        $expired_days = self::getExpiredDays();
        return view('home', compact('expired_days'));
    }

    public function dont_sell_info()
    {
        $expired_days = self::getExpiredDays();
        $content = self::getPolicyTermContent('dont_sell_info');
        return view('dont_sell_info', compact('expired_days', 'content'));
    }

    public function privacy_policy()
    {
        $expired_days = self::getExpiredDays();
        $content = self::getPolicyTermContent('privacy_policy');
        return view('privacy_policy', compact('expired_days', 'content'));
    }

    public function terms()
    {
        $expired_days = self::getExpiredDays();
        $content = self::getPolicyTermContent('terms');
        return view('terms', compact('expired_days', 'content'));
    }

}
