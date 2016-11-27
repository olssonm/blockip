<?php namespace Olssonm\Blockip\Handlers;

/**
 * The default Blockip-handler
 */
class BlockipHandler implements BaseHandler
{
    /**
     * Retrieve the requestees IP
     * @return string
     */
    public function getIp()
    {
        // Check for Cloudflare-set IP
        $ip = request()->server('HTTP_CF_CONNECTING_IP');
        if ($ip) {
            return $ip;
        }

        // Return "standard" IP
        return request()->ip();
    }

    /**
     * Get all the IPs that are supposed to be blocked
     * @return array
     */
    public function getIpsToBlock()
    {
        return config('blockip.ips');
    }

    /**
     * Retrieve the error-response
     * @return mixed/respone
     */
    public function getError()
    {
        $view = config('blockip.error_view');
        $message = config('blockip.error_message');

        if ($view) {
            return response()->view($view, [], 401);
        }

        return response($message, 401);
    }
}
