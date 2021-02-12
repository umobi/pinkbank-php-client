<?php


namespace PinBank\Api;


use PinBank\Requests\ExtratoPosRequest;
use PinBank\Responses\CaptureResponse;
use PinBank\Responses\ExtratoPosResponse;

class ContaDigitalApi extends BaseApi
{

    public function extratoPos(ExtratoPosRequest $request, $clientCode = null, $channelCode = null)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $channelCode ?? $this->config->getChannelCode(),
                "CodigoCliente" => $clientCode ?? $this->config->getClientCode(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/ContaDigital/ExtratoPosEncrypted", $payload);
        return new ExtratoPosResponse($response);
    }

}