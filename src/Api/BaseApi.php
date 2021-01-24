<?php


namespace PinBank\Api;


use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Utils;
use PinBank\ApiException;
use PinBank\Configuration;

class BaseApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;


    public function __construct(Configuration $config, ClientInterface $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    /**
     * @param $method
     * @param $uri
     * @param \JsonSerializable|array|null $content
     * @return null
     * @throws ApiException
     */
    protected function sendRequest($method, $uri, $content = null)
    {
        $options = [];
        if ($method == "POST") {
            $json = [];
            if ($content instanceof \JsonSerializable) {
                $json = $content->jsonSerialize();
            } else if (is_array($content)) {
                $json = $content;
            }


            $body = Utils::jsonEncode($json, JSON_UNESCAPED_SLASHES);

            if (strpos($uri, 'Encrypted') > 0) {
                $bodyEncrypted = $this->crypt(Utils::jsonEncode($json, JSON_UNESCAPED_SLASHES));

                $body = Utils::jsonEncode([
                    'Data' => [
                        'Json' => $bodyEncrypted
                    ]
                ]);

            }

            $options['body'] = $body;
            $options['headers'] = [
                'Content-Type' => 'application/json'
            ];

        } elseif ($method == "GET" || $method == "PUT" || $method == "DELETE") {
            $options['query'] = is_array($content) ? $content: [];
        }

        try {
            $res = $this->client->request($method, $uri, $options);
            $body = $res->getBody();
            $parsedBody = $this->readResponse($res->getStatusCode(), $body);


            [$one, $two, $caller] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);

            return $parsedBody;
        } catch (RequestException $exception) {
            $this->readException($exception);
        } catch (GuzzleException $exception) {
            $exception = new ApiException($exception->getMessage(), $exception->getCode(), [], null, $exception);
            throw $exception;
        }
    }

    /**
     * @param $statusCode
     * @param $responseBody
     * @return null
     * @throws ApiException
     */
    protected function readResponse($statusCode, $responseBody)
    {
        $unserialized = null;
        switch ($statusCode) {
            case 200:
            case 201:
                $unserialized = $this->unserialize($responseBody);
                break;

        }
        return $unserialized;

    }

    protected function readException(RequestException $exception)
    {
        throw ApiException::fromGuzzleException($exception);
    }

    /**
     * @param $body
     * @return object|null
     * @throws ApiException
     */
    protected function unserialize($body) {
        $json = Utils::jsonDecode($body);

        if ($json->ResultCode != 0) {
            throw ApiException::fromBodyResponse($json);
        }

        if (isset($json->Data->Json)) {
            $json->Data = Utils::jsonDecode($this->decrypt($json->Data->Json));
        }
        return $json;
    }

    protected function crypt($data)
    {
        $ciphering = "AES-128-CBC";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = OPENSSL_RAW_DATA;

        $encryption_iv = pack("x".$iv_length);

        return base64_encode(openssl_encrypt($data, $ciphering, $this->config->getPassword(), $options, $encryption_iv));
    }

    function decrypt($data) {

        $ciphering = "AES-128-CBC";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = OPENSSL_RAW_DATA;
        $decryption_iv = pack("x".$iv_length);

        $decryption=openssl_decrypt (base64_decode($data), $ciphering,
            $this->config->getPassword(), $options, $decryption_iv);

        return $decryption;
    }

}