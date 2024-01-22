<?php

namespace App\Http\Controllers;
use App\Exceptions\Err;
use App\Helpers\IpHelper;
use App\Models\IpLogs;
use App\Models\Settings;
use App\Models\User;
use Exception;
use Illuminate\Support\Carbon;
class CustomBaseController extends Controller
{
    protected ?User $user = null;

    /**
     * @return Users|null
     * @throws Err
     */
    public function getUser(): ?User
    {
        if (!$this->user) {
            $user = auth()->user();
            if (!$user || !$user->is_active) return null;

            if (get_class($user) != User::class) {
                // throw new Exception(__("User not login"), 10000);
                return null;
            }

            $this->user = $user;
        }
        return $this->user;
    }

    public function checkIpAddrValidation(string $method): void
    {
        $user = auth()->user();
        $ipAddr = IpHelper::GetIP();
        logger("$ipAddr is Searching Data");
        $setting = Settings::where('key', 'payments')->first();
        if(!$setting) {
            Err::throw('Contact to administrator to pay out!!');
        }
        $config = json_decode($setting->value, true);
        $max_free_num = $config['max_free_num'] ?? 1;

        if (!$user) {
            $ipLog = IpLogs::where('ip_address', $ipAddr)
                ->where('method', $method)
                ->first();
            if(!$ipLog) {
                $ipLog = IpLogs::create([
                    'ip_address' => $ipAddr,
                    'method' => $method
                ]);
            }
            $ipLog->can_download = 0;
            $ipLog->save();
            if($ipLog->try_num >= $max_free_num) {
                $freeAt = Carbon::parse($ipLog->updated_at)->addDay();
                if($freeAt > now()) {
                    $minutes = now()->diffInMinutes($freeAt);
                    $hours = floor($minutes / 60);
                    $minutes = $minutes % 60;
                    throw new Exception("You must wait $hours hrs $minutes mins to search for free", 10008);
                } else {
                    $ipLog->try_num -= 1;
                    $ipLog->save();
                }
            }
            $ipLog->can_download = 1;
            $ipLog->try_num += 1;
            $ipLog->save();
        } else {
            $ipLog = IpLogs::where('method', $method)
                ->where('users_id', $user->id)
                ->first();
            if(!$ipLog) {
                $ipLog = IpLogs::create([
                    'users_id' => $user->id,
                    'ip_address' => $ipAddr,
                    'method' => $method
                ]);
            }
            $ipLog->can_download = 0;
            $ipLog->save();
            if($user->user_type == 1) {
                return;
            }
            if($ipLog->try_num >= $max_free_num && !$user->is_paid) {
                $freeAt = Carbon::parse($ipLog->updated_at)->addDay();
                if($freeAt > now()) {
                    $minutes = now()->diffInMinutes($freeAt);
                    $hours = floor($minutes / 60);
                    $minutes = $minutes % 60;
                    throw new Exception("You must wait $hours hrs $minutes mins to search for free", 10008);
                } else {
                    $ipLog->try_num -= 1;
                    $ipLog->save();
                }
            } else if($user->is_paid == 1 && $user->last_paid_at) {
                $expiredAt = Carbon::parse($user->expired_at);
                if($expiredAt < now()) {
                    $user->is_paid = 0;
                    $user->save();
                    if($ipLog->try_num >= $max_free_num) {
                        $freeAt = Carbon::parse($ipLog->updated_at)->addDay();
                        if($freeAt > now()) {
                            $minutes = now()->diffInMinutes($freeAt);
                            $hours = floor($minutes / 60);
                            $minutes = $minutes % 60;
                            throw new Exception("You unlimited search option has been expired, You must wait $hours hrs $minutes mins to search for free", 10008);
                        } else {
                            $ipLog->try_num -= 1;
                            $ipLog->save();
                        }
                    }
                }
            }
            if(!$user->is_paid) {
                $ipLog->try_num += 1;
                $ipLog->can_download = 1;
                $ipLog->save();
            }
        }
    }

}
