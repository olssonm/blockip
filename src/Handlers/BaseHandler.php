<?php namespace Olssonm\Blockip\Handlers;

interface BaseHandler {

    public function getIp();

    public function getIpsToBlock();

    public function getError();

}
