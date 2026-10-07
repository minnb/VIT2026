<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Chan truy cap khu quan tri voi tai khoan khong phai admin.
 */
class EnsureUserIsAdmin
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user || ! $user->isAdmin()) {
            Auth::logout();

            return redirect()->route('login')
                ->with(['flash_message' => 'Tài khoản của bạn không có quyền truy cập khu quản trị.']);
        }

        return $next($request);
    }
}