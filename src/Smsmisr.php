<?php

namespace Ghanem\LaravelSmsmisr;

use GuzzleHttp\Client;
use Illuminate\Contracts\Foundation\Application;
use Psr\Http\Message\ResponseInterface;

class Smsmisr
{

    protected function buildHttpClient()
    {
        return new Client([
            'base_uri' => config('smsmisr.endpoint'),
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
        $sender = $sender ?? config('smsmisr.sender');
        $client = $this->buildHttpClient();

        $response = $client->request('POST', 'webapi', [
            'query' => [
                'username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'sender' => $sender,
                'language' => 1,
                'message' => $message,
                'mobile' => $to,
                'DelayUntil' => null,
            ]
        ]);
        $array = json_decode($response->getBody(), true) ;
        return $array;
    }

    /**
     * @param string $message
     * @param string $to
     * @param string|null $from
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendVerify(string $message, string $to, $sender = null)
    {
        $sender = $sender ?? config('smsmisr.sender');
        $client = $this->buildHttpClient();

        $response = $client->request('POST', 'verify', [
            'query' => [
                'username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'sender' => $sender,
                'language' => 1,
                'message' => $message,
                'mobile' => $to,
                'DelayUntil' => null,
            ]
        ]);
        $array = json_decode($response->getBody(), true) ;
        return $array;
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
        $response = $client->request('POST', 'Request', [
            'query' => [
                'username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'request' => 'status',
                'SMSID' => 4945703,
            ]
        ]);
        $array = json_decode($response->getBody(), true) ;
        return $array;
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
                'username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'request' => 'status',
                'SMSID' => 72973,
            ]
        ]);
        $array = json_decode($response->getBody(), true) ;

        return $array;
    }
}