<?php namespace Olssonm\Blockip\Http\Middleware;

use Olssonm\Blockip\Blockip;

use Closure;

class BlockipMiddleware
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
        $blockip = new Blockip();

        if ($blockip->isActiveEnv() && $blockip->shouldBlockIp()) {
            return $blockip->getErrorResponse();
        }

        return $next($request);
    }
}
