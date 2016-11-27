<?php

    /**
     * Configuration for the "Blockip"-middleware
     */
    return [

        // IPs to block
        'ips' => [
            '37.123.187.245',   // an example of a single IP
            '23.20.0.0/14'      // an example of an IP-range with CIDR-notation
        ],

        // Message for blocked requests
        'error_message'     => '401 Unauthorized.',

        // Uncomment to use a view instead of plaintext message
        // 'error_view'     => 'blockip::default'

        // Environments where the middleware is active
        'envs'              => [
            'testing',
            'development',
            'production'
        ],

        // Main handler for the getIp(), getIpsToBlock() and getError-methods().
        // Check the documentation on how to customize this to your liking.
        'handler'           => Olssonm\Blockip\Handlers\BlockipHandler::class,

    ];
