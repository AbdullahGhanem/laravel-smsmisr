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
            'allow_redirects' => false,
            'connect_timeout' => 3,
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'appliction/json',
            ],
            'timeout' => 5,
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

        $response = $client->post($this->config['endpoint'].'/webapi', [
            'query' => [
                'username' => $this->config['endpoint'],
                'password' => $this->config['endpoint'],
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
    public function sendVerify(string $message, string $to, $sender = null)
    {
        $sender = $sender ?? $this->config['sender'];
        $client = $this->buildHttpClient();

        $response = $client->post($this->config['endpoint'].'/verify', [
            'query' => [
                'username' => $this->config['endpoint'],
                'password' => $this->config['endpoint'],
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
    public function balance()
    {
        $client = $this->buildHttpClient();

        $response = $client->post($this->config['endpoint'].'/Request', [
            'query' => [
                'username' => $this->config['endpoint'],
                'password' => $this->config['endpoint'],
                'request' => 'status',
                'SMSID' => 7511,
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
    public function balanceVerify()
    {
        $client = $this->buildHttpClient();

        $response = $client->post($this->config['endpoint'].'/vRequest', [
            'query' => [
                'username' => $this->config['endpoint'],
                'password' => $this->config['endpoint'],
                'request' => 'status',
                'SMSID' => 7511,
            ]
        ]);

        return $response;
    }
}