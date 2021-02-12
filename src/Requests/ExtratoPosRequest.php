<?php


namespace PinBank\Requests;


class ExtratoPosRequest
{
    /**
     * Valid \DateTime string
     */
    public string $DataInicial;

    /**
     * Valid \DateTime string
     */
    public string $DataFinal;

    /**
     * Todos, Pago, Pendente
     */
    public string $Status;
    /**
     * Todos, Ecommerce, Terminal
     */
    public ?string $MeioCaptura;

    public string  $IdTerminalPos;

    public int $QuantidadeLinhasRetorno = 0;

    public function __construct($startDate, $endDate, $statuses = null, $origin = null, $pos = null, $limit = 0)
    {
        $this->DataInicial = $startDate;
        $this->DataFinal = $endDate;
        $this->Status = $statuses ?? "Todos";
        $this->MeioCaptura = $origin ?? "Todos";
        $this->IdTerminalPos = $pos ?? "";
        $this->QuantidadeLinhasRetorno = $limit;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}