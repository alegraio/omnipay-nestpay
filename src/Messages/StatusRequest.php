<?php


namespace Omnipay\NestPay\Messages;


class StatusRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data['OrderId'] = $this->getTransactionId();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        $this->setStatus(true);
        // $data['Currency'] = $this->getCurrencyNumeric();
        // $data['Total'] = $this->getAmount();

        return $data;
    }

    /**
     * @param $data
     * @return StatusResponse
     */
    protected function createResponse($data): StatusResponse
    {
        return new StatusResponse($this, $data);
    }
}