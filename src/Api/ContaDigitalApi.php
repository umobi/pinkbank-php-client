<?php


namespace PinBank\Api;


use PinBank\Requests\ExtratoPosRequest;
use PinBank\Responses\CaptureResponse;
use PinBank\Responses\ExtratoPosResponse;

class ContaDigitalApi extends BaseApi
{

    public function extratoPosEncrypted(ExtratoPosRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/ContaDigital/ExtratoPosEncrypted", $payload);
        return new ExtratoPosResponse($response);
    }

}