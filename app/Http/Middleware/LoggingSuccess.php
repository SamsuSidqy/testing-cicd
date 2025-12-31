<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Developer\LoggingHelpers;
class LoggingSuccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $resp = $next($request);

        $statusCode = $resp->getStatusCode();

        if ($statusCode === 200 || $statusCode <= 300) {
            $message = 'Services Berhasil | '. 'Status : ' . $statusCode;
            LoggingHelpers::CreateLogging('Success',$message,'Info',$statusCode);
        }elseif($statusCode != 500 && $statusCode > 300){
            if (session()->has('success')) {
                $message = 'Services Berhasil | '. 'Status : ' . $statusCode;
                LoggingHelpers::CreateLogging('Success',$message,'Info',$statusCode);
            }else{
                $message = 'Services Warning | '. 'Status : ' . $statusCode;
                LoggingHelpers::CreateLogging('Warning',$message,'Warning',$statusCode);
            }
        }

        return $resp;
    }
}
