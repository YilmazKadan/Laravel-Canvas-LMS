<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('access_token') or is_null(Session::get('access_token'))) {
            return redirect("/giris");
        }
        /*
            Burada invalid token hatası alınırsa login sayfasına yönlendiriyoruz.
        */
//        Cache takılmamak amaçlı cach'siz bir şekilde rastgele bir istek yapıyoruz. Ve olası hata mesajını kontrol ediyoruz.
        $accessKeyControl = \CanvasApi::using('accounts')->withoutCache()->listAccounts()->errorMessage();

        if ($accessKeyControl != false and  $accessKeyControl == "Geçersiz token") {
            // Token hatalı hatası alırsak session'u siliyoruz ve yönlendirmeyi yapıyoruz.
            Session::remove("access_token");

            return redirect("/giris");
        };
        return $next($request);
    }
}
