<?php

namespace Krymen\Guzzle;

use GuzzleHttp\ClientInterface;

class GuzzlePlayground
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function play()
    {
        $res = $this->client->get('users/krymen');
        echo $res->getStatusCode() . PHP_EOL;           // 200
        echo $res->getHeader('Content-Type') . PHP_EOL; // 'application/json; charset=utf8'
        var_export($res->json());                       // Outputs the JSON decoded data
    }
}
