<?php


namespace Krymen\Guzzle\Test;

use GuzzleHttp\Adapter\MockAdapter;
use GuzzleHttp\Adapter\TransactionInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Tests\Server;
use Krymen\Guzzle\GuzzlePlayground;

class GuzzlePlaygroundTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    private $response;

    protected function setUp()
    {
        $this->response = new Response(200, ['Content-Type' => 'application/json']);
    }

    /**
     * @test
     */
    public function mock_subscriber()
    {
        $mock = new Mock([$this->response]);

        $client = new Client();
        $client->getEmitter()->attach($mock);

        $playground = new GuzzlePlayground($client);
        $playground->play();
    }

    /**
     * @test
     */
    public function mock_adapter()
    {
        $response = $this->response;
        $mockAdapter = new MockAdapter(function (TransactionInterface $trans) use ($response) {
            return $response;
        });

        $client = new Client(['adapter' => $mockAdapter]);

        $playground = new GuzzlePlayground($client);
        $playground->play();
    }

    /**
     * @test
     */
    public function web_server()
    {
        require_once __DIR__ . '/../vendor/guzzlehttp/guzzle/tests/Server.php';

        Server::enqueue([$this->response]);
        $client = new Client(['base_url' => Server::$url]);

        $playground = new GuzzlePlayground($client);
        $playground->play();
    }

    /**
     * @test
     */
    public function real()
    {
        $client = new Client(['base_url' => 'https://api.github.com']);

        $playground = new GuzzlePlayground($client);
        $playground->play();
    }
}
