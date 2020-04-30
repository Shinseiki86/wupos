<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use App\Http\Controllers\App\MenuController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];



    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Session\TokenMismatchException
     */
    public function handle($request, Closure $next)
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->inExceptArray($request) ||
            $this->tokensMatch($request)
        ) {
            if(auth()->check() and is_null(session()->get('menusLeft'))){
                MenuController::refreshMenu();
            }
            return $this->addCookieToResponse($request, $next($request));
        }

        flash_alert( 'La página ha caducado por inactividad.', 'danger' );
        //throw new TokenMismatchException;
        // redirect the user back to the last page and show error
        return Redirect::back();
    }

}
