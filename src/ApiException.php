<?php

namespace PinBank;

use \Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class ApiException extends Exception
{

    /**
     * The HTTP body of the server response either as Json or string.
     *
     * @var mixed
     */
    protected $responseBody;

    /**
     * The HTTP header of the server response.
     *
     * @var string[]|null
     */
    protected $responseHeaders;

    /**
     * The deserialized response object
     *
     * @var $responseObject;
     */
    protected $responseObject;

    /**
     * Constructor
     *
     * @param string $message Error message
     * @param int $code HTTP status code
     * @param string[]|null $responseHeaders HTTP response header
     * @param mixed $responseBody HTTP decoded body of the server response either as \stdClass or string
     * @param \Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, $responseHeaders = [], $responseBody = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->responseHeaders = $responseHeaders;
        $this->responseBody = $responseBody;
    }

    /**
     * Gets the HTTP response header
     *
     * @return string[]|null HTTP response header
     */
    public function getResponseHeaders()
    {
        return $this->responseHeaders;
    }

    /**
     * Gets the HTTP body of the server response either as Json or string
     *
     * @return mixed HTTP body of the server response either as \stdClass or string
     */
    public function getResponseBody()
    {
        return $this->responseBody;
    }

    /**
     * Sets the deseralized response object (during deserialization)
     *
     * @param mixed $obj Deserialized response object
     *
     * @return void
     */
    public function setResponseObject($obj)
    {
        $this->responseObject = $obj;
    }

    /**
     * Gets the deseralized response object (during deserialization)
     *
     * @return mixed the deserialized response object
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }

    public static function fromGuzzleException(GuzzleException $exception)
    {
        $response = $exception instanceof  ClientException ? $exception->getResponse() : null;
        $headers = $response ? $response->getHeaders() : [];
        $body = $response ? (string)$response->getBody() : "";
        $exception = new ApiException($exception->getMessage(), $exception->code, $headers, $body, $exception);
        return $exception;
    }

    public static function fromBodyResponse(\stdClass $bodyResponse)
    {
        $exception = new ApiException($bodyResponse->Message, $bodyResponse->ResultCode, [], json_encode($bodyResponse));
        return $exception;
    }
}
