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
                'User-Agent' => 'LaravelSmsmisr/1.0',
                'Accept' => 'application/json',
                'Content-Type' => 'appliction/json',
                'Authorization' => sprintf('Bearer %s', $this->config['token']),
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
    public function send(string $message, string $to, $from = null): ResponseInterface
    {
        $from = $from ?? $this->config['from'];
        $client = $this->buildHttpClient();

        $response = $client->post($this->config['endpoint'], [
            'json' => [
                'Text' => $message,
                'From' => $from,
                'To' => $to,
            ]
        ]);

        return $response;
    }
}