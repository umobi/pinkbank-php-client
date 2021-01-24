<?php
namespace PinBank;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use PinBank\Api\ContaDigitalApi;
use PinBank\Api\TransactionsApi;


class PinBank
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    private $transactionApi;

    private $contaDigitalApi;

    /**
     * @param Configuration   $config
     */
    public function __construct(
        Configuration $config
    ) {
        if ($config == null) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $config in PinBank API Client'
            );
        }

        $this->config = $config;

        $this->client = new Client([
            'base_uri' => $config->getHost(),
            'verify' => false,
            'headers' => [
                'User-Agent' => 'pinBank Client/1.0 PHP SDK',
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip',
                'RequestId' => uniqid(),
                'Authorization' => "Bearer {$config->getAccessToken()}",
                'UserName' => $config->getUsername(),
                'RequestOrigin' => $config->getRequestOrigin(),
            ]
        ]);

        $this->transactionApi = new TransactionsApi($this->config, $this->client);
        $this->contaDigitalApi = new ContaDigitalApi($this->config, $this->client);
    }

    public function __call($method, array $args)
    {
        $apis = [
            $this->transactionApi,
            $this->contaDigitalApi
        ];
        foreach ($apis as $api) {
            if (method_exists($api, $method)) {
                return $api->$method(...$args);
            }
        }
        throw new \InvalidArgumentException("Method {$method} not found in any API");
    }
}