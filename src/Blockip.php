<?php namespace Olssonm\Blockip;

use Symfony\Component\HttpFoundation\IpUtils;

/**
 *
 */
class Blockip
{

    protected $handler;

    function __construct()
    {
        $handler = config('blockip.handler');
        $this->handler = new $handler;
    }

    public function isActiveEnv()
    {
        if (in_array(app()->environment(), config('blockip.envs'))) {
            return true;
        }
        return false;
    }

    public function shouldBlockIp()
    {
        if (IpUtils::checkIp($this->getIp(), $this->getIpsToBlock())) {
            return true;
        }

        return false;
    }

    public function getErrorResponse()
    {
        return $this->handler->getError();
    }

    protected function getIp()
    {
        return $this->handler->getIp();
    }

    protected function getIpsToBlock()
    {
        return $this->handler->getIpsToBlock();
    }
}
