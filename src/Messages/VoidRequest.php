<?php


namespace Omnipay\NestPay\Messages;


class VoidRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data['Type'] = 'Void';
        $data['OrderId'] = $this->getTransactionId();
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        // $data['Currency'] = $this->getCurrencyNumeric();
        // $data['Total'] = $this->getAmount();

        return $data;
    }

    /**
     * @param $data
     * @return VoidResponse
     */
    protected function createResponse($data): VoidResponse
    {
        return new VoidResponse($this, $data);
    }
}