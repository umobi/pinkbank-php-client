<?php


namespace PinBank\Api;


use PinBank\Requests\ConsultarBoletoLoteRequest;
use PinBank\Requests\ConsultarBoletoRequest;
use PinBank\Requests\GerarBoletoRequest;
use PinBank\Responses\TransactionResponse;

class BoletoApi extends BaseApi
{

    public function gerarBoleto(GerarBoletoRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/GerarBoletoEncrypted", $payload);
        var_dump($response);exit;
        return new TransactionResponse($response);
    }

    public function consultarBoleto(ConsultarBoletoRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/ConsultarBoletoEncrypted", $payload);
        var_dump($response);exit;
        return new TransactionResponse($response);
    }

    public function consultarBoletoLote(ConsultarBoletoLoteRequest $request)
    {
        $payload = [
            "Data" => array_merge($request->jsonSerialize(), [
                "CodigoCanal" => $this->config->getChannelCode(),
                "CodigoCliente" => $this->config->getClientCode(),
                "KeyLoja" => $this->config->getKeyStore(),
            ])
        ];

        $response = $this->sendRequest("POST", "api/Transacoes/ConsultarBoletoLoteEncrypted", $payload);
        return new TransactionResponse($response);
    }

}