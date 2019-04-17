<?php

namespace Ghanem\LaravelSmsmisr;

use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Psr\Http\Message\ResponseInterface;

class Smsmisr
{
    /** @var Application $app */
    protected $app;
    /** @var array */
    protected $config = [];

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->loadDefaultOptions();
    }

    protected function loadDefaultOptions(): Smsmisr
    {
        $this->config = $this->app['config']->get('smsmisr');
        return $this;
    }

    protected function buildHttpClient(): Client
    {
        return new Client([
            'base_uri' => $this->config['endpoint'],
        ]);
    }

    /**
     * @param string $message
     * @param string $to
     * @param string|null $from
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(string $message, string $to, $sender = null)
    {
        $sender = $sender ?? $this->config['sender'];
        $client = $this->buildHttpClient();

        $response = $client->request('POST', 'webapi', [
            'query' => [
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'sender' => $sender,
                'language' => 1,
                'message' => $message,
                'mobile' => $to,
                'DelayUntil' => null,
            ]
        ]);

        return $response;
    }

    /**
     * @param string $message
     * @param string $to
     * @param string|null $from
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendVerify(string $message, string $to, $sender = null): ResponseInterface
    {
        $sender = $sender ?? $this->config['sender'];
        $client = $this->buildHttpClient();

        $response = $client->request('POST', 'verify', [
            'query' => [
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'sender' => $sender,
                'language' => 1,
                'message' => $message,
                'mobile' => $to,
                'DelayUntil' => null,
            ]
        ]);

        return $response;
    }

    /**
     * @param string $message
     * @param string $to
     * @param string|null $from
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function balance(): ResponseInterface
    {
        $client = $this->buildHttpClient();

        $response = $client->request('POST', 'Request', [
            'query' => [
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'request' => 'status',
                'SMSID' => 7511,
            ]
        ]);
        // dd($response->getBody());

        return $response;
    }
    
    /**
     * @param string $message
     * @param string $to
     * @param string|null $from
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function balanceVerify()
    {
        $client = $this->buildHttpClient();

        $response = $client->request('POST', 'vRequest', [
            'query' => [
                'username' => $this->config['username'],
                'password' => $this->config['password'],
                'request' => 'status',
                'SMSID' => 7511,
            ]
        ]);

        return $response;
    }
}