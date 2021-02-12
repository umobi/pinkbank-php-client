<?php


namespace PinBank\Api;


use PinBank\Requests\ConsultarBoletoLoteRequest;
use PinBank\Requests\ConsultarBoletoRequest;
use PinBank\Requests\GerarBoletoRequest;
use PinBank\Requests\SolicitarEcommerceQrCodeRequest;
use PinBank\Responses\TransactionResponse;

class PixApi extends BaseApi
{

    public function solicitarEcommerceQrCode(SolicitarEcommerceQrCodeRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Pix/SolicitarEcommerceQrCodeEncrypted", $payload);
        var_dump($response);exit;
        return new TransactionResponse($response);
    }

}