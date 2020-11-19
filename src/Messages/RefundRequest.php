<?php


namespace Omnipay\NestPay\Messages;


use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{

    /**
     * @inheritDoc
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('amount');

        $data['Type'] = 'Credit';
        $data['Name'] = $this->getUserName();
        $data['Password'] = $this->getPassword();
        $data['ClientId'] = $this->getClientId();
        $data['OrderId'] = $this->getTransactionId();
        $data['Total'] = $this->getAmount();
        $data['Currency'] = $this->getCurrencyNumeric();

        return $data;
    }

    /**
     * @param $data
     * @return RefundResponse
     */
    protected function createResponse($data): RefundResponse
    {
        return new RefundResponse($this, $data);
    }
}