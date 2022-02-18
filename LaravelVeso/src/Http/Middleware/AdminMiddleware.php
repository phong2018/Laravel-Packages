<?php 
namespace Phonglg\LaravelVeso\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Log::debug('AdminMiddleware: Not allow go to Admin/');
        // return redirect('/');

        if (!Auth::check() || Auth::user()->role_id>=config('laraveluserrole.defaultRoleId')) {
            Log::debug('AdminMiddleware: Not allow go to Admin/');
            return redirect('/');
        }

        return $next($request);
    }
}
?>