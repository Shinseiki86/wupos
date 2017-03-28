<?php

namespace Wupos\Http\Middleware;

use Symfony\Component\HttpFoundation\Cookie;
use Closure;
use Redirect;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    public function handle( $request, Closure $next )
    {
        if (
            $this->isReading($request) ||
            $this->runningUnitTests() ||
            $this->shouldPassThrough($request) ||
            $this->tokensMatch($request)
        ) {
            return $this->addCookieToResponse($request, $next($request));
        }

        // redirect the user back to the last page and show error
        \Session::flash('alert-danger', 'Disculpa, No fue posible verificar tu solicitud. Por favor intenta nuevamente.');
        return Redirect::back();
    }

    /**
     * Add the CSRF token to the response cookies.
     * Se configura cookie con flag http_only.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Http\Response
     */
    protected function addCookieToResponse($request, $response)
    {
        $config = config('session');

        $response->headers->setCookie(
            new Cookie(
                'XSRF-TOKEN', $request->session()->token(), time() + 60 * $config['lifetime'],
                $config['path'], $config['domain'], $config['secure'], $config['http_only']
            )
        );

        return $response;
    }
}
