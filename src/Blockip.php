<?php namespace Olssonm\Blockip;

use Symfony\Component\HttpFoundation\IpUtils;

/**
 * Main Blockip-logic
 */
class Blockip
{

    /**
     * Loaded handler
     * @var object
     */
    protected $handler;

    /**
     * Constructor
     */
    function __construct()
    {
        $handler = config('blockip.handler');
        $this->handler = new $handler;
    }

    /**
     * Check if current environment is used
     * @return bool
     */
    public function isActiveEnv()
    {
        if (in_array(app()->environment(), config('blockip.envs'))) {
            return true;
        }
        return false;
    }

    /**
     * Check if the request IP should be blocked
     * @return bool
     */
    public function shouldBlockIp()
    {
        if (IpUtils::checkIp($this->getIp(), $this->getIpsToBlock())) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve the error response from the handler
     * @return response
     */
    public function getErrorResponse()
    {
        return $this->handler->getError();
    }

    /**
     * Get the request IP from the handler
     * @return string
     */
    protected function getIp()
    {
        return $this->handler->getIp();
    }

    /**
     * Get the IPs to be blocked from the handler
     * @return array
     */
    protected function getIpsToBlock()
    {
        return $this->handler->getIpsToBlock();
    }
}
