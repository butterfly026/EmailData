<?php

namespace App\Exceptions;

use App\Helpers\IpHelper;
use ArgumentCountError;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionRender
{
    /**
     * @param Throwable $e
     * @return mixed
     * @throws Err
     */
    public static function Render(Throwable $e): mixed
    {
        $class = get_class($e);
        $request = request();
        if ($class != Err::class) {
            switch ($class) {
                case AuthenticationException::class:
                    return redirect(route('auth.loginPage'));
                case NotFoundHttpException::class:
                    if(Request::isMethod('get'))
                        return redirect(route('route.404error'));
                // case ValidationException::class:
                // case ArgumentCountError::class:
                // default:
                //     return redirect(route('auth.loginPage'));
                    //                    Err::Throw($e->getMessage(), 999);
            }
        }

        $isDebug = config('app.debug');

        $debugInfo = [
            'request' => [
                'client' => IpHelper::GetIP(),
                //$request->getClientIps(),
                'method' => $request->getMethod(),
                'uri' => $request->getPathInfo(),
                'params' => $request->all(),
            ],
            'exception' => [
                'class' => $class,
                'trace' => self::getTrace($e)
            ]
        ];

        $code = $e->getCode() == 0 ? 999 : $e->getCode();
        $message = $e->getMessage();

        $skipLog = self::getSkipLog($request->getPathInfo());
        if (!$skipLog) {

            $logInfo = $debugInfo;

            Log::error($message, $logInfo);
        }


        return response()->json([
            'code' => $code,
            'message' => $message,
            'debug' => $isDebug ? $debugInfo : null
        ]);
    }

    /**
     * @param Throwable $e
     * @return array
     */
    private static function getTrace(Throwable $e): array
    {
        $arr = $e->getTrace();
        $file = array_column($arr, 'file');
        $line = array_column($arr, 'line');
        $trace = [];
        for ($i = 0; $i < count($file); $i++) {
            if (!strpos($file[$i], '/vendor/'))
                $trace[] = [
                    $i => "$file[$i]($line[$i])"
                ];
        }
        return $trace;
    }

    /**
     * @param string $pathInfo
     * @return bool
     */
    private static function getSkipLog(string $pathInfo): bool
    {
        $skipLogPathInfo = config('common.skipLogPathInfo');
        if (!$skipLogPathInfo)
            return false;

        return in_array($pathInfo, $skipLogPathInfo);
    }
}
