<?php

namespace Ghanem\LaravelSmsmisr;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Smsmisr
{
    /**
     * Codes FROM SMSMISR.
     */
    public const SMSMISR_SUCCESS_CODE = 1901;
    public const SMSMISR_VERIFY_SUCCESS_CODE = 4901;
    public const SMSMISR_BALANCE_SUCCESS_CODE = 6000;

    /**
     * GuzzleHttp\Client.
     * @var Client
     */
    public $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('smsmisr.endpoint'),
        ]);
    }

    /**
     * Send Normal SMS using SMSMISR API.
     *
     * @param string $message
     * @param string $to
     * @param string|null $sender
     * @param int $language
     * @return array|ResponseInterface
     * @throws GuzzleException
     */
    public function send(string $message, string $to, ?string $sender = null, int $language = 1)
    {
        $sender = $sender ?? config('smsmisr.sender');

        $response = $this->client->request('POST', 'webapi', [
            'query' => [
                'username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'sender' => $sender,
                'language' => $language,
                'message' => $message,
                'mobile' => $to,
                'DelayUntil' => null,
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * Send Verify SMS using SMSMISR API.
     *
     * @param string $code
     * @param string $to
     * @return array|ResponseInterface
     * @throws GuzzleException
     */
    public function sendVerify(string $code, string $to)
    {
        $response = $this->client->request('POST', 'vSMS', [
            'query' => [
                'Username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'Msignature' => config('smsmisr.m_signature'),
                'Token' => config('smsmisr.token'),
                'mobile' => $to,
                'DelayUntil' => null,
                'Code' => $code,
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * Check Normal SMS Balance using SMSMISR API.
     *
     * @return array|ResponseInterface
     * @throws GuzzleException
     */
    public function balance()
    {
        $response = $this->client->request('POST', 'Request', [
            'query' => [
                'username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'request' => 'status',
                'SMSID' => config('smsmisr.sms_id'),
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * Check Verify SMS Balance using SMSMISR API.
     *
     * @return array|ResponseInterface
     * @throws GuzzleException
     */
    public function balanceVerify()
    {
        $response = $this->client->request('POST', 'vRequest', [
            'query' => [
                'username' => config('smsmisr.username'),
                'password' => config('smsmisr.password'),
                'request' => 'status',
                'SMSID' => config('smsmisr.sms_verify_id'),
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * Helper Function to determine if the request was successful or not
     *
     * @param array|ResponseInterface $responseCode
     * @return bool
     */
    public function isSuccessful($responseCode): bool
    {
        if ($responseCode == null || !is_array($responseCode) || !array_key_exists('code', $responseCode)) return false;

        if ($responseCode['code'] == self::SMSMISR_SUCCESS_CODE) return true;
        if ($responseCode['code'] == self::SMSMISR_VERIFY_SUCCESS_CODE) return true;
        if ($responseCode['code'] == self::SMSMISR_BALANCE_SUCCESS_CODE) return true;

        return false;
    }
}
