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
        $data['OrderId'] = $this->getTransactionId();
        $data['Currency'] = $this->getCurrencyNumeric();
        $data['Total'] = $this->getAmount();

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