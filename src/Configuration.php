<?php


namespace PinBank;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Configuration
{
    protected $devHost = 'https://dev.pinbank.com.br/services/';

    protected $host = 'https://dev.pinbank.com.br/services/';

    protected $requestOrigin = '';

    protected $channelCode = '';

    protected $clientCode = '';

    protected $keyStore = '';

    protected $username = '';

    protected $password = '';

    protected $sandbox = false;

    protected $accessToken = '';
    protected $accessTokenExpireAt;


    public function __construct($username, $password, $requestOrigin, $channelCode = 0, $clientCode = 0, $keyStore = "", $sandbox = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->requestOrigin = $requestOrigin;
        $this->channelCode = $channelCode;
        $this->clientCode = $clientCode;
        $this->keyStore = $keyStore;
        $this->sandbox = $sandbox;
    }

    public function getRequestOrigin(): string
    {
        return $this->requestOrigin;
    }

     public function getKeyStore(): string
    {
        return $this->keyStore;
    }

    public function getChannelCode(): string
    {
        return $this->channelCode;
    }

    public function getClientCode()
    {
        return $this->clientCode;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAccessToken(): string
    {
        if (!$this->accessToken || !$this->accessTokenExpireAt || $this->accessTokenExpireAt <= time()) {
            $this->authenticate();
        }
        return $this->accessToken;
    }

    public function getHost(): string
    {
        return $this->sandbox ? $this->devHost : $this->host;
    }

    /**
     * @throws ApiException
     */
    private function authenticate() {
        $client = new Client([
            'base_uri' => $this->getHost(),
            'verify' => false,
            'headers' => [
                'User-Agent' => 'pinBank Client/1.0 PHP SDK',
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'RequestId' => uniqid(),
            ]
        ]);

        try {
            $res = $client->post("api/token", [
                "form_params" => [
                    "username" => $this->username,
                    "password" => $this->password,
                    "grant_type" => "password",
                ]
            ]);

            $body = \GuzzleHttp\json_decode($res->getBody()->getContents());

            $this->accessToken = $body->access_token;
            $this->accessTokenExpireAt = time() + ($body->expires_in / 2);
        } catch (GuzzleException $e) {
            throw ApiException::fromGuzzleException($e);
        }
    }
}